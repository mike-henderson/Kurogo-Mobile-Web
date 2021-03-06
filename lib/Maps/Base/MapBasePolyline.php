<?php

class MapBasePolyline extends MapBasePoint implements MapPolyline {

    protected $points;

    public function __construct($points, $centroid=null) {
        $this->points = $points;
        if ($centroid) {
            $this->centroid = $centroid;
        }
    }

    public function getCenterCoordinate()
    {
        if (!isset($this->centroid)) {
            $lat = 0;
            $lon = 0;
            $n = count($this->points);
            foreach ($this->points as $coordinate) {
                $lat += $coordinate['lat'];
                $lon += $coordinate['lon'];
            }
            $this->centroid = array(
                'lat' => $lat / $n,
                'lon' => $lon / $n,
                );
        }
        return $this->centroid;
    }

    public function getPoints() {
        return $this->points;
    }

    public function serialize() {
        return serialize(
            array(
                'centroid' => serialize($this->centroid),
                'points' => serialize($this->points),
            ));
    }

    public function unserialize($data) {
        $data = unserialize($data);
        $this->centroid = unserialize($data['centroid']);
        $this->points = unserialize($data['points']);
    }
}


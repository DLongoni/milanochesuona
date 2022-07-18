<?php
class Location
{
    private static $_linkCode = '<a href="%s" target="_blank" 
        class="card-link mb-0">%s</a>';
    private static $_fbMask='https://facebook.com/%s';

    private static $_locationCode = '<a href="%s" target="_blank" 
        class="card-text"><small class="text-muted">%s</small></a>';
    private static $_gMapsMask='https://maps.google.com/?q=%s';

    public $id;
    public $fbId;
    public $city;
    public $country;
    public $latitude;
    public $longitude;
    public $street;

    public function getDescription(): string
    {
      $loc_description = '';

      if(isset($this->street) and isset($this->city)) :
          $loc_description = sprintf('%s, %s', $this->street, $this->city);
      elseif(isset($this->street)) :
          $loc_description = $this->street;
      elseif(isset($this->city)) :
          $loc_description = $this->city;
      endif;

      return $loc_description;
    }

    public function getDistance(): float
    {
        $cLon=9.191383;
        $cLat=45.464211;
        if (!(isset($this->latitude) and isset($this->longitude))) {
            return 10000.0;
        }
        $bLon=$this->longitude;
        $bLat=$this->latitude;

        $theta = $cLon - $bLon;
        $dist = sin(deg2rad($cLat)) * sin(deg2rad($bLat)) +  
            cos(deg2rad($cLat)) * cos(deg2rad($bLat)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $km = $dist * 60 * 1.85316;

        return $km;
    }

    public function getMilanoClass(): string
    {
        $ret = '';
        if (isset($this->city)) {
            if (strtolower($this->city) == "milano" 
                or strtolower($this->city) == "milan"
            ) {
                $ret='milano';
            }
        }
        return $ret;
    }

    public function getNsweClass(): string
    {
        $cLon=9.191383;
        $cLat=45.464211;
        $classArr = [];
        $x = $this->longitude - $cLon;
        $y = $this->latitude - $cLat;
        // Est
        if ($x > 0 and abs($y) < 4*$x) {
            $classArr[] = "loc-e";
        }
        // Ovest
        if ($x < 0 and abs($y) < -4*$x) {
            $classArr[] = "loc-w";
        }
        // Nord
        if ($y > 0 and $y > abs($x)/4) {
            $classArr[] = "loc-n";
        }
        // Sud
        if ($y < 0 and $y < -abs($x)/4) {
            $classArr[] = "loc-s";
        }
        $ret=join(' ', $classArr);
        return $ret;
    }

    public function getLinkHtml(): string
    {
        $descr = $this->getDescription();
        if(isset($this->fbId)) {
            $l = sprintf(self::$_fbMask, $this->fbId);
        } else {
            $l = jsprintf(self::$_gMapsMask, $descr);
        }

        $loc_link=sprintf(self::$_linkCode, $l, $descr);
        return $loc_link;
    }

    public function getHtml(): string
    {
        $loc_description = $this->getDescription();
        $loc_html = '';

        if (isset($loc_description) and $loc_description != '') {
            $gMap=sprintf(self::$_gMapsMask, $loc_description);
            $loc_html=sprintf(self::$_locationCode, $gMap, $loc_description);
        }
        return $loc_html;
    }
}
?>

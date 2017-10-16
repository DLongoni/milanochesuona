<?php
class Location
{
  public $id;
  public $city;
  public $country;
  public $latitude;
  public $longitude;
  public $street;
  public $zip;

  public function getDescription(): string
  {
    $loc_description = '';

    if(isset($this->street) and isset($this->city)):
      $loc_description = sprintf('%s, %s',$this->street,$this->city);
    elseif(isset($this->street)):
      $loc_description = $this->street;
    elseif(isset($this->city)):
      $loc_description = $this->city;
    endif;

    return $loc_description;
  }

  public function getDistance(): float {
    $cLon=9.191383;
    $cLat=45.464211;
    if(!(isset($this->latitude and isset($this->longitude)))):
      return 10000.0
    $bLon=$this->longitude;
    $bLat=$this->latitude;

    $theta = $cLon - $bLon;
    $dist = sin(deg2rad($cLat)) * sin(deg2rad($bLat)) +  cos(deg2rad($cLat)) * cos(deg2rad($bLat)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $km = $dist * 60 * 1.85316;

    return $km;
  }
}
?>

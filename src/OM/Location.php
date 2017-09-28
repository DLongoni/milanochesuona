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
}
?>

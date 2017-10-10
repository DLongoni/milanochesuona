<?php
class Venue
{
  private static $linkCode = '<a href="%s" target="_blank" class="card-link">%s</a>';
  private static $fbMask='https://facebook.com/%s';

  private static $locationCode = '<a href="%s" target="_blank" class="card-text"><small class="text-muted">%s</small></a>';
  private static $gMapsMask='https://maps.google.com/?q=%s';

  public $id;
  public $fbId;
  public $name;
  public $location; // type: Location
  public $website;
  public $fbPage;
  public $logo;
  public $picture;
  public $description;
  public $phone;
  public $email;
  public $venue_type_id;

  public function getLocationHtml(): string {
    $loc_description = $this->location->getDescription();
    $loc_html = '';

    if(isset($loc_description) and $loc_description != '')
    {
      $gMap=sprintf(self::$gMapsMask,$this->name . ' ' . $loc_description);
      $loc_html=sprintf(self::$locationCode,$gMap,$loc_description);
    }

    return $loc_html;
  }

  public function getLinkHtml(): string {
    $venue_link = '';
    if(isset($this->website) and filter_var($this->website,FILTER_VALIDATE_URL)): 
      $l = $this->website;
    elseif(isset($this->fbId)):
      $l = sprintf(self::$fbMask,$this->fbId);
endif;

if(isset($l))
  $venue_link=sprintf(self::$linkCode,$l,$this->name);

return $venue_link;
  }

  public function hasLocation() {
    if(!isset($this->location)) {
      return False;
    }
    if(!isset($this->location->latitude) or !isset($this->location->longitude)) {
      return False;
    }
    if($this->venue_type_id==1) {
      return True;
    }
    else {
      return False;
    }
  }

  private function getMilanoClass(): string {
    $ret = '';
    if ($this->hasLocation()){
      if(isset($this->location->city){
        if strtolower($this->location->city) == "milano"{
          $ret='milano';
        }
      }
    }
    return $ret;
  }

  private function getNsweClass(): string {
    $cLon=9.191383;
    $cLat=45.464211;
    if (!$this->hasLocation()){
      return "";
    }
    $classArr = [];
    $x = $this->location->longitude - $cLon;
    $y = $this->location->latitude - $cLat;
    // Est
    if($x > 0 and abs($y) < 4*$x){
      $classArr[] = "loc-e";
    }
    // Ovest
    if($x < 0 and abs($y) < -4*$x){
      $classArr[] = "loc-w";
    }
    // Nord
    if($y > 0 and $y < abs($x)/4){
      $classArr[] = "loc-n";
    }
    // Sud
    if($y < 0 and $y < -abs($x)/4){
      $classArr[] = "loc-s";
    }
    $ret=join(' ',$classArr);
    return $ret;
  }
}
?>

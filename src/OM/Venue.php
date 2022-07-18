<?php
class Venue
{
    private static $_linkCode = '<a href="%s" target="_blank" 
        class="card-link mb-0">%s</a>';
    private static $_fbMask='https://facebook.com/%s';

    private static $_locationCode = '<a href="%s" target="_blank" 
        class="card-text"><small class="text-muted">%s</small></a>';
    private static $_gMapsMask='https://maps.google.com/?q=%s';

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

    public function getLocationHtml(): string
    {
        $loc_description = $this->location->getDescription();
        $loc_html = '';

        if (isset($loc_description) and $loc_description != '') {
            $gMap=sprintf(self::$_gMapsMask, $this->name . ' ' . $loc_description);
            $loc_html=sprintf(self::$_locationCode, $gMap, $loc_description);
        }

        return $loc_html;
    }

    public function getLinkHtml(): string
    {
        $venue_link = '';
        if (isset($this->website)  
            and filter_var($this->website, FILTER_VALIDATE_URL)
        ) : 
            $l = $this->website;
      elseif(isset($this->fbId)) :
          $l = sprintf(self::$_fbMask, $this->fbId);
      endif;

      if (isset($l)) {
          $venue_link=sprintf(self::$_linkCode, $l, $this->name);
      }

      return $venue_link;
    }

    public function hasLocation()
    {
        if (!isset($this->location)) {
            return false;
        }
        if (!isset($this->location->latitude) 
            or !isset($this->location->longitude)
        ) {
            return false;
        }
        return true;
    }

    public function getDistance(): float
    {
        if ($this->hasLocation()) {
            return $this->location->getDistance();
        } else {
            return 10000.0;
        }
    }

    public function getMilanoClass(): string
    {
        $ret = '';
        if ($this->hasLocation()) {
          $ret = $this->location->getMilanoClass();
        }
        return $ret;
    }

    public function getNsweClass(): string
    {
        if ($this->hasLocation()) {
            return $this->location->getNsweClass();
        }
    }
}
?>

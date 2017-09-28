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

  public function getLocationHtml(): string
  {
    $loc_description = $this->location->getDescription();
    $loc_html = '';

    if(isset($loc_description) and $loc_description != '')
    {
      $gMap=sprintf(self::$gMapsMask,$this->name . ' ' . $loc_description);
      $loc_html=sprintf(self::$locationCode,$gMap,$loc_description);
    }

    return $loc_html;
  }

  private function getLinkHtml(): string
  {
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
}
?>

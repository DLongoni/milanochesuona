<?php
class Event
{
  // Parametri:
  // link
  // picture
  // title
  // hour 
  // venue link
  // venue name
  // venue address
  // description
  // venue link
  // venue name
  // band link
  // band name
  private static $htmlMask='
    <div class="card m-2">
      <div style="max-height:300px;overflow:hidden">
        <a href="%s" target="_blank">
          <img class="card-img-top" src="%s" alt="Event picture (supposedly)">
        </a>
      </div>
      <div class="card-block p-2">
        <h4 class="card-title">%s</h4>
        <p class="card-text mb-0"><strong>%s - <a href="%s" class="card-link">%s</a> </strong></p>
        %s
        <div class="toolong"><p class="card-text">%s</p></div>
        %s
        %s
      </div>
  </div>
  ';
  private static $linkCode = '<a href="%s" class="card-link">%s</a>';
  private static $locationCode = '<p class="card-text"><small class="text-muted">%s</small></p>';
  private static $fbMask='https://facebook.com/%s';

  public $id;
  public $fbId;
  public $title;
  public $startTime;
  public $endTime;
  public $venue;
  public $link;
  public $picture;
  public $description;
  public $htmlDescription;
  public $statusId; // scelgo di lasciare solo ID senza nestare l'oggetto
  public $cost;
  public $bands;

  public function getHtml()
  {
    $ret=sprintf(self::$htmlMask,
      $this->link,
      $this->picture,
      $this->title,
      date_format(date_create($this->startTime),"H:i"),
      $this->venue->website,
      $this->venue->name,
      $this->getLocationInfo(),
      $this->description,
      $this->getVenueLink(),
      $this->getBandLink()
    );
    return $ret;
  }

  private function getBandLink()
  {
    $bandLink = '';
    if(isset($this->bands) and isset($this->bands[0]->website) and 
      filter_var($this->bands[0]->website,FILTER_VALIDATE_URL)) 
    {
      $l = $this->bands[0]->website;
    }
    elseif(isset($this->bands) and isset($this->bands[0]->fbId) )
    {
      $l = sprintf(self::$fbMask,$this->bands[0]->fbId);
    }
    if(isset($l))
    {
      $bandLink=sprintf(self::$linkCode,$l,$this->bands[0]->name);
    }
    return $bandLink; 
  }

  private function getVenueLink()
  {
    $venueLink = '';
    if(isset($this->venue) and isset($this->venue->website) and 
      filter_var($this->venue->website,FILTER_VALIDATE_URL)) 
    {
      $l = $this->venue->website;
    }
    elseif(isset($this->venue) and isset($this->venue->fbId) )
    {
      $l = sprintf(self::$fbMask,$this->venue->fbId);
    }
    if(isset($l))
    {
      $venueLink=sprintf(self::$linkCode,$l,$this->venue->name);
    }
    return $venueLink;
  }

  private function getLocationInfo()
  {
    $loc = $this->venue->location;
    $loc_info = '';
    if(isset($loc))
    {
      if(isset($loc->street) and isset($loc->city))
      {
        $loc_info = sprintf('%s, %s',$loc->street,$loc->city);
      }
      elseif(isset($loc->street))
      {
        $loc_info = $loc->street;
      }
      elseif(isset($loc->city))
      {
        $loc_info = $loc->city;
      }
    }
    if(isset($loc_info))
    {
      $loc_info=sprintf(self::$locationCode,$loc_info);
    }
    return $loc_info;
  }
}
?>

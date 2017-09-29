<?php
class Event
{
  private static $htmlMask='
    <div class="grid-item p-2">
      <div class="card">
        <div style="max-height:300px;overflow:hidden">
          <a href="%s" target="_blank">
            <img class="card-img-top" src="%s" alt="Event picture (supposedly)">
          </a>
        </div>
        <div class="card-header p-2 m-0">
          <h5 class="card-title p-0 m-0 text-center">%s</h5>
        </div>
        <div class="card-block px-2 py-1 my-0">
          <p class="card-text mb-0"><strong>%s - <a href="%s" class="card-link mb-0">%s</a> </strong></p>
          %s
        </div>
        <div class="card-block px-2 pt-0 pb-2 my-0 border border-bottom-0 border-right-0 border-left-0">
          <div class="toolong small text-justify mt-2">%s</div>
          %s
        </div>
      </div>
    </div>
  ';

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

  public function getHtml(): string
  {
    $ret=sprintf(self::$htmlMask,
      $this->link,
      $this->picture,
      $this->title,
      date_format(date_create($this->startTime),"H:i"),
      $this->venue->getLink(),
      $this->venue->name,
      $this->getLocationHtml(),
      $this->description,
      $this->getBandHtml()
    );
    return $ret;
  }

  private function getBandHtml(): string
  {
    $band_link = '';
    if(isset($this->bands) and isset($this->bands[0]))
      $band_link = $this->bands[0]->getLinkHtml();

    return $band_link; 
  }

  private function getVenueHtml(): string
  {
    $venue_link = '';
    if(isset($this->venue))
      $venue_link = $this->venue->getLinkHtml();

    return $venue_link;
  }

  private function getLocationHtml(): string
  {
    $loc_info = '';
    if(isset($this->venue))
      $loc_info = $this->venue->getLocationHtml();

    return $loc_info;
  }
}
?>

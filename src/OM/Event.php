<?php
class Event
{
  private static $htmlMask='
    <div class="grid-item p-2 %s %s">
      <div class="card">
        <div class="border border-top-0 border-right-0 border-left-0 bg-secondary">
          <a href="%s" target="_blank">
            <img class="card-img-top mx-auto d-block" style="max-height:200px;width:auto;max-width:100%;" src="%s" alt="Event picture (supposedly)">
          </a>
        </div>
        <div class="card-header p-2 m-0">
          <h5 class="card-title p-0 m-0 text-center">%s</h5>
        </div>
        <div class="card-block px-2 pt-1 my-0">
          <p class="card-text mb-0">%s - %s</p>
          %s
        </div>
        <div class="card-block px-2 pt-0 pb-2 border border-bottom-0 border-right-0 border-left-0 collapse">
          <div class="small text-justify mt-2 mb-1">%s</div>
          %s
        </div>
        <div class="card-footer m-0 p-0">
          <button class="btn btn-light text-small text-muted btn-sm btn-block p-0 m-0" style="font-size:0.6em" type="button" >&#9661</button>
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
    if (!isset($this->venue) or !$this->venue->hasLocation()){
      return "";
    }
    $ret=sprintf(self::$htmlMask,
      $this->GetMilanoClass(),
      $this->GetNsweClass(),
      $this->link,
      $this->picture,
      $this->title,
      date_format(date_create($this->startTime),"H:i"),
      $this->venue->getLinkHtml(),
      $this->getLocationHtml(),
      $this->description,
      $this->getBandHtml()
    );
    return $ret;
  }

  private function getBandHtml(): string {
    $band_link = '';
    if(isset($this->bands) and isset($this->bands[0]))
      foreach($this->bands as $b)
      {
        $band_link = $band_link . $b->getLinkHtml();
      }

    return $band_link; 
  }

  private function getVenueHtml(): string {
    $venue_link = '';
    if(isset($this->venue))
      $venue_link = $this->venue->getLinkHtml();

    return $venue_link;
  }

  private function getLocationHtml(): string {
    $loc_info = '';
    if(isset($this->venue))
      $loc_info = $this->venue->getLocationHtml();

    return $loc_info;
  }

  private function getMilanoClass(): string { 
    return $this->venue->getMilanoClass(); 
  }

  private function getNsweClass(): string { 
    return $this->venue->getNsweClass(); 
  }
}
?>

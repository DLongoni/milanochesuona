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
    <div class="card">
      <a href="%s" target="_blank">
        <img class="card-img-top img-fluid" src="%s" alt="Event picture (supposedly)">
      </a>
      <div class="card-block">
        <h4 class="card-title">%s</h4>
        <p class="card-text"><strong>%s - <a href="%s" class="card-link">%s</a> </strong></p>
        <p class="card-text"><small class="text-muted">%s</small></p>
        <p class="card-text">%s</p>
        <a href="%s" class="card-link">%s</a>
        <a href="%s" class="card-link">%s</a>
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

  public function getHtml()
  {
    $ret=sprintf(self::$htmlMask,
      $this->link,
      $this->picture,
      $this->title,
      date_format(date_create($this->startTime),"H:i"),
      $this->venue->website,
      $this->venue->name,
      $this->venue->location->street,
      $this->description,
      $this->venue->website,
      $this->venue->name,
      $this->bands[0]->website, //TODO: extend to multiple bands
      $this->bands[0]->name
    );
    return $ret;
  }
}
?>

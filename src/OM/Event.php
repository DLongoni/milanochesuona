<?php
class Event
{
    private static $_htmlMask='
    <div class="grid-item p-1 %s %s" d=%s>
      <div class="card">
        <div class="" style="max-height:200px;overflow:hidden">
          <img class="card-img-top mx-auto d-block txt-c in-click" 
                style="max-width:100%%;" t-link="%s" src="%s" 
                alt="Pagina del concerto"></img>
          <a class="btnClose d-md-block d-none">&times;</a>
        </div>
        <div class="card-header txt-d p-2 m-0">
          <h6 class="card-title p-0 m-0 text-center">%s</h6>
        </div>
        <div class="card-block px-2 pt-1 my-0">
          <p class="card-text mb-0 oraluogo"><span class="txt-d">%s</span> - %s</p>
          %s
        </div>
        <div class="card-block px-2 pt-0 pb-2 collapse">
          <div class="small text-justify mt-2 mb-1">%s</div>
          %s
        </div>
        <div class="card-footer text-center m-0 p-0">&#9661</div>
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
        if (!isset($this->venue) or !$this->venue->hasLocation()) {
            return "";
        }
        $ret=sprintf(
            self::$_htmlMask,
            $this->_getMilanoClass(),
            $this->_getNsweClass(),
            round($this->venue->getDistance(), 2),
            $this->link,
            // $this->picture,
            $this->_getPicPath(),
            $this->title,
            date_format(date_create($this->startTime), "H:i"),
            $this->venue->getLinkHtml(),
            $this->_getLocationHtml(),
            $this->description,
            $this->_getBandHtml()
        );
        return $ret;
    }

    private function _getBandHtml(): string
    {
        $band_link = '';
        if (isset($this->bands) and isset($this->bands[0])) {
            foreach ($this->bands as $b) {
                $band_link = $band_link . $b->getLinkHtml();
            }
        }

        return $band_link; 
    }

    private function _getVenueHtml(): string
    {
        $venue_link = '';
        if (isset($this->venue)) {
            $venue_link = $this->venue->getLinkHtml();
        }

        return $venue_link;
    }

    private function _getLocationHtml(): string
    {
        $loc_info = '';
        if (isset($this->venue)) {
            $loc_info = $this->venue->getLocationHtml();
        }

        return $loc_info;
    }

    private function _getMilanoClass(): string
    { 
        return $this->venue->getMilanoClass(); 
    }

    private function _getNsweClass(): string
    { 
        return $this->venue->getNsweClass(); 
    }

    private function _getPicPath(): string
    {
        return '/EventPictures/' . $this->fbId . '.jpg';
    }
}
?>

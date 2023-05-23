<?php
class Event
{
    private static $_fbMask='https://facebook.com/events/%s';
    private static $_diceMask='https://dice.fm/event/%s';
    private static $_costMask='<div class="pb-0"><small class="text-dark font-weight-bold">%s€</small></div>';

    private static $_htmlMask='
    <div class="grid-item p-1 %s %s" d=%s>
      <div class="card">
        <div class="d-flex align-items-center" style="max-height:250px;overflow:hidden">
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
    public $providerId;
    public $bands;

    public function getHtml(): string
    {
        if (!(isset($this->venue) or isset($this->location))) {
            return "";
        }
        $ret=sprintf(
            self::$_htmlMask,
            $this->_getMilanoClass(),
            $this->_getNsweClass(),
            round($this->_getDistance(), 2),
            $this->_getLink(),
            $this->_getPicPath(),
            $this->title,
            date_format(date_create($this->startTime), "H:i"),
            $this->_getPlaceHtml(),
            $this->_getLocationHtml(),
            $this->_getCostHtml(),
            $this->description,
            $this->_getBandHtml()
        );
        return $ret;
    }

    private function _getDistance(): string
    { 
        if (isset($this->venue)) {
            return $this->venue->getDistance(); 
        } elseif (isset($this->location)) {
            return $this->location->getDistance(); 
        }
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

    private function _getPlaceHtml(): string
    {
        $pl_html = '';
        if (isset($this->venue)) {
            $pl_html = $this->venue->getLinkHtml();
        } elseif (isset($this->location)) {
            $pl_html = $this->location->getLinkHtml();
        }
        return $pl_html;
    }

    private function _getVenueHtml(): string
    {
        return $venue_link;
    }

    private function _getLocationHtml(): string
    {
        $loc_info = '';
        if (isset($this->venue)) {
            $loc_info = $this->venue->getLocationHtml();
        } elseif (isset($this->location)) {
            $loc_info = $this->location->getHtml();
        }
        return $loc_info;
    }
    private function _getCostHtml(): string
    {
        $ret = '';
        if (isset($this->cost)) {
          if ($this->cost != 0) {
            return sprintf(self::$_costMask, $this->cost);
          }
        }
        return $ret;
    }

    private function _getMilanoClass(): string
    { 
        if (isset($this->venue)) {
            return $this->venue->getMilanoClass(); 
        } elseif (isset($this->location)) {
            return $this->location->getMilanoClass(); 
        }
    }

    private function _getNsweClass(): string
    { 
        if (isset($this->venue)) {
            return $this->venue->getNsweClass(); 
        } elseif (isset($this->location)) {
            return $this->location->getNsweClass(); 
        }
    }

    private function _getLink(): string
    {
      $ret = '';
      if (isset($this->link))  { 
          $ret = $this->link; 
      } elseif($this->providerId == 1) {
          $ret = sprintf(self::$_fbMask, $this->fbId);
      } elseif($this->providerId == 2) {
          $ret = sprintf(self::$_diceMask, $this->diceId);
      }
      return $ret;
    }

    private function _getPicPath(): string
    {
      $fname = '';
      if($this->providerId == 1) {
          $fname = sprintf('F%s', $this->fbId);
      } elseif($this->providerId == 2) {
          $fname = sprintf('D%s', $this->diceId);
      }
      return '/EventPictures/' . $fname . '.jpg';
    }
}
?>

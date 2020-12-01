<?php
class Band
{
    private static $_linkCode = '<a href="%s" target="_blank" 
        class="btn btn-mute btn-sm py-0 mt-0 mx-1" 
        style="white-space:normal;">%s</a>';
    private static $_fbMask='https://facebook.com/%s';

    public $id;
    public $fbId;
    public $name;
    public $fbPage;
    public $website;
    public $logo;
    public $picture;
    public $description;
    public $email;

    public function getLinkHtml(): string
    {
        $band_link = '';
        if(isset($this->website) 
            and filter_var($this->website, FILTER_VALIDATE_URL)
        ) : $l = $this->website;
      elseif(isset($this->fbId)) :
          $l = sprintf(self::$_fbMask, $this->fbId);
      endif;

      if (isset($l)) {
          $band_link=sprintf(self::$_linkCode, $l, $this->name);
      }

      return $band_link;
    }
}
?>

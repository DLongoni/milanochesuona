<?php
class Band
{
  private static $linkCode = '<a href="%s" target="_blank" class="btn btn-secondary py-1 px-2">%s</a>';
  private static $fbMask='https://facebook.com/%s';

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
    if(isset($this->website) and filter_var($this->website,FILTER_VALIDATE_URL)): 
      $l = $this->website;
    elseif(isset($this->fbId)):
      $l = sprintf(self::$fbMask,$this->fbId);
    endif;

    if(isset($l))
      $band_link=sprintf(self::$linkCode,$l,$this->name);

    return $band_link;
  }
}
?>

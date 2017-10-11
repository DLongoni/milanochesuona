<?php

require_once __DIR__ . '/OM/Location.php';
require_once __DIR__ . '/REP/RepEvent.php';
require_once __DIR__ . '/REP/RepVenue.php';
require_once __DIR__ . '/DbConn.php';

$rep=new RepEvent();

$eI = new Event();
$bArr=array();
$bArr[]=RepBand::getByName("Boz Trio");
$eI->bands=$bArr;
// RepEvent::add($eI);

$eO=RepEvent::getList();

$V=RepVenue::getById(23);

foreach ($eO as $e)
{
  if ($e-> id == 190):
    var_dump($e->getHtml());
  endif;
}
?>

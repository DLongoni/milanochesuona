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

$V=RepVenue::getById(39);
var_dump($V->name);
var_dump($V->location->latitude);
var_dump($V->location->longitude);
var_dump($V->getDistance());
foreach ($eO as $e)
{
  if ($e-> id == 359):
    // var_dump($e->getHtml());
    // var_dump($e->description);
  endif;
}
?>

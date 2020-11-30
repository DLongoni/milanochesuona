<?php

require_once __DIR__ . '/OM/Location.php';
require_once __DIR__ . '/REP/RepEvent.php';
require_once __DIR__ . '/REP/RepVenue.php';
require_once __DIR__ . '/REP/RepUserSubmissions.php';
require_once __DIR__ . '/DbConn.php';


$eI = new Event();
$bArr=array();
// $bArr[]=RepBand::getByName("Boz Trio");
$eI->bands=$bArr;

// $V=RepVenue::getById(39);
$e=RepEvent::getById(11634);
// var_dump($e->title);
var_dump($e->title);
var_dump($e->venue->hasLocation());
var_dump($e->getHtml());
$inDt = date_create_from_format('d/m/Y','10/10/2018');
$inDt = date_format($inDt,"j-M-Y");
$eList=RepEvent::getByDate($inDt);
foreach ($eList as $e)
{
    // var_dump("******************************");
    // var_dump($e->getHtml());
    // var_dump($e->title);
    // var_dump($e->id);
}

// RepUserSubmissions::reject(1);
// $l=RepUserSubmissions::getList();
// $V = RepVenue::getByFbLink('cascinamart');
// var_dump($V);
// foreach ($l as $e)
// {
//   print_r($matches);
// }

?>

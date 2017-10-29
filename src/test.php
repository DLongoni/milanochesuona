<?php

require_once __DIR__ . '/OM/Location.php';
require_once __DIR__ . '/REP/RepEvent.php';
require_once __DIR__ . '/REP/RepVenue.php';
require_once __DIR__ . '/REP/RepUserSubmissions.php';
require_once __DIR__ . '/DbConn.php';


$eI = new Event();
$bArr=array();
$bArr[]=RepBand::getByName("Boz Trio");
$eI->bands=$bArr;

// $V=RepVenue::getById(39);
$e=RepEvent::getById(724);
// var_dump($e->title);
var_dump($e->getHtml());
// foreach ($eO as $e)
// {
//   if ($e-> id == 725):
//     var_dump($e->getHtml());
//     // var_dump($e->description);
//   endif;
// }

// RepUserSubmissions::reject(1);
$l=RepUserSubmissions::getList();
$V = RepVenue::getByFbLink('cascinamart');
var_dump($V);
// foreach ($l as $e)
// {
//   print_r($matches);
// }

?>

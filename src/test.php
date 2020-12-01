<?php

require_once __DIR__ . '/OM/Location.php';
require_once __DIR__ . '/REP/RepEvent.php';
require_once __DIR__ . '/REP/RepLocation.php';
require_once __DIR__ . '/REP/RepVenue.php';
require_once __DIR__ . '/REP/RepBand.php';
require_once __DIR__ . '/REP/RepUserSubmissions.php';
require_once __DIR__ . '/DbConn.php';

$a=(2==3);
if ($a) { print("pre"); 
} 
if (!$a) { $a=1==1;
}
if ($a) {
    print("post");
}

$eI = new Event();
$bArr=array();
// $bArr[]=RepBand::getByName("Boz Trio");
$eI->bands=$bArr;

$eb=RepLocation::getById(2);
var_dump($eb);

// $V=RepVenue::getById(39);
$e=RepEvent::getById(11634);
// var_dump($e->title);
var_dump($e->title);
var_dump($e->venue->hasLocation());
var_dump($e->getHtml());
// $inDt = date_create_from_format('d/m/Y','10/10/2018');
// $inDt = date_format($inDt,"j-M-Y");
$eList=RepEvent::getByDate("20-jan-2019");
var_dump(count($eList));
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

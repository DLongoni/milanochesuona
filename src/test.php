<?php

require_once __DIR__ . '/OM/Location.php';
require_once __DIR__ . '/REP/RepEvent.php';
require_once __DIR__ . '/DbConn.php';

$conn = GetConn();
if (!($res = $conn->query("CALL VenueGetList()"))) {
  echo "CALL failed: (" . $conn->errno . ") " . $conn->error;
}
$rep=new RepEvent();

$eI = new Event();
$eI->description="A settembre si ricomincia, e anche noi possiamo dare una mano a ricostruire quanto è andato distrutto e perduto.;

Insieme agli amici del Boz Trio, che suoneranno dalle 19.30, un concerto per aiutare le vittime del terremoto in centro Italia.

  L'intero incasso della serata sarà devoluto alla campagna #unaiutosubito promossa da TIM, Il Corriere della Sera, TgLa7 e Starteed. 

  www.unaiutosubito.org/it/terremotocentroitalia2016";
$eI->title="Colibrì Live per il Centro Italia";
$eI->endTime=date_create("2016-09-13T23:59:00+0200");
$eI->startTime=date_create("2016-09-13T18:30:00+0200");
$eI->fbId=1653900074921905;
$eI->venue=RepVenue::getById(1);
$eI->link="https://facebook.com/" . $eI->fbId;
$eI->statusId=1;
$bArr=array();
$bArr[]=RepBand::getByName("Boz Trio");
$eI->bands=$bArr;
// RepEvent::add($eI);

$eO=RepEvent::getByDate('13-sep-2016')[0];
var_dump($eO->getHtml());
?>

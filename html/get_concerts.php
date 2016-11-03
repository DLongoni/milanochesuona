<?php
require_once __DIR__ . '/../src/REP/RepEvent.php';
$rep=new RepEvent();
$inDt = date_create_from_format('d/m/Y',$_REQUEST['date']);
$inDt = date_format($inDt,"j-M-Y");
$eO=RepEvent::getByDate($inDt)[0];
if ($eO != NULL){
  echo($eO->getHtml());
}
?>

<?php
require_once __DIR__ . '/../src/REP/RepEvent.php';
$rep=new RepEvent();
$inDt = date_create_from_format('d/m/Y',$_REQUEST['date']);
$inDt = date_format($inDt,"j-M-Y");
$eList=RepEvent::getByDate($inDt);
$eArray=array();
foreach ($eList as $e){
  // array_push($eArray,$e->getHtml());
  $eArray[] = $e->getHtml();
  // echo($e->getHtml());
}
echo json_encode($eArray);
?>

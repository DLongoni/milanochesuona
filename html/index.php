<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>MilanoCheSuona</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.3/css/bootstrap.min.css" integrity="sha384-MIwDKRSSImVFAZCVLtU0LMDdON6KVCrZHyVQQj6e8wIEJkW4tvwqXrbMIya1vriY" crossorigin="anonymous">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
  </head>
  <body style="padding:2em">
    <div class="container">
      <div class="header">
        <h1 class="text-md-center">MilanoCheSuona</h1> 
        <p class="text-md-center text-muted">solo musica dal vivo</p> 
        <!-- <button type="button" class="btn btn btn&#45;primary pull&#45;md&#45;right">Segnala concerto</button>   -->
      </div>
      <hr>
      <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
          <div class="input-group text-md-center"> 
            <span class="input-group-btn">
              <button id="btnPrev" type="button"  class="btn btn-secondary"><strong>&lt;</strong></button>
            </span>
            <input type="text" id="txtDatePicker" class="form-control text-md-center input-large"></input>
            <span class="input-group-btn">
              <button id="btnNext" type="button" class="btn btn-secondary"><strong>&gt;</strong></button>    
            </span>
          </div>
        </div>
        <div class="col-md-4"></div>
      </div>
    </div>
    <div id="divConcerts" class="container m-t-2">
<?php
// require_once __DIR__ . '/../src/REP/RepEvent.php';
// $rep=new RepEvent();
// $eO=RepEvent::getByDate('13-sep-2016')[0];
// echo($eO->getHtml());
?>
</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js" integrity="sha384-THPy051/pYDQGanwU6poAc/hOdQxjnOEXzbT+OuUAFqNqFjL+4IGLBgCJC3ZOShY" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js" integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.3/js/bootstrap.min.js" integrity="sha384-ux8v3A6CPtOTqOzMKiuo3d/DomGaaClxFYdCu2HPMBEkf6x2xiDyJ7gkXU0MWwaD" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script src="https://kswedberg.github.io/jquery-expander/jquery.expander.js"></script>
<script>
$(document).ready(
  function() {
    $( "#txtDatePicker" ).datepicker(
  {minDate: 0,
  dateFormat: "dd/mm/yy",
  showOtherMonths: true,
  selectOtherMonths: true,
  showAnim: 'slideDown',
defaultDate: '0',
onSelect: function(dtTxt){
  loadConcerts(dtTxt);
}
  }).datepicker('setDate', new Date()); // to select today as default

    $("#btnNext").click(function () {
      var selDt = $('#txtDatePicker').datepicker("getDate");
      selDt.setDate(selDt.getDate()+1);
      $('#txtDatePicker').datepicker("setDate", selDt);
      loadConcerts($('#txtDatePicker').datepicker().val());
    });

    $("#btnPrev").click(function () {
      var selDt = $('#txtDatePicker').datepicker("getDate");
      selDt.setDate(selDt.getDate()-1);
      $('#txtDatePicker').datepicker("setDate", selDt);
      loadConcerts($('#txtDatePicker').datepicker().val());
    });
    // $("#divConcerts").load("concertsColumns.html");
    // $("#divConcerts").load("concertsCardColumns.html");
  } );

function loadConcerts(dt) {
  $.ajax({
  url:"/get_concerts.php",
    data:"date="+dt,
    type:"POST",
    success:function(data){
      $("#divConcerts").html(data);},
        error:function(xhr,ajaxOptions,thrownError){
          alert(xhr.status);
          alert(thrownError);
        }
});
}
</script>
  </body>
</html>

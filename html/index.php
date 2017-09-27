<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>MilanoCheSuona</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
    <style>
      #grid[data-columns]::before {
        content: '3 .column.size-1of3';
      }

      /* These are the classes that are going to be applied: */
      .column { float: left; }
      .size-1of3 { width: 33.333%; }
    </style>
  </head>
  <body style="padding:2em">
    <div class="container">
      <div class="header">
        <h1 class="text-md-center">MilanoCheSuona</h1> 
        <p class="text-md-center text-muted">solo musica dal vivo</p> 
        <p class="text-md-center text-danger small">VERSIONE PROGETTO IN ALPHA TESTING</p> 
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
    <div id="grid" data-columns>
    </div>
<?php
// require_once __DIR__ . '/../src/REP/RepEvent.php';
// $rep=new RepEvent();
// $eO=RepEvent::getByDate('13-sep-2016')[0];
// echo($eO->getHtml());
?>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js" integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
    <script src="https://kswedberg.github.io/jquery-expander/jquery.expander.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/salvattore/1.0.9/salvattore.min.js"></script>
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
  } );

function loadConcerts(dt) {
  $.ajax({
  url:"/get_concerts.php",
    data:"date="+dt,
    type:"POST",
    success:function(data){
      var cards = jQuery.parseJSON(data);
      var grid = document.getElementById('grid');
      grid.innerHTML='';
      salvattore.registerGrid(grid);
      salvattore.recreateColumns(grid);
      jQuery.each(cards, function(index,value){
        var item = document.createElement('div');
        salvattore['append_elements'](grid, [item]);
        item.outerHTML = value;
      });

      $('.toolong').expander({
      slicePoint: 200,
        preserveWords: true,
        widow: 10,
        expandEffect: 'fadeIn',
        collapseEffect: 'fadeOut',
        expandText: ' leggi tutto',
        expandPrefix: '...',
        userCollapsePrefix: ' ',
        userCollapseText: ' leggi meno'
      });
      $('.toolong').expander().removeClass('js-toolong-hidden');
    },
    error:function(xhr,ajaxOptions,thrownError){
      alert(xhr.status);
      alert(thrownError);
    }
});
}

</script>
  </body>
</html>

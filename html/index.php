<!DOCTYPE html>
<html lang="en">
  <!-- HEAD {{{ -->
  <head> 
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>MilanoCheSuona</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href='./lib/mcs.css'>

  </head> 
  <!-- }}} -->

  <!-- BODY {{{ -->
  <body style="padding:2em">
    <div class="container">
      <div class="header">
        <h1 class="text-md-center">MilanoCheSuona</h1> 
        <p class="text-md-center text-muted">solo musica dal vivo</p> 
        <p class="text-md-center text-danger small">VERSIONE PROGETTO IN ALPHA TESTING</p> 
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
      <div id="grid"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js" integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
    <script src="https://kswedberg.github.io/jquery-expander/jquery.expander.js"></script>
    <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
    <script src="./lib/mcs.js"></script>
  </body>
  <!-- }}} -->
</html>

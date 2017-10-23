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
    <link rel="stylesheet" href='./lib/mcs.css?v=4'>
  </head> 
  <!-- }}} -->

  <!-- BODY {{{ -->
  <body>
    <div class="container mt-md-2">
      <div class="header">
        <h1 class="text-center mb-md-1 mb-0">MilanoCheSuona</h1> 
        <p class="text-center text-muted mt-0 pt-0 mb-0 mb-md-3">solo musica dal vivo</p> 
      </div>
      <div class="row">
        <div class="col-lg-3 col-md-2"></div>
        <div class="col-lg-6 col-md-8 mb-0 mb-md-3 alert alert-secondary mx-1">
          <div class = "row m-0 p-0">
            <div class="col-1 col-md-2"></div>
            <div class="col-10 col-md-8">
              <div class="input-group text-center"> 
                <span class="input-group-btn">
                  <button id="btnPrev" type="button" class="btn btn-secondary"><strong>&lt;</strong></button>
                </span>
                <input type="text" id="txtDatePicker" class="form-control text-center input-large"></input>
                <span class="input-group-btn">
                  <button id="btnNext" type="button" class="btn btn-secondary"><strong>&gt;</strong></button>    
                </span>
              </div>
            </div>
          </div>
          <div id="divFilters" class="text-center">
            <div id="divMilanoHinterland" class="btn-group mt-1"> 
              <button id="btnMilano" type="button" class="btn btn-sm btn-dark">Milano</button>
              <button id="btnHinterland" type="button" class="btn btn-sm btn-dark">Hinterland</button>
            </div>
            <div id="divNswe" class="btn-group mt-1"> 
              <button id="btnNord" type="button" class="btn btn-sm btn-secondary">N</button>
              <button id="btnSud" type="button" class="btn btn-sm btn-secondary">S</button>
              <button id="btnOvest" type="button" class="btn btn-sm btn-secondary">W</button>
              <button id="btnEst" type="button" class="btn btn-sm btn-secondary">E</button>
            </div>
          <div id="divSort" class="btn-group ml-md-2 mt-1"> 
            <button id="btnSortd" type="button" class="btn btn-sm btn-dark">Distanza &#8593</button>
            <button id="btnSorto" type="button" class="btn btn-sm btn-secondary">Orario &#8593</button>
          </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-2"></div>
      </div>
      <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10 p-0">
          <div id="grid"></div>
        </div>
        <div class="col-md-1"></div>
        <div id="divLoadingOuter" class="row text-center pt-5">
          <div id = "divLoadingInner">
            <img src="./img/load2.gif" style="max-width:60px">
          </div>
        </div>
      </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js" integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
   <script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>   <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
    <script type="text/javascript" src="lib/jquery.touchSwipe.min.js"></script>
    <script src="./lib/mcs.js?5"></script>
  </body>
  <!-- }}} -->
</html>

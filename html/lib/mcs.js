// {{{ REGION: Definitions
$grid = $('#grid');
$datePicker = $('#txtDatePicker');
locFilters = [];
milanoHinterland = [1,1];
// }}}

$(document).ready(
    function() {
      // {{{ REGION: Date Picker
      $datePicker.datepicker(
          {minDate: 0,
            dateFormat: "D dd/mm/yy",
            showOtherMonths: true,
            selectOtherMonths: true,
            showAnim: 'slideDown',
            defaultDate: '0',
            dayNamesShort:["Dom","Lun","Mar","Mer","Gio","Ven","Sab"],
            onSelect: function(dtTxt){
              loadConcerts(dtTxt);
            }
          }).datepicker('setDate', new Date()); // to select today as default

      $("#btnNext").click(function () {
        var selDt = $datePicker.datepicker("getDate");
        selDt.setDate(selDt.getDate()+1);
        $datePicker.datepicker("setDate", selDt);
        loadConcerts($datePicker.datepicker().val());
      });

      $("#btnPrev").click(function () {
        var selDt = $datePicker.datepicker("getDate");
        selDt.setDate(selDt.getDate()-1);
        $datePicker.datepicker("setDate", selDt);
        loadConcerts($datePicker.datepicker().val());
      });
      // }}}

      // {{{ REGION: Load Concerts
      function loadConcerts(dt) {
        dt = dt.substring(4); // delete day name
        $.ajax({
          url:"/../get_concerts.php",
          data:"date="+dt,
          type:"POST",
          success:function(data){
            $grid.isotope('remove',$grid.isotope('getItemElements'));
            var $data_obj=$(data);
            $grid.append($data_obj).isotope('appended',$data_obj);

            $grid.imagesLoaded().progress( function() {
            $grid.isotope({sort:'dist'});
            });
          },
          error:function(xhr,ajaxOptions,thrownError){
            // Uncomment only for debugging purposes
            // alert(xhr.status);
            // alert(thrownError);
            alert('Errore imprevisto nel caricamento dati.');
          }
        });
      }
      // }}}

      // {{{ REGION: Collapse
      $grid.on('shown.bs.collapse',function(){$grid.isotope()});
      $grid.on('hidden.bs.collapse',function(){$grid.isotope()});

      $grid.on('click','.card-footer .btn',function(event){
        $(this).parents().eq(1).find('.collapse').collapse('toggle');
        if($(this).html()=='\u25BD'){ $(this).html('\u25B3'); }
        else{ $(this).html('\u25BD'); }
      });
      // }}}

      // {{{ REGION: Initializations
      setFiltersFromCookies();

      $grid.isotope({
        // options
        itemSelector: '.grid-item',
        transitionDuration: '0.2s',
        layoutMode: 'masonry',
        masonry:{
          horizontalOrder:true,
          gutter:0
        },
        filter: function(){
          var isMatched = true;
          var $this = $(this); // Check all the functions in filterFunctions
          for(var i=0;i<filterFunctions.length;i++){
            if (!filterFunctions[i]($this)){
              return false;
            }
          }
          return true;
        },
        getSortData: { dist: function(elem){ // sort by distance from the center
          var e = $(elem).attr('d');
          if (e===undefined) {
            return 10000.0;
          }
          return parseFloat(e);
        }
        },
        sortBy: 'dist'
      });

      loadConcerts($datePicker.datepicker().val());
      // }}}
    } );

// {{{ REGION: Filters

var filterFunctions = [
  function(elem) { // check milano
    if((milanoHinterland[0] && elem.hasClass('milano')) ||
        (milanoHinterland[1] && !elem.hasClass('milano'))) {
      return true; }
    else
    { return false; }
  },
  function(elem) { //check loc
    if(locFilters.length ==0){return true;}
    for(var i=0;i<locFilters.length;i++){
      if( elem.hasClass('loc-' + locFilters[i]) ){
        return true;
      }
    }
    return false;
  }
]

// Clic button Nswe -> set filter array and re-isotope
$('#divNswe').on('click','button',function(event){
  $target = $(event.currentTarget);
  var isUnChecked = toggleClassAndIsChecked($target);
  var f = $target.html().toLowerCase();
  if (isChecked) {addLocFilter(f);}
  else {removeLocFilter(f);}
  $grid.isotope();
});

// Clic button Mh -> set filter array and re-isotope
$('#divMilanoHinterland').on('click','button',function(event){
  $target = $(event.currentTarget);
  var isChecked = toggleClassAndIsChecked($target);
  if (isChecked) {var v = 1}
  else {var v = 0}
  if ($target.html() == "Milano"){
    milanoHinterland[0] = v;
  }
  else{
    milanoHinterland[1] = v;
  }
  $grid.isotope();
});

function addLocFilter(filter) { // location filter add
  if (locFilters.indexOf(filter)==-1)
  { locFilters.push(filter); }
}

function removeLocFilter(filter) { // location filter del
  var id = locFilters.indexOf(filter);
  if (id !=-1)
  { locFilters.splice(id,1); }
}

// toggle class and return whether is checked or not
function toggleClassAndIsChecked($target){
  if($target.hasClass('btn-dark')) { deSelectBtn($target); }
  else { selectBtn($target); }
  var isChecked = $target.hasClass('btn-dark');
  return isChecked;
}

function deSelectBtn($b){
  $b.removeClass('btn-dark').addClass('btn-secondary');
}

function selectBtn($b){
  $b.removeClass('btn-secondary').addClass('btn-dark');
}
// }}}

// {{{ REGION: Cookies
function setFilterCookies() {
  var d = new Date();
  d.setTime(d.getTime() + (365 * 24 * 60 * 60 * 1000));
  var expires = "expires="+d.toUTCString();
  // cookie will be locFilters|mhFilters
  var filtersStr = locFilters.join(",") + "|" + milanoHinterland.join(",");
  document.cookie = "filters=" + filtersStr + ";" + expires + ";path=/";
}

function setFiltersFromCookies(){
  var name = "filters=";
  var filterC = "";
  var ca = document.cookie.split(';');
  for(var i = 0; i < ca.length; i++) { // Get filters cookie val
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      filterC = c.substring(name.length, c.length);
    }
  } 
  if (filterC != ""){
    filtersArr = filterC.split("|");
    locFilterC = filtersArr[0].split(",");
    mhFilterC  = filtersArr[1].split(",");
    if (locFilterC.length >0){ // Set loc filters
      locFilters = locFilterC;
      setNsweClasses();
    }
    if (mhFilterC.length >0){ // Set mh filters
      milanoHinterland = mhFilterC;
      setMhClasses();
    }
  }
}

function setNsweClasses(){
  for(var i = 0 ;i<locFilters.length;i++){
    $('#divNswe').children('button').each(function(){
      if ($(this).html().toLowerCase()==locFilters[i]){
        selectBtn($(this));
      }
    });
  }
}

function setMhClasses(){
  if(milanoHinterland[0]==0){
    deSelectBtn($('#divMilanoHinterland #btnMilano'));
  }
  if(milanoHinterland[1]==0){
    deSelectBtn($('#divMilanoHinterland #btnHinterland'));
  }
}
// }}}

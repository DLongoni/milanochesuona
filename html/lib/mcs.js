// {{{ REGION: Definitions
$grid = $('#grid');
$datePicker = $('#txtDatePicker');
var sort = 'da';
var $loadingOverlay = $('.overlay');

locFilters = [];
milanoHinterland = [1,1];
// }}}

// {{{ REGION: Loader
$(document)
  .ajaxStart(function () {
    $loadingOverlay.show();
  })
  .ajaxStop(function () {
    $loadingOverlay.hide();
  });
// }}}

function isMobile(){
  try{ document.createEvent("TouchEvent"); return true; }
  catch(e){ return false; }
}

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
          setDateHash();
          loadConcerts(dtTxt);
        }
      }).datepicker('setDate', new Date()); // to select today as default

    $("#btnNext").click(function () {
      var selDt = $datePicker.datepicker("getDate");
      selDt.setDate(selDt.getDate()+1);
      $datePicker.datepicker("setDate", selDt);
      setDateHash();
      loadConcerts($datePicker.datepicker().val());
    });

    $("#btnPrev").click(function () {
      var selDt = $datePicker.datepicker("getDate");
      selDt.setDate(selDt.getDate()-1);
      $datePicker.datepicker("setDate", selDt);
      setDateHash();
      loadConcerts($datePicker.datepicker().val());
    });

    function setDateHash(val){
      val = $datePicker.datepicker().val()
      dt = val.substring(4).replace(/\//g,"");
      window.location.hash="/"+dt;
    }
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
            $grid.isotope();
          });

          $('.btnClose').click(function(){
            $gridItem = $(this).closest('.grid-item');
            $grid.isotope('remove',$gridItem);
            $grid.isotope();
          });

          $(".in-click").click( function(event, direction, distance, duration, fingerCount, fingerData){
            window.open($(this).attr("t-link"));
          });


          if (isMobile()){
            $("#grid .grid-item").swipe('destroy');
            $("#grid .grid-item").swipe( {
              swipeLeft:function(event, direction, distance, duration, fingerCount, fingerData){
                swipeCallback($(this), direction, fingerCount);
              },
              swipeRight:function(event, direction, distance, duration, fingerCount, fingerData){
                swipeCallback($(this), direction, fingerCount);
              },
              allowPageScroll:"vertical",
              threshold:80
            });
          }

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

    $grid.on('click','.card-footer',function(event){
      $(this).parents().eq(1).find('.collapse').collapse('toggle');
      if($(this).html()=='\u25BD'){ $(this).html('\u25B3'); }
      else{ $(this).html('\u25BD'); }
    });
    // }}}

    // {{{ REGION: Swipe Callback
    function swipeCallback($elem, direction, fingerCount) {
      // Uncomment only when deployed on actual mobile devices
      // if ((direction == "left" || direction == "right") && fingerCount == 1){
      if ($(window).width() < 760){
        var targetClass ="";
        if ((direction == "left" || direction == "right") && fingerCount <= 1){
          if (direction == "left"){
            targetClass = "swipel";
          }
          if (direction == "right"){
            targetClass = "swiper";
          }
          // $grid.isotope({transitionDuration:0});
          $elem.addClass(targetClass).delay(80).queue(function(){
            $grid.isotope('remove',$elem).dequeue();
            // $grid.isotope({transitionDuration:'0.4s'});
            $grid.isotope();
          });
        }
      }
    }
    // }}}

    // {{{ REGION: Initializations
    $('#modalSegnala').on('show.bs.modal',function(e){
      $(this).find(".modal-dialog").load('./modalSegnala.html');
    });

    var dHash =window.location.hash;
    if (dHash == ""){
      setDateHash();
    }
    else{
      if (dHash.length != 10){ // Something was wrong -> reset
        setDateHash();
      }
      var hashDate = new Date(dHash.substr(6,4),dHash.substr(4,2)-1,dHash.substr(2,2));
      $datePicker.datepicker("setDate", hashDate);
    }

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
      getSortData: { d: function(elem){
        var e = $(elem).attr('d');
        if (e===undefined) {
          return 1000.0;
        }
        return parseFloat(e);
      },
        o: function(elem){
          $span = $(elem).find('.oraluogo');
          if ($span === undefined){
            return 0;
          }
          var oraArr = $span.text().split(" - ");
          if (oraArr.length <= 1){
            return 0;
          }
          var oraMin = oraArr[0].split(":");
          var val = 0;
          val = val + parseFloat(oraMin[0])*60;
          val = val + parseFloat(oraMin[1]);
          return val;
        }
      },
      sortBy: 'd'
    });

    setFiltersFromCookies();
    setSortFromCookies();
    loadConcerts($datePicker.datepicker().val());
    // }}}

    // {{{ Cookie policy
    var cookieAlert = document.querySelector(".cookiealert");
    var acceptCookies = document.querySelector(".acceptcookies");

    cookieAlert.offsetHeight; // Force browser to trigger reflow (https://stackoverflow.com/a/39451131)

    function closeBanner(){
      setCookie("acceptCookies", true, 60);
      cookieAlert.classList.remove("show");
    }

    if (!getCookie("acceptCookies")) {
      cookieAlert.classList.add("show");

      // close on click outside
      $(document).click(function(e) {
          var container = $(".acceptCookies");
          if (!container.is(e.target) && container.has(e.target).length === 0)
          {
            closeBanner();
            $(document).off('click');
          }
        });


      // close on scroll
      window.addEventListener('scroll', windowScroll, false);
      function windowScroll(){
        closeBanner();
        window.removeEventListener('scroll', windowScroll, false);
      }
    }

    // close on accept
    acceptCookies.addEventListener("click", function () {
      closeBanner();
    });

    // }}}
  } );
// {{{ REGION: Filters
var filterFunctions = [
  function(elem) { // check milano
    if((milanoHinterland[0] == 1 && elem.hasClass('milano')) ||
      (milanoHinterland[1] == 1 && !elem.hasClass('milano'))) {
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
  var isChecked = toggleClassAndIsChecked($target);
  var f = $target.html().toLowerCase();
  if (isChecked) {addLocFilter(f);}
  else {removeLocFilter(f);}
  setFilterCookies();
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
  setFilterCookies();
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
  if($target.hasClass('btn-sel')) { deSelectBtn($target); }
  else { selectBtn($target); }
  var isChecked = $target.hasClass('btn-sel');
  return isChecked;
}

function deSelectBtn($b){
  $b.removeClass('btn-sel').addClass('btn-not-sel');
}

function selectBtn($b){
  $b.removeClass('btn-not-sel').addClass('btn-sel');
}
// }}}

// {{{ REGION: Cookies
function setCookie(cname, cvalue, exdays) {
  var d = new Date();
  d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
  var expires = "expires=" + d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function setFilterCookies() {
  // cookie will be locFilters|mhFilters
  var filtersStr = locFilters.join(",") + "|" + milanoHinterland.join(",");
  setCookie("filters",filtersStr,1000);
}

function setSortFromCookies(){
  var filterS = getCookie("sort");
  sort = filterS;
  isoSort();
}

function setFiltersFromCookies(){
  var filterC = getCookie("filters");
  if (filterC != ""){
    filtersArr = filterC.split("|");
    if(filtersArr[0]!=""){
      locFilterC = filtersArr[0].split(",");
    }
    else{
      locFilterC=[];
    }
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

function getCookie(cname) {
  var name = cname + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');
  for (var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) === ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) === 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
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

// {{{ REGION: Sort
$("#divSort button").click(function(){
  toggleSort($(this));
  isoSort();
  setCookie("sort",sort,1000);
});

function isoSort(){
  var field = sort.charAt(0);
  var asc = sort.charAt(1) == 'a';
  $btnSort = $('#btnSort'+field);
  var t = $btnSort.text().split(" ");
  var tipo_ord = t[0];
  var arrow_n = ((asc) ? '\u2191' : '\u2193');
  $btnSort.text(tipo_ord + ' ' + arrow_n);
  $btnSort.siblings().removeClass('btn-sel').addClass('btn-not-sel');
  $btnSort.addClass('btn-sel').removeClass('btn-not-sel');
  $grid.isotope({sortBy: field, sortAscending: asc});
}

function toggleSort($target){
  var t = $target.text().split(" ");
  var tipo_ord = t[0];
  var sort_t = tipo_ord.charAt(0).toLowerCase();
  var arrow_n = "";
  if ($target.hasClass('btn-sel')){
    if (t[1]=='\u2191'){
      arrow_n = '\u2193';
    }
    else{
      arrow_n = '\u2191';
    }
  }
  else{
    arrow_n = t[1];
  }
  if (arrow_n =='\u2191'){
    sort_o = 'a';
  }
  else{
    sort_o = 'd';
  }
  sort = sort_t + sort_o;
}
// }}}

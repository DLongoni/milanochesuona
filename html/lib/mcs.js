$grid = $('#grid');
$datePicker = $('#txtDatePicker');
// locFilters = ['loc-n','loc-s','loc-e','loc-w'];
locFilters = [];
milanoHinterland = [true,true];

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
              $grid.isotope('layout');
            });
          },
          error:function(xhr,ajaxOptions,thrownError){
            // Uncomment only for debugging purposes
            alert(xhr.status);
            alert(thrownError);
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
          var $this = $(this);
          for(var i=0;i<filterFunctions.length;i++){
            if (!filterFunctions[i]($this)){
              return false;
            }
          }
          return true;
        },
        getSortData: { dist: function(elem){
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
      if( elem.hasClass(locFilters[i]) ){
        return true;
      }
    }
    return false;
  }
]

$('#divNswe').on('click','button',function(event){
  $target = $(event.currentTarget);
  var isUnChecked = toggleClassAndIsUnChecked($target);
  var f = 'loc-'+$target.html().toLowerCase();
  if (isUnChecked)
  {removeFilter(f);}
  else
  {addFilter(f);}
  $grid.isotope();
});

$('#divMilanoHinterland').on('click','button',function(event){
  $target = $(event.currentTarget);
  var isUnChecked = toggleClassAndIsUnChecked($target);
  if (isUnChecked)
  {var v = false}
  else
  {var v = true}
  if ($target.html() == "Milano"){
    milanoHinterland[0] = v;
  }
  else{
    milanoHinterland[1] = v;
  }
  $grid.isotope();
});

function addFilter(filter) {
  if (locFilters.indexOf(filter)==-1)
  { locFilters.push(filter); }
}

function removeFilter(filter,arr) {
  var id = locFilters.indexOf(filter);
  if (id !=-1)
  { locFilters.splice(id,1); }
}

function toggleClassAndIsUnChecked($target){
  if($target.hasClass('btn-dark'))
  { $target.removeClass('btn-dark').addClass('btn-secondary'); }
  else
  { $target.removeClass('btn-secondary').addClass('btn-dark'); }
  var isUnChecked = $target.hasClass('btn-secondary');
  return isUnChecked;
}


// }}}

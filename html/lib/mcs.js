$grid = $('#grid');
$datePicker = $('#txtDatePicker');

$(document).ready(
    function() {
      // {{{ REGION: Date Picker
      $datePicker.datepicker(
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
        $.ajax({
          url:"/../get_concerts.php",
          data:"date="+dt,
          type:"POST",
          success:function(data){
            $grid.isotope('remove',$grid.isotope('getItemElements'));
            var $data_obj=$(data);
            $grid.append($data_obj).isotope('appended',$data_obj);

            // Expander for event descriptions should stay inside here
            $('.toolong').expander({
              slicePoint: 200,
              preserveWords: true,
              widow: 10,
              expandEffect: 'fadeIn',
              collapseEffect: 'fadeOut',
              expandText: ' leggi tutto',
              expandPrefix: '...',
              userCollapsePrefix: ' ',
              userCollapseText: ' leggi meno',
              afterExpand: function(){$grid.isotope('layout');},
              afterCollapse: function(){$grid.isotope('layout');},
            });
            $('.toolong').expander().removeClass('js-toolong-hidden');

            $grid.imagesLoaded().progress( function() {
              $grid.isotope('layout');
            });
            // $grid.isotope('layout');
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

      // {{{ REGION: Initializations
      $grid.isotope({
        // options
        itemSelector: '.grid-item',
        transitionDuration: '0.2s',
        layoutMode: 'masonry',
        masonry:{
          horizontalOrder:true,
          gutter:0
        }
      });

      loadConcerts($datePicker.datepicker().val());
      // }}}
    } );

// {{{ REGION: Filters
$('#divFilters div').on('click','button',function(event){
  $target = $(event.currentTarget);
  var isUnChecked = toggleClassAndIsUnChecked($target);
  if ($(this).parent().attr('id')=="divNswe")
  { var filter = ':not(.loc-'+$target.html().toLowerCase()+')'; }
      else
      { var filter = $target.attr('data-filter'); }
      if (isUnChecked)
      {addFilter(filter);}
      else
      {removeFilter(filter);}
      $grid.isotope({filter:filters.join('')});
      });
  });

function addFilter(filter) {
  if (filters.indexOf(filter)==-1)
  { filters.push(filter); }
}

function removeFilter(filter) {
  var id = filters.indexOf(filter);
  if (id !=-1)
  { filters.splice(id,1); }
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

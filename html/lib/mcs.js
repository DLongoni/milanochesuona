$(document).ready(
    function() {
      // Date Picker
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

      $('#grid').isotope({
        // options
        itemSelector: '.grid-item',
        transitionDuration: '0.2s',
        layoutMode: 'masonry',
        masonry:{
          horizontalOrder:true,
          gutter:0
        }
      });
    } );

// Load Concerts - called on datepicker select or arrow click
function loadConcerts(dt) {
  $.ajax({
    url:"/../get_concerts.php",
    data:"date="+dt,
    type:"POST",
    success:function(data){
      $('#grid').isotope('remove',$('#grid').isotope('getItemElements'));
      var $data_obj=$(data);
      $('#grid').append($data_obj).isotope('appended',$data_obj);
      $('#grid').isotope('layout');

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
        userCollapseText: ' leggi meno'
      });
      $('.toolong').expander().removeClass('js-toolong-hidden');
    },
    error:function(xhr,ajaxOptions,thrownError){
      // Uncomment only for debugging purposes
      alert(xhr.status);
      alert(thrownError);
      alert('Errore imprevisto nel caricamento dati.');
    }
  });
}



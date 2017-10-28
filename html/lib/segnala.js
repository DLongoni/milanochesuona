$().ready(function(){

  $(".helpPopover").popover({ trigger: "hover" });

  // {{{ REGION: Validation
  $.validator.addMethod(
      "regex",
      function(value, element, regexp) {
        var re = new RegExp(regexp);
        return this.optional(element) || re.test(value);
      },
      "Please check your input."
      );

  var dicRules = { 
    ev: {
      required:true,
      regex: /^https?:\/\/\S{0,5}facebook\.[\w]{2,3}\/events\/[\d]+\/?$/ 
    },
    loc: {
      required:true,
      regex: /^https?:\/\/\S{0,5}facebook\.[\w]{2,3}\/[\w-]+\/?$/
    }
  }

  var arrM = {
    required:"Inserire un url",
    regex: "Il formato dell'url non risulta corretto"
  };

  function placeError( error, element ) {
    error.addClass( "err text-danger" );
    if(element.parent().next("label").html() === undefined){
      error.appendTo(element.parent().parent());
    }
  };

  function valHl( element, errorClass, validClass ) {
    $( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
  }

  function valUhl( element, errorClass, validClass ) {
    $( element ).addClass( "is-valid" ).removeClass( "is-invalid" );
  }

  $('#igLoc').validate({
    rules:{ link: dicRules["loc"] },
    messages:{link: arrM},
    errorPlacement: placeError,
    highlight: valHl ,
    unhighlight: valUhl
  });

  $('#igEv').validate({
    rules:{ link: dicRules["ev"] },
    messages:{link: arrM},
    errorPlacement:placeError,
    highlight:valHl,
    unhighlight: valUhl
  });
  // }}}

  // {{{ REGION: Data Post and user Feedback
  $("input").click(function(){
    $(".div-segnala").slideUp();
  });

  $('.btn-val').click(function(){
    $this = $(this);
    if($this.parent().prev().valid()){
      var val = $this.parent().prev().val();
      var tp = $this.parent().prev().attr("id");

      $.ajax({
        url:"/../user_submit.php",
        data: {link: val, type: tp},
        type:"POST",
        success:function(data){
          switch(parseInt(data)){
            case 0:
              $('#divForms').slideUp();
              $("#divSegnalaErr").slideDown();
              break;
            case 1:
              $("#divSegnalaSucc").slideDown();
              break;
            case 2:
              $("#divSegnalaExist").slideDown();
              break;
            case 3:
              $("#divSegnalaLocaleOk").slideDown();
              break;
            case 4:
              $("#divSegnalaEventoOk").slideDown();
              break;
            case 5:
              $("#divSegnalaEventoKo").slideDown();
              break;
            default:
              $('#divForms').slideUp();
              $("#divSegnalaErr").slideDown();
          }
        },
        error:function(xhr,ajaxOptions,thrownError){
          $("divSegnalaErr").slideDown();
          // Uncomment only for debugging purposes
          alert(xhr.status);
          alert(thrownError);
          // alert('Errore imprevisto nel caricamento dati.');
        }
      });
    }
  });
});

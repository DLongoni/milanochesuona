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
      alert($this.parent().prev().val());
      // $.ajax({
      //   url:"/../get_concerts.php",
      //   data: {link: val, type: tp}
      //   type:"POST",
      //   success:function(data){
      //     if(data == 1){
      //       $("divSegnalaSucc").show();
      //     }
      //     else{
      //       $("divSegnalaErr").slideDown();
      //     }
      //   },
      //   error:function(xhr,ajaxOptions,thrownError){
      //     $("divSegnalaErr").slideDown();
      //     // Uncomment only for debugging purposes
      //     // alert(xhr.status);
      //     // alert(thrownError);
      //     alert('Errore imprevisto nel caricamento dati.');
      //   }
      // });
    }
  });
});

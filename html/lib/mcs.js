$(document).ready(
  function() {
    // {{{ REGION: Initializations
    $('#modalSegnala').on('show.bs.modal',function(e){
      $(this).find(".modal-dialog").load('./modalSegnala.html');
    });

    $("#main_content").load("concerts.html");

    // var dHash =window.location.hash;
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

// {{{ REGION: Cookies
function setCookie(cname, cvalue, exdays) {
  var d = new Date();
  d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
  var expires = "expires=" + d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
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
// }}}

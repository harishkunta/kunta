(function ($, Drupal, cookies) {
  var gatedUrl = null;
  Drupal.behaviors.gatedFileurl = {
    attach: function (context, settings) {
      $('a.gated-form-true.related-more-links.use-ajax', context).click(function() {
        gatedUrl = $('.gated-download-brochure article > div').html();
        cookies.set('gatedFile', gatedUrl);
      });
      // $('form.webform-submission-form', context).submit(function() {
      //   if( gatedUrl !== null || gatedUrl !== undefined) {
      //   }
      // });
    },
  };
  

  // $.fn.sample = function sample() {
  //   console.log('Registrering the new method.');
  //   console.log('http://verathontagit.com' + getCookie('gatedFile'));
  //   window.open('http://verathontagit.com' + getCookie('gatedFile'));
  //   return false;
  // }
})(jQuery, Drupal, window.Cookies);


// function getCookie(cname) {
//   let name = cname + "=";
//   let ca = document.cookie.split(';');
//   for(let i = 0; i < ca.length; i++) {
//     let c = ca[i];
//     while (c.charAt(0) == ' ') {
//       c = c.substring(1);
//     }
//     if (c.indexOf(name) == 0) {
//       return c.substring(name.length, c.length);
//     }
//   }
//   return "";
// }
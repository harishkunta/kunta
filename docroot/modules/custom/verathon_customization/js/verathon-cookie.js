(function ($, Drupal, cookies) {
  var gatedUrl = null;
  Drupal.behaviors.gatedFileurl = {
    attach: function (context, settings) {
      $('a.gated-form-true.related-more-links.use-ajax', context).click(function() {
        gatedUrl = $('.gated-download-brochure article > div').html();
      });
      $('form.webform-submission-form', context).submit(function() {
        if( gatedUrl !== null || gatedUrl !== undefined) {
          cookies.set('gatedFile', gatedUrl);
        }
      });
    },
  };
})(jQuery, Drupal, window.Cookies);
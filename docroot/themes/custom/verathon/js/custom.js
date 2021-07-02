(function ($, Drupal) {
  $('.solution-block').on('click', function () {
    $(this).parent().css('position', 'absolute').animate({ "margin-left": "-100%" }, "slow");
    $(this).parents('.verathon-solutions-wrap').find('.solution-feature-container').css('position', 'static').animate({ "margin-left": "0" }, "slow")
  });

  $('.solution-bread-crumbs-arrow').on('click', function () {
    $('.solution-block-wrap').css('position', 'static').animate({ "margin-left": "0" }, "slow");
    $('.solution-feature-container').css('position', 'absolute').animate({ "margin-left": "100%" }, "slow")
  });

  $('.airway-management-block').on('click', function () {
    $('.airway-management-feature').show()
    $('.bronchoscopy-feature').hide()
    $('.bladder-scanning-feature').hide()
  });
  $('.bronchoscopy-block').on('click', function () {
    $('.bronchoscopy-feature').show()
    $('.airway-management-feature').hide()
    $('.bladder-scanning-feature').hide()
  });
  $('.bladder-scanning-block').on('click', function () {
    $('.bladder-scanning-feature').show()
    $('.airway-management-feature').hide()
    $('.bronchoscopy-feature').hide()
  });
})(jQuery, Drupal);

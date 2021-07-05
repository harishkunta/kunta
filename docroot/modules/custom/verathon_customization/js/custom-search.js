(function ($, Drupal) {
  Drupal.behaviors.search = {
    attach: function (context) {
      if (context !== document) {
        return;
      }
      /* 
          Fetches the url parameter 
          Takes parameter name as input
      */
      var getUrlParameter = function getUrlParameter(param) {
        var pageUrl = window.location.search.substring(1),
          urlVariables = pageUrl.split('&'),
          urlParams,
          i;

        for (i of urlVariables) {
          urlParams = i.split('=');

          if (urlParams[0] === param) {
            return typeof urlParams[1] === undefined ? true : decodeURIComponent(urlParams[1]);
          }
        }
        return false;
      };
      var chipsArray = getUrlParameter('keywords');

      /* 
          Trimming all the empty spaces before and after the search Term
          Filtering all the empty search strings 
      */
      if (chipsArray.length) {
        chipsArray = chipsArray.split('+').join('');
      }

      if (chipsArray.length > 1) {
        chipsArray = chipsArray.split(',').filter(chip => chip !== '');
        /* 
            Maximum allowable chips are set to 5 
        */
        const maxChips = 5;
        if (chipsArray.length > maxChips) {
          chipsArray.length = maxChips;
          $('.search-keywords-warning').removeClass('d-none');
        }

        /* 
            Adding chips adding event listener for close button on chip 
        */
        var chips = document.querySelector(".chips");

        chipsArray.map(chip => {
          chips.appendChild(function () {
            var _chip = document.createElement('div');

            _chip.classList.add('chip');
            _chip.append(
              (function () {
                var _chip_text = document.createElement('span');
                _chip_text.classList.add('chip-text');
                _chip_text.innerHTML = chip;

                return _chip_text;
              })(),
              (function () {
                var _chip_close = document.createElement('span');
                _chip_close.classList.add('chip-button');
                _chip_close.innerHTML = 'x';
                _chip_close.addEventListener('click', chipClickHandler);

                return _chip_close;
              })()
            );

            return _chip;
          }());
        });
      }

      /* 
          Handling close button click on every chip created 
      */
      function chipClickHandler(event) {
        var removedChip = event.currentTarget.parentNode.children[0].innerText;
        chipsArray = chipsArray.map(chip => chip.trim());
        var index = chipsArray.indexOf(removedChip);
        if (index !== -1) {
          chipsArray.splice(index, 1);
        }
        chips.removeChild(event.currentTarget.parentNode);
        var updatedstring = chipsArray.join(', ');
        $('#views-exposed-form-acquia-search-search input[name=keywords]').val(updatedstring);
        $('#views-exposed-form-acquia-search-search input[value=Search]').trigger('click');
      }
    }
  };
})(jQuery, Drupal);
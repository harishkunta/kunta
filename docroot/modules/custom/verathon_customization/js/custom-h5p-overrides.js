(function ($) {
    $(document).ready(function() {
        /* 
            Event listener for hotspot on click
        */
        $('.h5p-image-hotspot').on('click', function() {   
            /* 
                condition to handle width of popup if the hotspot clicked 
                is at the outer half of the image
            */      
            if(parseInt($(this)[0].style.left) > 50) {               
                var interval = setInterval(function () { 
                    var popUpObj = $(".h5p-image-hotspots-overlay.visible .h5p-image-hotspot-popup"), popUpLeft = popUpObj.css("left");
                    if( popUpLeft == '0px' || popUpLeft == '0') {
                        clearInterval(interval);
                        let popUpPointerLeft = $(".h5p-image-hotspots-overlay.visible .h5p-image-hotspot-popup-pointer").css("left");
                        let popUpWidth = popUpObj.width();
                        let value = parseInt(popUpPointerLeft) - popUpWidth;
                        popUpObj.css("transition", 'none');
                        popUpObj.css("left", value + 'px');
                    }
                 }, 1);
            }
        });
     });
})(H5P.jQuery);

/* Comments will be removed after design is finalised by client */
(function ($) {
    $(document).ready(function() {
        $('.h5p-image-hotspot').on('click', function() {
            if(parseInt($(this)[0].style.left) > 50) {
                var interval = setInterval(function () { 
                    var popUpLeft = $(".h5p-image-hotspots-overlay.visible .h5p-image-hotspot-popup").css("left");
                    console.log(1);
                    if( popUpLeft == '0px') {
                        clearInterval(interval);
                        let popUpPointerLeft = $(".h5p-image-hotspots-overlay.visible .h5p-image-hotspot-popup-pointer").css("left");
      /* edit */  //    var popUpPointertop = $(".h5p-image-hotspots-overlay.visible .h5p-image-hotspot-popup-pointer").css("top");
                        let popUpWidth = $(".h5p-image-hotspots-overlay.visible .h5p-image-hotspot-popup").width();
        /* edit */      let value = parseInt(popUpPointerLeft) - popUpWidth;
      /* edit */  //    $(".h5p-image-hotspot-popup").css("top", popUpPointertop);
      /* edit */ //     $(".h5p-image-hotspots-overlay.visible .h5p-image-hotspot-popup").css("transform", 'translatey(-90px)');
                        $(".h5p-image-hotspots-overlay.visible .h5p-image-hotspot-popup").css("transition", 'none');
                        $(".h5p-image-hotspots-overlay.visible .h5p-image-hotspot-popup").css("left", value + 'px');
                    }
                 }, 1);
            }
            // else {
            //     var interval2 = setInterval(function() {
            //             console.log("hi");
            //             var popUpLeft = $(".h5p-image-hotspots-overlay.visible .h5p-image-hotspot-popup-pointer").css("left");
            //             if(popUpLeft != undefined) {
            //                 clearInterval(interval2);
            //                 var popUptop = $(".h5p-image-hotspots-overlay.visible .h5p-image-hotspot-popup-pointer").css("top");
            //                 console.log(popUptop);
            //                     $(".h5p-image-hotspot-popup").css("flex-direction", 'row');
            //                     $(".h5p-image-hotspot-popup").css("left", parseInt(popUpLeft) - 50 + 'px');
            //                     $(".h5p-image-hotspot-popup").css("top", popUptop);
            //                     console.log($(".h5p-image-hotspot-popup").css('top'));
            //             }
            //         }, 1);
            // }

        });
     });
})(H5P.jQuery);





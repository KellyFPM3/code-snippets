jQuery(window).scroll(function() {
    fpm3_parallax();
});

function fpm3_parallax() {
    var scroll = jQuery(window).scrollTop();
    var screenHeight = jQuery(window).height();
  
    jQuery('.has-parallax').each(function() {
        var offset = jQuery(this).offset().top;
        var distanceFromBottom = offset - scroll - screenHeight
        var bgYpos;

        if (offset > screenHeight && offset) {
            bgYpos = (distanceFromBottom * 0.35) + 150;
            
            jQuery(this).css('background-position', 'center ' + bgYpos +'px');
        } else {
            bgYpos = (-scroll * 0.35) + 150;

            jQuery(this).css('background-position', 'center ' + bgYpos + 'px');
        }
    });
}
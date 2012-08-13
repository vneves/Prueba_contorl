/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function mycarousel_initCallback(carousel)
{

    carousel.clip.hover(function() {
        carousel.stopAuto();
    }, function() {
        carousel.startAuto();
    });
};
jQuery.easing['BounceEaseOut'] = function(p, t, b, c, d) {
        if ((t/=d)<(1/2.75)) {
                return c*(7.5625*t*t) + b;
        } else if (t<(2/2.75)) {
                return c*(7.5625*(t-=(1.5/2.75))*t + .75) + b;
        } else if (t<(2.5/2.75)) {
                return c*(7.5625*(t-=(2.25/2.75))*t + .9375) + b;
        } else {
                return c*(7.5625*(t-=(2.625/2.75))*t + .984375) + b;
        }
};
jQuery(document).ready(function() {
    jQuery('#mycarousel').jcarousel({
        auto: 2,
        wrap: 'last',
        initCallback: mycarousel_initCallback,
        wrap: 'circular',
        easing: 'BounceEaseOut',
        animation: 1000
    });
});
jQuery(document).ready(function() {
    jQuery('#mycarousel2').jcarousel({
    scroll: 1 
    });
});
jQuery(document).ready(function() {
    jQuery('#mycarousel3').jcarousel({
    scroll: 1,
    vertical: true
    });
});


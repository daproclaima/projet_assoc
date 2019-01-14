$('body').append('<div class="container-fluid"><section class="row"><div class="publication-image-overlay col-12"><span class="publication-image-overlay-close">x</span><img src="" /></div></section></div>');
var productImage = $('.publication-image');
var productOverlay = $('.publication-image-overlay');
var productOverlayImage = $('.publication-image-overlay img');

productImage.click(function () {
    event.preventDefault();
    var productImageSource = $(this).attr('src');

    productOverlayImage.attr('src', productImageSource);
    productOverlay.fadeIn(100);
    $('#scrollUp').css('display','none');
    $('body').css('overflow', 'hidden');

    $('.publication-image-overlay-close').click(function () {
        productOverlay.fadeOut(100);
        $('#scrollUp').css('display','initial');
        $('body').css('overflow', 'auto');

    });
});
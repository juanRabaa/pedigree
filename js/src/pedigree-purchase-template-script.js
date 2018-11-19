jQuery(function($) {
    $(document).on('click', '.post-box .more-button, .product-header .buy-button .more-button', function(e){
        e.preventDefault();
        e.stopPropagation();
        var $purchaseSection = $('#purchase-options');
        var offset = $purchaseSection.offset();
        offset.left -= 100;
        offset.top -= 100;
        $('html, body').animate({
            scrollTop: offset.top,
            scrollLeft: offset.left
        });
    });
});

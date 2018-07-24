( function( $ ) {  
    function checkHeight(selector){

        var window = $(document).width();
        if (window > 768) {
            //console.log('checking height',window);
            var maxHeight = 0;
            $(selector).each(function(){
               if ($(this).height() > maxHeight) { maxHeight = $(this).height(); }
            });
            $(selector).height(maxHeight);
        } else{
            $(selector).height('auto');
        }
    }; 

    wp.customize( 'tfc_color', function( setting ) {
    var value = setting.get();
    //console.log('preview',value);
    $('body').removeClass('podium modblue modmult').addClass(value);
    checkHeight('.tfc-cta div.col-equal');
    checkHeight('.hestia-features-content .row .feature-box');
    });

    wp.customize( 'tfc_head_color', function( setting ) {
        var value = setting.get();
        var backgroundWhite = 'white-menu';
        if (value == false) {
          $('body').removeClass(backgroundWhite);
        }else{
          $('body').addClass(backgroundWhite);
        }
    //console.log('white variant',value);
});
} )( jQuery );
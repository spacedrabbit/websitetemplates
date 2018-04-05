( function( $ ) {  
    wp.customize( 'tfc_color', function( setting ) {
    var value = setting.get();
    console.log('preview',value);
    $('body.wp-customizer').addClass(value);
});
} )( jQuery );
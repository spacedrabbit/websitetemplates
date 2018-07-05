( function( $ ) {  
    wp.customize( 'tfc_color', function( setting ) {
    var value = setting.get();
    //console.log('preview',value);
    $('body.wp-customizer').addClass(value);
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
(function($) {
  wp.customize.bind('ready', function() {
    var customize = this;


customize('hestia_about_hide', function(value) {
      value.bind(function(newval) {
      	console.log('hestia_about_hide',newval)
      })
  });



    // TFC color schemes
    customize('tfc_color', function(value) {
      value.bind(function(newval) {
        var themeFont = 'Libre Baskerville';
        var themeBodyFont = 'Open Sans';
        var themeColor = '#8A332D';
        if (newval == 'modblue') {
          themeFont = 'Montserrat';
          themeBodyFont = 'Montserrat';
          themeColor = '#A62A22';
        } else if (newval == 'modmult') {
          themeFont = 'Libre Franklin';
          themeBodyFont = 'Source Serif Pro';
          themeColor = '#183E58';
        }
        console.log('themeColor', themeColor + '  ' + themeFont);
        customize.value('accent_color')(themeColor);
        customize.value('hestia_headings_font')(themeFont);
        customize.value('hestia_body_font')(themeBodyFont);
        console.log('customize', newval);
        
        $('body').removeClass("modmult modblue podium");
        $('body').addClass(newval);


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
    
    	checkHeight('.tfc-cta div.col-equal');
    	checkHeight('.hestia-features-content .row .feature-box');


      });
    });
  });
})(jQuery);
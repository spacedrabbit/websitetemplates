jQuery(document).ready(function( $ ) {
  
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

    $( window ).resize(function() {
        checkHeight('.tfc-cta div.col-equal');
        checkHeight('.hestia-features-content .row .feature-box');
        });
     
    var nvtag_callbacks = nvtag_callbacks || {};
    nvtag_callbacks.postRender = nvtag_callbacks.postRender || [];
    nvtag_callbacks.postRender.push(checkHeight('.tfc-cta div.col-equal'));

    
});
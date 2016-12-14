jQuery(document).ready(function(){
    var styleLayout = jQuery("#jform_params_module_layout");
    var pauseOnHover, pause, asset;
    pauseOnHover = jQuery("#jform_params_autoPauseHover").parent().parent();
    pause = jQuery("#jform_params_pause").parent().parent();
    asset = jQuery("#jform_params_asset-lbl").parent().parent();
    asset.hide();
    function loadStyle(style) {
        switch (style) {
            case '_:carousel':
                pauseOnHover.show();
                pause.show();
                break;
            case '_:default':
                pauseOnHover.hide();
                pause.hide();
                break;
        }
    }
    loadStyle(styleLayout.val());
    jQuery("body").on("change","#jform_params_module_layout",function(){
        loadStyle(styleLayout.val());
    });
    jQuery('#jform_params_consumer_key , #jform_params_consumer_secret, #jform_params_oauth_access_token, #jform_params_oauth_access_token_secret').on('change',function(){
        jQuery(this).val(jQuery.base64.encode(jQuery(this).val()));
    })

});
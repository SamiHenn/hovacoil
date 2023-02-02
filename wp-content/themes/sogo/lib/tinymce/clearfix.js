(function() {
    tinymce.create('tinymce.plugins.Sogobtns', {
        /**
         * Initializes the plugin, this will be executed after the plugin has been created.
         * This call is done before the editor instance has finished it's initialization so use the onInit event
         * of the editor instance to intercept that event.
         *
         * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
         * @param {string} url Absolute URL to where the plugin is located.
         */
        init : function(ed, url) {


            ed.addButton('clearfix1', {
                title : 'Break',
                cmd : 'clearfix1',
                icon: 'wp_code'
            });
            ed.addCommand('clearfix1', function() {

                return_text = '<span class="clearfix"><!--more--></span>';
                ed.insertContent(  return_text);
            });

        },




    });

    // Register plugin
    tinymce.PluginManager.add( 'sogobtns', tinymce.plugins.Sogobtns );
})();
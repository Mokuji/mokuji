<?php namespace plugins; if(!defined('TX')) die('No direct access.'); ?>
    <!-- elFinder -->
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $plugin; ?>css/elfinder.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $plugin; ?>css/theme.css">
    <script type="text/javascript" src="<?php echo $plugin; ?>js/elfinder.min.js"></script>
    <script type="text/javascript">
      ;(function($){
        
        $.fn.elFinderButton = function(options){
          
          $(this).click(function(e){
            
            var src = "<?php echo $plugin; ?>elfinder.html"
              , name = "elFinder - filepicker"
              , width = 960
              , height = 670;
            
            var target = window.open(src,name,"width="+width+",height="+height+",menubar=0,personalbar=0,toolbar=0,scrollbars=0,resizable=1");
            
            target.getFileCallback = options.getFileCallback;
            target.closeOnGetFile = options.closeOnGetFile ? options.closeOnGetFile === true : false;
            
          });
          
        };
        
      })(jQuery);
    </script>
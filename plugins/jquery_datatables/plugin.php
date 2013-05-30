<?php namespace plugins; if(!defined('TX')) die('No direct access.'); ?>

  <link type="text/css" rel="stylesheet" href="<?php echo $plugin; ?>media/css/jquery.dataTables_tuxion.css" media="screen" charset="utf-8">

  <script type="text/javascript" language="javascript" src="<?php echo $plugin ?>media/js/jquery.dataTables.js"></script>

  <script>
            
  $(document).ready(function() {
    $.extend( $.fn.dataTable.defaults, {
      "oLanguage": {
        "sUrl": "<?php echo $plugin; ?>media/language/<?php echo tx('Language')->code; ?>.json"
      }
    });
  });
  
  </script>

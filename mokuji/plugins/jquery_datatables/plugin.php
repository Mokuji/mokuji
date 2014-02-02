<?php namespace plugins; if(!defined('TX')) die('No direct access.'); ?>

  <link type="text/css" rel="stylesheet" href="<?php echo $plugin; ?>media/css/jquery.dataTables_tuxion.css" media="screen" charset="utf-8">

  <script type="text/javascript" language="javascript" src="<?php echo $plugin ?>media/js/jquery.dataTables.js"></script>
  
  <?php
  
  if(file_exists($path.DS.'media'.DS.'language'.DS.mk('Language')->code.'.json'))
  {
    
    ?>
    
    <script>
              
    $(document).ready(function() {
      $.extend( $.fn.dataTable.defaults, {
        "oLanguage": {
          "sUrl": "<?php echo $plugin.'media/language/'.mk('Language')->code.'.json'; ?>"
        }
      });
    });
    
    </script>
    
    <?php
    
  }
    
  ?>
  
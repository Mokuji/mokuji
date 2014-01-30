<?php namespace plugins; if(!defined('TX')) die('No direct access.'); ?>

  <link type="text/css" rel="stylesheet" href="<?php echo $plugin; ?>media/css/jquery.dataTables_tuxion.css" media="screen" charset="utf-8">

  <script type="text/javascript" language="javascript" src="<?php echo $plugin ?>media/js/jquery.dataTables.js"></script>
  
  <?php
  
  $i18n_file = $plugin.'media/language/'.mk('Language')->code.'.json';
  if(file_exists($i18n_file))
  {
    
    ?>
    
    <script>
              
    $(document).ready(function() {
      $.extend( $.fn.dataTable.defaults, {
        "oLanguage": {
          "sUrl": "<?php echo $i18n_file ?>"
        }
      });
    });
    
    </script>
    
    <?php
    
  }
    
  ?>
  
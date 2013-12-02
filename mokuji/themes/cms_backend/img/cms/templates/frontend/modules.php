<?php namespace components\cms; if(!defined('TX')) die('No direct access.'); ?>

<div class="modules">

<?php
foreach($modules->all as $module)
{
  echo
    '<div class="module">'.
      tx('Component')->modules($module->component)->get_html($module->name).
    '</div>';
}
?>

</div>
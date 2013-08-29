<?php namespace components\update; if(!defined('TX')) die('No direct access.'); ?>

<div id="install_step_app">
  
  <div class="title-bar clearfix">
    <h2>Introduction</h2>
  </div>
  <div class="body clearfix">
    <p>Welcome to the Mokuji installation process.</p>
    <p>
      Before moving on, the requirements for the Mokuji core are checked below.
      While any failed checks do not prevent you from attempting an installation, we recommend making sure the requirements are met.
    </p>
    <div class="requirements">
      <?php echo $data->requirements->as_table(array(
        'Requirement' => function($requirement){ return $requirement->key(); },
        'Status' => function($requirement){ return $requirement->passed->get('boolean') ? '<span class="passed">Passed</span>' : '<span class="failed">Failed</span>'; },
        'Component' => 'component'
      )); ?>
    </div>
    <p class="actions">
      <a class="button black next-step" href="#">Next step</a>
    </p>
  </div>
  
</div>

<?php namespace components\update; if(!defined('TX')) die('No direct access.'); ?>

<div id="install_step_app">
  
  <div class="title-bar clearfix">
    <h2>Check file references</h2>
  </div>
  <div class="body clearfix">
    <p>
      Finally we will check for references to file in the old file-structure.
      This will go through the contents of Text pages and Blogs to check for broken links.
    </p>
    <form class="form upgrade-file-references-form" data-upgrade-action="<?php echo url('/install/?rest=update/upgrade_file_references', true); ?>">
      <p class="actions">
        <a class="button black upgrade-file-references" href="#">Execute</a>
        <a href="?action=update/finalize_install" class="button grey finalize-install">Skip step</a>
        <a class="button grey cancel" href="<?php echo url('', true); ?>">Cancel upgrade</a>
      </p>
    </form>
  </div>
  
</div>

<?php namespace components\update; if(!defined('TX')) die('No direct access.'); ?>

<div id="install_step_app">
  
  <div class="title-bar clearfix">
    <h2>Transfer files</h2>
  </div>
  <div class="body clearfix">
    <p>Now we will transfer files from the old file structure to the new.</p>
    <p>
      This includes uploaded files, logs, components, themes, templates and plugins.
      Furthermore some redundant files will be deleted, such as the old API-docs and configuration.
    </p>
    <p>
      Actions will be suggested to resolve any file issues, which you can execute.
      If manual action is required you can perform them and press "Rescan" when ready.
    </p>
    <form class="form transfer-files-form" data-scan-action="<?php echo url('/install/?rest=update/files_scan', true); ?>">
      <div class="requirements">
        <table class="tx-table">
          <thead class="tx-table-head"><tr>
            <th>Execute</th>
            <th>Source</th>
            <th>Target</th>
            <th>Action</th>
          </tr></thead>
          <tfoot class="tx-table-foot"></tfoot>
          <tbody id="files-list" class="tx-table-body"></tbody>
        </table>
      </div>
      <p class="actions">
        <a class="button black transfer-files" href="#">Execute</a>
        <a class="button grey scan-files" href="#">Rescan</a>
        <a class="button grey cancel" href="<?php echo url('', true); ?>">Cancel upgrade</a>
      </p>
    </form>
    <script type="text/javascript">
      Installer.rescanFiles();
    </script>
  </div>
  
</div>

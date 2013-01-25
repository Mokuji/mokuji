<?php namespace components\update; if(!defined('TX')) die('No direct access.'); ?>

<div id="install_step_app">
  
  <div class="title-bar clearfix">
    <h2>Site configuration</h2>
  </div>
  <div class="body clearfix">
    <p>We can now configure the site. >>TODO give more info</p>
    
    <form method="post" action="#" data-action="<?php echo url('?rest=update/site_installation', true); ?>" class="form install-site-form">
      
      <div class="setting language">
        
        <h3>Site information</h3>
        
        <div class="ctrlHolder">
          <label for="l_site_title" accesskey="v">Site title</label>
          <input class="small" type="text" id="l_site_title" name="site_title" value="My website" required />
        </div>
        
        <div class="ctrlHolder">
          <label for="l_email_webmaster_name">Webmaster name</label>
          <input class="small" type="text" id="l_email_webmaster_name" name="email_webmaster_name" value="<?php echo defined('EMAIL_NAME_WEBMASTER') ? EMAIL_NAME_WEBMASTER : ''; ?>" required />
        </div>
        
        <div class="ctrlHolder">
          <label for="l_email_webmaster">Webmaster email</label>
          <input class="small" type="text" id="l_email_webmaster" name="email_webmaster" value="<?php echo defined('EMAIL_ADDRESS_WEBMASTER') ? EMAIL_ADDRESS_WEBMASTER : ''; ?>" required />
        </div>
        
        <div class="ctrlHolder">
          <label for="l_email_automated_name">Automated messages name</label>
          <input class="small" type="text" id="l_email_automated_name" name="email_automated_name" value="<?php echo defined('EMAIL_NAME_AUTOMATED_MESSAGES') ? EMAIL_NAME_AUTOMATED_MESSAGES : ''; ?>" required />
        </div>
        
        <div class="ctrlHolder">
          <label for="l_email_automated">Automated messages email</label>
          <input class="small" type="text" id="l_email_automated" name="email_automated" value="<?php echo defined('EMAIL_ADDRESS_AUTOMATED_MESSAGES') ? EMAIL_ADDRESS_AUTOMATED_MESSAGES : ''; ?>" required />
        </div>
        
      </div>
      
      <div class="setting language">
        
        <h3>Default language</h3>
        
        <div class="ctrlHolder">
          <label for="l_lang_code" accesskey="v">Language code</label>
          <input class="small" type="text" id="l_lang_code" name="lang_code" value="en-GB" required />
        </div>
        
        <div class="ctrlHolder">
          <label for="l_lang_shortcode" accesskey="s">Short code</label>
          <input class="small" type="text" id="l_lang_shortcode" name="lang_shortcode" value="EN" required />
        </div>
        
      </div>
      
      <p><a href="#" class="show-advanced">Show advanced options</a></p>
      <div class="advanced">
        
        <div class="setting site-paths">
          
          <h3>Site paths</h3>
          
          <div class="ctrlHolder">
            <label for="l_paths_base">Base path</label>
            <input class="small" type="text" id="l_paths_base" name="paths_base" value="<?php echo tx('Data')->server->DOCUMENT_ROOT; ?>" required />
          </div>
          
          <div class="ctrlHolder">
            <label for="l_paths_url">Url path</label>
            <input class="small" type="text" id="l_paths_url" name="paths_url" value="<?php echo URL_PATH; ?>" />
          </div>
          
        </div>
        
      </div>
      
      <p class="actions">
        <a class="button black apply-site" href="#">Apply settings</a>
        <a class="button grey cancel" href="<?php echo url('', true); ?>">Cancel installation</a>
      </p>
      
      <p id="install-site-message"></p>
      
    </form>
  </div>
  
</div>

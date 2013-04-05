<?php namespace components\cms; if(!defined('TX')) die('No direct access.'); tx('Account')->page_authorisation(2); ?>

<script id="edit_page_tmpl" type="text/x-jquery-tmpl">
  
  {{if menu_id}}
    <div class="detach-page-wrapper">
      <a href="?action=cms/detach_page&menu=${menu_id}&pid=${page.id}" class="icon detach-page" id="detach-page" title="<?php __($names->component, 'Detach page from menu item'); ?>">Detach</a>
    </div>
  {{/if}}
  <div id="edit_page">
    
    <div class="title-bar page-title">
      <h2><span class="title">${
        page.info && page.info[<?php echo tx('Language')->id; ?>] &&
        (page.info[<?php echo tx('Language')->id; ?>].title || page.info[<?php echo tx('Language')->id; ?>].title_recommendation) ||
        page.title
      }</span> <span style="font-weight:normal;">(<?php __('Page', 0, 'l'); ?>)</span></h2>
      <div class="clear"></div>
    </div>
    
    <div id="page-languages" class="language-bar" data-id="<?php echo tx('Language')->get_language_id(); ?>" data-iln="<?php __('IN_LANGUAGE_NAME'); ?>">
      <?php $data->languages->each(function($language){ ?>
        <a href="#" class="language"
          data-id="<?php echo $language->id; ?>"
          data-code="<?php echo $language->code; ?>"
          data-shortcode="<?php echo $language->shortcode; ?>"
          data-title="<?php __($language->title); ?>"><?php __($language->title); ?></a
        >
      <?php }); ?>
    </div>
    
    <div id="page-tabs" class="tab-bar"></div>
    
    <div id="page-tab-body" class="tab-body"></div>
    
    <div class="footer" id="save-buttons">
      
      <button id="save-page" class="button black" data-success="<?php __('Saved page'); ?>"
        data-working="<?php __('Saving page'); ?>"><?php __('Save'); ?></button>
      
    </div>
    
  </div>
  
</script>

<script id="edit_page_findability_tmpl" type="text/x-jquery-tmpl">
  <form id="page-findability" class="form-inline-elements page-config clearfix" method="PUT" action="<?php echo url('rest=cms/page_findability/', true); ?>${page.id}">
    
    {{each(language_id, language) languages}}
      
      <div class="multilingual-section" data-language-id="${language.id}">
        
        <div class="clearfix">
        
          <fieldset class="fieldset-general clearfix page-captions">
            
            <legend><?php __($names->component, 'Page captions'); ?></legend>
            
            <div class="ctrlHolder">
              <label for="l_title_page_${language.code}"><?php __($names->component, 'Title'); ?></label>
              <input id="l_title_page_${language.code}" class="big page-title" type="text" name="info[${language.id}][title]"
                placeholder="${page.info && page.info[language.id] && page.info[language.id].title_recommendation || '<?php echo str_replace("'", "\\'", tx('Config')->user('site_name')); ?>'}"
                value="${page.info && page.info[language.id] && page.info[language.id].title}" />
              <input class="page-title-recommendation" type="hidden" name="info[${language.id}][title_recommendation]"
                value="${page.info && page.info[language.id] && page.info[language.id].title_recommendation}" />
            </div>
            
            <div class="ctrlHolder">
              <div>
                <label for="l_page_key_${language.code}"><?php __($names->component, 'URL-key'); ?></label>
                <input id="l_page_key_${language.code}" class="big page-key" type="text" name="info[${language.id}][url_key]"
                  placeholder="<?php __($names->component, 'URL-key') ?>" value="${page.info && page.info[language.id] && page.info[language.id].url_key}" />
              </div>
              <div>
                <label for="l_page_key_example_${language.code}" class="subtle-hint"><?php __($names->component, 'Example'); ?></label>
                <div id="l_page_key_example_${language.code}" class="subtle-hint page_key_example">
                  <?php echo URL_BASE; ?>${page.id}/<span class="key-section">${page.info && page.info[language.id] && page.info[language.id].url_key ? page.info[language.id].url_key : "<?php __($names->component, 'URL-key') ?>"}</span>
                </div>
              </div>
            </div>
            
            <div class="ctrlHolder">
              <label for="l_slogan_page_${language.code}"><?php __($names->component, 'Slogan'); ?></label>
              <input id="l_slogan_page_${language.code}" class="big page-slogan" type="text" name="info[${language.id}][slogan]"
                placeholder="<?php echo tx('Config')->user('site_slogan'); ?>" value="${page.info && page.info[language.id] && page.info[language.id].slogan}" />
            </div>
            
          </fieldset>
          
          <fieldset class="fieldset-general clearfix seo">
            
            <legend><?php __($names->component, 'Search engine optimization'); ?></legend>
            <div class="grey-border">
              <div class="ctrlHolder">
                <label for="l_keywords_page_${language.code}"><?php __($names->component, 'Page keywords'); ?></label>
                <input id="l_keywords_page_${language.code}" class="big page-keywords" type="text" name="info[${language.id}][keywords]"
                  placeholder="<?php echo tx('Config')->user('site_description'); ?>" value="${page.info && page.info[language.id] && page.info[language.id].keywords}" />
              </div>
              
              <div class="ctrlHolder">
                <label for="l_description_page_${language.code}"><?php __($names->component, 'Page description'); ?></label>
                <textarea id="l_description_page_${language.code}" class="big page-description" type="text" name="info[${language.id}][description]"
                  placeholder="<?php echo tx('Config')->user('site_keywords'); ?>">${page.info && page.info[language.id] && page.info[language.id].description}</textarea>
              </div>
            </div>
          </fieldset>
        
        </div>
        
        <fieldset class="fieldset-general clearfix social-media">
          
          <legend><?php __($names->component, 'Social media'); ?></legend>
          <p class="subtle-hint"><?php __($names->component, 'SOCIAL_MEDIAL_OVERRIDE_VALUES_EXPLANATION') ?></p>
          
          <fieldset class="fieldset-general clearfix facebook">
            
            <div class="page-findability-content">
              <legend><span><?php //__($names->component, 'Open Graph (Facebook)'); ?> Open Graph<br /><strong>Facebook</strong></span><i class="icon-facebook"></i></legend>
              <div class="ctrlHolder">
                <label for="l_title_og_${language.code}"><?php __($names->component, 'OG title'); ?></label>
                <input id="l_title_og_${language.code}" class="big defaults-to-title" type="text" name="info[${language.id}][og_title]"
                  value="${page.info && page.info[language.id] && page.info[language.id].og_title}" />
              </div>
              
              <div class="ctrlHolder">
                <label for="l_description_og_${language.code}"><?php __($names->component, 'OG description'); ?></label>
                <textarea id="l_description_og_${language.code}" class="big defaults-to-description"
                  name="info[${language.id}][og_description]">${page.info && page.info[language.id] && page.info[language.id].og_description}</textarea>
              </div>
              
              <div class="ctrlHolder">
                <label for="l_keywords_og_${language.code}"><?php __($names->component, 'OG keywords'); ?></label>
                <input id="l_keywords_og_${language.code}" class="big defaults-to-keywords" type="text" name="info[${language.id}][og_keywords]"
                  value="${page.info && page.info[language.id] && page.info[language.id].og_keywords}" />
              </div>
            </div>
            <div class="page-findability-preview">
              <h2>Preview</h2>
              <div class="card-content clearfix">
                <div class="card-image"><img src="http://placehold.it/60x60" alt="Placeholder" /></div>
                <div class="card-content-text">
                  <h3>Twitter Title Goes here</h3>
                  <span>By Twitter Author placed here @twitterauthor</span>
                  <p>
                  Sed sed dictum felis. Sed mollis ullamcorper luctus. Donec hendrerit posuere velit ac vulputate. Quisque posuere luctus odio, vitae posuere.
                  </p>
                </div>
              <div class="arrow"></div>
              </div>
            </div>
          </fieldset>
          
          <fieldset class="fieldset-general clearfix twitter">
            
            <div class="page-findability-content">
             <legend><span><?php //__($names->component, 'Twitter cards'); ?>Cards<br /><strong>Twitter</strong></span><i class="icon-twitter"></i></legend>
              <div class="ctrlHolder">
                <label for="l_title_tw_${language.code}"><?php __($names->component, 'Twitter title'); ?></label>
                <input id="l_title_tw_${language.code}" class="big defaults-to-title" type="text" name="info[${language.id}][tw_title]"
                  value="${page.info && page.info[language.id] && page.info[language.id].tw_title}" />
              </div>
              
              <div class="ctrlHolder">
                <label for="l_description_tw_${language.code}"><?php __($names->component, 'Twitter description'); ?></label>
                <textarea id="l_description_tw_${language.code}" class="big defaults-to-description"
                  name="info[${language.id}][tw_description]">${page.info && page.info[language.id] && page.info[language.id].tw_description}</textarea>
              </div>
              
              <div class="ctrlHolder">
                <label for="l_author_tw_${language.code}"><?php __($names->component, 'Twitter author'); ?></label>
                <input id="l_author_tw_${language.code}" class="big" type="text" name="info[${language.id}][tw_author]"
                  placeholder="<?php echo tx('Config')->user('site_twitter'); ?>" value="${page.info && page.info[language.id] && page.info[language.id].tw_author}" />
              </div>
            </div>
            <div class="page-findability-preview">
              <h2>Preview</h2>
              <div class="card-content clearfix">
                <div class="card-image"><img src="http://placehold.it/60x60" alt="Placeholder" /></div>
                <div class="card-content-text">
                  <h3>Twitter Title Goes here</h3>
                  <span>By Twitter Author placed here @twitterauthor</span>
                  <p>
                    Sed sed dictum felis. Sed mollis ullamcorper luctus. Donec hendrerit posuere velit ac vulputate. Quisque posuere luctus odio, vitae posuere.
                  </p>
                </div>
              <div class="arrow"></div>
              </div>
            </div>
          </fieldset>
          
          <fieldset class="fieldset-general clearfix google-plus">
            
            <div class="page-findability-content">
              <legend><span><?php //__($names->component, 'Google+'); ?>&nbsp;<br /><strong>Google+</strong></span><i class="icon-google-plus"></i></legend>
              <div class="ctrlHolder">
                <label for="l_author_gp_${language.code}"><?php __($names->component, 'Google+ author'); ?></label>
                <input id="l_author_gp_${language.code}" class="big" type="text" name="info[${language.id}][gp_author]"
                  placeholder="<?php echo tx('Config')->user('site_googleplus'); ?>" value="${page.info && page.info[language.id] && page.info[language.id].gp_author}" />
              </div>
            </div>
            <div class="page-findability-preview">
              <h2>Preview</h2>
              <div class="card-content clearfix">
                <div class="card-image"><img src="http://placehold.it/60x60" alt="Placeholder" /></div>
                <div class="card-content-text">
                  <span>By Twitter Author placed here @twitterauthor</span>
                  <p>
                    Sed sed dictum felis. Sed mollis ullamcorper luctus. Donec hendrerit posuere velit ac vulputate. Quisque posuere luctus odio, vitae posuere.
                  </p>
                </div>
              <div class="arrow"></div>
              </div>
            </div>
          </fieldset>
          
        </fieldset>
        
      </div>
      
    {{/each}}
  
  </form>
</script>

<script id="edit_page_config_tmpl" type="text/x-jquery-tmpl">
  <form id="page-config" class="form-inline-elements page-config" method="PUT" action="<?php echo url('rest=cms/page/', true); ?>${page.id}">
    
    <fieldset class="fieldset-display">
      
      <legend><?php __($names->component, 'PAGE_DISPLAY', 'ucfirst'); ?></legend>
      
      <?php if($data->layout_info->size() > 0){ ?>
        <div class="ctrlHolder">
          <label for="l_layout"><?php echo __($names->component, 'Layout'); ?></label>
          <select name="layout_id" id="l_layout">
            <?php
            foreach($data->layout_info as $layout){
              echo '<option value="'.$layout->layout_id.'"{{if page.layout_id && page.layout_id == '.$layout->layout_id.'}}selected="selected"{{/if}}>'.$layout->title.'</option>';
            }
            ?>
          </select>
        </div>
      <?php } ?>
      
      <div class="ctrlHolder">
        <label for="cf_site_layout"><?php __($names->component, 'Site layout'); ?></label>
        <select id="cf_site_layout" name="template_id">
          <?php
          foreach($data->templates as $template){
            echo '<option value="'.$template->id.'"{{if default_template && default_template == '.$template->id.'}}selected="selected"{{/if}}>'.$template->title.'</option>';
          }
          ?>
        </select>
      </div>
      
      <div class="ctrlHolder">
        <label for="cf_theme"><?php __($names->component, 'Theme'); ?></label>
        <select id="cf_theme" name="theme_id">
          <?php
          foreach($data->themes as $themes){
            echo '<option value="'.$themes->id.'"{{if default_theme && default_theme == '.$themes->id.'}}selected="selected"{{/if}}>'.$themes->title.'</option>';
          }
          ?>
        </select>
      </div>
      
    </fieldset>
    
    <fieldset class="fieldset-homepage">
      
      <legend><?php __('Home page'); ?></legend>
      
      <input id="checkbox-set-as-homepage" type="checkbox" name="homepage" value="{{if is_homepage == true}}0{{else}}1{{/if}}" {{if is_homepage == true}}checked="checked" disabled="disabled"{{/if}}/>
      
      <label for="checkbox-set-as-homepage"><?php __('Use this page as the home-page'); ?></label>
      
    </fieldset>
    
    <fieldset class="fieldset-rights">
      
      <legend><?php __('User rights'); ?></legend>
      
      <?php __('Accessible to'); ?>:
      <ul>
        <li><label><input type="radio" name="access_level" value="0"{{if page.access_level <= 0}}checked="checked"{{/if}} /> <?php __('Everyone'); ?></label></li>
        <li><label><input type="radio" name="access_level" value="1"{{if page.access_level == 1}}checked="checked"{{/if}} /> <?php __('Logged in users'); ?></label></li>
        <li><label><input type="radio" name="access_level" value="2"{{if page.access_level == 2}}checked="checked"{{/if}} class="members" /> <?php __($names->component, 'Group members'); ?></label></li>
        <li><label><input type="radio" name="access_level" value="3"{{if page.access_level == 3}}checked="checked"{{/if}} /> <?php __('Admins'); ?></label></li>
      </ul>
      
      <fieldset class="fieldset-groups"{{if page.access_level == 2}} style="display:block;"{{/if}}>
        
        <legend><?php __($names->component, 'Groups with access'); ?></legend>
        
        <ul>
          {{each permissions.group_permissions}}
            <li><label><input type="checkbox" name="user_group_permission[${$value.id}]" value="1"{{if $value.access_level > 0}}checked="checked"{{/if}} /> ${$value.title}</label></li>
          {{/each}}
        </ul>
        
      </fieldset>
      
    </fieldset>
    
    <fieldset class="fieldset-general">
      
      <legend><?php __('Page notes'); ?></legend>
      
      <textarea name="notes" class="big large">${page.notes}</textarea>
      
    </fieldset>
    
  </form>
</script>

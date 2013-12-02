<?php namespace components\cms; if(!defined('TX')) die('No direct access.'); ?>

<p class="settings-description"><?php __($names->component, 'SETTINGS_CMS_CONFIGURATION_VIEW_DESCRIPTION'); ?></p>

<?php

mk('Sql')->model('cms', 'CmsConfig')->merge($data->values)
  ->render_form( $form_id, url('?rest=cms/settings',1),
    array(
      'method'=>'put',
      'fields'=>array(
        
        //Actually, don't show this model.
        'id'=>false,
        'key'=>false,
        'value'=>false,
        'site_id'=>false,
        'autoload'=>false,
        'language_id'=>false,
        
        //But show the configuration values.
        'homepage[default]' => array(
          'title' => 'Homepage',
          'type' => 'TextField'
        ),
        'cms_url_format[default]' => array(
          'title' => 'URL format',
          'type' => 'SelectField',
          'options' => array(
            'LEGACY' => transf('cms', '{0} (Legacy)', '/?pid=1'),
            'SIMPLE_KEYS' => transf('cms', '{0} (Simple keys)', '/about'),
            'ID_BASED' => transf('cms', '{0} (ID based)', '/1/about'),
            'LANGUAGE_AND_KEYS' => transf('cms', '{0} (Language and keys)', '/en/about')
          )
        ),
        'login_page[default]' => array(
          'title' => 'Login page',
          'type' => 'TextField'
        ),
        
        'template_id[default]' => array(
          'title' => 'Default template',
          'type' => 'SelectField',
          'options' => $data->templates->as_option_set('id')
        ),
        'forced_template_id[default]' => array(
          'title' => 'Forced template',
          'type' => 'SelectField',
          'options' => $data->templates->as_option_set('id')
        ),
        
        'theme_id[default]' => array(
          'title' => 'Default theme',
          'type' => 'SelectField',
          'options' => $data->themes->as_option_set('id')
        ),
        'forced_theme_id[default]' => array(
          'title' => 'Forced theme',
          'type' => 'SelectField',
          'options' => $data->themes->as_option_set('id')
        ),
        
        'default_language[default]' => array(
          'title' => 'Default language',
          'type' => 'SelectField',
          'options' => $data->languages->as_option_set('id')
        ),
        
        'tx_editor_toolbar[default]' => array(
          'title' => 'CKEditor toolbar layout',
          'type' => 'TextAreaField'
        )
        
      )
    )
  );

?>

<script type="text/javascript">
$(function(){
  $('#<?php echo $form_id; ?>').restForm();
});
</script>

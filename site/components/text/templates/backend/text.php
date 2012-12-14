<?php namespace components\text; if(!defined('TX')) die('No direct access.'); ?>

<script id="tmpl-text-item" type="text/x-jquery-tmpl">

<div class="page-item">

  <form class="form-text" data-callback="text" method="post" action="<?php echo url('action=text/save_item/post', true); ?>" class="form-inline-elements">

    <fieldset id="language-tabs">

      <!--<h3>${title}</h3>-->
    
      <input type="hidden" name="id" value="${id}" />

      <div class="idTabs">

        <?php echo tx('Component')->available('language') ? tx('Component')->helpers('language')->create_language_tabs(array('in_language_id'=>tx('Language')->get_language_id())) : ''; ?>
        
        <div class="language-tab-content">

          <?php
          
          if(tx('Component')->available('language')){
            
            $languages =
              tx('Component')->helpers('language')->get_languages(array('in_language_id'=>tx('Language')->get_language_id()));

            $languages
              ->each(function($lang)use($data, $languages){

              $in_language_text = ($languages->size() <= 1 ? '' : $in_language_text = ' '.__('IN_LANGUAGE_NAME', 1).' '.$lang->title);
              ?>

              <div id="tab-<?php echo $lang->id; ?>">

                <div class="ctrlHolder">
                  <label><?php __('Title').$in_language_text; ?></label>
                  <input class="big large" type="text" name="info[<?php echo $lang->id; ?>][title]" value="${$item.dataInfo($item.data, <?php echo $lang->id->get('int'); ?>, 'title')}" /><?php /* ${$item.dataInfo($item.data, 'title', <?php echo $lang->id; ?>)} | ${$item.dataArrayIndex($item.data)}*/ ?>
                </div>

                <br />

                <div class="ctrlHolder">
                  <label><?php __($names->component, 'Main text').$in_language_text; ?></label>
                  <textarea name="info[<?php echo $lang->id; ?>][text]" id="l_text_<?php echo $lang->id; ?>_${id}" class="text editor">${$item.dataInfo($item.data, <?php echo $lang->id->get('int'); ?>, 'text')}</textarea>
                </div>

                <br />

                <div class="ctrlHolder">
                  <label><?php __($names->component, tx('Data')->get->menu->get('int') <= 0 ? 'Introduction text' : 'Side text').$in_language_text; ?></label>
                  <textarea name="info[<?php echo $lang->id; ?>][description]" id="l_description_<?php echo $lang->id; ?>_${id}" class="description editor">${$item.dataInfo($item.data, <?php echo $lang->id->get('int'); ?>, 'description')}</textarea>
                </div>

              </div><!-- /#tab-<?php echo $lang->id; ?> -->

              <?php
            });
            
          }
          
          //Without language component
          else {
            
            ?>
            <div id="tab-<?php echo tx('Language')->get_language_id(); ?>">

              <div class="ctrlHolder">
                <label><?php __('Title'); ?></label>
                <input class="big large" type="text" name="info[<?php echo tx('Language')->get_language_id(); ?>][title]" value="${$item.dataInfo($item.data, <?php echo tx('Language')->get_language_id(); ?>, 'title')}" /><?php /* ${$item.dataInfo($item.data, 'title', <?php echo $lang->id; ?>)} | ${$item.dataArrayIndex($item.data)}*/ ?>
              </div>

              <br />

              <div class="ctrlHolder">
                <label><?php __($names->component, 'Hoofdtekst'); ?></label>
                <textarea name="info[<?php echo tx('Language')->get_language_id(); ?>][text]" id="l_text_<?php echo tx('Language')->get_language_id(); ?>_${id}" class="text editor">${$item.dataInfo($item.data, <?php echo tx('Language')->get_language_id(); ?>, 'text')}</textarea>
              </div>

<!--
              <br />

              <div class="ctrlHolder">
                <label><?php __($names->component, tx('Data')->get->menu->get('int') <= 0 ? 'Introductietekst' : 'Zijtekst'); ?></label>
                <textarea name="info[<?php echo tx('Language')->get_language_id(); ?>][description]" id="l_description_<?php echo tx('Language')->get_language_id(); ?>_${id}" class="description editor">${$item.dataInfo($item.data, <?php echo tx('Language')->get_language_id(); ?>, 'description')}</textarea>
              </div>
-->
            </div><!-- /#tab-<?php echo tx('Language')->get_language_id(); ?> -->

            <?php
            
          }
          
          ?>

        </div><!-- /.language-tab-content -->
      
      </div><!-- /.idTabs -->

    </fieldset><!-- /#language-tabs -->

  </form>

</div><!-- eof:.page-item -->

</script>

<div id="com-text-backend">

  <!--<input class="btn-new-text" type="submit" class="button" value="Nieuw tekstbericht" />-->

</div><!-- eof:#com-text-backend -->

<script type="text/javascript">

  app.Page.subscribe('save', function(e, page_id){
    $("#com-text-backend .form-text").ajaxSubmit({
      data: {page_id:page_id},
      done: function(data){
        console.log(data);
        $("#com-text-backend .form-text").find("input[name=id]").val(data);
      }
    });
  });

var com_text_backend;
/*
var com_cms = function(TxComCms){
  
  if(!TxComCms.submitCallbacks)
    TxComCms.submitCallbacks={};
  
  return TxComCms;
  
}(com_cms || {});*/

$(function(){
  
  com_text_backend = new ComTextBackend({
    pid: <?php echo $data->pid->get('int'); ?>
  });
  /*
  com_cms.submitCallbacks['text'] = function(data){
    $("#com-text-backend .form-text").find("input[name=id]").val(data);
  };*/
  
});

</script>

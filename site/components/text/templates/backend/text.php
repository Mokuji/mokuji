<?php namespace components\text; if(!defined('TX')) die('No direct access.'); ?>

<script id="tmpl-text-item" type="text/x-jquery-tmpl">

<div class="page-item">

  <form class="form-text" data-callback="text" method="post" action="<?php echo url('action=text/save_item/post'); ?>" class="form-inline-elements">

    <fieldset id="language-tabs">

      <!--<h3>${title}</h3>-->
    
      <input type="hidden" name="id" value="${id}" />
      <input type="hidden" name="page_id" value="<?php echo tx('Data')->get->pid; ?>" />

      <div class="idTabs">

        <?php echo tx('Component')->available('language') ? tx('Component')->helpers('language')->create_language_tabs(array('in_language_id'=>LANGUAGE)) : ''; ?>
        
        <div class="language-tab-content">

          <?php
          
          if(tx('Component')->available('language')){
            
            $languages =
              tx('Component')->helpers('language')->get_languages(array('in_language_id'=>LANGUAGE));

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
                  <label><?php __('Hoofdtekst').$in_language_text; ?></label>
                  <textarea name="info[<?php echo $lang->id; ?>][text]" id="l_text_<?php echo $lang->id; ?>_${id}" class="text editor">${$item.dataInfo($item.data, <?php echo $lang->id->get('int'); ?>, 'text')}</textarea>
                </div>

                <br />

                <div class="ctrlHolder">
                  <label><?php __(tx('Data')->get->menu->get('int') <= 0 ? 'Introductietekst' : 'Zijtekst').$in_language_text; ?></label>
                  <textarea name="info[<?php echo $lang->id; ?>][description]" id="l_description_<?php echo $lang->id; ?>_${id}" class="description editor">${$item.dataInfo($item.data, <?php echo $lang->id->get('int'); ?>, 'description')}</textarea>
                </div>

              </div><!-- /#tab-<?php echo $lang->id; ?> -->

              <?php
            });
            
          }
          
          //Without language component
          else {
            
            ?>
            <div id="tab-<?php echo LANGUAGE; ?>">

              <div class="ctrlHolder">
                <label><?php __('Title'); ?></label>
                <input class="big large" type="text" name="info[<?php echo LANGUAGE; ?>][title]" value="${$item.dataInfo($item.data, <?php echo LANGUAGE; ?>, 'title')}" /><?php /* ${$item.dataInfo($item.data, 'title', <?php echo $lang->id; ?>)} | ${$item.dataArrayIndex($item.data)}*/ ?>
              </div>

              <br />

              <div class="ctrlHolder">
                <label><?php __('Hoofdtekst'); ?></label>
                <textarea name="info[<?php echo LANGUAGE; ?>][text]" id="l_text_<?php echo LANGUAGE; ?>_${id}" class="text editor">${$item.dataInfo($item.data, <?php echo LANGUAGE; ?>, 'text')}</textarea>
              </div>

              <br />

              <div class="ctrlHolder">
                <label><?php __(tx('Data')->get->menu->get('int') <= 0 ? 'Introductietekst' : 'Zijtekst'); ?></label>
                <textarea name="info[<?php echo LANGUAGE; ?>][description]" id="l_description_<?php echo LANGUAGE; ?>_${id}" class="description editor">${$item.dataInfo($item.data, <?php echo LANGUAGE; ?>, 'description')}</textarea>
              </div>

            </div><!-- /#tab-<?php echo LANGUAGE; ?> -->

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

var com_text_backend;

var com_cms = function(TxComCms){
  
  if(!TxComCms.submitCallbacks)
    TxComCms.submitCallbacks={};
  
  return TxComCms;
  
}(com_cms || {});

$(function(){
  
  com_text_backend = new ComTextBackend({
    pid: <?php echo tx('Data')->get->pid->get('int'); ?>
  });
  
  com_cms.submitCallbacks['text'] = function(data){
    $("#com-text-backend .form-text").find("input[name=id]").val(data);
  };
  
});

</script>

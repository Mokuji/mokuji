<?php namespace components\account; if(!defined('TX')) die('No direct access.'); tx('Account')->page_authorisation(2);
$uid = tx('Security')->random_string(20);

$data->get()
  
  //Import finished
  ->success(function($userfunction)use($uid){
    
    ?>
    
    <div id="<?php echo $uid; ?>">
      
      <div class="import-result finished">
        <div class="message first">
          <?php echo $userfunction->return_value->size() . ' ' . __('users successfully imported', 1); ?>.
        </div>
      </div>
      
      <div class="buttonHolder">
        <input class="button b_return" type="button" value="<?php __('Return'); ?>" />
      </div>
      
    </div>
    
    <script type="text/javascript" language="javascript">
      jQuery(function($){
        
        $('#<?php echo $uid; ?>').on('click', '.b_return', function(e){
          
          e.preventDefault();
          
          $.ajax('<?php echo url("?action=account/cancel_import_users"); ?>')
            .done(function(data){
              $('#tab-import').html(data);
            });
          
        })
        
      });
    </script>
    
    <?php
    
  })
  
  //Import halted
  ->failure(function($userfunction)use($uid){
    
    ?>
    
    <form method="post" id="<?php echo $uid; ?>" action="<?php echo url('section=account/execute_import_users'); ?>" class="form import-users-form" enctype="multipart/form-data">
      
      <input type="hidden" name="retry" value="true" />
      
      <div class="import-result halted">
        <div class="message first">
          <?php echo count($userfunction->exception->errors()) . ' ' . __('errors occured while importing', 1); ?>.
        </div>
        
        <?php
          
          foreach($userfunction->exception->errors() as $error)
          {
            
            ?>
            
            <div class="message error">
              
              <?php echo $error->message; ?>
              
              <?php $error->input->is('set', function()use($error){ ?>
                <div class="override">
                  <label>
                    <input type="checkbox" name="overrides[<?php echo $error->row_number; ?>][skip]" value="1"<?php cond_print($error->overrides->skip->is_set(), 'checked="checked"'); ?> />
                    <?php __('Skip this user'); ?>
                  </label>
                  <div class="user_edit">
                    <div class="ctrlHolder">
                      <label><?php __('E-mailadres'); ?></label>
                      <input class="big large" type="text" name="overrides[<?php echo $error->row_number; ?>][email]" value="<?php echo $error->input->email; ?>" required />
                    </div>
                    
                    <div class="ctrlHolder">
                      <label for="l_username" accesskey="g"><?php __('Gebruikersnaam'); ?></label>
                      <input class="big large" type="text" name="overrides[<?php echo $error->row_number; ?>][username]" value="<?php echo $error->input->username; ?>" />
                    </div>
                    
                    <div class="ctrlHolder">
                      <label for="l_name" accesskey="f"><?php __('Voornaam'); ?></label>
                      <input class="big large" type="text" name="overrides[<?php echo $error->row_number; ?>][name]" value="<?php echo $error->input->name; ?>" />
                    </div>
                    
                    <div class="ctrlHolder">
                      <label for="l_preposition" accesskey="t"><?php __('Tussenvoegsel'); ?></label>
                      <input class="big large" type="text" name="overrides[<?php echo $error->row_number; ?>][preposition]" value="<?php echo $error->input->preposition; ?>" />
                    </div>
                    
                    <div class="ctrlHolder">
                      <label for="l_family_name" accesskey="l"><?php __('Achternaam'); ?></label>
                      <input class="big large" type="text" name="overrides[<?php echo $error->row_number; ?>][family_name]" value="<?php echo $error->input->family_name; ?>" />
                    </div>
                    
                    <div class="ctrlHolder">
                      <label for="l_comments" accesskey="c"><?php __('Comments'); ?></label>
                      <textarea class="big large" name="overrides[<?php echo $error->row_number; ?>][comments]"><?php echo $error->input->comments; ?></textarea>
                    </div>
                  </div>
                </div>
              </div>
            <?php });
            
          }
        
        ?>
        
      </div>
      
      <div class="buttonHolder">
        <?php if($userfunction->exception->value() === true){ ?>
          <input class="primaryAction button black" type="submit" value="<?php __('Import'); ?>" />
        <?php } ?>
        <input class="button b_cancel" type="button" value="<?php __('Cancel'); ?>" />
      </div>
    
    </form>
    
    <script type="text/javascript" language="javascript">
      jQuery(function($){
        
        $('#<?php echo $uid; ?>').on('click', '.b_cancel', function(e){
          
          e.preventDefault();
          
          $.ajax('<?php echo url("?action=account/cancel_import_users"); ?>')
            .done(function(data){
              $('#tab-import').html(data);
            });
          
        })
        
      });
    </script>
    
    <?php
    
  });

?>

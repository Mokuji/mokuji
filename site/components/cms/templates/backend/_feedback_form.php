<?php namespace components\cms; if(!defined('TX')) die('No direct access.'); ?>

<form id="feedback-form" action="<?php echo url('action=cms/send_feedback/post'); ?>" method="post">
  <h1><?php __($names->component, 'Send feedback', 'ucfirst') ?></h1>
  <div><textarea name="feedback" placeholder=""></textarea></div>
  <a href="#" id="feedback-hide"><?php __($names->component, 'Cancel', 'l') ?></a>
  <input type="submit" id="feedback-btn" value="<?php __($names->component, 'Send feedback', 'ucfirst'); ?>" required />
</form>


<style type="text/css">

/* =Feedback form
-------------------------------------------------------------- */
                  
#feedback-form{
  position:absolute;
  bottom:0px;
  right:15px;
  background-color:#F1F1F1;
  -moz-border-radius: 3px;
  -webkit-border-radius: 3px;
  border-radius: 3px;
}
#feedback-form.open{
  
}
  #feedback-form div,
  #feedback-form h1{
    display:none;
  }
  #feedback-form h1{
    font-size:12px;
    margin:5px 0;
  }
  #feedback-form textarea{
    width:200px;
    height:80px;
    margin-bottom:20px;
  }
  #feedback-hide{
    display:none;
  }
  #feedback-form.open #feedback-hide{
    display:block;
    position:relative;
    left:0px;
    bottom:0px;
    padding:0px;
  }
   #feedback-btn{
    border:none;
    position:absolute;
    right:15px;
    bottom:15px;
    height:23px;
    display:block;
    background-color:#F1F1F1;
    -moz-border-radius: 3px;
    -webkit-border-radius: 3px;
    border-radius: 3px;
  }
  #feedback-btn:hover{
    cursor:pointer;
    background-color: #f4812d;
    color: #fff !important;
  }

#feedback-form.open{
  padding:20px;
}
  #feedback-form.open h1,
  #feedback-form.open div{
    display:block;
  }

</style>

<script type="text/javascript">

// class com_cms_feedback_form extends Feedback
var com_cms_feedback_form = (function(Feedback){
  
  var //private properties
    defaults = {
      feedback_form: '#feedback-form'
    }
    
  //public properties
  $.extend(Feedback, {
    html: '',
    options: null,
    page: -1
  });
  
  //public CmsFeedbackForm init(o)
  Feedback.init = function(o){
    
    //create options
    this.options = new Options(o);
    
    //start doing stuff
    $(function(){
      $('*').off('.feedback');
      Feedback.build_form();
    });
    
    return this;
    
  }
  
  //public void build_form()
  Feedback.build_form = function(){

    $(this.options.feedback_form)
      .on('click.feedback', '#feedback-hide', function(e){
        e.preventDefault();
        Feedback.hide_feedback_form({btn_text:'<?php __($names->component, 'Send feedback', 'ucfirst') ?>'})
      })
      .on('submit.feedback', function(e){

        e.preventDefault();
        
        if($(Feedback.options.feedback_form).find('textarea').val().length <= 0){
          $(Feedback.options.feedback_form).find('textarea').stop(true).effect('shake', {times:2, distance:3}, 250).focus();
          return false;
        }
        
        $(Feedback.options.feedback_form).find('input[type=submit]').val('Pompiedom...');
        
        $(this).ajaxSubmit(function(){
          Feedback.hide_feedback_form({flash_text:'Thank you!', btn_text:'<?php __($names->component, 'Send more feedback', 'ucfirst') ?>', clear_form:true});
        });

      })
      .on('click.feedback', 'input[type=submit]', function(e){
        
        var el = e.delegateTarget;
        
        if( ! $(el).hasClass('open')){
          e.preventDefault();
          Feedback.show_feedback_form();
        }
        
      });
      
  }
  
  //public void show_feedback_form()
  Feedback.show_feedback_form = function(){
    
    $(this.options.feedback_form).addClass('open')

      //focus textarea
      .find('textarea').focus().end()

      //change submit button text
      .find('input[type=submit]').val('<?php __($names->component, 'Send feedback', 'ucfirst') ?>').end();

  }
  
  //public void hide_feedback_form({flash_text,btn_text,clear_form})
  Feedback.hide_feedback_form = function(o){

    var submit_btn = $(this.options.feedback_form).find('input[type=submit]');

    //hide form elements, except the feedback button
    $(this.options.feedback_form).removeClass('open');

    //clear form
    if(o.clear_form === true){
      $(this.options.feedback_form).find('input[type=text], textarea, select').val('');
    }
    
    //show flash text and change button text afterwards
    if(o.flash_text !== undefined){
    
      $(submit_btn)
        .val(o.flash_text)
        .effect('bounce', {}, 192, function(){
          $(this).val(o.btn_text);
        })

    }
    
    //or only change button text
    else if(o.btn_text !== undefined){
      $(submit_btn).val(o.btn_text);
    }

  }
 
  //private Options Options(o)
  function Options(o){
    $.extend(this, defaults, o);
    return this;
  }
  
  return Feedback;
  
})({});

com_cms_feedback_form.init({});

</script>

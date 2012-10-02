<?php namespace components\cms; if(!defined('TX')) die('No direct access.'); ?>

<form id="feedback-form" action="<?php echo url('action=cms/send_feedback/post'); ?>" method="post">
  <h1>Send feedback</h1>
  <div id="feedback-info">
    <p>
      Wat vindt u van de site? Heeft u opmerkingen of suggesties ter verbetering van de site? Laat het <a href="http://tuxion.nl" target="_blank">ons ontwikkelaarsteam</a> weten. Bij voorbaat dank!
    </p>
  </div>
  <div><textarea name="feedback" placeholder=""></textarea></div>
  <div><a href="#" id="feedback-hide">cancel</a></div>
  <input type="submit" id="feedback-btn" value="<?php __('Send feedback'); ?>" required />
</form>


<style type="text/css">

/* =Feedback form
-------------------------------------------------------------- */
                  
#feedback-form{
  position:fixed;
  color: #323232;
  font-family: "lucida grande",tahoma,verdana,arial,sans-serif;
  font-size:11px;
  bottom:5px;
  right:25px;
  padding:0;
  background-color:#F1F1F1;
  -moz-border-radius: 3px;
  -webkit-border-radius: 3px;
  border-radius: 3px;
  z-index:10;
}
  #feedback-form div,
  #feedback-form h1{
    display:none;
  }
  #feedback-form h1{
    font-size:12px;
    margin:0;
    padding-top:5px;
  }
  #feedback-info{
    width:200px;
  }
    #feedback-info p{
      margin-top:4px;
    }
  #feedback-form textarea{
    width:200px;
    height:80px;
  }
  #feedback-hide{
    position:absolute;
    left:3px;
    bottom:0;
    padding:3px;
  }
  #feedback-btn{
    border:none;
    position:absolute;
    right:0;
    bottom:0;
    height:23px;
    display:block;
    background-color:#F1F1F1;
    -moz-border-radius: 3px;
    -webkit-border-radius: 3px;
    border-radius: 3px;
    font-size:10px;
  }
  #feedback-btn:hover{
    cursor:pointer;
    background-color:#1B1F29 !important;
    color: #fff !important;
  }

#feedback-form.open{
  padding:0 5px 25px 5px;
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
        Feedback.hide_feedback_form({btn_text:'Send feedback'})
      })
      .on('submit.feedback', function(e){

        e.preventDefault();
        
        if($(Feedback.options.feedback_form).find('textarea').val().length <= 0){
          $(Feedback.options.feedback_form).find('textarea').stop(true).effect('shake', {times:2, distance:3}, 250).focus();
          return false;
        }
        
        $(Feedback.options.feedback_form).find('input[type=submit]').val('Pompiedom...');
        
        $(this).ajaxSubmit(function(){
          Feedback.hide_feedback_form({flash_text:'Thank you!', btn_text:'Send more feedback', clear_form:true});
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
      .find('input[type=submit]').val('Send feedback').end();

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

com_cms_feedback_form.init();

</script>
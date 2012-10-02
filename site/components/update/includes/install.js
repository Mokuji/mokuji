;jQuery(function($){
  
  //REST
  $.rest = function(type, path, data){
    
    return $.ajax({
      url: path,
      type: type,
      data: JSON.stringify(data),
      dataType: 'json',
      processData: false
    });
    
  };
  
  //Functions for progressing steps.
  var currentStep = -1;
  var nextStep = function(){ loadStep(++currentStep); };
  var loadStep = function(step){
    $.ajax('?section='+installSteps[step].section).done(function(result){
      $('#install-steps li')
        .removeClass('active')
        .filter('[data-step='+step+']')
        .addClass('active');
      $('#app').html(result);
    });
  };
  
  //Bind event handlers.
  $('#app')
    
    /* ---------- Next step button ---------- */
    .on('click', '.actions a.next-step', function(e){
      e.preventDefault();
      nextStep();
    })
    
    /* ---------- Test settings button ---------- */
    .on('click', '.actions a.test-db', function(e){
      
      e.preventDefault();
      
      var form = $(e.target).closest('form.form');
      $.rest('post', form.attr('data-test-action'), form.formToObject())
        .done(function(result){
          $(form).find('.validation-error').remove();
          if(result.success === true){
            $('#install-db-message').html(result.message);
          }else{
            $('#install-db-message').html('');
          }
        })
        .error(function(xhr, state, message){
          $(form).find('.validation-error').remove();
          $('#install-db-message').html('');
          var errorMeta = JSON.parse(xhr.responseText);
          for(var name in errorMeta){
            $(form).find('[name='+name+']')
              .focus()
              .parent().append(
                $('<span>').addClass('validation-error').text(errorMeta[name])
              );
          }
        });
      
    })
    
    /* ---------- Apply settings button ---------- */
    .on('click', '.actions a.apply-db', function(e){
      
      e.preventDefault();
      
      var form = $(e.target).closest('form.form');
      $.rest('post', form.attr('data-action'), form.formToObject())
        .done(function(result){
          $(form).find('.validation-error').remove();
          if(result.success === true){
            nextStep();
          }else{
            $('#install-db-message').html('');
          }
        })
        .error(function(xhr, state, message){
          $(form).find('.validation-error').remove();
          $('#install-db-message').html('');
          var errorMeta = JSON.parse(xhr.responseText);
          for(var name in errorMeta){
            $(form).find('[name='+name+']')
              .focus()
              .parent().append(
                $('<span>').addClass('validation-error').text(errorMeta[name])
              );
          }
        });
      
      $('#install-db-message').html('Configuring...');
      
    })
    
    /* ---------- Show advanced button ---------- */
    .on('click', '.show-advanced', function(e){
      
      e.preventDefault();
      
      $(e.target).closest('form').find('.advanced').slideToggle();
      
    })
    
    /* ---------- Apply settings button ---------- */
    .on('click', '.actions a.apply-site', function(e){
      
      e.preventDefault();
      
      var form = $(e.target).closest('form.form');
      $.rest('post', form.attr('data-action'), form.formToObject())
        .done(function(result){
          $(form).find('.validation-error').remove();
          if(result.success === true){
            nextStep();
          }else{
            $('#install-site-message').html('');
          }
        })
        .error(function(xhr, state, message){
          $(form).find('.validation-error').remove();
          $('#install-site-message').html('');
          var errorMeta = JSON.parse(xhr.responseText);
          for(var name in errorMeta){
            $(form).find('[name='+name+']')
              .focus()
              .parent().append(
                $('<span>').addClass('validation-error').text(errorMeta[name])
              );
          }
        });
      
    })
    
    /* ---------- Create admin button ---------- */
    .on('click', '.actions a.create-admin', function(e){
      
      e.preventDefault();
      
      var form = $(e.target).closest('form.form');
      $.rest('post', form.attr('data-action'), form.formToObject())
        .done(function(result){
          $(form).find('.validation-error').remove();
          if(result.success === true){
            $('#create-admin-message').html(result.message);
            $(e.target).replaceWith('<a href="?action=update/finalize_install" class="button black finalize-install">Finalize installation</a>').focus();
          }else{
            $('#create-admin-message').html('');
          }
        })
        .error(function(xhr, state, message){
          $(form).find('.validation-error').remove();
          $('#install-site-message').html('');
          var errorMeta = JSON.parse(xhr.responseText);
          for(var name in errorMeta){
            $(form).find('[name='+name+']')
              .focus()
              .parent().append(
                $('<span>').addClass('validation-error').text(errorMeta[name])
              );
          }
        });
      
    })
  
  ;//END - #app
  
  //Load first step.
  nextStep();
  
  //Make public class.
  window.Installer = {
    nextStep: nextStep
  };
  
});

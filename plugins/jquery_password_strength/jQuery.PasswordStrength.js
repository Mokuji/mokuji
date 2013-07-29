(function($){
  
  var //As a floating point percentage.
    STRENGTH_NONE = 0,
    STRENGTH_VERY_WEAK = 1/5,
    STRENGTH_WEAK = 2/5,
    STRENGTH_DECENT = 3/5,
    STRENGTH_STRONG = 4/5,
    STRENGTH_VERY_STRONG = 1;
  
  var
    BIAS_BALANCED = 0,
    BIAS_BIASED = 1,
    BIAS_UNCOMMON = 2;
  
  var progressColours = ['#ff0000','#ff0000','#ff9b1a','#f8e61a','#bbe528','#2ddb29'];
  
  /**
   * Detects the passwords bias for the most common character sets, the opposite of this or a balanced mix.
   * @param  string input The plain text password to be challenged.
   * @return int One of the bias constant values (balanced, biased, uncommon)
   */
  function detect_password_bias(input)
  {
    
    //Don't even bother with short strings.
    if(input.length < 3)
      return BIAS_BALANCED;
    
    //Set counters.
    var num_lowercase = 0;
    var num_uppercase = 0;
    var num_numbers = 0;
    var num_uncommon = 0;
    var chars = input.split("");
    
    for (var i=0; i < chars.length; i++) { 
      
      //Lowercase is most common.
      if('abcdefghijklmnopqrstuvwxyz'.indexOf(chars[i]) != -1){
        num_lowercase++;
        continue;
      }
      
      if('ABCDEFGHIJKLMNOPQRSTUVWXYZ'.indexOf(chars[i]) != -1){
        num_uppercase++;
        continue;
      }
      
      if('0123456789'.indexOf(chars[i]) != -1){
        num_numbers++;
        continue;
      }
      
      //From a reading perspective, even punctuation and letters with accents count as this.
      //From password perspective numbers are not uncommon.
      num_uncommon++;
      
    }
    
    //First find if uncommon is biased.
    var factor_uncommon = num_uncommon / input.length;
    
    //Over 40% is uncommon, since nobody uses this, yet it's a large set.
    if(factor_uncommon > 0.4)
      return BIAS_UNCOMMON;
    
    //Now try for common bias.
    var factor_lowercase = num_lowercase / input.length;
    var factor_uppercase = num_uppercase / input.length;
    var factor_numbers = num_numbers / input.length;
    
    //These form the majority of used characters. Over 55% means you're biased for one.
    if(
      factor_lowercase > 0.55 ||
      factor_uppercase > 0.55 ||
      factor_numbers > 0.55
    )
      return BIAS_BIASED;
    
    //Anything else is fairly balanced.
    return BIAS_BALANCED;
    
  }
  
  /**
   * Finds the password strength and returns it's name and a tip.
   * @param  string input The plain text password to challenge.
   * @return object An object describing strength, bias, name and tip of the password strength.
   */
  function detect_password_strength(input) {
    
    var i18n = $.fn.PasswordStrength.i18n;
    var bias = detect_password_bias(input);
    
    //No strength at all.
    if(input.length <= 0){ return {
      bias: bias,
      strength: STRENGTH_NONE,
      name: null,
      tip: i18n.tip_none
    }; }
    
    //Very weak strength.
    if(input.length < 6){ return {
      bias: bias,
      strength: STRENGTH_VERY_WEAK,
      name: i18n.strength_very_weak,
      tip: i18n.tip_very_weak
    }; }
    
    switch(bias){
      
      case BIAS_BIASED:
        
        //Biased weak.
        if(input.length < 11){ return {
          bias: bias,
          strength: STRENGTH_WEAK,
          name: i18n.strength_weak,
          tip: i18n.tip_biased_weak
        }; }
        
        //Biased decent.
        if(input.length < 16){ return {
          bias: bias,
          strength: STRENGTH_DECENT,
          name: i18n.strength_decent,
          tip: i18n.tip_biased_decent
        }; }
        
        //Biased strong.
        if(input.length < 21){ return {
          bias: bias,
          strength: STRENGTH_STRONG,
          name: i18n.strength_strong,
          tip: i18n.tip_biased_strong
        }; }
        
        break;
      
      case BIAS_BALANCED:
        
        //Balanced weak.
        if(input.length < 9){ return {
          bias: bias,
          strength: STRENGTH_WEAK,
          name: i18n.strength_weak,
          tip: i18n.tip_balanced_weak
        }; }
        
        //Balanced decent.
        if(input.length < 14){ return {
          bias: bias,
          strength: STRENGTH_DECENT,
          name: i18n.strength_decent,
          tip: i18n.tip_balanced_decent
        }; }
        
        //Balanced strong.
        if(input.length < 18){ return {
          bias: bias,
          strength: STRENGTH_STRONG,
          name: i18n.strength_strong,
          tip: i18n.tip_balanced_strong
        }; }
        
        break;
        
      case BIAS_UNCOMMON:
        
        //Uncommon weak.
        if(input.length < 9){ return {
          bias: bias,
          strength: STRENGTH_WEAK,
          name: i18n.strength_weak,
          tip: i18n.tip_uncommon_weak
        }; }
        
        //Uncommon decent.
        if(input.length < 13){ return {
          bias: bias,
          strength: STRENGTH_DECENT,
          name: i18n.strength_decent,
          tip: i18n.tip_uncommon_decent
        }; }
        
        //Uncommon strong.
        if(input.length < 18){ return {
          bias: bias,
          strength: STRENGTH_STRONG,
          name: i18n.strength_strong,
          tip: i18n.tip_uncommon_strong
        }; }
        
        break;
      
    }
    
    //Anything better is very strong!
    return {
      bias: bias,
      strength: STRENGTH_VERY_STRONG,
      name: i18n.strength_very_strong,
      tip: i18n.tip_very_strong
    };
    
  }
  
  /**
   * Creates a widget out of any password field with tips to improve the strength.
   * @return jQuery Returns 'this' for chaining.
   */
  $.fn.PasswordStrength = function(){
    
    var $this = $(this);
    
    //Check that you're using password fields only.
    if(!$this.is('input[type=password]'))
      throw('This function should be used on password inputs.');
    
    //Define DOM elements.
    var $container = $('<div class="password-strength-container">')
      , $progress = $('<div class="password-strength-progressbar">')
      , $completed = $('<div class="password-strength-completed-progress">')
      , $comment = $('<div class="password-strength-comment">');
    
    //Prepare progress bar.
    $progress.append($completed.css({
      'width': '0%',
      'height': '5px'
    }));
    
    //Prepare container.
    $container
      .css('width', $this.outerWidth()+'px')
      .append($progress)
      .append($comment)
      .insertAfter($this);
    
    //Insert the first comment.
    $comment.text($.fn.PasswordStrength.i18n.tip_none);
    
    //Bind event to update the password status.
    $this.on('keyup', function(e){
      
      var meta = detect_password_strength($(e.target).val());
      
      $completed.css({
        'width': Math.round(meta.strength*100)+'%',
        'background': progressColours[Math.floor(meta.strength * 5)]
      });
      
      $comment.text((meta.name ? (meta.name + ': ') : '') + meta.tip);
      
    });
    
    return $this;
    
  };
  
  //The default locale: en-GB. Translation files should overwrite this object.
  $.fn.PasswordStrength.i18n = {
    
    //Strength names.
    strength_very_weak:   "Very weak",
    strength_weak:        "Weak",
    strength_decent:      "Decent",
    strength_strong:      "Strong",
    strength_very_strong: "Very strong",
    
    //The tips per password strength and bias.
    tip_none:             "Remember, don't reuse passwords. Password managers can help you with this.",
    tip_very_weak:        "Password is too short. Longer passwords are safer, try mixing random nouns and verbs to make it longer.",
    tip_biased_weak:      "Longer passwords are safer, try adding non-English words in mixed cases.",
    tip_biased_decent:    "I'm sure you can do better though! Try making it even longer or mixing punctuation and symbols into it.",
    tip_biased_strong:    "Clearly you're putting in some good effort here! If you want the best passwords possible, try using a password manager to generate unique passwords for every service.",
    tip_balanced_weak:    "To be safer, try adding non-English words to make it longer.",
    tip_balanced_decent:  "I'm sure you can do better though! Try making it even longer by adding extra words.",
    tip_balanced_strong:  "But be sure not to reuse passwords. Password managers can help you with this.",
    tip_uncommon_weak:    "You're probably doing it wrong, this is hard to remember and not safe at all (http://xkcd.com/936). Try adding non-English words to make it longer.",
    tip_uncommon_decent:  "But you're probably doing it wrong, this is hard to remember and not that safe (http://xkcd.com/936). Try adding non-English words to make it longer.",
    tip_uncommon_strong:  "But be sure not to reuse passwords. Password managers can help you with this.",
    tip_very_strong:      "But be sure not to reuse passwords. Password managers can help you with this."
    
  };
  
})(jQuery);
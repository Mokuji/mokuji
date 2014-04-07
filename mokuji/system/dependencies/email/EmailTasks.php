<?php namespace dependencies\email; if(!defined('MK')) die('No direct access.');

abstract class EmailTasks
{
  
  /**
   * Send an email message using internal formatting logic.
   * @param string $messageKey  An identifier for this message. Used to allow custom templates.
   * @param array $messageData Message information such as "to", "bcc" and "subject".
   * @param array $contentData The data to be inserted into the message placeholders.
   * @param Callable $getTemplate Function to use when the template is not known yet.
   * @return boolean Whether sending was successful or not.
   */
  public static function SendFormattedMessage($messageKey, $messageData, $contentData, $getTemplate)
  {
    
    raw($messageKey, $messageData, $contentData);
    
    mk('Logging')->log('Email', 'Sending', $messageKey);
    
    #TODO: Actually store custom messages.
    #TODO: Implement different formatting.
    $template = $getTemplate(array(
      'language' => mk('Language')->id
    ));
    
    //Twig it.
    load_plugin('twig');
    $loader = new \Twig_Loader_String();
    $twig = new \Twig_Environment($loader);
    $output = $twig->render($template['content'], $contentData);
    
    //Gather mail params.
    $params = $messageData;
    
    //Apply the format we picked.
    $params['html_message'] = EmailFormatting::format($template['type'], $output);
    
    //Supporting mail component for advanced delivery.
    if(mk('Component')->available('mail'))
    {
      
      //Send email.
      mk('Component')->helpers('mail')->send_fleeting_mail($params)
      
      ->failure(function($info){
        mk('Logging')->log('Email', 'Error sending', $info->get_user_message());
        throw new \exception\Unexpected($info->get_user_message());
      }); 
      
    }
    
    else
    {
      
      //A formatter that can handle most of the Mail component formats.
      $quickformat = function($addresses){
        
        //Strings, we don't format.
        if(is_string($addresses)){
          return $addresses;
        }
        
        //Arrays may be of two types.
        if(is_array($addresses)){
          
          //Single address, with kv pairs.
          if(array_key_exists('email', $addresses))
            return $addresses['email'];
          
          //Otherwise it's a set.
          $formattedAddresses = array();
          
          foreach($addresses as $address){
            
            //If it's a name & email key value pair, format it.
            if(array_key_exists('email', $address)){
              $formattedAddresses[] = $address['email'];
            }
            
            //Array of strings, can be imploded.
            elseif(is_string($address)){
              $formattedAddresses[] = $address;
            }
            
            else
              throw new \exception\Unexpected('Unknown email formatting');
            
          }
          
          //Now add the comma's.
          return implode(',', $formattedAddresses);
          
        }
        
        throw new \exception\Unexpected('Unknown email formatting');
        
      };
      
      //Additional headers
      $headers  = 'X-Mailer: Mokuji EmailTasks'.n;
      $headers .= 'From: '.$quickformat(
        isset($messageData['from']) ?
          $messageData['from']:
          EMAIL_NAME_AUTOMATED_MESSAGES.' <'.EMAIL_ADDRESS_AUTOMATED_MESSAGES.'>'
      ).n;
      
      if(isset($messageData['cc'])){
        $headers .= 'Cc: '.$quickformat($messageData['cc']).n;
      }
      
      if(isset($messageData['bcc'])){
        $headers .= 'Bcc: '.$quickformat($messageData['bcc']).n;
      }
      
      //Try send it.
      $success = @mail(
        $quickformat($messageData['to']),
        $messageData['subject'],
        strip_tags($params['html_message']),
        $headers
      );
      
      if(!$success){
        mk('Logging')->log('Email', 'Error sending', 'Mail function reported unsuccessful queue.');
        throw new \exception\Unexpected('Mail function reported unsuccessful queue.');
      }
      
    }
    
    mk('Logging')->log('Email', 'Sent', $messageKey);
    return true;
    
  }
  
  /**
   * Makes a function you can pass to SendFormattedMessage to get a markdown based twig template from file.
   * @param string $filename Path to the template file.
   */
  public static function MarkdownTemplateGetter($filename)
  {
    
    return function($options)use($filename){
      return array(
        'type' => EmailFormatting::MARKDOWN,
        'content' => file_get_contents($filename)
      );
    };
    
  }
  
}
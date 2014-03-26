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
    $params['html_message'] = $output;//EmailFormatting::format($template['type'], $output);
    
    #TODO: Support fallback methods.
    //Send email.
    mk('Component')->helpers('mail')->send_fleeting_mail($params)
    
    ->failure(function($info){
      mk('Logging')->log('Email', 'Error sending', $info->get_user_message());
      throw new \exception\Unexpected($info->get_user_message());
    }); 
    
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
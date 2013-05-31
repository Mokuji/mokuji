<?php namespace core; if(!defined('TX')) die('No direct access.');

class Controller
{

  public function render_page($contents)
  {
    
     //remove >= tripple newlines
    $contents = preg_replace('~(?:\n\r?){2,}~', "\n\n", $contents);
    
    //output the content unless it is supressed
    if(!(DEBUG && tx('Data')->get->check('no_content'))) echo $contents;
    
  }
  
  public function message($message)
  {
    
    //normalize message content by putting it in Data
    $data = Data($message);
    
    //if the data is scalar, we move it to the "notification" subnode, which is the default
    if($data->is_leafnode()){
      $data->set(array('notification' => $data));
    }
    
    //add it as a session flash variable
    tx('Session')->flash('messages', $data);
    
  }
  
  public function get_messages()
  {
    return tx('Session')->flash('messages');
  }
  
  public function load_template($template, $theme, $body=array(), $head=array())
  {
    
    //include js from /includes
    $js=array();
    foreach(files(PATH_INCLUDES.DS.'js'.DS.'*.js') as $file){
      $js[] = t.t.'<script type="text/javascript" src="'.URL_INCLUDES.'js/'.basename($file).'"></script>';
    }
    
    //include css from /includes
    $css=array();
    foreach(files(PATH_INCLUDES.DS.'css'.DS.'*.css') as $file){
      $css[] = t.t.'<link rel="stylesheet" type="text/css" href="'.URL_INCLUDES.'css/'.basename($file).'" />';
    }
    
    //create injection data
    $data = array(
      
      //the $head variable will contain the following data array merged with given $head array
      'head' => Data(array(
        'links' => array($css),
        'scripts' => array($js),
        'theme' => load_html(PATH_THEMES.DS.str_replace('/', DS, $theme).DS.'theme'.EXT, array('theme' => URL_THEMES.$theme.'/', 'template' => URL_TEMPLATES.$template.'/'), true)
      ))->merge($head, true),
      
      //the body contains the given $body array
      'body' => Data($body),
      
      //we get the messages that were send through the session from the previous page
      'messages' => $this->get_messages()
      
    );
    
    // merge the output buffers with the existing $head data
    $data['head']->merge(array(
      'meta'=>array(tx('Ob')->get('meta')),
      'links'=>array(tx('Ob')->get('link')),
      'scripts'=>array(tx('Ob')->get('script'))
    ), true);
    
    //require the template, injecting the $data array
    return load_html(PATH_TEMPLATES.DS.$template.DS.'template'.EXT, $data);
    
  }
  
  /**
   * Parses exception data into the error template and sends it to the output stream.
   *
   * @param  \Exception $e The exception containing the template data.
   *
   * @return void          This method exits the code.
   */
  public function load_error_template(\Exception $e)
  {
    
    $paths = array('theme' => URL_THEMES."error/", 'template' => URL_TEMPLATES."error/");
    
    $data = array(
      'head' => Data(array(
        'title' => 'An error occured.',
        'meta' => array(
          'robots' => 'noindex, nofollow',
          'description' => 'This used to be a nicely looking properly working web page - until YOU broke it!'
        ),
        'theme' => load_html(PATH_THEMES.DS.'error'.DS.'theme'.EXT, $paths)
      )),
      'body' => Data(array(
        'message' => $e->getMessage()
      )),
      'exception' => $e
    );
    
    
    echo load_html(PATH_TEMPLATES.DS.'error'.DS.'template'.EXT, array_merge($data, $paths));
    
    exit;
    
  }
  
  public function load_redirect_template(\dependencies\Url $redirect)
  {
    echo 'REDIRECT: <a href="'.$redirect.'">'.$redirect.'</a>';
    trace($redirect->dump());
  }
  
}

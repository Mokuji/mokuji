<?php namespace components\account; if(!defined('TX')) die('No direct access.');

class Json extends \dependencies\BaseComponent
{

  protected function get_mail_autocomplete($data, $parameters)
  {
    
    $resultset = Data();
    
    tx('Sql')
      ->table('account', 'Accounts')
      ->join('UserInfo', $ui)
      ->where("(`$ui.status` & (1|4))", '>', 0)
      ->where(tx('Sql')->conditions()
        ->add('1', array('email', '|', "'%{$parameters->{0}}%'"))
        ->add('2', array("$ui.name", '|', "'%{$parameters->{0}}%'"))
        ->add('3', array("$ui.family_name", '|', "'%{$parameters->{0}}%'"))
        ->combine('4', array('1', '2', '3'), 'OR')
        ->utilize('4')
      )
      ->execute()
      ->each(function($user)use($resultset){
        $resultset->push(array(
          'is_user' => true,
          'id' => $user->id,
          'label' => $user->user_info->full_name->not('empty', function($full_name)use($user){ return $full_name->get().' <'.$user->email->get().'>'; })->otherwise($user->email),
          'value' => $user->email
        ));
      });
    
    tx('Sql')
      ->table('account', 'UserGroups')
      ->where('title', '|', "'%{$parameters->{0}}%'")
      ->execute()
      ->each(function($group)use($resultset){
        $resultset->push(array(
          'is_group' => true,
          'id' => $group->id,
          'label' => __('Group', 1).': '.$group->title->get().' ('.$group->users->size().')',
          'value' => $group->title
        ));
      });
    
    return $resultset->as_array();
    
  }
  
  //Send mail might have been a better name. But that's the current REST convention for you.
  protected function create_mail($data, $parameters)
  {
    
    $recievers = Data();
    
    //Add groups.
    tx('Sql')
      ->table('account', 'AccountsToUserGroups')
      ->where('user_group_id', $data->group)
      ->join('Accounts', $A)
      ->workwith($A)
      ->join('UserInfo', $UI)
      ->where("(`$UI.status` & (1|4))", '>', 0)
      ->execute($A)
      ->each(function($node)use($recievers){
        $recievers->merge(array($node->id->get() => $node->email));
      });
    
    //Add individual users.
    tx('Sql')
      ->table('account', 'Accounts')
      ->pk($data->user)
      ->join('UserInfo', $UI)
      ->where("(`$UI.status` & (1|4))", '>', 0)
      ->execute()
      ->each(function($node)use($recievers){
        $recievers->merge(array($node->id->get() => $node->email));
      });
    
    //Check if we have enough recievers.
    if($recievers->is_empty()){
      $ex = new \exception\Validation("You must provide at least one recipient.");
      $ex->key('recievers_input');
      $ex->errors(array('You must provide at least one recipient'));
      throw $ex;
    }

    //Mailers only validate, so store them for later.
    $mailers = Data();
    
    //Itterate over recievers.
    $recievers->each(function($reciever)use($data, $mailers){
      
      $message = $data->message->get();
      
      //If we have autologin component available.
      if(tx('Component')->available('autologin')){
        
        //Find all autologin links.
        preg_match_all('~<a[^>]+data-autologin="true"[^>]+>~', $data->message->get(), $autologinElements, PREG_SET_ORDER);
        
        //Go over each of them.
        foreach($autologinElements as $autologinElement)
        {
          
          //Gather autologin-link generation parameters.
          $linkParams = Data(array(
            'user_id' => $reciever->key(),
            'link_admins' => true
          ));
          
          //Find it's parameters.
          preg_match_all('~data-(failure_url|success_url)="([^"]*)"~', $autologinElement[0], $dataParams, PREG_SET_ORDER);
          
          //Merge each parameter into the link parameters.
          foreach($dataParams as $dataParam){
            $linkParams->merge(array($dataParam[1] => html_entity_decode($dataParam[2]))); //use html_entity_decode because of CKEDITOR bug.
          }
          
          //Replace the element with the resulting link.
          $link = tx('Component')->helpers('autologin')->call('generate_autologin_link', $linkParams);
          $message = str_replace($autologinElement[0], '<a class="autologin" data-autologin="true" href="'.$link->output.'">', $message);
          
        }
        
      }
      
      //Validate email through mail component.
      tx('Component')->helpers('mail')->send_fleeting_mail(array(
        'to' => $reciever,
        'subject' => $data->subject->get(),
        'html_message' => $message,
        'validate_only' => true
      ))
      
      ->failure(function($info){
        throw $info->exception;
      })
      
      //If it's ok, store the mailer.
      ->success(function($info)use($mailers){
        $mailers->push($info->return_value);
      });
      
    });
    
    //After all mail was validated, send it.
    $mailers->each(function($mailer){
      try{
        $mailer->get()->Send();
      }catch(\Exception $e){
        throw new \exception\Programmer('Fatal error sending email. Exception message: %s', $e->getMessage());
      }
    });
    
    tx('Logging')->log('Account', 'Mail sent', 'Sent '.$mailers->size().' email.');
    
  }
  

}

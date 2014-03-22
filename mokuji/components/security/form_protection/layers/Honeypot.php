<?php namespace components\security\form_protection\layers; if(!defined('MK')) die('No direct access.');

use \dependencies\Data;
use \components\security\enums\ThreatLevel;
use \components\security\enums\SuspicionLevel;
use \components\security\form_protection\Layer;
use \components\security\form_protection\HoneypotFormField;

/**
 * Layer that uses the honeypot technique.
 * 
 * * **Effectiveness vs spammers**: Very high
 * * **Effectiveness vs hackers**: Ineffective
 * * **Performance**: Perfect! - O(1)
 * * **Privacy awareness**: Perfect! Content does not need to be logged or shared.
 * 
 * Use a field that is invisible to users, but bots may fill in automatically.
 * It has a high catch rate and high certainty against spammers.
 * We assume hackers are willing to adjust their scripts to circumvent this.
 * Making sure only the proper fields are filled in is a trivial task for them.
 * 
 */
class Honeypot implements Layer
{
  
  protected $session;
  protected $enabled;
  protected $count;
  protected $fields;
  
  /**
   * Creates the protection layer based on the given settings.
   * @param array $settings The settings to use for form protection.
   * @param Data $session The data object of the server-side storage for this form.
   */
  public function __construct(array $settings, Data $session)
  {
    
    //Hold onto the session.
    $this->session = $session;
    
    //Whether this module is enabled or not.
    $this->enabled = !!$settings['honeypot.enabled'];
    
    //Get our basic fields.
    $fields = explode('|', $settings['honeypot.fieldCandidates']);
    $this->fields = array();
    
    //Trim those fields and don't include empty ones.
    for($i=0; $i<count($fields); $i++)
    {
      
      $field = trim($fields[$i]);
      
      if(!empty($field)){
        $this->fields = $field;
      }
      
    }
    
    //We must have some fields to pick from.
    if(count($this->fields) === 0){
      $this->enabled = false;
      mk('Logging')->log('Security', 'Form protection', 'Honeypot did not receive any field candidates.');
    }
    
    //See if we need to randomize the fields.
    if($settings['honeypot.randomize'] === true){
      shuffle($this->fields);
    }
    
    //Use at least one field, but check our settings.
    $this->count = max(intval($settings['honeypot.fields']), 1);
    
  }
  
  /**
   * Checks whether there is reason to increase the threat level before presenting the form.
   * @return ThreatLevel The level of threat that we can predetermine with this layer.
   */
  public function predetermineThreatLevel(){
    //We can't predetermine anything.
    return ThreatLevel::NORMAL;
  }
  
  /**
   * Generate additional fields required for this layer.
   * @param  BaseFormField[] $currentFields An array of the currently added fields, to prevent conflicts.
   * @return BaseFormField[] An array of fields this layer uses.
   */
  public function generateFields(array $currentFields)
  {
    
    //When disabled, add no fields.
    if(!$this->enabled) return array();
    
    //Track a couple of things.
    $remaining = $this->count;
    $candidates = $this->fields;
    $addedFields = array();
    
    //Keep adding fields until we don't need any more or run out of candidates.
    while($remaining > 0)
    {
      
      //Get the next candidate.
      $candidate = array_shift($candidates);
      
      //Seems we ran out of candidates.
      if(is_null($candidate)) break;
      
      //If this conflicts with another field, don't use it.
      if(array_key_exists($candidate, $currentFields)){
        continue;
      }
      
      //Add this field.
      $addedFields[$candidate] = new HoneypotFormField(
        $candidate, __('security', 'Please leave this field empty'), Data(null)
      );
      
    }
    
    //We did not meet our target.
    if($remaining > 0){
      mk('Logging')->log(
        'Security', 'Form protection',
        'Honeypot could not add the suggested '.$this->count.' fields. Need more candidates perhaps.'
      );
    }
    
    //Store our used fields in the session.
    $this->session->honeypot->fields->set(array_keys($addedFields));
    
    //And return the fields.
    return $addedFields;
    
  }
  
  /**
   * Inspect the form data to spot signals of hackers / spammers.
   * @param  Data $formData The form data received.
   * @return SuspicionLevel The suspicion level that this detection layer indicates.
   */
  public function verifyFormSubmission(Data $formData)
  {
    
    //When disabled, don't check.
    if(!$this->enabled) return SuspicionLevel::NEUTRAL;
    
    //Track the matches.
    $trapped = 0;
    
    //Get the fields to check from the session.
    $fields = $session->honeypot->fields->as_array();
    foreach($fields as $field)
    {
      
      //Yay! We spotted a bad guy!
      if(!$formData->$field->is_empty())
        $trapped++;
      
    }
    
    //If somehow there were no traps... this kind of defeats the purpose.
    if(count($fields) === 0)
      return SuspicionLevel::NEUTRAL;
    
    //If the bad guy fell for all of the traps, there is no excuse!
    if(count($fields) === $trapped)
      return SuspicionLevel::CERTAIN;
    
    //Falling for some of the traps looks bad as well.
    if($trapped > 0)
      return SuspicionLevel::HIGH;
    
    //If they did not get trapped at all, that builds a bit of faith.
    return SuspicionLevel::LOW;
    
  }
  
  
}
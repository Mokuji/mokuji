<?php namespace components\security\form_protection\layers; if(!defined('MK')) die('No direct access.');

use \dependencies\Data;
use \components\security\enums\ThreatLevel;
use \components\security\enums\SuspicionLevel;
use \components\security\form_protection\Layer;
use \components\security\form_protection\HoneypotFormField;

/**
 * Layer that checks for user agent headers.
 * 
 * * **Effectiveness vs spammers**: Medium
 * * **Effectiveness vs hackers**: Ineffective
 * * **Performance**: Perfect! O(1)
 * * **Privacy awareness**: Perfect! Content does not need to be logged or shared.
 * 
 * Check for the presence of a user agent. Simple spambots may not have included one.
 * This detection is trivial to circumvent though.
 * So if the spammer is willing to change one line of code, this method stops being effective.
 * The same goes for hackers, we assume they are very likely willing to invest the time to add
 * a user-agent so it counts as ineffective.
 * 
 */
class UserAgent implements Layer
{
  
  protected $enabled;
  
  /**
   * Creates the protection layer based on the given settings.
   * @param array $settings The settings to use for form protection.
   * @param Data $session The data object of the server-side storage for this form.
   */
  public function __construct(array $settings, Data $session)
  {
    
    //Whether this module is enabled or not.
    $this->enabled = !!$settings['user-agent.enabled'];
    
  }
  
  /**
   * Checks whether there is reason to increase the threat level before presenting the form.
   * @return ThreatLevel The level of threat that we can predetermine with this layer.
   */
  public function predetermineThreatLevel()
  {
    
    //When disabled, return a neutral answer.
    if(!$this->enabled) return ThreatLevel::NORMAL;
    
    //No user agent is strange, but not deterministic.
    //A user agent is normal no matter how you look at it.
    return $this->hasUserAgent() ?
      ThreatLevel::NORMAL:
      ThreatLevel::HIGH;
    
  }
  
  /**
   * Generate additional fields required for this layer.
   * @param  BaseFormField[] $currentFields An array of the currently added fields, to prevent conflicts.
   * @return BaseFormField[] An array of fields this layer uses.
   */
  public function generateFields(array $currentFields){
    return array(); //This layer doesn't use any fields.
  }
  
  /**
   * Inspect the form data to spot signals of hackers / spammers.
   * @param  Data $formData The form data received.
   * @return SuspicionLevel The suspicion level that this detection layer indicates.
   */
  public function verifyFormSubmission(Data $formData)
  {
    
    //When disabled, return a neutral answer.
    if(!$this->enabled) return SuspicionLevel::NEUTRAL;
    
    //No user agent is strange, but not deterministic.
    //A user agent is normal no matter how you look at it.
    return $this->hasUserAgent() ?
      SuspicionLevel::NEUTRAL:
      SuspicionLevel::HIGH;
    
  }
  
  /**
   * Checks whether the current client has a user agent header set.
   * @return boolean
   */
  public function hasUserAgent(){
    return !mk('Data')->server->HTTP_USER_AGENT->is_empty();
  }
  
}
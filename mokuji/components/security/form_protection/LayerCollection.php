<?php namespace components\security\form_protection; if(!defined('MK')) die('No direct access.');

use \dependencies\Data;
use \components\security\enums\ThreatLevel;
use \components\security\enums\SuspicionLevel;

/**
 * Can perform operations on a collection of layers.
 */
class LayerCollection
{
  
  /**
   * The layers this collection operates on.
   * @var Layer[]
   */
  protected $layers;
  
  /**
   * The settings to use for form protection.
   * @var array
   */
  protected $settings;
  
  /**
   * Creates a new collection from the given layers.
   * @param Layer[] $layers The layers to manage in this collection.
   * @param array $settings The settings to use for form protection.
   * @param Data $session The data object of the server-side storage for this form.
   */
  public function __construct(array $layers, array $settings, Data $session){
    $this->layers = $layers;
    $this->settings = $settings;
  }
  
  /**
   * Checks whether there is reason to increase the threat level before presenting the form.
   * @return ThreatLevel The level of threat that we can predetermine with these layers.
   */
  public function predetermineThreatLevel()
  {
    
    //Keep track of a score in either direction.
    $scoring = ThreatLevel::NORMAL;
    
    //Go through all the layers, or until we have a decisive result.
    foreach($this->layers as $layer)
    {
      
      switch($layer->predetermineThreatLevel())
      {
        
        //In these extreme results, they are decisive.
        case ThreatLevel::TRUSTED:
        case ThreatLevel::EXTREME:
          return $level;
        
        //Otherwise combine them into a scoring.
        default:
          $scoring += $level;
          break;
        
      }
      
    }
    
    //Convert the score to a level.
    return $this->scoreToLevel($scoring);
    
  }
  
  /**
   * Generate additional fields required for this layer.
   * @param  BaseFormField[] $currentFields An array of the currently added fields, to prevent conflicts.
   * @return BaseFormField[] An array of fields this layer uses.
   */
  public function generateFields(array $currentFields)
  {
    
    //Keep track of the fields that are new.
    $collectedFields = array();
    
    foreach($this->layers as $layer)
    {
      
      //Get extra fields.
      $extraFields = $layer->generateFields($currentFields);
      
      //Add these to both the total of fields (to be aware of other layers).
      $currentFields = array_merge($currentFields, $extraFields);
      $collectedFields = array_merge($collectedFields, $extraFields);
      
    }
    
    //Return the fields that are new.
    return $collectedFields;
    
  }
  
  /**
   * Inspect the form data to spot signals of hackers / spammers.
   * @param  Data $formData The form data received.
   * @return SuspicionLevel The suspicion level that this detection layer indicates.
   */
  public function verifyFormSubmission(Data $formData)
  {
    
    //Keep track of a score in either direction.
    $scoring = SuspicionLevel::NEUTRAL;
    
    //Go through all the layers, or until we have a decisive result.
    foreach($this->layers as $layer)
    {
      
      switch($layer->verifyFormSubmission($formData))
      {
        
        //In these extreme results, they are decisive.
        case SuspicionLevel::TRUSTED:
        case SuspicionLevel::NONE:
          return $level;
        
        //Otherwise combine them into a scoring.
        default:
          $scoring += $level;
          break;
        
      }
      
    }
    
    //Convert the score to a level.
    return $this->scoreToLevel($scoring);
    
  }
  
  /**
   * Given a scoring, converts to a Suspicion / ThreatLevel based on our settings.
   * @return int A level coherent with SuspicionLevel and ThreatLevel values.
   */
  protected function scoreToLevel()
  {
    
    //Depending on our settings, the scoring may be so little that we don't want to change our threat level.
    if(abs($scoring) < (int)$this->settings['minimalScoreThreshold'])
      return ThreatLevel::NORMAL;
    
    //Depending on our settings, multiple indecisive indicators can combine to a decisive result.
    $decisive = abs($scoring) >= (int)$this->settings['decisiveScoreThreshold'];
    
    //The positive extreme being trusted / low.
    if($scoring > 0) return $decisive ? ThreatLevel::TRUSTED : ThreatLevel::LOW;
    
    //The negative side being extreme / high.
    else return $decisive ? ThreatLevel::EXTREME : ThreatLevel::HIGH;
    
  }
  
}
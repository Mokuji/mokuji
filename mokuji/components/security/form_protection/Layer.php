<?php namespace components\security\form_protection; if(!defined('MK')) die('No direct access.');

use \dependencies\Data;
use \dependencies\forms\BaseFormField;
use \components\security\enums\ThreatLevel;
use \components\security\enums\SuspicionLevel;

/**
 * A protection layer is one aspect of form protection with particular attributes and
 * verification methods to protect against spammers and / or hackers abusing forms.
 */
interface Layer
{
  
  /**
   * Creates the protection layer based on the given settings.
   * @param array $settings The settings to use for form protection.
   * @param Data $session The data object of the server-side storage for this form.
   */
  public function __construct(array $settings, Data $session);
  
  /**
   * Checks whether there is reason to increase the threat level before presenting the form.
   * @return ThreatLevel The level of threat that we can predetermine with this layer.
   */
  public function predetermineThreatLevel();
  
  /**
   * Generate additional fields required for this layer.
   * @param  BaseFormField[] $currentFields An array of the currently added fields, to prevent conflicts.
   * @return BaseFormField[] An array of fields this layer uses.
   */
  public function generateFields(array $currentFields);
  
  /**
   * Inspect the form data to spot signals of hackers / spammers.
   * @param  Data $formData The form data received.
   * @return SuspicionLevel The suspicion level that this detection layer indicates.
   */
  public function verifyFormSubmission(Data $formData);
  
}
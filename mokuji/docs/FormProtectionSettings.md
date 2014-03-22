# Form protection settings.

Since there are a lot of them. Lets track them here.
In the core tables all of these are prefixed with 'security.form_protection.'.

## General

* `minimalScoreThreshold` (int) The minimal scoring before an increase in threat / suspicion is issued.
* `decisiveScoreThreshold` (int) The scoring at which point a score is considered decisive.
* `predeterminationLayers` (string) The layers to use for threat level predetermination. Separator is `|`.

## Threat level customization

* `threatlevel.trusted.layers` (string) The layers to use for the trusted threat level. Separator is `|`.
  Try not to disable all layers here, or we can't catch them doing anything bad to break the trust level.
* `threatlevel.low.layers` (string) The layers to use for the low threat level. Separator is `|`.
* `threatlevel.normal.layers` (string) The layers to use for the normal threat level. Separator is `|`.
* `threatlevel.high.layers` (string) The layers to use for the high threat level. Separator is `|`.
* `threatlevel.extreme.layers` (string) The layers to use for the extreme threat level. Separator is `|`.

## User-agent layer

* `user-agent.enabled` (boolean) Whether or not to use this layer at all.

## Honeypot layer

* `honeypot.enabled` (boolean) Whether or not to use this layer at all.
* `honeypot.fields` (int) How many fields should be used to try and trap our spammers.
  Note: using just one field makes this layer rather black or white.
  Use more than one field if you are having trouble with false positives.
* `honeypot.fieldCandidates` (string) An ordered list of candidates for the name attribute
  of the honeypot field. Separator is `|`.
* `honeypot.randomize` (boolean) Whether or not to randomly select fields from the candidates
  instead of following the order. This option is only useful to gather effectiveness data
  on all candidates. For production environments you may want to disable this and sort the
  field candidates in order of effectiveness instead.
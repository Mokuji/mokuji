#### [Version 0.20.1 Beta](https://github.com/Tuxion/mokuji/tree/0.20.1-beta)
_3-Jun-2013_

* Bugfix / Improved backwards compatibility in dependencies\Resultset.

#### [Version 0.20.0 Beta](https://github.com/Tuxion/mokuji/tree/0.20.0-beta)
_3-Jun-2013_

* Added the `as_hoptions` function to `\dependencies\Resultset` and `menu` module in the `menu` component.
* Fixed bug with hwalk where it would grab too many sub-items if the lft-rgt structure is not complete.

#### [Version 0.19.1 Beta](https://github.com/Tuxion/mokuji/tree/0.19.1-beta)
_31-May-2013_

* Removed old version tags and removed references to them in `CHANGES.md`.

#### [Version 0.19.0 Beta](https://github.com/Tuxion/mokuji/tree/0.19.0-beta)
_31-May-2013_

* From now on this CMS is called Mokuji (目次).
* New version naming system and release cycle.
* `security` component has been added.
* Underduck theme and template have been added.
* Added image uploading to `timeline` component.
* Password reset function added.
* Sessions can now be closed by the core to improve performance.
* Log in form uses AJAX to be faster and more user friendly.
* Module created for `timeline` component to display entries based on page settings.
* `timeline` component has better date-time formatting options.
* `timeline` component now has an option to hide entries in the past.
* CKEditor now has template options.
* The `ensure_pagetypes` helper now has an option to delete.
* Themes and templates no longer are split into a `system` and `custom` folder.
* Option to extend URL keys has been implemented by CMS entrypoint.
  - Pagetypes need to make use of this information for it to do anything.
* New settings manager.
  - Includes website information
  - Includes CMS configuration
  - Includes security settings
* Security changes:
  - Default permission requirements for new controllers is set to administrator.
  - Added .htaccess files to protect sensitive folders.
  - Fixed SQL injection vulnerability.
  - Improved TLS support (using `security` component).
  - Added a `without()` function to `\dependencies\Data` to filter sensitive information.
  - Created a CAPTCHA helper. [Read more](http://development.mokuji.org/31/captcha?menu=32)
  - Removed several unused functions.
* Bug fixes:
  - Fixed many translations in nl-NL (using [SDK component](https://github.com/Tuxion/mokuji-sdk)).
  - Fixed highlighting menu items.
  - Fixed ORM model caching problems in `update` component.
  - Fixed findability tab layout bugs.
  - Fixed bug where `timeline` titles would submit multiple times.
  - Used workaround for PHP bug where multiple instances at the same time bugs some static variables.
  - Pretty URL's now have menu item ID's so menu modules and breadcrumbs switching on this don't break.
  - Shimmed the `string.trim()` function for IE8.
  - Fixed bug that didn't allow `tx-require-admin` to submit an empty `url_path` to `init.php`.
  - Fixed bug that caused `ENUM` datatype in ORM to be split incorrectly.
  - Staying idle in the backend no longer logs you out.

#### Version 1.2.0 Beta (Old versioning system)
_11-Apr-2013_

* Timeline component (enabling blogs) now added to the base components.
* Translation formatting is now added, so translations can handle indexed variables.
* New ORM features:
  - Added `Table->helper`.
  - Added `Table->distinct`.
  - Improved `Table->join` which now supports join conditions.
* UI improvements:
  - Findability tabs has had a visual upgrade.
  - Added a "set as homepage" checkbox in the configuration tab for every page.
  - The active menu item is now highlighted in the backend.
  - The 'home' button in the site switcher now takes you to the page you were viewing in the backend.
* CMS improvements:
  - Default language can be set per site.
  - Greatly improved the jQuery.restForm plugin.
  - SimplePageType now allow simple forms and datasources.
  - Implemented a CSV import helper in the core.
  - Added helper for page-type deployment.
  - Created table helpers for permissions.
  - Integrated translating with the SDK to log untranslated phrases and missing files.
  - Validation translations are now optional.
  - Implemented experimental javascript translations.
  - Added new validators `component_name`, `jid` and `phonenumber`.
  - Page titles can now be recommended by the page-type controller.
  - Menu-items now need a confirm before being deleted.
  - The `BaseModel->render_form` function can now exclude fields.
* Bug fixes:
  - The install wizard is no longer unresponsive when saving the website configuration.
  - The site switcher did not work as expected.
  - Stack traces now display HTML tags in arguments properly.
  - String based primary keys no longer breaks the `BaseModel->save` function.
  - Detach page has been fixed.

#### Version 1.1.0 Beta 2 (Old versioning system)
_21-Mar-2013_

* Important updates
  - Installer bug that prevented installing completely.
  - Homepage system implemented to prevent having to edit DB manually.
  - URL parser did not properly detect external URLs.
* Critical security update
  - elFinder remote code execution exploit.

#### Version 1.1.0 Beta 1  (Old versioning system)
_5-Mar-2013_

* Base components are now fully driven on the PageTypes architecture.
* Automatically generated forms have the ability to detect field types based on ORM relations.
* Upgraded to the latest CKEditor release.
* Backend now has the capacity to include a help chat.
* Greatly improved overall stability.
* UI improvements:
  - Implemented a feedback overlay for the CMS backend.
  - Improved findability tab design.
  - Menu items can be collapsed.
  - New "detach item" design.
  - Added Tuxion theme for CKEditor.
  - Tuxion logo can be removed by a setting in the `config/miscelanious.php` file.
  - Added edit button to the admin toolbar for frontend editing.
* CMS improvements:
  - Page titles now have a default and are optional.
  - File handlers have a filesize getter.
  - Enabled additional text to be added to text pages.
  - Uses improved image uploader from `media` component.
  - Better search results for `text` component.
  - Implemented automatically generated forms based on ORM relations.
  - Created documentation tools and started adding code documentation.
  - Added very basic validation translations (should be further improved).
  - Lipsum helper function `lipsum()`.
  - Added shorter notation for checking if the user is logged in.
  - Added more debugging paths in core components.
  - Made URL validation more strict, fixes #43.
  - Updated CKEditor to 4.0.1.1 (20 Feb 2013).
  - Menu items are multilingual now.
  - Creating PageTypes has been greatly simplified.
  - All existing base components now use PageTypes.
  - Added support for the `helpchat` component.
* Bug fixes:
  - Several plug-ins had missing files.
  - Lowered check for MySQL version requirement down to `5.x` from `5.0.3+`.
  - Removed dependency to non-base component `language`.
  - Login screen no longer gives missing jQuery errors.
  - Fatal errors no longer delete session data or log out the user.
  - Page permissions are displayed and saved properly again.
  - The installation script works again.
  - REST forms now properly focus the first field with an error.
  - Removed some PHP `5.3.2` backward compatibility bugs.
  - Claiming account has been rewritten to work with the current core.
  - Account profiles have been rewritten to work with the current core.
  - Added default tx/skin.js to CKEditor plugin, fixes #36.
  - Made sure default theme and template are picked for new pages, fixes #41.
  - The `New versions loaded!` string displays properly again when updating.
  - Added first language title to install script.

#### Version 1.0.1 Beta 1 (Old versioning system)
_17-Jan-2013_

* Automatically generated forms give much better feedback to the user submitting them.
* Automatically generated forms are better and support additional field types.
* Lowered MySQL version requirement down to `5.x` from `5.0.3+`.
* Updated the text editor to 4.0, making it faster, better, prettier etc.
* UI improvements:
  - The text editor has a new skin.
  - The profile button is back!
  - New icons.
* Many bug fixes:
  - Actually check for the required version of MySQL instead of just presence of it at install.
  - The install script can now be run from the get go.
  - The install script no longer randomly stops.
  - Deleting pages now works.
  - Pages now are properly named, instead of always being called "New Page".
  - Saving menu items, pages and texts should now cause no more trouble.

#### Version 1.0.0 (Old versioning system)

* The first stable version to be recorded as a version.

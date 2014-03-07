#### [Version 0.31.0 Beta](https://github.com/Tuxion/mokuji/tree/0.31.0-beta)
_07-Mar-2014_

* README.md can now be used for themes and templates as package information.

#### [Version 0.30.0 Beta](https://github.com/Tuxion/mokuji/tree/0.30.0-beta)
_07-Feb-2014_

* Replaced the password strength check with a better one.
* Added the jQuery.PasswordStrenght plug-in to display password strength and improvement tips.

#### [Version 0.29.0 Beta](https://github.com/Tuxion/mokuji/tree/0.29.0-beta)
_05-Feb-2014_

* Added a CLI for actions (useful for cronjobs).
* Added database backup functionality.

#### [Version 0.28.6 Beta](https://github.com/Tuxion/mokuji/tree/0.28.6-beta)
_04-Feb-2014_

* Fixed a bug which caused "required" form fields to not actually be required for the empty value to make it to the database.

#### [Version 0.28.5 Beta](https://github.com/Tuxion/mokuji/tree/0.28.5-beta)
_30-Jan-2014_

* Fixed an undefined variable bug with IP blacklisting.
* Fixed a bug where `/index.php` was not detected by the LegacyUrlFormat.
* Fixed a problem with `Data->filter()` not preserving models.
* Fixed a bug with `jquery_datatables` plugin and it's i18n files.

#### [Version 0.28.4 Beta](https://github.com/Tuxion/mokuji/tree/0.28.4-beta)
_15-Jan-2014_

* Added some function aliases to allow access through both REST interfaces.
* Improved MySQL version detection for install script.
* Fixed some PHP 5.3.8 compatibility bugs.
* Updated CGI version of the `.htaccess` file.
* Fixed problems with parallel calls using the same persistent authentication cookie to log in.
* Fixed a bug that caused the install wizard to fail when given a configuration value with a quotation symbol.

#### [Version 0.28.3 Beta](https://github.com/Tuxion/mokuji/tree/0.28.3-beta)
_12-Dec-2013_

* Added style to frontend editing.

#### [Version 0.28.2 Beta](https://github.com/Tuxion/mokuji/tree/0.28.2-beta)
_10-Dec-2013_

* Updated underscore JavaScript plugin.

#### [Version 0.28.1 Beta](https://github.com/Tuxion/mokuji/tree/0.28.1-beta)
_5-Dec-2013_

* Added external URL pagetype.
* Added forced_template_id code to CMS.
* Added status to curl function.
* Fixed menu problems, by returning proper model instances with Resultset::hwalk.
* Fixed 5.3.x compatibility bugs.
* Removed a Tuxion CMS reference.

#### [Version 0.28.0 Beta](https://github.com/Tuxion/mokuji/tree/0.28.0-beta)
_3-Dec-2013_

URL keys

* Implemented URL format in CMS
* Automatically generate URL keys for pages
* Now no longer redirects for the homepage URL formatting (stays on root)
* Throw 404 error if page doesn't exist.
* Improved menu module, prettier LegacyUrlFormat and url_key validation in backend.

First prototype of editable is working!

* Added inline editing functionality (merge branch inline_editing).
* Added LineTemplate and more.
* Only save when there are changes, the proper way.
* Made blog posts in-line editable.

And many bugs and papercuts fixed.

#### [Version 0.27.7 Beta](https://github.com/Tuxion/mokuji/tree/0.27.7-beta)
_27-Okt-2013_

* Fixed a bug which occurred when trying to log in. Ouch.

#### [Version 0.27.6 Beta](https://github.com/Tuxion/mokuji/tree/0.27.6-beta)
_27-Okt-2013_

Account:
* `/account/me` To get the user object.
* `/account/login_status` To get the users access level.
* Created controller factory and base controller.
* Created SessionController.
* Migrated user session business from Actions and Json to SessionController.

Misc:
* Added Mokuji logo to installation wizard.
* Minor improvements in backend UI.
* Fixed bug, so you can set a different entrypoint for front- and backend.
* Added md5 to the hash algoritms to choose from. See commit message.
* Fixed bugs caused by core updates and IE9.
* Added ATOM feed based on timeline entries.

#### [Version 0.27.5 Beta](https://github.com/Tuxion/mokuji/tree/0.27.5-beta)
_13-Nov-2013_

* The `url` validator rule now respects the `required` rule.
* The `number` validator rule now validates float and double types appropriately.
* Added two missing variables in the `/rest/` interface.

#### [Version 0.27.4 Beta](https://github.com/Tuxion/mokuji/tree/0.27.4-beta)
_31-Okt-2013_

* The new REST interface now returns empty fields as NULL instead of letting the key disappear.
* Fixed two translating bugs.

#### [Version 0.27.3 Beta](https://github.com/Tuxion/mokuji/tree/0.27.3-beta)
_18-Okt-2013_

* Cleaned the page manager somewhat.
* Added placeholder to show default value in language specific website settings.
* Now copying website title to site meta-information as well as multi-site information during install.
* CMS settings now has select fields for themes, templates and languages.

#### [Version 0.27.2 Beta](https://github.com/Tuxion/mokuji/tree/0.27.2-beta)
_16-Okt-2013_

* Improved page title editing to be more user friendly and effective.

#### [Version 0.27.1 Beta](https://github.com/Tuxion/mokuji/tree/0.27.1-beta)
_15-Okt-2013_

* The /rest/ interface now supports custom errors for (Model)Validation exceptions.

#### [Version 0.27.0 Beta](https://github.com/Tuxion/mokuji/tree/0.27.0-beta)
_14-Okt-2013_

* Added a new REST interface at /rest/<path> (?rest=<path> still exists).

#### [Version 0.26.9 Beta](https://github.com/Tuxion/mokuji/tree/0.26.9-beta)
_9-Okt-2013_

* Made some performance optimizations in the Data and BaseModel classes.
* Fixed jQuery tmpl encoding problems, causing malformed data in most editors.

#### [Version 0.26.8 Beta](https://github.com/Tuxion/mokuji/tree/0.26.8-beta)
_7-Okt-2013_

* Added functionality to log in as a specific user based on user ID, by using become_user().
* Fixed a bugs in installation and update script.

#### [Version 0.26.7 Beta](https://github.com/Tuxion/mokuji/tree/0.26.7-beta)
_25-Sept-2013_

* Security update: Improved random bits sources. Fixing several problems with weak or no random data.
* Bugfixes:
    - Corrected a typo in the update component.
    - Setting config values using mk('Config') now checks if it needs to insert.
    - The REST interface now properly implements UTF-8.

#### [Version 0.26.6 Beta](https://github.com/Tuxion/mokuji/tree/0.26.6-beta)
_23-Sept-2013_

* Fixed Table::count() bug.
* Fixed install bug when tables are not overwritten.

#### [Version 0.26.5 Beta](https://github.com/Tuxion/mokuji/tree/0.26.5-beta)
_21-Sept-2013_

* Bugfix.
* Fixed hyperlinks in docs/ORM.md.

#### [Version 0.26.4 Beta](https://github.com/Tuxion/mokuji/tree/0.26.4-beta)
_21-Sept-2013_

* Added DocBlocks to the Table class.
* Added documentation: Using the Mokuji ORM.

#### [Version 0.26.3 Beta](https://github.com/Tuxion/mokuji/tree/0.26.3-beta)
_18-Sept-2013_

* Bugfixes and tweaks
    - Improved compatibility for .htaccess rewrite rules.
    - Added more licensing details for the login backgrounds (see `/mokuji/themes/tx_login/css/style.css`).
    - Added `autofocus` option to the login and register forms.
    - Added `target_url` parameter for the login REST call.
    - Added a CSS class to fieldsets generated by `render_form` based on it's title.

#### [Version 0.26.2 Beta](https://github.com/Tuxion/mokuji/tree/0.26.2-beta)
_16-Sept-2013_

Papercuts:
* Made accounts/Accounts model better extendable.
* Made formToObject JS work in Internet Explorer 8-.
* Made Entrypoint Component adjustable.
* Translations.
* Small modifications.

#### [Version 0.26.1 Beta](https://github.com/Tuxion/mokuji/tree/0.26.1-beta)
_12-Sept-2013_

* Bugfixes
    - Added a .htaccess-cgi file to fix a CGI problem.
    - Added the `old_title` key again to the core `package.json`.
    - The `CoreUpdate` class now properly detects file references with HTTP vs HTTPS and including www or without.
    - The `File` class leaves capitalization of file extensions alone now.

#### [Version 0.26.0 Beta](https://github.com/Tuxion/mokuji/tree/0.26.0-beta)
_11-Sept-2013_

* Added account registration functionality.
* Implemented a module to display a registration form.
* Improved `$.restForm` by returning a form reference to callback functions.
* Improved the PageType system with a `template(key, data)` javascript function.
* Added `indenting_field` option with `Data()->as_options()`.
* Added `$path` variable inside plugins.
* Improved `str_max` which now trims whitespace.
* Added fieldsets to `render_form`.
* Improved `render_form` by allowing "bonus fields".
* Improved `Image` class to detect diversions from the requested operations.
* Bugfixes
    - Fixed permission problem with the `keep_alive` call.
    - Securimage now works with the new core structure.
    - Restored the `.clearfix` class to `globals.css`.
    - Outputbuffer core class had some typo's.
    - Fixed a query in the core's `update_to_0_10_0_beta` function.
    - Fixed a bug with the `create_file_reference_update` step of the core update script.
    - Missed an update path in `update` component.

#### [Version 0.25.1 Beta](https://github.com/Tuxion/mokuji/tree/0.25.1-beta)
_3-Sept-2013_

* Bugfixes in `update` component.
    - Fixed update bug for inserting new components.

#### [Version 0.25.0 Beta](https://github.com/Tuxion/mokuji/tree/0.25.0-beta)
_3-Sept-2013_

* Restructured the `update` component.
    - New support for referencing packages by reference ID.
    - New support for the `old_title` key in `package.json` files.

#### [Version 0.24.0 Beta](https://github.com/Tuxion/mokuji/tree/0.24.0-beta)
_29-Aug-2013_

* Core
  - Allow persistent login.
* Account
  - Added "remember me" button to login form.

#### [Version 0.23.0 Beta](https://github.com/Tuxion/mokuji/tree/0.23.0-beta)
_29-Aug-2013_

* [Major core rework](http://development.mokuji.org/60/core-codenames?menu=62&action=language%2Fset_language&language_id=1).
    - Moved files to a better folder structure.
    - Created an Initializer class to replace the init.php script and improve 3rd party integration.
    - Reduced reserved words for folders in the root. They are now `/admin`, `/install` and `/mokuji`.
    - Extended the class autoloader to include component classes.
    - Created an upgrade script to assist in upgrading to the new Ballistic Badger core.
* Added new global I/O functions `recursive_move` and `recursive_delete`.
* Fixed a bug in the Url class, you can now refer to sub-folders that have the same name as the `URL_PATH`.
* Fixed a bug in the Sql class, setting DB connection data during installation now works again after PDO upgrade.

#### [Version 0.22.2 Beta](https://github.com/Tuxion/mokuji/tree/0.22.2-beta)
_9-Aug-2013_

* Fixed a bug when installing with the new PDO setup.
* Removed some Tuxion CMS references.

#### [Version 0.22.1 Beta](https://github.com/Tuxion/mokuji/tree/0.22.1-beta)
_7-Aug-2013_

* Allowed FormBuilder class to be extended, switching private variables to protected.

#### [Version 0.22.0 Beta](https://github.com/Tuxion/mokuji/tree/0.22.0-beta)
_5-Aug-2013_

* Updated core to work with PDO:MySql
* Updated installation script to work with PDO:MySql
* Fixed a bug in text component using a mysql function directly.

#### [Version 0.21.4 Beta](https://github.com/Tuxion/mokuji/tree/0.21.4-beta)
_1-Jul-2013_

* Fixed a scoping problem with older PHP version in BaseDBUpdates.
* Moved private helper function BaseDBUpdates::vtfn($version) to system helpers.

#### [Version 0.21.3 Beta](https://github.com/Tuxion/mokuji/tree/0.21.3-beta)
_1-Jul-2013_

* Added more entropy to the generation of random table aliases. Fixes #59.
* Added DocBlocks and better code comments here and there.

#### [Version 0.21.2 Beta](https://github.com/Tuxion/mokuji/tree/0.21.2-beta)
_26-Jun-2013_

* Fixed a bug that occurred when setting a page as home-page via the configuration tab.

#### [Version 0.21.1 Beta](https://github.com/Tuxion/mokuji/tree/0.21.1-beta)
_26-Jun-2013_

* Updated CKEditor to 4.1.2 (10 Jun 2013)

#### [Version 0.21.0 Beta](https://github.com/Tuxion/mokuji/tree/0.21.0-beta)
_24-Jun-2013_

* Added option for configuring the CKEditor toolbar.
* Increased size for value fields in core configuration tables.

#### [Version 0.20.3 Beta](https://github.com/Tuxion/mokuji/tree/0.20.3-beta)
_7-Jun-2013_

* Fixed installing bug in Underduck template.

#### [Version 0.20.2 Beta](https://github.com/Tuxion/mokuji/tree/0.20.2-beta)
_6-Jun-2013_

* Changed documenting tool to use phar file.

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

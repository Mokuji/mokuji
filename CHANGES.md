#### Development



#### [Version 1.1.0 Beta 1](https://github.com/Tuxion/tuxion.cms/tree/v1.1.0-beta1)
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

#### [Version 1.0.1 Beta 1](https://github.com/Tuxion/tuxion.cms/tree/v1.0.1-beta1)
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

#### [Version 1.0.0](https://github.com/Tuxion/tuxion.cms/tree/v1.0.0)

* The first stable version to be recorded as a version.

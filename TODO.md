# Account restructure TODO list

Make sure to delete this when done.

## Principles

- The core never provides management tasks. Use components for that.
- Functions provided by the core should be related to core tables.
  IE: group permission functions are only allowed if groups are defined in the core tables.
- The core delegates all logic to the designated component.
- When no component is designated, do not run the framework.

## Sub-components

1. Cooperating with the core
2. Authentication tasks
3. Permission tasks
4. User management tasks
5. Group management tasks
6. Configuration

### 1. Cooperating with the core

Current dependencies:

- Core classes use the `mk('Account')->check_level` function.
- The `mk('Account')->user` data is abused all over the place.
- The account component uses the majority of `mk('Account')` features.
- The `mk('Account')->page_authorisation(2)` clause used to be a thing, before the level 2 default permissions probably.
- The cms component uses various checks and even login logic from `mk('Account')`.
- External components (like community) uses the `mk('Account')->user` object for things like comparing user ID's with owner ID's.
- External components use the `->check('login')` function on the user object for checking user level 1+.
- External components use the `mk('Account')->is_login()` function on object for checking user level 1+.
- Update component uses `mk('Account')->register()` for the install script's first admin user.
- Some old components made their own `mk('Account')->login()` calls (same for register).

Desirable setup:

* All authentication and permission tasks should be handled by the account component, not the core.
* A proper interface should be written for the `mk('Account')` properties and methods.
* `mk('Account')` should provide easy yet predictable access to common permission and authentication checking features.
* `mk('Account')->user` should be information about the user only (ID, username, email, etc...). Not permissions.
* The account component should be able to alter the `mk('Account')` class.
* It should be possible to define which component takes care of implementing / extending the account features.
* Deprecation warnings should be issued by the account component, not the core.

### 2. Authentication tasks

* Login
* Logout
* Create remember me cookie
* Verify remember me cookie
* Claiming??
* Banning??

### 3. Permission tasks

Because introducing new permission systems will take a while to propagate to all components,
backward compatibility should be maintained for components. The core may be altered though.

However, the ability to extend or swap out permission systems would be nice.

Minimum for backward compatibility:

* Check level (used everywhere)
* Is logged in

Commonly used (may not want in this task though):

* Is level 1 / 2
* Is logged in
* Member of a group (possibly a list of groups)
* User ID matches owner ID

Best to offer:

* Level checking for backward compatibility
* Is logged in, because you want to differ between guests (also backwards compatibility until you apply guest rules)

????

#### 4. User management tasks

* Create user
* Edit user
* Delete user
* Register user
* Password forgotten
* Claiming??
* Banning??

#### 5. Group management tasks

* Create group
* Edit group
* Delete group

#### 6. Configuration

* Which component handles the core link
* Login throttling
* Allow registration
* Logging levels
* User settings (language, font size, theme, html or markdown editor, ...)??
* User level mode or permissions mode??

Would be nice to set a class that handles the storage part.
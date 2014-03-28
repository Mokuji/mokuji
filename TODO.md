# Account restructure TODO list

Make sure to delete this when done.

## Principles

- The core never provides full management tasks, only the tools needed to perform it properly.
- Use components for the actual management implementations.
- Functions provided by the core should be related to core tables.
- Usergroups will not be part of the core.
- The core handles the majority of the logic, to provide a consistent API.

## Sub-components

1. Cooperating with the core
2. Authentication tasks
3. Permission tasks
4. User management tasks
5. Configuration

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

* All authentication and permission tasks should be handled by the core.
* Management tasks should be initiated by the account component, however the core is responsible for maintaining a stable state.
* A proper interface should be written for the `mk('Account')` properties and methods.
* `mk('Account')` should provide easy yet predictable access to common permission and authentication checking features.
* `mk('Account')->user` should be information about the user only (ID, username, email, etc...). Not permissions.
* Deprecation warnings for security related reasons should be issued by the core.

### 2. Authentication tasks

- Login
- Logout
- Create remember me cookie
- Verify remember me cookie
* Claiming??
* Email verification??
* Action tokens (random keys to authenticate e-mail actions like claiming, email verification or password reset).

### 3. Permission tasks

Because introducing new permission systems will take a while to propagate to all components,
backward compatibility should be maintained for components. The core may be altered though.

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

* Check for problems (like duplicates).
  Send mail to admin every week when duplicates exist.
  Send mail when user blocked because of duplicates.
- Create user
- Edit user
- Delete user
* Password forgotten
* Claiming??
* Banning??
* Require password change??

#### 5. Configuration

* Login throttling = yes / no
* Allow registration = yes / no
* Persistent cookie support = yes / no
* Persistent cookie name = <string>
* Max session lifetime (seconds) = <int>
* Max become_user session lifetime (seconds) = <int>
* Minimum level for become_user action = <int> (0:anyone, 1:users+admins, 2:admins, 3+:nobody)

* Notify admins of newly registered users = yes / no

* ??? Restrict become_user to level 1 = yes / no

# Finally

* Clean up email templating stub.
* Create and Edit user are very similar, make more DRY?
* Add installer to core dbupdates to skip the old update methods.

Regex to check for deprecated usage.

`(tx|mk)\(['"]Account['"]\)->(user-|become_user|register|is_login|check_level|page_authorisation)`
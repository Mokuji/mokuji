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

**Done**

### 2. Authentication tasks

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
* Maybe move php_mailer to base and move send_fleeting_mail features.
* Create and Edit user are very similar, make more DRY?
* Add installer to core dbupdates to skip the old update methods.

Regex to check for deprecated usage.

`(tx|mk)\(['"]Account['"]\)->(user-|become_user|register|is_login|check_level|page_authorisation)`
# You have been invited to {{site_name}}!

An account has been created for you and you can claim it now.
All you need to do is use the link below to set a password.

Claim your account here:

[{{claim_url}}]({{claim_url}})

Your account information:

{% if user.full_name %}* Name: {{user.full_name}}{% endif %} 
* Username: {{user.username}}
* E-mail: {{user.email}} {% if user.dt_email_verified %}(not verified){% endif %} 
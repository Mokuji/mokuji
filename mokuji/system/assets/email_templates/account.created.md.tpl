# Welcome to {{site_name}}!

Your account has been created.

Your account information:

{% if user.full_name %}* Name: {{user.full_name}}{% endif %} 
* E-mail: {{user.email}} {% if verify_email_url %}(not verified){% endif %} 
* Username: {{user.username}}
* Password: _hidden_

{% if verify_email_url %}
You can verify your e-mail address here:

[{{verify_email_url}}]({{verify_email_url}})
{% endif %}
Emil Beli<br>
beli0135@gmail.com<br>

## Setup: Preparation
- Create database ex. "<font color="rgb(187 247 208)">menutest</font>"
- Edit .env file and setup database connection parameters

<pre><code>
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=menutest
DB_USERNAME=root
DB_PASSWORD=
</code></pre>

Also, set your mail configuration
<pre>
MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

#---- I used mailtrap for testing ---
#MAIL_LOCAL_DOMAIN=menutest
#MAIL_MAILER=smtp
#MAIL_HOST=smtp.mailtrap.io
#MAIL_PORT=2525
#MAIL_USERNAME=
#MAIL_PASSWORD=
#MAIL_ENCRYPTION=tls
#MAIL_FROM_ADDRESS=test@test.com
#MAIL_FROM_NAME="${APP_NAME}"
</pre>

- Run
<pre><code>php artisan migrate --pretend</code></pre>
If everything is OK, database is set.

# Setup
<pre><code>php artisan migrate:fresh --seed</code></pre>

Configure delivery e-mail address if needed:
<pre>
config/menutest.php

return [
    'to_mail_address' => 'test@example.org',
];
</pre>

Final touch, rebuild route and config cache
<pre>php artisan optimize</pre>

# Updating exchange rates

To update exchange rate, a command is created, which can be executed from Cron.
<pre>
php artisan app:update-exchange-rates

//or from Cron (bash)
* * * * * php /path/to/artisan app:update-exchange-rates
</pre>

Additionally, there are two API routes:
<pre><code>
// query exchange rates, just for info, if needed
GET: {{url}}/api/exchange-rates

// update exchange rates
POST: {{url}}/api/update-exchange-rates
</code></pre>



# Automated tests
<pre>php artisan test</pre>

Check database after running tests. If tables are empty, you may need to run
<pre>
php artisan cache:clear
php artisan config:clear

//seed database again
php artisan migrate:fresh --seed
</pre>

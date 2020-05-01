<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## Installation instructions

- Extract the archive and put it in the folder you want
- Run <pre><code> cp .env.example .env </pre></code> file to copy example file to <pre><code>.env</pre></code>
Then edit your <pre><code>.env</pre></code> file with DB credentials and other settings.
- Run <pre><code>composer install</pre></code> command
- Run <pre><code>php artisan migrate --seed</pre></code> command.
Notice: seed is important, because it will create the first admin user for you.
- Run <pre><code>php artisan key:generate</pre></code> command.
- If you have file/photo fields, run <pre><code>php artisan storage:link</pre></code> command.
- If you run a SaaS project, add your Stripe credentials and plans: read more here

And that's it, go to your domain and login:

Username:	<pre><code>admin@admin.com</pre></code>
Password:	<pre><code>password</pre></code>

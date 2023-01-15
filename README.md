## Laravel Eloquent Factories

In this repository, I'm' going to show how to use Laravel 9 Factories and seeder with an example. This repository is intended for those who have a basic understanding of Laravel and are looking to expand their knowledge. I will be using a practical example to demonstrate how Factories and Seeders can be used to generate dummy data for testing purposes.

Let's get started!

## Overview

Look at one of the following topics to learn more about Laravel Eloquent Factories.

* [Requirements](#requirements)
* [Installation](#installation)
* [Usage](#usage)
* [Official Documentation](#official-documentation)


## Requirements
- PHP >= 8.0.0
- Laravel >= 9.0.0
- MySQL  >= 8.0.0

## Installation

Before creating Laravel project, you should ensure that your local machine has PHP and [Composer](https://getcomposer.org/) installed. Assuming you have already configured your database and completed installation, you are now all set to go.

However, let me explain the steps for those who need to have.

After you have installed PHP and Composer, you may create a new Laravel project via the Composer create-project command:

```shell
composer create-project laravel/laravel laravel-eloquent-factories
```

Or, you may create new Laravel project by globally installing the Laravel installer via Composer:

```shell
composer global require laravel/installer

laravel new laravel-eloquent-factories
```

After the project has been created, start Laravel's local development server using the Laravel's Artisan CLI serve command:

```shell
cd laravel-eloquent-factories

php artisan serve
```

## Example

First, creating migration for database structure as below:

After creating migration for posts, I added the following columns which are needed to be used. Of course some ones are optional, it is up to you.

```shell
php artisan make:migration create_posts
```

```php
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('title')->unique();
            $table->string('excerpt')->unique();
            $table->string('body');
            $table->string('min_to_read')->default(1);
            $table->string('image_path');
            $table->string('is_published');
            $table->timestamps();
        });
```

After creating migration for tags, I added the following columns which are fundamental requirements.

```shell
php artisan make:migration create_tags
```

```php
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
        });
```

After creating migration for post and tag, I added the following columns which are required regarding relation between posts and tags.

```shell
php artisan make:migration create_post_tag
```

```php
        Schema::create('post_tag', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('tag_id');
            $table->timestamps();
        });
```
## Official Documentation

Please see [Eloquent: Factories](https://laravel.com/docs/9.x/eloquent-factories) for more information on Laravel documentation.

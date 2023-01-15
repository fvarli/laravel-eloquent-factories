## Laravel Eloquent Factories

In this repository, I'm' going to show how to use Laravel 9 Factories and seeder with an example. This repository is
intended for those who have a basic understanding of Laravel and are looking to expand their knowledge. I will be using
a practical example to demonstrate how Factories and Seeders can be used to generate dummy data for testing purposes.

Let's get started!

## Overview

Look at one of the following topics to learn more about Laravel Eloquent Factories.

* [Requirements](#requirements)
* [Installation](#installation)
* [Example](#example)
* [Official Documentation](#official-documentation)

## Requirements

- PHP >= 8.0.0
- Laravel >= 9.0.0
- MySQL  >= 8.0.0

## Installation

Before creating Laravel project, you should ensure that your local machine has PHP
and [Composer](https://getcomposer.org/) installed. Assuming you have already configured your database and completed
installation, you are now all set to go.

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

After the project has been created, start Laravel's local development server using the Laravel's Artisan CLI serve
command. Thus, you can ensure everything installed properly.

```shell
cd laravel-eloquent-factories

php artisan serve
```

## Example

### Migrations

First, let's describe what Laravel Migration is and create migrations for database structure as below:

#### What is Laravel Migration?

Laravel Migration is an essential feature in Laravel that allows you to create a table in your database. It allows you
to modify and share the application's database schema. You can modify the table by adding a new column or deleting an
existing column.

You can use the artisan make:migration command line helper to generate new migrations for your application. To create a
new migration for your posts table, run:

```shell
php artisan make:migration create_posts
```

After creating migration for posts, I added the following columns which are needed to be used. Of course some ones are
optional, it is up to you.

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

After creating migration for post and tag, I added the following columns which are required regarding relation between
posts and tags.

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

### Models

Now, let's describe what Laravel Model is and create models for Eloquent ORM (Object-Relational Mapping) structure as
below:

#### What is Laravel Model?

A Model is basically a way for querying data to and from the table in the database. Laravel provides a simple way to do
that using Eloquent ORM (Object-Relational Mapping). Every table has a Model to interact with the table. Eloquent uses
database models to represent tables and relationships in supported databases. The name of the database table is
typically inferred from the model name, in plural form. For instance, a model named Post will use posts as its default
table name.

You can use the artisan make:model command line helper to generate new models for your application. To create a new
Eloquent model for your posts table, run:

```shell
php artisan make:model Post
```

After creating model for Post, I added the following functions which are needed to be used. Since user has one more
posts, relation should be belongsTo as reverse. Since post and tag have many-to-many relation between them, relation
with Tag should be belongsToMany as reverse.

```php
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
```

After creating model for Tag, I added the following function which is needed to be used. Since post and tag have
many-to-many relation between them, relation with Post should be belongsToMany as reverse.

```shell
php artisan make:model Tag
```

```php
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
```

User model already is existing since when creating a Laravel Project. So I added the following function since a user can
have one more posts.

```php
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
```

### Factories

Now, let's describe what Laravel Factory is and create factories for dummy data as below:

#### What is Laravel Factory?

When testing your application or seeding your database, you may need to insert a few records into your database. Instead
of manually specifying the value of each column, Laravel allows you to define a set of default attributes for each of
your Eloquent models using model factories.

You can use the artisan make:factory command line helper to generate new factories for your application. To create a new
Eloquent model for your posts table, run:

```shell
php artisan make:factory PostFactory
```

After creating factory for Post, I added the following dummy data for each column where was added to posts table with
migration above.

```php
        return [
            'title' => $this->faker->unique()->sentence(),
            'excerpt' => $this->faker->realText(maxNbChars: 50),
            'body' => $this->faker->text(),
            'image_path' => $this->faker->imageUrl(640,480),
            'is_published' => 1,
            'min_to_read' => $this->faker->numberBetween(1,10)
        ];
```

After creating factory for Tag, I added the following dummy data for name and slug columns where were added to tags
table with migration above. For slug, its name can be used as shown below.

```shell
php artisan make:factory TagFactory
```

```php
        $name = ucwords($this->faker->word);

        return [
            'name' => $name,
            'slug' => Str::slug($name)
        ];
```

User factory already is existing since when creating a Laravel Project. I kept the user factory as it is since I changed
noting regarding users table.

## Official Documentation

Please see [Eloquent: Factories](https://laravel.com/docs/9.x/eloquent-factories) for more information on Laravel
documentation.

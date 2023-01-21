## Laravel Eloquent Factories

In this repository, I'm going to show how to use Laravel 9 Factories and seeder with an example. This repository is
intended for those who have a basic understanding of Laravel and are looking to expand their knowledge. I will be using
a practical example to demonstrate how Factories and Seeders can be used to generate dummy data for testing purposes.

Let's get started!

## Overview

In this repository, you'll find information on the following topics:


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
and [Composer](https://getcomposer.org/) installed. Assuming you have already configured your database and completed installation, you are now all set to go.

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

After the project has been created, start Laravel's local development server using the Laravel's Artisan CLI serve command. Thus, you can ensure everything installed properly. Please also configure your database connection.

```shell
cd laravel-eloquent-factories

php artisan serve
```

## Example
In this section, I'll go through an example of how to use migrations and models to create a database structure and interact with it using Eloquent ORM.

### Migrations

First, let's describe what Laravel Migration is and create migrations for the database structure.

#### What is Laravel Migration?

Laravel Migration is an essential feature that allows you to create tables in your database and modify them. You can use the php artisan make:migration command line helper to generate new migrations for your application.

You can use the artisan make:migration command line helper to generate new migrations for your application.

After creating a migration for posts, I added the following columns which are needed to be used. Of course, some are optional, it is up to you. To create a new migration for your posts table, run the following command and add new columns to the posts table:

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

After creating a migration for tags, I added the following columns as they are fundamental requirements.

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

### Models

Now, let's describe what Laravel Model is and create models for Eloquent ORM (Object-Relational Mapping) structure as below:

#### What is Laravel Model?

A Model is basically a way for querying data to and from the table in the database. Laravel provides a simple way to do that using Eloquent ORM (Object-Relational Mapping). Every table has a Model to interact with the table. Eloquent uses database models to represent tables and relationships in supported databases. The name of the database table is typically inferred from the model name, in plural form. For instance, a model named Post will use posts as its default table name.

You can use the artisan make:model command line helper to generate new models for your application.

After creating model for Post, I added the following functions which are needed to be used. Since user has one more posts, relation should be belongsTo as reverse. Since post and tag have many-to-many relation between them, relation with Tag should be belongsToMany as reverse. To create a new Eloquent model for your posts table, run the following command and add the following functions regarding the relations:

```shell
php artisan make:model Post
```

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

After creating model for Tag, I added the following function which is needed to be used. Since post and tag have many-to-many relation between them, relation with Post should be belongsToMany as reverse.

```shell
php artisan make:model Tag
```

```php
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
```

User model already is existing since when creating a Laravel Project. So I added the following function since a user can have one more posts.

```php
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
```

### Factories

Now, let's describe what Laravel Factory is and create factories for dummy data as below:

#### What is Laravel Factory?

When testing your application or seeding your database, you may need to insert a few records into your database. Instead of manually specifying the value of each column, Laravel allows you to define a set of default attributes for each of your Eloquent models using model factories.

You can use the artisan make:factory command line helper to generate new factories for your application.

After creating factory for Post, I added the following dummy data for each column where was added to posts table with migration above. To create a new Eloquent model for your posts table, run add the faker date for each column which is necessary:

```shell
php artisan make:factory PostFactory
```

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

After creating factory for Tag, I added the following dummy data for name and slug columns where were added to tags table with migration above. For slug, its name can be used as shown below.

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

User factory already is existing since when creating a Laravel Project. I kept the user factory as it is since I changed noting regarding users table.


### Seeders

Now, let's describe what Laravel Seeder is and create seeder as below:

#### What is Laravel Seeder?

Laravel offers a tool to include automatically dummy data to the database which means called seeding. The database seeder is used for adding simply testing data to database.

You can use the artisan make:seeder command line helper to generate new seeders for your application. To create a new Seeder, run the following command.

In this case, I added 10 dummy data for the Tag factory. It is the same for the User factory with 30 dummy data. For each user, there's each method with function user and also uses tags so these ones and then we create posts for each user randomly one to four posts for each user, and then again third layer third level for each of the posts we attach tags also randomly to tags from those ten so from these ones and this is great because we don't query the database we take randomly from the same collection so that one sentence actually uses three tables to see the data and then those posts.

```shell
php artisan make:seeder UserSeeder
```

```php
        $tags = Tag::factory(10)->create();

        User::factory(30)->create()->each(function ($user) use($tags){
            Post::factory(rand(1,4))->create([
                'user_id' => $user->id
            ])->each(function ($posts) use($tags){
                $posts->tags()->attach($tags->random(2));
            });
        });
```

You can execute the db:seed artisan command to seed your database. By default, the db:seed command runs the Database\Seeders\DatabaseSeeder class, which may, in turn, invoke other seed classes. it is used for laravel seed multiple records at a time.

Database Seeder
```php
    public function run()
    {
        $this->call(UserSeeder::class);
    }
```

```shell
php artisan db:seed
```

## Official Documentation

Please see [Eloquent: Factories](https://laravel.com/docs/9.x/eloquent-factories) for more information on Laravel
documentation.

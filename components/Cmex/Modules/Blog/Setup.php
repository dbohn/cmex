<?php

namespace Cmex\Modules\Blog;

use Cmex\Libraries\Installer\ModuleSetup;

class Setup extends ModuleSetup
{

    public function install()
    {
        // Create schema for blogs
        Schema::create(
            'blogs',
            function ($table) {
                $table->increments('id');
                $table->string('name');
                $table->string('slug');
            }
        );

        // Create database schema for blog posts
        Schema::create(
            'blog_posts',
            function ($table) {
                $table->increments('id');
                $table->string('title');
                $table->string('slug', 50);
                $table->text('post');
                $table->integer('author');
                $table->integer('blog_id');
            }
        );
    }

    public function update($installedVersion)
    {
        //
    }

    public function uninstall()
    {
        //
    }
}

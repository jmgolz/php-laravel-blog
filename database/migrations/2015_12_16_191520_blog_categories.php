<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BlogCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('category')->unique();
            $table->timestamps();
        });
        
        //Pre-populate with some categories
        DB::table('blog_categories')->insert(array(
            'category' => "WOMEN"
        ));

        DB::table('blog_categories')->insert(array(
            'category' => "MEN"
        ));

        DB::table('blog_categories')->insert(array(
            'category' => "KIDS"
        ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('blog_categories');
    }
}

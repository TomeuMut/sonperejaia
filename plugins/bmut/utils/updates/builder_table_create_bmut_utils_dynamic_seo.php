<?php namespace Bmut\Utils\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateBmutUtilsDynamicSeo extends Migration
{
    public function up()
    {
        Schema::create('bmut_utils_dynamic_seo', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->string('keywords')->nullable();
            $table->string('og_title')->nullable();
            $table->string('og_description')->nullable();
            $table->string('robots')->nullable();
            $table->string('seoable_type')->nullable();
            $table->integer('seoable_id')->nullable()->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('bmut_utils_dynamic_seo');
    }
}
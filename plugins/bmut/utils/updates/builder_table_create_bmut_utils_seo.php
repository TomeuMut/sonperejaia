<?php namespace Bmut\Utils\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateBmutUtilsSeo extends Migration
{
    public function up()
    {
        Schema::create('bmut_utils_seo', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('page');
            $table->string('title');
            $table->string('description');
            $table->string('keywords')->nullable();
            $table->string('og_title')->nullable();
            $table->string('og_description')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('bmut_utils_seo');
    }
}

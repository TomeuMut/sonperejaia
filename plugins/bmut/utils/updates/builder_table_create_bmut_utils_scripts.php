<?php namespace Bmut\Utils\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateBmutUtilsScripts extends Migration
{
    public function up()
    {
        Schema::create('bmut_utils_scripts', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->text('script')->nullable();
            $table->text('noscript')->nullable();
            $table->boolean('is_active')->default(1);
            $table->integer('sort_order')->default(1);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('bmut_utils_scripts');
    }
}
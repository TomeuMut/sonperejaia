<?php namespace Bmut\Headers\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateBmutHeadersSliders extends Migration
{
    public function up()
    {
        Schema::create('bmut_headers_sliders', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('page')->nullable();
            $table->string('title')->nullable();
            $table->boolean('is_active')->default(0);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('bmut_headers_sliders');
    }
}
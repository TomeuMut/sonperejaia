<?php namespace Bmut\Headers\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateBmutHeadersSlideSlider extends Migration
{
    public function up()
    {
        Schema::create('bmut_headers_slide_slider', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('slide_id')->unsigned();
            $table->integer('slider_id')->unsigned();
            $table->integer('relation_sort_order')->nullable();
            $table->primary(['slide_id','slider_id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('bmut_headers_slide_slider');
    }
}
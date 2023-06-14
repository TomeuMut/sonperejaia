<?php namespace Bmut\SonPereJaia\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateBmutSonperejaiaContact extends Migration
{
    public function up()
    {
        Schema::create('bmut_sonperejaia_contact', function($table)
        {
            $table->increments('id')->unsigned();
            $table->string('name', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('phone')->nullable();
            $table->text('text')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->boolean('check_policy')->default(0);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('bmut_sonperejaia_contact');
    }
}

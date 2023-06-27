<?php namespace Bmut\SonPereJaia\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBmutSonperejaiaWine2 extends Migration
{
    public function up()
    {
        Schema::table('bmut_sonperejaia_wine', function($table)
        {
            $table->string('slug', 255)->nullable()->unsigned(false)->default(null)->comment(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('bmut_sonperejaia_wine', function($table)
        {
            $table->smallInteger('slug')->nullable()->unsigned(false)->default(null)->comment(null)->change();
        });
    }
}

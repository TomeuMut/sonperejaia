<?php namespace Bmut\SonPereJaia\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBmutSonperejaiaWine extends Migration
{
    public function up()
    {
        Schema::table('bmut_sonperejaia_wine', function($table)
        {
            $table->smallInteger('slug')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('bmut_sonperejaia_wine', function($table)
        {
            $table->dropColumn('slug');
        });
    }
}

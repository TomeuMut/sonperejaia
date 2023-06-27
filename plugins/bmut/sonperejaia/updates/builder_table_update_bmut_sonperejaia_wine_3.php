<?php namespace Bmut\SonPereJaia\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateBmutSonperejaiaWine3 extends Migration
{
    public function up()
    {
        Schema::table('bmut_sonperejaia_wine', function($table)
        {
            $table->string('type', 255)->nullable();
            $table->string('type_grape', 255)->nullable();
            $table->string('capacity', 255)->nullable();
            $table->string('color', 255)->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('bmut_sonperejaia_wine', function($table)
        {
            $table->dropColumn('type');
            $table->dropColumn('type_grape');
            $table->dropColumn('capacity');
            $table->dropColumn('color');
        });
    }
}

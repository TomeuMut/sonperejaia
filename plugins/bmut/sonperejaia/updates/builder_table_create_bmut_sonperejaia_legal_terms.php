<?php namespace Bmut\SonPereJaia\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateBmutSonperejaiaLegalTerms extends Migration
{
    public function up()
    {
        Schema::create('bmut_sonperejaia_legal_terms', function($table)
        {
            $table->increments('id')->unsigned();
            $table->text('legal_terms');
            $table->text('policy_privacity');
            $table->text('policy_cookies');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('bmut_sonperejaia_legal_terms');
    }
}

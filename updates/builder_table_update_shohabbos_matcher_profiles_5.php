<?php namespace Shohabbos\Matcher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateShohabbosMatcherProfiles5 extends Migration
{
    public function up()
    {
        Schema::table('shohabbos_matcher_profiles', function($table)
        {
            $table->smallInteger('age')->nullable()->unsigned()->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('shohabbos_matcher_profiles', function($table)
        {
            $table->string('age', 191)->nullable()->unsigned(false)->default(null)->change();
        });
    }
}

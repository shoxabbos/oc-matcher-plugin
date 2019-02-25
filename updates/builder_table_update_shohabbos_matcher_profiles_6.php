<?php namespace Shohabbos\Matcher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateShohabbosMatcherProfiles6 extends Migration
{
    public function up()
    {
        Schema::table('shohabbos_matcher_profiles', function($table)
        {
            $table->boolean('gender')->nullable()->unsigned(false)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('shohabbos_matcher_profiles', function($table)
        {
            $table->string('gender', 191)->nullable()->unsigned(false)->default(null)->change();
        });
    }
}

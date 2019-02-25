<?php namespace Shohabbos\Matcher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateShohabbosMatcherProfiles3 extends Migration
{
    public function up()
    {
        Schema::table('shohabbos_matcher_profiles', function($table)
        {
            $table->smallInteger('children')->nullable()->unsigned(false)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('shohabbos_matcher_profiles', function($table)
        {
            $table->string('children', 191)->nullable()->unsigned(false)->default(null)->change();
        });
    }
}

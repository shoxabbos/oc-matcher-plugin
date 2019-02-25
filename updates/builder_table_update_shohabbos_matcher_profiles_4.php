<?php namespace Shohabbos\Matcher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateShohabbosMatcherProfiles4 extends Migration
{
    public function up()
    {
        Schema::table('shohabbos_matcher_profiles', function($table)
        {
            $table->smallInteger('children')->unsigned()->change();
        });
    }
    
    public function down()
    {
        Schema::table('shohabbos_matcher_profiles', function($table)
        {
            $table->smallInteger('children')->unsigned(false)->change();
        });
    }
}

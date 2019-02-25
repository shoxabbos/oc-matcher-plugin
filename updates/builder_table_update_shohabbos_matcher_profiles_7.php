<?php namespace Shohabbos\Matcher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateShohabbosMatcherProfiles7 extends Migration
{
    public function up()
    {
        Schema::table('shohabbos_matcher_profiles', function($table)
        {
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->string('middlename')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('shohabbos_matcher_profiles', function($table)
        {
            $table->dropColumn('name');
            $table->dropColumn('surname');
            $table->dropColumn('middlename');
        });
    }
}

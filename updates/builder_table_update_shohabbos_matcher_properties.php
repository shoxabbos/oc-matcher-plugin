<?php namespace Shohabbos\Matcher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateShohabbosMatcherProperties extends Migration
{
    public function up()
    {
        Schema::table('shohabbos_matcher_properties', function($table)
        {
            $table->integer('sort_order');
        });
    }
    
    public function down()
    {
        Schema::table('shohabbos_matcher_properties', function($table)
        {
            $table->dropColumn('sort_order');
        });
    }
}

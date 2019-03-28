<?php namespace Shohabbos\Matcher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateShohabbosMatcherProperties2 extends Migration
{
    public function up()
    {
        Schema::table('shohabbos_matcher_properties', function($table)
        {
            $table->integer('parent_id')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('shohabbos_matcher_properties', function($table)
        {
            $table->dropColumn('parent_id');
        });
    }
}

<?php namespace Shohabbos\Matcher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateShohabbosMatcherProperties3 extends Migration
{
    public function up()
    {
        Schema::table('shohabbos_matcher_properties', function($table)
        {
            $table->integer('nest_left');
            $table->integer('nest_right');
            $table->integer('nest_depth');
            $table->integer('parent_id')->nullable(false)->change();
        });
    }
    
    public function down()
    {
        Schema::table('shohabbos_matcher_properties', function($table)
        {
            $table->dropColumn('nest_left');
            $table->dropColumn('nest_right');
            $table->dropColumn('nest_depth');
            $table->integer('parent_id')->nullable()->change();
        });
    }
}

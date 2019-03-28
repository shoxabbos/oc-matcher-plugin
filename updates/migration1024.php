<?php namespace Shohabbos\Matcher\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class Migration1024 extends Migration
{
    public function up()
    {
        Schema::table('users', function($table) {
            $table->string('notify_key')->nullable();
        });
    }

    public function down()
    {
        $table->dropDown([
            'notify_key',
        ]);
    }
}
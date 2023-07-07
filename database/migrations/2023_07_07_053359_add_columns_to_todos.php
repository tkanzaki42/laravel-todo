<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToTodos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('todos', 'id')) {
            Schema::table('todos', function (Blueprint $table) {
                $table->increments('id');
            });
        }

        if (!Schema::hasColumn('todos', 'task')) {
            Schema::table('todos', function (Blueprint $table) {
                $table->string('task');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('todos', function (Blueprint $table) {
            $table->dropColumn(['id', 'task']);
        });
    }
}

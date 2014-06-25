<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsUsers extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() 
    {
        Schema::table('users', function(Blueprint $table)
        {
            /* TODO unittest */
            $table->string('fullname');
            $table->string('username')->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() 
    {
        Schema::table('users', function(Blueprint $table) 
        {
            $table->dropColumn(array('fullname', 'username'));
        });
    }

}

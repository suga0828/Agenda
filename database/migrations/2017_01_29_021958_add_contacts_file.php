<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddContactsFile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //modificar la tabla contactos
        Schema::table('contacts', function (Blueprint $table) {
            $table->string('file')->notnull();;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //eliminar campo creado
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn('file');
        });
    }
}

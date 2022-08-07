<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocument extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document', function (Blueprint $table) {
            $table->id();
            $table->integer('type_id');
            $table->date('edition_date');
            $table->integer('number');
            $table->integer('client_id');
            $table->timestamps();
        });

        Schema::create('document_line', function (Blueprint $table) {
            $table->id();
            $table->integer('document_id');
            $table->string('label');
            $table->integer('price')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document');
    }
}

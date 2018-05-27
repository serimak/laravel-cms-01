<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResResponsiblePersonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('res_responsible_person', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_th')->default('')->comment('ผู้รับผิดชอบ');
            $table->string('name_en')->default('')->comment('ผู้รับผิดชอบภาษาอังกฤษ');       
            $table->bigInteger('created_by')->default('0');
            $table->bigInteger('updated_by')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('res_responsible_person');
    }
}

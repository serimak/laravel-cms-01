<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResResearcherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('res_researcher', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('res_registration_id')->unsigned()->comment('รหัสโครงการที่ร่วมวิจัย');
            $table->integer('res_responsible_person_id')->unsigned()->comment('รหัสประเภทผู้รับผิดชอบ');
            $table->string('name_th')->default('')->nullable()->comment('ชื่อภาษาไทย');
            $table->string('name_en')->default('')->nullable()->comment('ชื่อภาษาอังกฤษ');
            $table->integer('percent')->unsigned()->nullable()->comment('เปอร์เซ็นต์');
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
        Schema::dropIfExists('res_researcher');
    }
}

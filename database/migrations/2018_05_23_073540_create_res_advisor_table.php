<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResAdvisorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('res_advisor', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('res_registration_id')->unsigned()->comment('รหัสโครงการที่ให้การปรึกษา');
            $table->string('advisor_name_th')->default('')->comment('ชื่อที่ปรึกษาภาษาไทย');
            $table->string('advisor_name_en')->default('')->comment('ชื่อ่ปรึกษาภาษาอังกฤษ');
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
        Schema::dropIfExists('res_advisor');
    }
}

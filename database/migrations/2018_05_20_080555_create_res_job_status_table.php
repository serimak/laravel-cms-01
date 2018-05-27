<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResJobStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('res_job_status', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_th')->default('')->comment('สถานะงาน(เสร็จ/ไม่เสร็จ)');
            $table->string('name_en')->default('')->comment('สถานะงาน(เสร็จ/ไม่เสร็จ)ภาษาอังกฤษ');        
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
        Schema::dropIfExists('res_job_status');
    }
}

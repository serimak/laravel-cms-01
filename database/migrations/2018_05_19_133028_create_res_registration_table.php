<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResRegistrationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('res_registration', function (Blueprint $table) {
            $table->increments('id');
            $table->string('project_name_th', 1024)->default('')->nullable()->comment('1)ชื่อโครงการภาษาไทย');
            $table->string('project_name_en', 1024)->default('')->nullable()->comment('1)ชื่อโครงการภาษาอังกฤษ');
            $table->integer('responsible_person_id')->unsigned()->nullable()->comment('2)ผู้รับผิดชอบ');
            $table->integer('fiscal_year_id')->unsigned()->nullable()->comment('3)ปีงบประมาณ');
            $table->integer('budget_type_id')->unsigned()->nullable()->comment('4)ประเภทงบประมาณ');
            $table->string('advisors', 1024)->default('')->nullable()->comment('5)อาจารย์ที่ปรึกษา');
            $table->integer('agency_responsible_id')->unsigned()->nullable()->comment('6)หน่วยงาน/คณะที่รับผิดชอบ');
            $table->decimal('budget_allocated', 10, 2)->nullable()->comment('7)งบประมาณที่ได้รับจัดสรร');
            $table->dateTime('start_date')->nullable()->comment('8)วันที่เริ่ม');
            $table->dateTime('end_date')->nullable()->comment('8)วันที่สิ้นสุด');
            $table->integer('job_status_id')->unsigned()->nullable()->comment('9)สถานะงาน(เสร็จ/ไม่เสร็จ)');
            $table->dateTime('date_of_submission')->nullable()->comment('10)วันที่ส่งงาน');
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
        Schema::dropIfExists('res_registration');
    }
}

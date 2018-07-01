<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResAbstractTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('res_abstract', function (Blueprint $table) {
            $table->integer('res_registration_id')->unsigned()->comment('รหัสโครงการของบทคัดย่อ');
            $table->string('abstract_th')->default('')->comment('บทคัดย่อภาษาไทย');
            $table->string('abstract_en')->default('')->comment('บทคัดย่อภาษาอังกฤษ');
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
        Schema::dropIfExists('res_abstract');
    }
}

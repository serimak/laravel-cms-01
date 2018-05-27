<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResFiscalYearTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('res_fiscal_year', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_th')->default('')->comment('ปีงบประมาณ');
            $table->string('name_en')->default('')->comment('ปีงบประมาณอังกฤษ');        
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
        Schema::dropIfExists('res_fiscal_year');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArduinoInfoTable extends Migration
{
    /**
     * Run the migrations.
     * Writer           :   Sung GyeongIm
     * Table Name       :   arduino_info
     * Table Explain    :   create hardware's serial number information manage table
     */

    public function up()
    {
        // Table 'arduino_info'
        // 하드웨어 아두이노의 고유번호 관리 테이블.

        /*
         CREATE TABLE `arduino_info`
        (
          `arduino_no` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'arduino table primary key',
          `serial_num` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT 'serial number',
          `registered_date` timestamp NULL DEFAULT NULL COMMENT 'register date',
          PRIMARY KEY (`arduino_no`),
          UNIQUE KEY `arduino_info_serial_num_unique` (`serial_num`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
        */

        Schema::create('arduino_info', function (Blueprint $table)
        {

            // columns
            $table->increments('arduino_no')->comment('arduino table primary key');
            $table->string('serial_num', 32)->comment('serial number');
            $table->timestamp('registered_date')->nullable()->comment('register date');

            // unique key
            // 시리얼 번호 중복 X
            $table->unique('serial_num');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // DROP TABLE IF EXISTS `arduinoInfo`;
        Schema::dropIfExists('arduino_info');
    }
}
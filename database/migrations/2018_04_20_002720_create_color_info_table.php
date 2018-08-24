<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColorInfoTable extends Migration
{
    /**
     * Run the migrations.
     * Writer           :   Sung GyeongIm
     * Table Name       :   color_info
     * Table Explain    :   create use color's information manage table
     */
    public function up()
    {
        /*CREATE TABLE `color_info`
        (
          `color_no` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'color table primary key',
          `color_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT 'color name',
          `R` int(10) unsigned NOT NULL COMMENT 'RGB R',
          `G` int(10) unsigned NOT NULL COMMENT 'RGB G',
          `B` int(10) unsigned NOT NULL COMMENT 'RGB B',
          `registered_date` timestamp NULL DEFAULT NULL COMMENT 'register date',
          PRIMARY KEY (`color_no`),
          UNIQUE KEY `color_info_r_g_b_unique` (`R`,`G`,`B`),
          UNIQUE KEY `color_info_color_name_unique` (`color_name`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci*/

        Schema::create('color_info', function (Blueprint $table)
        {
            $table->increments('color_no')->comment('color table primary key');
            $table->string('color_name', 20)->comment('color name');
            $table->integer('R')->unsigned()->comment('RGB R');
            $table->integer('G')->unsigned()->comment('RGB G');
            $table->integer('B')->unsigned()->comment('RGB B');
            $table->timestamp('registered_date')->nullable()->comment('register date');

            // unique key
            $table->unique(array('R', 'G','B')); // 동일한 색상이 되면 안된다.
            $table->unique('color_name'); // 색상명은 중복이 되면 안된다.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // DROP TABLE IF EXISTS `color_info`;
        Schema::dropIfExists('color_info');
    }
}
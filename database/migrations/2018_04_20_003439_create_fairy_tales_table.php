<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFairyTalesTable extends Migration
{
    /**
     * Run the migrations.
     * Writer           :   Sung GyeongIm
     * Table Name       :   fairy_tales
     * Table Explain    :   create fairy tale's information manage table
     */
    public function up()
    {
        /*
          CREATE TABLE `fairy_tales`
        (
          `fairy_tale_no` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'fairy tale table primary key',
          `tale_price` int(10) unsigned NOT NULL COMMENT 'fairy tale price',
          `tale_title` varchar(40) COLLATE utf8_unicode_ci NOT NULL COMMENT 'fairy tale title',
          `tale_explain` varchar(200) COLLATE utf8_unicode_ci NOT NULL COMMENT 'fairy tale explain',
          `registered_date` timestamp NULL DEFAULT NULL COMMENT 'register date',
          PRIMARY KEY (`fairy_tale_no`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
         */

        Schema::create('fairy_tales', function (Blueprint $table)
        {

            // colums
            $table->increments('fairy_tale_no')->comment('fairy tale table primary key');
            $table->integer('tale_price')->unsigned()->comment('fairy tale price');
            $table->string('tale_title', 40)->comment('fairy tale title');
            $table->string('tale_explain', 200)->comment('fairy tale explain');
            $table->timestamp('registered_date')->nullable()->comment('register date');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // DROP TABLE IF EXISTS `tale_images`;
        Schema::dropIfExists('tale_images');
        // DROP TABLE IF EXISTS `tale_designs`;
        Schema::dropIfExists('tale_designs');
        // DROP TABLE IF EXISTS `buylists`;
        Schema::dropIfExists('buylists');
        // DROP TABLE IF EXISTS `fairy_tales`;
        Schema::dropIfExists('fairy_tales');
    }
}
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImageRoutesTable extends Migration
{
    /**
     * Run the migrations.
     * Writer           :   Sung GyeongIm
     * Table Name       :   image_routes
     * Table Explain    :   create image's route manage table
     */
    public function up()
    {
        /*
        CREATE TABLE `image_routes`
        (
            `route_no` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'image route table primary key',
            `route_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT 'route name',
            `registered_date` timestamp NULL DEFAULT NULL COMMENT 'register date',
            PRIMARY KEY (`route_no`),
            UNIQUE KEY `image_routes_route_name_unique` (`route_name`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
        */

        Schema::create('image_routes', function (Blueprint $table) {

            $table->increments('route_no')->comment('image route table primary key');
            $table->string('route_name', 32)->comment('route name');
            $table->timestamp('registered_date')->nullable()->comment('register date');

            // unique key
            $table->unique('route_name'); // 경로명 중복 X

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // DROP TABLE IF EXISTS `imageRoutes`;
        Schema::dropIfExists('image_routes');
    }
}
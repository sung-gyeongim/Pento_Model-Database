<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaleImagesTable extends Migration
{
    /**
     * Run the migrations.
     * Writer           :   Sung GyeongIm
     * Table Name       :   tale_images
     * Table Explain    :   create fairy tale's image information manage table
     */
    public function up()
    {
        /*
         CREATE TABLE `tale_images`
        (
          `fairy_tale_no` int(10) unsigned NOT NULL COMMENT 'fairy tale number',
          `tale_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'fairy tale image file name',
          `registered_date` timestamp NULL DEFAULT NULL COMMENT 'register date',
          PRIMARY KEY (`fairy_tale_no`,`tale_image`),
          CONSTRAINT `tale_images_fairy_tale_no_foreign` FOREIGN KEY (`fairy_tale_no`) REFERENCES `fairy_tales` (`fairy_tale_no`) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
         */

        Schema::create('tale_images', function (Blueprint $table)
        {
            // columns
            $table->integer('fairy_tale_no')->unsigned()->comment('fairy tale number');
            $table->string('tale_image', 255)->comment('fairy tale image file name');
            $table->timestamp('registered_date')->nullable()->comment('register date');

            // foreign key
            $table->foreign('fairy_tale_no')
                ->references('fairy_tale_no')->on('fairy_tales')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            // unique key
            $table->primary(array('fairy_tale_no','tale_image'));

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
    }
}
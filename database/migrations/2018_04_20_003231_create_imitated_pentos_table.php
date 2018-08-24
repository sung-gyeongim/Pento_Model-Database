<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImitatedPentosTable extends Migration
{
    /**
     * Run the migrations.
     * Writer           :   Sung GyeongIm
     * Table Name       :   imitated_pentos
     * Table Explain    :   create user made designs manage information manage table
     */
    public function up()
    {
        /*
         CREATE TABLE `imitated_pentos`
        (
          `imitated_no` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'imitated design table primary key',
          `user_no` int(10) unsigned NOT NULL COMMENT 'made user number',
          `design_no` int(10) unsigned NOT NULL COMMENT 'imitate design number',
          `division_no` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'make or imitate division',
          `put_number` int(10) unsigned NOT NULL COMMENT 'block put number',
          `imitated_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'imitated_design image file name',
          `clear_time` time NOT NULL COMMENT 'clearTime',
          `registered_date` timestamp NULL DEFAULT NULL COMMENT 'register date',
          PRIMARY KEY (`imitated_no`),
          UNIQUE KEY `imitated_pentos_user_no_design_no_imitated_image_unique` (`user_no`,`design_no`,`imitated_image`),
          KEY `imitated_pentos_design_no_division_no_imitated_no_index` (`design_no`,`division_no`,`imitated_no`),
          CONSTRAINT `imitated_pentos_user_no_design_no_foreign` FOREIGN KEY (`user_no`, `design_no`) REFERENCES `collections` (`user_no`, `design_no`) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
         */

        Schema::create('imitated_pentos', function (Blueprint $table)
        {
            // columns
            $table->increments('imitated_no')->comment('imitated design table primary key');
            $table->integer('user_no')->unsigned()->comment('made user number');
            $table->integer('design_no')->unsigned()->comment('imitate design number');
            $table->integer('division_no')->unsigned()->default(0)->comment('make or imitate division');
            $table->integer('put_number')->unsigned()->comment('block put number');
            $table->string('imitated_image', 255)->comment('imitated_design image file name');
            $table->time('clear_time')->comment('clearTime');
            $table->timestamp('registered_date')->nullable()->comment('register date');

            // foreign keys
            $table->foreign(array('user_no', 'design_no'))
                ->references(array('user_no', 'design_no'))->on('collections')
                ->onDelete('cascade')
                ->onUpdate('cascade');


            // unique key
            $table->unique(array('user_no','design_no', 'imitated_image'));

            // index key
            $table->index(array('design_no', 'division_no', 'imitated_no'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // DROP TABLE IF EXISTS `recommends`;
        Schema::dropIfExists('recommends');
        // DROP TABLE IF EXISTS `pento_records`;
        Schema::dropIfExists('pento_records');
        // DROP TABLE IF EXISTS `imitated_pentos`;
        Schema::dropIfExists('imitated_pentos');
    }
}
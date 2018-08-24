<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecommendsTable extends Migration
{
    /**
     * Run the migrations.
     * Writer           :   Sung GyeongIm
     * Table Name       :   recommends
     * Table Explain    :   create user recommend imitated design information manage table
     */

    public function up()
    {
        /*
         CREATE TABLE `recommends`
        (
          `user_no` int(10) unsigned NOT NULL COMMENT 'recommended user number',
          `imitated_no` int(10) unsigned NOT NULL COMMENT 'imitated design number',
          `registered_date` timestamp NULL DEFAULT NULL COMMENT 'register date',
          PRIMARY KEY (`user_no`,`imitated_no`),
          KEY `recommends_imitated_no_foreign` (`imitated_no`),
          CONSTRAINT `recommends_imitated_no_foreign` FOREIGN KEY (`imitated_no`) REFERENCES `imitated_pentos` (`imitated_no`) ON DELETE CASCADE ON UPDATE CASCADE,
          CONSTRAINT `recommends_user_no_foreign` FOREIGN KEY (`user_no`) REFERENCES `user_info` (`user_no`) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
         */

        Schema::create('recommends', function (Blueprint $table)
        {

            // columns
            $table->integer('user_no')->unsigned()->comment('recommended user number');
            $table->integer('imitated_no')->unsigned()->comment('imitated design number');
            $table->timestamp('registered_date')->nullable()->comment('register date');

            // foreign keys
            $table->foreign('user_no')
                ->references('user_no')->on('user_info')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('imitated_no')
                ->references('imitated_no')->on('imitated_pentos')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            // primary key
            $table->primary(array('user_no', 'imitated_no'));


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
    }
}
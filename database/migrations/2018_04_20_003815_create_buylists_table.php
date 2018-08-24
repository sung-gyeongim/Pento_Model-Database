<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuylistsTable extends Migration
{
    /**
     * Run the migrations.
     * Writer           :   Sung GyeongIm
     * Table Name       :   buylists
     * Table Explain    :   user bought fairy tale information manage table
     * @return void
     */
    public function up()
    {
        /*
         CREATE TABLE `buylists`
        (
          `user_no` int(10) unsigned NOT NULL COMMENT 'fairy tale bought user number',
          `fairy_tale_no` int(10) unsigned NOT NULL COMMENT 'bought fairy tale number',
          `registered_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'bought date',
          PRIMARY KEY (`user_no`,`fairy_tale_no`),
          KEY `buylists_fairy_tale_no_foreign` (`fairy_tale_no`),
          CONSTRAINT `buylists_fairy_tale_no_foreign` FOREIGN KEY (`fairy_tale_no`) REFERENCES `fairy_tales` (`fairy_tale_no`) ON DELETE CASCADE ON UPDATE CASCADE,
          CONSTRAINT `buylists_user_no_foreign` FOREIGN KEY (`user_no`) REFERENCES `user_info` (`user_no`) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
         */

        Schema::create('buylists', function (Blueprint $table)
        {
            // colums
            $table->integer('user_no')->unsigned()->comment('fairy tale bought user number');
            $table->integer('fairy_tale_no')->unsigned()->comment('bought fairy tale number');
            $table->timestamp('registered_date')->comment('bought date');

            // foreign keys
            $table->foreign('user_no')
                ->references('user_no')->on('user_info')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('fairy_tale_no')
                ->references('fairy_tale_no')->on('fairy_tales')
                ->onDelete('cascade')
                ->onUpdate('cascade');


            // primary key

            $table->primary(array('user_no', 'fairy_tale_no'));

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // DROP TABLE IF EXISTS `buylists`;
        Schema::dropIfExists('buylists');
    }
}
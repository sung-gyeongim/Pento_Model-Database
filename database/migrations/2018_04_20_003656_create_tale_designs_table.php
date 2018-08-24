<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaleDesignsTable extends Migration
{
    /**
     * Run the migrations.
     * Writer           :   Sung GyeongIm
     * Table Name       :   tale_designs
     * Table Explain    :   create fairy tale's design information manage table
     * @return void
     */
    public function up()
    {
        /*
     CREATE TABLE `tale_designs`
        (
          `fairy_tale_no` int(10) unsigned NOT NULL COMMENT 'fairy tale number',
          `design_no` int(10) unsigned NOT NULL COMMENT 'design number',
          `registered_date` timestamp NULL DEFAULT NULL COMMENT 'register date',
          PRIMARY KEY (`fairy_tale_no`,`design_no`),
          KEY `tale_designs_design_no_foreign` (`design_no`),
          CONSTRAINT `tale_designs_design_no_foreign` FOREIGN KEY (`design_no`) REFERENCES `pento_designs` (`design_no`) ON DELETE CASCADE ON UPDATE CASCADE,
          CONSTRAINT `tale_designs_fairy_tale_no_foreign` FOREIGN KEY (`fairy_tale_no`) REFERENCES `fairy_tales` (`fairy_tale_no`) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
         */

        Schema::create('tale_designs', function (Blueprint $table)
        {
            $table->integer('fairy_tale_no')->unsigned()->comment('fairy tale number');
            $table->integer('design_no')->unsigned()->comment('design number');
            $table->timestamp('registered_date')->nullable()->comment('register date');


            // foreign key
            $table->foreign('fairy_tale_no')
                ->references('fairy_tale_no')->on('fairy_tales')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('design_no')
                ->references('design_no')->on('pento_designs')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            // primary key
            $table->primary(array('fairy_tale_no', 'design_no'));
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // DROP TABLE IF EXISTS `tale_designs`;
        Schema::dropIfExists('tale_designs');
    }
}

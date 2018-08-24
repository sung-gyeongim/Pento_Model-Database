<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     * Writer           :   Sung GyeongIm
     * Table Name       :   collections
     * Table Explain    :   create subscribe or made design information manage table
     */
    public function up()
    {
        /*
         CREATE TABLE `collections`
        (
          `user_no` int(10) unsigned NOT NULL COMMENT 'design made user number',
          `design_no` int(10) unsigned NOT NULL COMMENT 'design number',
          `registered_date` timestamp NULL DEFAULT NULL COMMENT 'register date',
          PRIMARY KEY (`user_no`,`design_no`),
          KEY `collections_design_no_foreign` (`design_no`),
          CONSTRAINT `collections_design_no_foreign` FOREIGN KEY (`design_no`) REFERENCES `pento_designs` (`design_no`) ON DELETE CASCADE ON UPDATE CASCADE,
          CONSTRAINT `collections_user_no_foreign` FOREIGN KEY (`user_no`) REFERENCES `user_info` (`user_no`) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
         */

        Schema::create('collections', function (Blueprint $table)
        {
            // columns
            $table->integer('user_no')->unsigned()->comment('design made user number');
            $table->integer('design_no')->unsigned()->comment('design number');
            $table->timestamp('registered_date')->nullable()->comment('register date');

            // foreign keys
            $table->foreign('user_no')
                ->references('user_no')->on('user_info')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('design_no')
                ->references('design_no')->on('pento_designs')
                ->onDelete('cascade')
                ->onUpdate('cascade');


            // primary key
            $table->primary(array('user_no', 'design_no'));

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // DROP TABLE IF EXISTS `imitated_pentos`;
        Schema::dropIfExists('imitated_pentos');
        // DROP TABLE IF EXISTS `collections`;
        Schema::dropIfExists('collections');
    }
}

?>
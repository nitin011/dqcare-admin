<?php
/**
 * Class PatientFilesTable
 *
 * @category  zStarter
 *
 * @ref  zCURD
 * @author    Defenzelite <hq@defenzelite.com>
 * @license  https://www.defenzelite.com Defenzelite Private Limited
 * @version  <zStarter: 1.1.0>
 * @link        https://www.defenzelite.com
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientFilesTable extends Migration
{ 
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('patient_files', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->comment('user table');                       
                 $table->timestamp('date')->comment('.');                       
                 $table->longText('comment')->nullable()->comment('.');   
                 $table->bigInteger('category_id')->comment('category');                       
                 $table->string('file')->comment('.');                       
                               
            $table->timestamps();
                            $table->softDeletes();
                        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::dropIfExists('patient_files');
    }
}

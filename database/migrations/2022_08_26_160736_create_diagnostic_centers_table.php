<?php
/**
 * Class DiagnosticCentersTable
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

class CreateDiagnosticCentersTable extends Migration
{ 
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('diagnostic_centers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('.');                       
                 $table->bigInteger('country_id')->comment('country table');                       
                 $table->bigInteger('state_id')->comment('state table');                       
                 $table->bigInteger('city_id')->comment('city table');                       
                 $table->string('pincode')->comment('.');                       
                 $table->text('addressline_1')->comment('.');                       
                 $table->text('addressline_2')->nullable()->comment('.');   
                 $table->string('district')->comment('.');                       
                               
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
        Schema::dropIfExists('diagnostic_centers');
    }
}

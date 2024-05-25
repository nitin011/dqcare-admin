<?php
/**
 * Class FollowUpsTable
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

class CreateFollowUpsTable extends Migration
{ 
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('follow_ups', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('doctor_id')->comment('user table');                       
                 $table->bigInteger('user_id')->comment('user table');                       
                 $table->string('remark')->comment('.');                       
                 $table->timestamp('date')->comment('.');                       
                 $table->integer('status')->comment('0:pen2:attende,ding,1:notattended,3:cancelled');                       
                               
            $table->timestamps();
                        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::dropIfExists('follow_ups');
    }
}

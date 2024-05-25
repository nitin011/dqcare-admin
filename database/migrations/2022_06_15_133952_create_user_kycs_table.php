
<?php
/**
 * Class UserKycsTable
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

class CreateUserKycsTable extends Migration
{ 
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('user_kycs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->comment('belongs to user table');                       
                 $table->integer('status')->comment('0=&gt;pending,1=&gt;accepted,2=&gt;rejected');                       
                 $table->longText('details')->comment('store json key value');                       
                               
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
        Schema::dropIfExists('user_kycs');
    }
}

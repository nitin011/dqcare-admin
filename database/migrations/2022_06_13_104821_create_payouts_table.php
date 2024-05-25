
<?php
/**
 * Class PayoutsTable
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

class CreatePayoutsTable extends Migration
{ 
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('payouts', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->comment('belongs to user table');                       
                 $table->double('amount')->comment('requested amount');                       
                 $table->integer('type')->comment('0: payout,1: refund');                       
                 $table->integer('status')->comment('0:unpaid,1:paid,2:cancel');                       
                 $table->integer('approved_by')->comment('whom approved this request');                       
                 $table->dateTime('approved_at')->comment('when approved this request');                       
                               
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
        Schema::dropIfExists('payouts');
    }
}

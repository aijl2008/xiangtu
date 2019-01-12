<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string("ToUserName");
            $table->string("FromUserName");
            $table->string("CreateTime");
            $table->string("MsgType");
            $table->string("Event");//subscribe(订阅)、unsubscribe(取消订阅),SCAN
            $table->string('EventKey');//事件KEY值，qrscene_为前缀，后面为二维码的参数值
            $table->string('Ticket');//二维码的ticket，可用来换取二维码图片

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_logs');
    }
}

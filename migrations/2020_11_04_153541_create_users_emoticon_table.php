<?php

declare(strict_types=1);
/**
 * This file is part of Swow-Chat.
 *
 * @link     https://xxx.com
 * @document https://xxx.wiki
 * @license  https://github.com/swow-cloud/swow-websocket/master/LICENSE
 */
use Hyperf\Database\Migrations\Migration;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Schema\Schema;

class CreateUsersEmoticonTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users_emoticon', function (Blueprint $table) {
            $table->unsignedInteger('id', true)->comment('表情包收藏ID');
            $table->unsignedInteger('user_id')->default(0)->comment('用户ID');
            $table->string('emoticon_ids', 255)->default('')->comment('表情包ID');

            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->unique(['user_id'], 'uk_user_id');
            $table->comment('用户收藏表情包');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_emoticon');
    }
}

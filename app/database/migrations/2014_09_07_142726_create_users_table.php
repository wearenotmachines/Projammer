<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create("users", function($table) {
			$table->increments("id");
			$table->string("email")->unique();
			$table->string("password", 60);
			$table->string("remember_token", 100)->nullable();
			$table->string("display_name");
			$table->timestamps();
			$table->softDeletes();
		});

		Schema::table("developers", function($table) {
			$table->timestamps();
			$table->integer("user_id")->unsigned()->nullable();
			$table->foreign("user_id", "fk_developer_user")->references("id")->on("users")->onUpdate("cascade")->onDelete("cascade");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement("SET FOREIGN_KEY_CHECKS = 0");
		Schema::dropIfExists("users");
		Schema::table("developers", function($table) {
			$table->dropTimestamps();
			$table->string("name");
			$table->string("email")->unique();
			$table->dropForeign("fk_developer_user");
			$table->dropColumn("user_id");
		});
		DB::statement("SET FOREIGN_KEY_CHECKS = 1");
	}

}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TimestampsOnRoles extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table("roles", function($table) {
			$table->integer("created_by")->after("label")->unsigned();
			$table->timestamps();
			$table->foreign("created_by", "fk_roles_creator")->references("id")->on("users")->onUpdate("cascade")->onDelete("restrict");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table("roles", function($table) {
			$table->dropForeign("fk_roles_creator");
			$table->dropColumn("created_by");
			$table->dropColumn("created_at");
			$table->dropColumn("updated_at");
		});
	}

}

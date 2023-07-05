<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('movies', function (Blueprint $table) {
			$table->id();
			$table->json('title')->nullable();
			$table->json('director')->nullable();
			$table->foreignId('user_id')->constrained();
			$table->integer('release_year')->nullable();
			$table->json('description')->nullable();
			$table->string('thumbnail')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('movies');
	}
};

<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenreSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('genres')->insert([
			[
				'name'       => json_encode(['en' => 'Fantasy', 'ka' => 'ფენტეზი']),
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
			],
			[
				'name'       => json_encode(['en' => 'Action', 'ka' => 'მძაფრ სიუჟეტიანი']),
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
			],
			[
				'name'       => json_encode(['en' => 'Comedy', 'ka' => 'კომედია']),
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
			],
			[
				'name'       => json_encode(['en' => 'Drama', 'ka' => 'დრამა']),
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
			],
			[
				'name'       => json_encode(['en' => 'Horror', 'ka' => 'საშინელებათა ფილმი']),
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
			],
			[
				'name'       => json_encode(['en' => 'Mystery', 'ka' => 'მისტიკა']),
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
			],
			[
				'name'       => json_encode(['en' => 'Romance', 'ka' => 'რომანტიკა']),
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
			],
			[
				'name'       => json_encode(['en' => 'Thriller', 'ka' => 'თრილერი']),
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
			],
			[
				'name'       => json_encode(['en' => 'Western', 'ka' => 'ვესტერნი']),
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
			],
			[
				'name'       => json_encode(['en' => 'Musical', 'ka' => 'მიუზიკლი']),
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
			],
		]);
	}
}

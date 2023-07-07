<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$json = File::get('database/data/genrees.json');

		$genrees = json_decode($json);

		foreach ($genrees as $key => $value) {
			Genre::create([
				'name' => [
					'en' => $value->name->en,
					'ka' => $value->name->ka,
				],
			]);
		}
	}
}

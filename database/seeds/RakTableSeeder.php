<?php

use Illuminate\Database\Seeder;

class RakTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Load the file
        $path = base_path() . '/database/rak.json';
        $file = File::get($path);
        $data = json_decode($file, true);

        // Insert into the database
        DB::table('raks')->insert($data);

        $this->command->info('RakTableSeeder sukses!!!');
    }
}

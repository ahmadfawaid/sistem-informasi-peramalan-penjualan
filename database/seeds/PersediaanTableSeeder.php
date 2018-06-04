<?php

use Illuminate\Database\Seeder;

class PersediaanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Load the file
        $path = base_path() . '/database/persediaan.json';
        $file = File::get($path);
        $data = json_decode($file, true);

        // Insert into the database
        DB::table('persediaans')->insert($data);

        $this->command->info('PersediaanTableSeeder sukses!!!');
    }
}

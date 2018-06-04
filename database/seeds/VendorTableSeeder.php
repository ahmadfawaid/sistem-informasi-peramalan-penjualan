<?php

use Illuminate\Database\Seeder;

class VendorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Load the file
        $path = base_path() . '/database/vendor.json';
        $file = File::get($path);
        $data = json_decode($file, true);

        // Insert into the database
        DB::table('vendors')->insert($data);

        $this->command->info('VendorTableSeeder sukses!!!');
    }
}

<?php

use Illuminate\Database\Seeder;

class ProdukTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Load the file
        $path = base_path() . '/database/produk.json';
        $file = File::get($path);
        $data = json_decode($file, true);

        // Insert into the database
        DB::table('produks')->insert($data);

        $this->command->info('ProdukTableSeeder sukses!!!');
    }
}

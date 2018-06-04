<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        DB::table('users')->insert([
        	[
        		'nama'		=> 'Ahmad Nur Fawaid',
                'username'  => 'admin',
                'email'     => 'admin@klinik.rolasmedika.com',
                'role'		=> 'manager',
                'status'    => 'aktif',
        		'password'	=> bcrypt('1324')
            ],
            [
                'nama'      => 'Yudhistirawati',
                'username'  => 'tira',
                'email'     => 'yudhistira@gmail.com',
                'role'      => 'apoteker',
                'status'    => 'aktif',
                'password'  => bcrypt('1324')
            ],
        	[
        		'nama'		=> 'Diana Larasati',
                'username'  => 'diana',
                'email'     => 'dianalarasati@gmail.com',
                'role'		=> 'apoteker',
                'status'    => 'aktif',
        		'password'	=> bcrypt('1324')
			]
        ]);
        
        $this->command->info('UserTableSeeder sukses!!!');
    }
}

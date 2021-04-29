<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

	    $user = [
	        ['id' => '1', 'name' => 'Admin', 'email' => 'contact@subdine.com', 'password' => bcrypt('admin123'),'remember_token' => '']
	        	        
        ];

       User::insert($user);
    }
}

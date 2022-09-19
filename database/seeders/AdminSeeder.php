<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory()->count(3)->create(['role_id'=>1,'password'=>'admin123']);
        $user = User::factory()->count(1)->create(['role_id'=>1,'name'=>'admin','email'=>'admin@std.com','username'=>'std-admin','password'=>'admin123']);
    }
}

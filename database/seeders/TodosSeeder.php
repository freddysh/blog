<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TodosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $userAdmin=User::create([
            'name'=>'Juan pablo',
            'email'=>'jpablo@gmail.com',
            'password'=>Hash::make('admin'),
            'rol'=>'admin'
        ]);
        $userEditor=User::create([
            'name'=>'Will',
            'email'=>'will@gmail.com',
            'password'=>Hash::make('editor'),
            'rol'=>'editor'
        ]);
    }
}

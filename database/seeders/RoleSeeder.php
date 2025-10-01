<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      DB::table('roles')->insert([
    ['id'=>1,'name'=>'Veterinario'],
    ['id'=>2,'name'=>'Entrenador'],
    ['id'=>3,'name'=>'Cliente'],
    ['id'=>4,'name'=>'Refugio'],
    ]);

    }
}

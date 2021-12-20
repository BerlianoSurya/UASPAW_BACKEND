<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //GD11
        DB::table('users')->insert([
            'name' => 'lino', // Isi dengann nama masing-masing
            'email' => '10250@students.uajy.ac.id', // isi YYYYY dengan 5 digit terakhir npm masing-masing
            'password' => '$2b$10$5xupPeFvxEr2pgIkXyKZ1OlCQ.jRoVmBw6x.SJCp1hz873IIlyOdi', //isi dengan hasil bcrypth (password terserah kalian)
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}

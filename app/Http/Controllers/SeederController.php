<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class SeederController extends Controller
{
    public function runSeeder()
    {
        // Call the seeder using Artisan
        Artisan::call('db:seed', ['--class' => 'UserSeeder']);

        return response()->json(['message' => 'Seeder executed successfully.']);
    }
}

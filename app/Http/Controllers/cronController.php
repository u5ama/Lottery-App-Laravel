<?php

namespace App\Http\Controllers;

use App\Models\admin_data;
use App\Models\new_combinations;

class cronController extends Controller
{
    public function index(){
        $numbers = array_combine(range(1,41), range(1,41));
            // dd(admin_data::all()->count());
        // if(admin_data::all()->count() !== 4750104241){
            for($i=0; $i < 100000; $i++){
                $userData = new admin_data;
                $combo = json_encode(array_rand($numbers, 6));
                if($userData->where('combinations', $combo)->first() !== null){
                    continue;
                }
                $userData->combinations = $combo;
                $userData->save();
            }
        // }
        // dd('Hellow');
    }
    
    public function newIndex(){
        $numbers = array_combine(range(1,49), range(1,49));

        for ($i = 0; $i < 100000; $i++) {
            $userData = new new_combinations();

            $combo = json_encode(array_rand($numbers, 7));
                if($userData->where('combinations', $combo)->first() !== null){
                    continue;
                }
            $userData->combinations = $combo;
            $userData->save();
        }
    }
}
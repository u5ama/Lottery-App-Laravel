<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Users;
use App\Models\Admin;

class lotteryController extends Controller
{
  public function index(Request $request){
    // if(isset($request->adminReserved)){
      // $reserved = $request->adminReserved;
      // $query = new Admin;
      // $query->reservedCombo = serialize($reserved);
      // $save = $query->save();

      // return view('lottery');
    // }else{
      $check = true;
      $numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41];

      // $adminReserved = Admin::select('reservedCombo')->latest()->first();
      // $adminReserved = unserialize($adminReserved->reservedCombo);
      // dd($adminReserved);
      $adminReserved = $request->adminReserved;
      $userCombo = $request->userCombo;

      foreach($adminReserved as $key => $value){
        if($k = array_search($value, $numbers)){
          unset($numbers[$k]);
        }
      }
      $numbers = array_values($numbers);

      function findConsecutive($array, $count){
        $consecutive = array();
        $previous = null;
        foreach($array as $value){
          if($previous !== null && $value == $previous + 1){
            $consecutive[] = $value;
            if($found == $count){
              return "I found it: ".implode("|", $consecutive)."<br>";
            }
          }else{
            $consecutive = array($value);
            $found = 1;
          }
          $previous = $value;
          $found++;
        }
      }

      function winCombo($value){
        $consecutive = '';
        while($consecutive !== null){
          $one = $value[array_rand($value)];
          $two = $value[array_rand($value)];
          $three = $value[array_rand($value)];
          $four = $value[array_rand($value)];
          $five = $value[array_rand($value)];
          $six = $value[array_rand($value)];

          $combo = [$one, $two, $three, $four, $five, $six];
          $consecutive = findConsecutive($combo, 3);
        }

        return $combo;
      }

      $winCombo = winCombo($numbers);

      if(array_diff($winCombo, $userCombo)){
        $msg = "Sorry, your combination does not matched.";
        $check = false;
      }else{
        $msg = "Congrats, your combination is matched.";
      }

      // $u = serialize($userCombo);

      // dd($userCombo);

      // $query = Users::find('2');
      // $query = new Users;

      // $query->name = 'Usama';
      // $query->combinations = $u;

      // $save = $query->save();

      // if($save){
      //   dd('ok');
      // }else{
      //   dd('not');
      // }

      if($check === true){
      //   return back()->with('success', $msg);
        return ['success', $msg, $winCombo, $userCombo];
      }else{
        // return back()->with('fail', $msg);
        return ['fail', $msg, $winCombo, $userCombo];
      }
    // }
  }
}
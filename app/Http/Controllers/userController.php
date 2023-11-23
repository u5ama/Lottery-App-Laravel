<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Users;
use App\Models\reserved_combo;
use App\Models\admin_data;
use App\Models\user_data;
use App\Models\user_played;
use App\Helpers\makeCombinations;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class userController extends Controller
{
  public function login(){
    return view('user.login');
  }

  public function signup(){
    return view('user.signup');
  }

  public function check(Request $request){
    $request->validate([
      'email'=> 'required|string|email',
      'pass'=> 'required|string'
    ]);

    $userInfo = Users::where('email', '=', $request->email)->first();

    if(!$userInfo){
      return back()->with('fail', 'Please add correct Username');
    }else{
      if($request->pass === $userInfo->pass){
        $request->session()->put('userLogIn',$userInfo->id);
        return redirect()->route('home');
      }else{
        return back()->with('fail', 'Please add correct Password');
      }
    }
  }

  public function checkSignup(Request $request){
    $request->validate([
      'email'=> 'required|string|email',
      'pass'=> 'required|string'
    ]);

    $userInfo = Users::where('email', '=', $request->email)->first();
    
    if(!empty($userInfo)){
      return back()->with('fail', 'This email is already exists!');
    }else{
      $user = new Users;
      $user->email = $request->email;
      $user->pass = $request->pass;
      $user->save();
      $request->session()->put('userLogIn',$user->id);
      return redirect()->route('user.play');
    }
  }

  public function logout(){
    if(session()->has('userLogIn')){
      session()->pull('userLogIn');
      return redirect('/');
    }
  }

  public function play(Request $request){
    $userInfo = Users::where('id', '=', session('userLogIn'))->first();

    if($request->has('playData')){
      $playData = json_decode($request->playData);

      if(!empty($playData)){
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

        $numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41];

        if(reserved_combo::first()){
          $adminReserved = json_decode(reserved_combo::first()->reserved_combos);

          foreach($adminReserved as $key => $value){
            if($k = array_search($value, $numbers)){
              unset($numbers[$k]);
            }
          }
          $numbers = array_values($numbers);
        }

        $winCombo = winCombo($numbers);
        $matches = [];

        foreach($playData as $playNum){
          $playNum = array_map('intval', $playNum);
          $played = new user_played;
          $played->played = json_encode($playNum);
          $played->save();

          $matches[] = array_intersect_assoc($winCombo, $playNum);
        }

        return view('index')
        ->with('userInfo', $userInfo)
        ->with('winCombo', $winCombo)
        ->with('matches', $matches)
        ->with('playData', $playData);
      }else{
        return back()->with('fail', 'Please fill all the fields');
      }
    }else{
      return back()->with('userInfo', $userInfo);
    }
  }

  public function played(Request $request){
    $userInfo = Users::where('id', '=', session('userLogIn'))->first();
    $userPlayed = user_played::orderBy('id', 'desc')->paginate('20');

    return view('user.played')
    ->with('userInfo', $userInfo)
    ->with('userPlayed', $userPlayed);
  }
}

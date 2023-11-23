<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\reserved_combo;
use App\Models\admin_data;
use App\Models\new_combinations;
use App\Models\winning_combo;
use App\Models\user_data;
use App\Models\Users;
use App\Helpers\makeCombinations;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class adminController extends Controller
{
  public function login(){
    return view('admin.login');
  }

  public function check(Request $request){
    $request->validate([
      'name'=> 'required',
      'pass'=> 'required'
    ]);

    $adminInfo = Admin::where('name', '=', $request->name)->first();

    if(!$adminInfo){
      return back()->with('fail', 'Please add correct Username');
    }else{
      if($request->pass === $adminInfo->pass){
        $request->session()->put('adminLogIn',$adminInfo->id);
        return redirect()->route('home');
      }else{
        return back()->with('fail', 'Please add correct Password');
      }
    }
  }

  public function logout(){
    if(session()->has('adminLogIn')){
      session()->pull('adminLogIn');
      return redirect('/admin');
    }
  }

  public function reserve(Request $request){
    $adminInfo = Admin::where('id', '=', session('adminLogIn'))->first();
    $check = reserved_combo::all();
    $reserved = $request->adminReserved;

    if($request->has('reserve')){
      if($check->isEmpty()){
        $reserve = new reserved_combo;
        $reserve->reserved_combos = json_encode($reserved);
        $save = $reserve->save();
        $msg = 'Combination Reserved and Combinations Created Successfully';
      }else{
        $reserveID = $check->first()->id;
        $reserve = reserved_combo::find($reserveID);
        $reserve->reserved_combos = json_encode($reserved);
        $save = $reserve->save();
        $msg = 'Reservation Updated and Combinations Created Successfully';
      }

      if($save){
        return back()->with('success', $msg);
      }else{
        return back()->with('fail', 'Reservation Failed');
      }
    }else{
      if($check->isEmpty()){
        return view('admin.reserve')
        ->with('adminInfo', $adminInfo);
      }else{
        $currentReserved = json_decode($check->first()->reserved_combos);
        return view('admin.reserve')
        ->with('currentReserved', $currentReserved)
        ->with('adminInfo', $adminInfo);
      }
    }
  }
  
    public function winning(Request $request){
    $adminInfo = Admin::where('id', '=', session('adminLogIn'))->first();
      $check = winning_combo::find(1);
      $winned = $request->adminWinning;
  
      if($request->has('reserve')){
        $win = winning_combo::updateOrCreate(['id' => 1],[
          'winning_combos' => json_encode($winned)
        ]);
        $msg = 'Winning Combination Updated and Created Successfully';
          if($win){
              return back()->with('success', $msg);
          }else{
            return back()->with('fail', 'Combination Failed');
          }
      }else{
        if(!$check){
          $status = '';
          return view('admin.winning')
          ->with('status', $status)
          ->with('adminInfo', $adminInfo);
        }else{
          $currentReserved = json_decode($check->winning_combos);
          $status = $check->combo;
          
          return view('admin.winning')
          ->with('status', $status)
          ->with('currentReserved', $currentReserved)
          ->with('adminInfo', $adminInfo);
        }
      }
  }

  public function winningStatus(Request $request){
      $win = winning_combo::find(1);
      $win->combo = $request->combo;
      $save = $win->save();
      
       return redirect()->route('admin.winning');
  }

  public function combinations(Request $request){
    $adminInfo = Admin::where('id', '=', session('adminLogIn'))->first();
    $combinations = admin_data::paginate(20);

      $combinations->each(function ($item) {
            $combinationsArray = json_decode($item->combinations, true);
            sort($combinationsArray);
            $item->combinations = json_encode($combinationsArray);
            return $item;
      });

    return view('admin.combinations')
    ->with('adminInfo', $adminInfo)
    ->with('combinations', $combinations);
  }

  public function filterReserved(Request $request){
    $adminInfo = Admin::where('id', '=', session('adminLogIn'))->first();

    $numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41];
    $reserved = json_decode(reserved_combo::first()->reserved_combos);
    
    $combos = admin_data::limit(200000)->get()->toArray();
    $filtered = [];

    foreach($combos as $i => $value){
        $val = json_decode($value['combinations']);
        if(empty(array_intersect($reserved, $val))){
            $filtered[] = $val;
        }
    }
    

    Collection::macro('paginate', function ($perPage, $total = null, $page = null, $pageName = 'page') {
      $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);

      return new LengthAwarePaginator($this->forPage($page, $perPage), $total ?: $this->count(), $perPage, $page, [
          'path' => LengthAwarePaginator::resolveCurrentPath(),
          'pageName' => $pageName,
      ]);
    });

    $paginator = collect($filtered)->paginate(20);

    return view('admin.combinations')
    ->with('adminInfo', $adminInfo)
    ->with('filterReserved', $paginator);
  }

   public function filterConsecutive(Request $request){
    $adminInfo = Admin::where('id', '=', session('adminLogIn'))->first();

    $filter = $request->filterConsecutive;

       $filter = $request->input('filterConsecutive', session('filterConsecutive'));
    
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

    function findNoConsecutive($array, $count)
      {
          // Ensure the array has enough elements
            if (count($array) < 2) {
                return null;
            }
        
            $result = [];
            $bool = false;
            for ($i = 1; $i < count($array); $i++) {
                if($array[$i] == $array[$i-1]+1)
                { 
                	$bool = true;
                	break;
                }
            }
            
            if($bool){
            	return null;
            }
             return $array;
      }

    $chars = array_values($numbers);
    
    $combos = admin_data::limit(200000)->get()->toArray();
    // $combos = admin_data::all()->toArray();

    $keys = [];
    $combo = [];
    $newArray = [];

    foreach($combos as $key => $value){
      $val = json_decode($value['combinations']);
      $combo[] = $val;
      if ($filter == 0) {
        $consecutive = findNoConsecutive($val, $filter);
        if($consecutive !== null){
            $newArray[] = $consecutive;
        }
      }
      else{
        $consecutive = findConsecutive($val, $filter);
        if($consecutive !== null){
            $keys[] = $key;
        }
      }
    }
    
    if(count($keys)>0){
      foreach($keys as $key => $value){
            unset($combo[$value]);
        }  
    }
    
    if(count($newArray)>0){
        $combos = array_values($newArray);
    }else{
        $combos = array_values($combo);
    }
    
    Collection::macro('paginate', function ($perPage, $total = null, $page = null, $pageName = 'page') use ($filter) {
        $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);

        return new LengthAwarePaginator($this->forPage($page, $perPage), $total ?: $this->count(), $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
            'pageName' => $pageName,
            'query' => ['filterConsecutive' => $filter],
        ]);
    });

    $paginator = collect($combos)->paginate(20);
    
    return view('admin.combinations')
    ->with('adminInfo', $adminInfo)
    ->with('filterConsecutive'.$filter, $paginator);
  }

  public function play(Request $request){
    $adminInfo = Admin::where('id', '=', session('adminLogIn'))->first();
    $playData = $request->playData;

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


        $win = winning_combo::find(1);
        if ($win->combo == 'admin'){
       
            $winCombo = json_decode(winning_combo::find(1)->winning_combos);
        }else{
        
            $winCombo = winCombo($numbers);
        }
        $matches = [];

        foreach($playData as $playNum){
          $playNum = array_map('intval', $playNum);
          $matches[] = array_intersect_assoc($winCombo, $playNum);
        }
        

        return view('index')
        ->with('adminInfo', $adminInfo)
        ->with('winCombo', $winCombo)
        ->with('matches', $matches)
        ->with('playData', $playData);
      }else{
        return back()->with('fail', 'Please fill all the fields');
      }
    }else{
      return back()->with('adminInfo', $adminInfo);
    }
  }

  public function users(){
    $adminInfo = Admin::where('id', '=', session('adminLogIn'))->first();
    $users = Users::paginate(20);

    return view('admin.users')
    ->with('adminInfo', $adminInfo)
    ->with('users', $users);
  }
  
  
  // New Combinations 1-49
    public function newCombinations(Request $request){
        $adminInfo = Admin::where('id', '=', session('adminLogIn'))->first();
        $combinations = new_combinations::paginate('20');
        
          $combinations->each(function ($item) {
                $combinationsArray = json_decode($item->combinations, true);
                sort($combinationsArray);
                $item->combinations = json_encode($combinationsArray);
                return $item;
          });

        return view('admin.new_combinations')
            ->with('adminInfo', $adminInfo)
            ->with('combinations', $combinations);
    }

    public function newFilterReserved(Request $request){
        $adminInfo = Admin::where('id', '=', session('adminLogIn'))->first();

        $numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42 ,43, 44, 45, 46, 47, 48, 49];
        $reserved = json_decode(reserved_combo::first()->reserved_combos);

        $combos = new_combinations::limit(200000)->get()->toArray();
        $filtered = [];

        foreach($combos as $i => $value){
            $val = json_decode($value['combinations']);
            if(empty(array_intersect($reserved, $val))){
                $filtered[] = $val;
            }
        }


        Collection::macro('paginate', function ($perPage, $total = null, $page = null, $pageName = 'page') {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);

            return new LengthAwarePaginator($this->forPage($page, $perPage), $total ?: $this->count(), $perPage, $page, [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'pageName' => $pageName,
            ]);
        });

        $paginator = collect($filtered)->paginate(20);

        return view('admin.new_combinations')
            ->with('adminInfo', $adminInfo)
            ->with('filterReserved', $paginator);
    }

    public function newFilterConsecutive(Request $request){
        $adminInfo = Admin::where('id', '=', session('adminLogIn'))->first();

            $filter = $request->input('filterConsecutive', session('filterConsecutive'));
        $numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42 ,43, 44, 45, 46, 47, 48, 49];

        if(reserved_combo::first()){
            $adminReserved = json_decode(reserved_combo::first()->reserved_combos);

            foreach($adminReserved as $key => $value){
                if($k = array_search($value, $numbers)){
                    unset($numbers[$k]);
                }
            }
            $numbers = array_values($numbers);
        }

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

        function findNoConsecutive($array, $count)
        {
            {
          // Ensure the array has enough elements
            if (count($array) < 2) {
                return null;
            }
        
            $result = [];
            $bool = false;
            for ($i = 1; $i < count($array); $i++) {
                if($array[$i] == $array[$i-1]+1)
                { 
                	$bool = true;
                	break;
                }
            }
            
            if($bool){
            	return null;
            }
             return $array;
            }
        }

        $chars = array_values($numbers);

        $combos = new_combinations::limit(200000)->get()->toArray();
        // $combos = admin_data::all()->toArray();

        $keys = [];
        $combo = [];
        $newArray = [];

        foreach($combos as $key => $value){
          $val = json_decode($value['combinations']);
          $combo[] = $val;
          if ($filter == 0) {
            $consecutive = findNoConsecutive($val, $filter);
            if($consecutive !== null){
                $newArray[] = $consecutive;
                // $keys[] = $key;
            }
          }
          else{
            $consecutive = findConsecutive($val, $filter);
            if($consecutive !== null){
                $keys[] = $key;
            }
          }
        }
        
        if(count($keys)>0){
          foreach($keys as $key => $value){
                unset($combo[$value]);
            }  
        }

        if(count($newArray)>0){
            $combos = array_values($newArray);
        }else{
            $combos = array_values($combo);
        }

        Collection::macro('paginate', function ($perPage, $total = null, $page = null, $pageName = 'page') use ($filter) {
        $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);

        return new LengthAwarePaginator($this->forPage($page, $perPage), $total ?: $this->count(), $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
            'pageName' => $pageName,
            'query' => ['filterConsecutive' => $filter],
        ]);
    });

    $paginator = collect($combos)->paginate(20);

        return view('admin.new_combinations')
            ->with('adminInfo', $adminInfo)
            ->with('filterConsecutive'.$filter, $paginator);
    }
    
    public function newPlay(Request $request){
        $adminInfo = Admin::where('id', '=', session('adminLogIn'))->first();
        $playData = $request->newPlayData;

        if($request->has('newPlayData')){
            $playData = json_decode($request->newPlayData);

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
                        $seven = $value[array_rand($value)];

                        $combo = [$one, $two, $three, $four, $five, $six, $seven];
                        $consecutive = findConsecutive($combo, 3);
                    }

                    return $combo;
                }

                $numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42 ,43, 44, 45, 46, 47, 48, 49];

                if(reserved_combo::first()){
                    $adminReserved = json_decode(reserved_combo::first()->reserved_combos);

                    foreach($adminReserved as $key => $value){
                        if($k = array_search($value, $numbers)){
                            unset($numbers[$k]);
                        }
                    }
                    $numbers = array_values($numbers);
                }


                $win = winning_combo::find(2);
                if ($win->combo == 'admin'){
               
                    $winCombo = json_decode(winning_combo::find(2)->winning_combos);
                }else{
                
                    $winCombo = winCombo($numbers);
                }
                $matches = [];

                foreach($playData as $playNum){
                    $playNum = array_map('intval', $playNum);
                    $matches[] = array_intersect_assoc($winCombo, $playNum);
                }

                return view('index')
                    ->with('adminInfo', $adminInfo)
                    ->with('newWinCombo', $winCombo)
                    ->with('newMatches', $matches)
                    ->with('newPlayData', $playData);
            }else{
                return back()->with('fail', 'Please fill all the fields');
            }
        }else{
            return back()->with('adminInfo', $adminInfo);
        }
    }
    
    public function new_winning(Request $request){
      $adminInfo = Admin::where('id', '=', session('adminLogIn'))->first();
      $check = winning_combo::find(2);
      $winned = $request->adminWinning;
  
      if($request->has('reserve')){
        $win = winning_combo::updateOrCreate(['id' => 2],[
          'winning_combos' => json_encode($winned)
        ]);
        $msg = 'Winning Combination Updated and Created Successfully';
          if($win){
              return back()->with('success', $msg);
          }else{
            return back()->with('fail', 'Combination Failed');
          }
      }else{
          
        if(!$check){
          $status = '';
          return view('admin.new_winning')
          ->with('status', $status)
          ->with('adminInfo', $adminInfo);
        }else{
          $currentReserved = json_decode($check->winning_combos);
          $status = $check->combo;
          
          return view('admin.new_winning')
          ->with('status', $status)
          ->with('currentReserved', $currentReserved)
          ->with('adminInfo', $adminInfo);
        }
      }
    }
  
    public function newWinningStatus(Request $request){
        $win = winning_combo::find(2);
        $win->combo = $request->combo;
        $save = $win->save();
        
         return redirect()->route('admin.new_winning');
    }
}

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lottery App</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <style>
      .dNone{
        display: none
      }
      .border_2{
        border: 1px solid #000
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="container-fluid">
        <div class="pt-5">
          {{-- @if(session()->has('success')) --}}
            {{-- <div class="alert alert-success alert-dismissible fade show alertDisplaySet">
              {{ session()->get('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div> --}}
          {{-- @elseif(session()->has('fail')) --}}
            <div class="alert alert-danger alert-dismissible fade show alertDisplaySet dNone dMsg">
              {{-- {{ session()->get('fail') }} --}}
              <span class="msg"></span>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          {{-- @endif --}}
          <form action="{{ route('lottery') }}" method="post" id="lotteryForm">
            @csrf
            <div class="row">
              <div class="col-7 admin">
                <div class="row">
                  <h4 class="mb-5">Admin Panel</h4>
                  <h5>Enter reserved numbers:</h5>
                  <input name="adminReserved[]" type="number" class="col m-3 adminReserved">
                  <input name="adminReserved[]" type="number" class="col m-3 adminReserved">
                  <input name="adminReserved[]" type="number" class="col m-3 adminReserved">
                  <input name="adminReserved[]" type="number" class="col m-3 adminReserved">
                  <input name="adminReserved[]" type="number" class="col m-3 adminReserved">
                </div>
              </div>
              <div class="col-5"></div>
            </div>
            <div class="row">
              <div class="col-7 user dNone">
                <div class="row">
                  <h4 class="mb-5">User Panel</h4>
                  <h5>Enter Number in between 1-41 in each cell and avoid consecutive numbers:</h5>
                  <input name="userCombo[]" type="number" class="col m-3 userCombo">
                  <input name="userCombo[]" type="number" class="col m-3 userCombo">
                  <input name="userCombo[]" type="number" class="col m-3 userCombo">
                  <input name="userCombo[]" type="number" class="col m-3 userCombo">
                  <input name="userCombo[]" type="number" class="col m-3 userCombo">
                  <input name="userCombo[]" type="number" class="col m-3 userCombo">
                </div>
              </div>
              <div class="col-5"></div>
            </div>
            <div class="row pt-3">
              <div class="col-7">
                <input type="button" name="save" class="btn btn-secondary ms-1 save" value="Save">
                <input type="button" name="Submit" class="btn btn-secondary ms-1 submit dNone" value="Submit">
                <a href="{{ route('lottery') }}" class="btn btn-secondary dNone back float-end">Back</a>
              </div>
              <div class="col-5"></div>
            </div>
          </form>
        </div>
        <div class="row mt-5 combos dNone">
          <div class="col-7">
            <h4>Winning Combination</h4>
            <div class="row">
              <div class="col winCombo mt-3 mb-4 fs-5 mx-2 border_2"></div>
              <div class="col winCombo mt-3 mb-4 fs-5 mx-2 border_2"></div>
              <div class="col winCombo mt-3 mb-4 fs-5 mx-2 border_2"></div>
              <div class="col winCombo mt-3 mb-4 fs-5 mx-2 border_2"></div>
              <div class="col winCombo mt-3 mb-4 fs-5 mx-2 border_2"></div>
              <div class="col winCombo mt-3 mb-4 fs-5 mx-2 border_2"></div>
            </div>
            <h4>Your Combination</h4>
            <div class="row">
              <div class="col yourCombo mt-3 mb-4 fs-5 mx-2 border_2"></div>
              <div class="col yourCombo mt-3 mb-4 fs-5 mx-2 border_2"></div>
              <div class="col yourCombo mt-3 mb-4 fs-5 mx-2 border_2"></div>
              <div class="col yourCombo mt-3 mb-4 fs-5 mx-2 border_2"></div>
              <div class="col yourCombo mt-3 mb-4 fs-5 mx-2 border_2"></div>
              <div class="col yourCombo mt-3 mb-4 fs-5 mx-2 border_2"></div>
            </div>
          </div>
          <div class="col-5"></div>
        </div>
        <footer>
          <script src="{{ asset('js/bootstrap.min.js') }}"></script>
          <script src="{{ asset('js/jQuery-3.6.0.js') }}"></script>
          <script>
            $(document).ready(function(){
              function findValueInArray(value,arr){
                var result = 0;
               
                for(var i = 0; i < arr.length; i++){
                  var name = arr[i];
                  if(name == value){
                    result = 1;
                    break;
                  }
                }
                return result;
              }
              var numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41];
              $('.save').on('click', function(){
                var inputs = $(".adminReserved");
                var check = true;
                var checkRange = true;
                for(var i = 0; i < inputs.length; i++){
                  var inputVal = $(inputs[i]).val();
                  if(inputVal === ''){
                    check = false;
                  }
                  var numbersCheck = findValueInArray(inputVal, numbers);
                  if(numbersCheck === 0){
                    checkRange = false;
                  }
                }

                if(check === false){
                  alert('Please fill all the fields');
                }else if(checkRange === false){
                  alert('Please select numbers in between 1-41 in each cell');
                }else{
                  $('.user, .submit, .back').show();
                  $('.admin, .save').hide();
;               }
              });

              $('.submit').on('click', function(){
                var inputs = $(".userCombo");
                var check = true;
                var checkRange = true;
                for(var i = 0; i < inputs.length; i++){
                  var inputVal = $(inputs[i]).val();
                  if(inputVal === ''){
                    check = false;
                  }
                  var numbersCheck = findValueInArray(inputVal, numbers);
                  if(numbersCheck === 0){
                    checkRange = false;
                  }
                }

                if(check === false){
                  alert('Please fill all the fields');
                }else if(checkRange === false){
                  alert('Please select numbers in between 1-41 in each cell');
                }else{
                  var formData = new FormData($("#lotteryForm").get(0));
                  $.ajax({
                    url: "{{ route('lottery') }}",
                    type: "post",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data){
                      console.log(data);
                      if(data[0] === 'success'){
                        $('.dMsg').removeClass('alert-danger');
                        $('.dMsg').addClass('alert-success');
                      }
                      $('.msg').text(data[1]);
                      
                      var winCombo = $('.winCombo');
                      var yourCombo = $('.yourCombo');
                      for(var i = 0; i < data[2].length; i++){
                        $(winCombo[i]).text(data[2][i]);
                        $(yourCombo[i]).text(data[3][i]);
                      }

                      $('.dMsg, .combos').show();
                    }
                  });
                }
              });
            });
          </script>
        </footer>
      </div>
    </div>
  </body>
</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Lottery App</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
  </head>
  <body>
    <div class="container">
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-light">
          <div class="container-fluid">
            <a class="navbar-brand logo" href="#">Lottomate</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="{{ !session()->has('userLogIn') ? (session()->has('adminLogIn') ? route('admin.logout') : route('user.login')) : route('user.logout') }}">
                    {{ session()->has('userLogIn') || session()->has('adminLogIn') ? 'Logout' : 'Login' }}
                  </a>
                </li>
                @if(!session()->has('userLogIn') && !session()->has('adminLogIn'))
                  <li class="nav-item">
                    <a class="nav-link btn mx-4 register" href="{{ route('user.signup') }}">Register</a>
                  </li>
                @elseif(session()->has('adminLogIn'))
                  <li class="nav-item">
                    <a class="nav-link btn mx-4 register" href="{{ route('admin.reserve') }}">Dashboard</a>
                  </li>
                @endif
                <li class="nav-item">
                  <a class="nav-link bg_success" href="javascript:void(0)">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="ms-2">Cart</span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </nav>
      </div>
    </div>
    <hr class="mt-0">
    <div class="container">
      <div class="container-fluid">
        <div class="how_bg">
          <h3 class="text-center">How to play?</h3>
          <div class="row mt-3">
            <div class="col-12 col-md-6 col-lg-3">
              <div class="how_item">
                <div class="how_num">01</div>
                <div class="how_cont">
                  <div class="how_sm">Pick a lottery and your lucky numbers to participate in the draw.</div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
              <div class="how_item">
                <div class="how_num">02</div>
                <div class="how_cont">
                  <div class="how_sm">Complete the purchase! Its confirmation will be sent to your email.</div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
              <div class="how_item">
                <div class="how_num">03</div>
                <div class="how_cont">
                  <div class="how_sm">Look for a scanned ticket or the bet details in your account.</div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
              <div class="how_item">
                <div class="how_num">04</div>
                <div class="how_cont">
                  <div class="how_sm">You are guaranteed to receive the draw results by email.</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    @if(Session::get('success'))
      <div class="alert alert-success">
        {{ Session::get('success') }}
      </div>
    @elseif(Session::get('fail'))
      <div class="alert alert-danger">
        {{ Session::get('fail') }}
      </div>
    @endif

    @php
      $k = -1;
      $check = false;
    @endphp

    @if(isset($winCombo))
      <div class="container">
        <div class="container-fluid">
          <div class="col-12 my-4">
            <div class="row">
              <p class="h5">Winning Combination:</p>
              
              @foreach($winCombo as $value)
              
                <div class="col-4 col-sm-3 col-md-2 mt-3">
                  <input type="number" class="col-12" value="{{ $value }}" disabled>
                </div>
              @endforeach
            </div>
            <div class="row">
              <p class="h5 mt-3">Matches:</p>
              @if(isset($matches))
              
                @foreach($playData as $key => $value)
                  <p class="h6 mt-3">Play {{ $key + 1 }}:</p>
                  @if(!empty($matches[$key]))
            
                    @if(array_key_exists($key, $matches[$key]))
                   
                      @if($key == ++$k)
                      
                       @foreach($value as $v)
              
                        <div class="col-4 col-sm-3 col-md-2 mt-3">
                          <input type="number" class="col-12 text-dark" style="background:#00800033" value="{{ $v }}" disabled>
                        </div>
                      @endforeach
                        
                        @php $check = true; @endphp
                      @elseif($check)
                     
                        <div class="col-4 col-sm-3 col-md-2 mt-3">
                          <input type="number" class="col-12" value="{{ $value[$key] }}" disabled>
                        </div>
                      @endif
                    @elseif($check)
                      <div class="col-4 col-sm-3 col-md-2 mt-3">
                        <input type="number" class="col-12" value="{{ $value[$key] }}" disabled>
                      </div>
                    @endif
                    @if($check === false)
                      <div class="col-12 mt-3">
                        <input type="text" class="col-12 alert-danger" value="None" disabled>
                      </div>
                    @endif
                  @else
                    <div class="col-12 mt-3">
                      <input type="text" class="col-12 alert-danger" value="None" disabled>
                    </div>
                  @endif
                @endforeach
              @endif
            </div>
          </div>
        </div>
      </div>
       
    @endif

    <div class="container">
      <div class="container-fluid">
        <div class="col-12 mySlider">
          <ul class="col-12 col-lg-9 list-group list-group-horizontal-md">
            <li class="list-group-item mt-3 mb-md-4">
              <span>Choose the number of lines:</span>
            </li>
            <li class="list-group-item mt-3 mb-md-4 lines activeLine" data-value="1">
              <span class="px-4 py-2 rounded-2 text-primary cursorP">1 line</span>
            </li>
            <li class="list-group-item mt-3 mb-md-4 lines" data-value="3">
              <span class="px-4 py-2 rounded-2 text-primary cursorP">3 lines</span>
            </li>
            <li class="list-group-item mt-3 mb-4 lines" data-value="5">
              <span class="px-4 py-2 rounded-2 text-primary cursorP">5 lines</span>
            </li>
          </ul>
          <div class="row" id="play_slider">
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xxl-2 playBox">
              <div class="col-12 outerBox">
                <div class="row">
                  <div class="owl-item active" style="width: auto; margin-right: 8px;">
                    <div class="number_box" data-num="1">
                      <div class="choose_number">
                        <div class="content_open">
                          <a href="#" class="clearBtn reset" title="Clear"><i class="fas fa-trash-alt"></i></a>
                          <a href="#" class="easyPick">Easy Pick</a>
                        </div>
                        <div class="choose_area">
                          <div class="box_list_number">
                            <div class="number ">1</div>
                            <p class="choose_text mb-0">Pick 6 numbers</p>
                            <ul class="list_number">
                              <li class="num1 "><a href="javascript:void(0)">1</a></li>
                              <li class="num2 "><a href="javascript:void(0)">2</a></li>
                              <li class="num3 "><a href="javascript:void(0)">3</a></li>
                              <li class="num4 "><a href="javascript:void(0)">4</a></li>
                              <li class="num5 "><a href="javascript:void(0)">5</a></li>
                              <li class="num6 "><a href="javascript:void(0)">6</a></li>
                              <li class="num7 "><a href="javascript:void(0)">7</a></li>
                              <li class="num8 "><a href="javascript:void(0)">8</a></li>
                              <li class="num9 "><a href="javascript:void(0)">9</a></li>
                              <li class="num10 "><a href="javascript:void(0)">10</a></li>
                              <li class="num11 "><a href="javascript:void(0)">11</a></li>
                              <li class="num12 "><a href="javascript:void(0)">12</a></li>
                              <li class="num13 "><a href="javascript:void(0)">13</a></li>
                              <li class="num14 "><a href="javascript:void(0)">14</a></li>
                              <li class="num15 "><a href="javascript:void(0)">15</a></li>
                              <li class="num16 "><a href="javascript:void(0)">16</a></li>
                              <li class="num17 "><a href="javascript:void(0)">17</a></li>
                              <li class="num18 "><a href="javascript:void(0)">18</a></li>
                              <li class="num19 "><a href="javascript:void(0)">19</a></li>
                              <li class="num20 "><a href="javascript:void(0)">20</a></li>
                              <li class="num21 "><a href="javascript:void(0)">21</a></li>
                              <li class="num22 "><a href="javascript:void(0)">22</a></li>
                              <li class="num23 "><a href="javascript:void(0)">23</a></li>
                              <li class="num24 "><a href="javascript:void(0)">24</a></li>
                              <li class="num25 "><a href="javascript:void(0)">25</a></li>
                              <li class="num26 "><a href="javascript:void(0)">26</a></li>
                              <li class="num27 "><a href="javascript:void(0)">27</a></li>
                              <li class="num28 "><a href="javascript:void(0)">28</a></li>
                              <li class="num29 "><a href="javascript:void(0)">29</a></li>
                              <li class="num30 "><a href="javascript:void(0)">30</a></li>
                              <li class="num31 "><a href="javascript:void(0)">31</a></li>
                              <li class="num32 "><a href="javascript:void(0)">32</a></li>
                              <li class="num33 "><a href="javascript:void(0)">33</a></li>
                              <li class="num34 "><a href="javascript:void(0)">34</a></li>
                              <li class="num35 "><a href="javascript:void(0)">35</a></li>
                              <li class="num36 "><a href="javascript:void(0)">36</a></li>
                              <li class="num37 "><a href="javascript:void(0)">37</a></li>
                              <li class="num38 "><a href="javascript:void(0)">38</a></li>
                              <li class="num39 "><a href="javascript:void(0)">39</a></li>
                              <li class="num40 "><a href="javascript:void(0)">40</a></li>
                              <li class="num41 "><a href="javascript:void(0)">41</a></li>
                            </ul>
                          </div>                      
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 mt-3 text-center">
          <form action="{{ session()->has('userLogIn') ? route('user.play') : route('admin.play') }}" method="post">
            @csrf
            <input type="hidden" name="playData" id="playData">
            <input type="submit" class="btn btn-primary btn-lg px-5" id="play" value="Play">
          </form>
        </div>
      </div>
    </div>
    
    {{-- 1-49 combo --}}
     @php
        $k = -1;
        $newCheck = false;
    @endphp

    @if(isset($newWinCombo))
        <div class="container">
            <div class="container-fluid">
                <div class="col-12 my-4">
                    <div class="row">
                        <p class="h5">Winning Combination:</p>
                        @foreach($newWinCombo as $value)
                            <div class="col-4 col-sm-3 col-md-2 mt-3">
                                <input type="number" class="col-12" value="{{ $value }}" disabled>
                            </div>
                        @endforeach
                    </div>
                    <div class="row">
                        <p class="h5 mt-3">Matches:</p>
                        @if(isset($newMatches))
                            @foreach($newPlayData as $key => $value)
                                <p class="h6 mt-3">Play {{ $key + 1 }}:</p>
                                @if(!empty($newMatches[$key]))
                                    @if(array_key_exists($key, $newMatches[$key]))
                                        @if($key == ++$k)
                                            @foreach($value as $v)
                                                <div class="col-4 col-sm-3 col-md-2 mt-3">
                                                    <input type="number" class="col-12 text-dark" style="background:#00800033" value="{{ $v }}" disabled>
                                                </div>
                                            @endforeach
                                            @php $newCheck = true; @endphp
                                        @elseif($check)
                                            <div class="col-4 col-sm-3 col-md-2 mt-3">
                                                <input type="number" class="col-12" value="{{ $value }}" disabled>
                                            </div>
                                        @endif
                                    @elseif($newCheck)
                                        <div class="col-4 col-sm-3 col-md-2 mt-3">
                                            <input type="number" class="col-12" value="{{ $value }}" disabled>
                                        </div>
                                    @endif
                                    @if($newCheck === false)
                                        <div class="col-12 mt-3">
                                            <input type="text" class="col-12 alert-danger" value="None" disabled>
                                        </div>
                                    @endif
                                @else
                                    <div class="col-12 mt-3">
                                        <input type="text" class="col-12 alert-danger" value="None" disabled>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="container">
        <div class="container-fluid">
            <div class="col-12 mySlider">
                <ul class="col-12 col-lg-9 list-group list-group-horizontal-md">
                    <li class="list-group-item mt-3 mb-md-4">
                        <span>Choose the number of lines:</span>
                    </li>
                    <li class="list-group-item mt-3 mb-md-4 newLines activeLine" data-value="1">
                        <span class="px-4 py-2 rounded-2 text-primary cursorP">1 line</span>
                    </li>
                    <li class="list-group-item mt-3 mb-md-4 newLines" data-value="3">
                        <span class="px-4 py-2 rounded-2 text-primary cursorP">3 lines</span>
                    </li>
                    <li class="list-group-item mt-3 mb-4 newLines" data-value="5">
                        <span class="px-4 py-2 rounded-2 text-primary cursorP">5 lines</span>
                    </li>
                </ul>
                <div class="row" id="new_play_slider">
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xxl-2 newPlayBox">
                        <div class="col-12 outerBox">
                            <div class="row">
                                <div class="owl-item active" style="width: auto; margin-right: 8px;">
                                    <div class="number_box" data-num="1">
                                        <div class="choose_number">
                                            <div class="content_open">
                                                <a href="#" class="clearBtn reset" title="Clear"><i class="fas fa-trash-alt"></i></a>
                                                <a href="#" class="easyPick">Easy Pick</a>
                                            </div>
                                            <div class="choose_area">
                                                <div class="box_list_number">
                                                    <div class="number ">1</div>
                                                    <p class="choose_text mb-0">Pick 7 numbers</p>
                                                    <ul class="new_list_number">
                                                        <li class="num1 "><a href="javascript:void(0)">1</a></li>
                                                        <li class="num2 "><a href="javascript:void(0)">2</a></li>
                                                        <li class="num3 "><a href="javascript:void(0)">3</a></li>
                                                        <li class="num4 "><a href="javascript:void(0)">4</a></li>
                                                        <li class="num5 "><a href="javascript:void(0)">5</a></li>
                                                        <li class="num6 "><a href="javascript:void(0)">6</a></li>
                                                        <li class="num7 "><a href="javascript:void(0)">7</a></li>
                                                        <li class="num8 "><a href="javascript:void(0)">8</a></li>
                                                        <li class="num9 "><a href="javascript:void(0)">9</a></li>
                                                        <li class="num10 "><a href="javascript:void(0)">10</a></li>
                                                        <li class="num11 "><a href="javascript:void(0)">11</a></li>
                                                        <li class="num12 "><a href="javascript:void(0)">12</a></li>
                                                        <li class="num13 "><a href="javascript:void(0)">13</a></li>
                                                        <li class="num14 "><a href="javascript:void(0)">14</a></li>
                                                        <li class="num15 "><a href="javascript:void(0)">15</a></li>
                                                        <li class="num16 "><a href="javascript:void(0)">16</a></li>
                                                        <li class="num17 "><a href="javascript:void(0)">17</a></li>
                                                        <li class="num18 "><a href="javascript:void(0)">18</a></li>
                                                        <li class="num19 "><a href="javascript:void(0)">19</a></li>
                                                        <li class="num20 "><a href="javascript:void(0)">20</a></li>
                                                        <li class="num21 "><a href="javascript:void(0)">21</a></li>
                                                        <li class="num22 "><a href="javascript:void(0)">22</a></li>
                                                        <li class="num23 "><a href="javascript:void(0)">23</a></li>
                                                        <li class="num24 "><a href="javascript:void(0)">24</a></li>
                                                        <li class="num25 "><a href="javascript:void(0)">25</a></li>
                                                        <li class="num26 "><a href="javascript:void(0)">26</a></li>
                                                        <li class="num27 "><a href="javascript:void(0)">27</a></li>
                                                        <li class="num28 "><a href="javascript:void(0)">28</a></li>
                                                        <li class="num29 "><a href="javascript:void(0)">29</a></li>
                                                        <li class="num30 "><a href="javascript:void(0)">30</a></li>
                                                        <li class="num31 "><a href="javascript:void(0)">31</a></li>
                                                        <li class="num32 "><a href="javascript:void(0)">32</a></li>
                                                        <li class="num33 "><a href="javascript:void(0)">33</a></li>
                                                        <li class="num34 "><a href="javascript:void(0)">34</a></li>
                                                        <li class="num35 "><a href="javascript:void(0)">35</a></li>
                                                        <li class="num36 "><a href="javascript:void(0)">36</a></li>
                                                        <li class="num37 "><a href="javascript:void(0)">37</a></li>
                                                        <li class="num38 "><a href="javascript:void(0)">38</a></li>
                                                        <li class="num39 "><a href="javascript:void(0)">39</a></li>
                                                        <li class="num40 "><a href="javascript:void(0)">40</a></li>
                                                        <li class="num41 "><a href="javascript:void(0)">41</a></li>
                                                        <li class="num42 "><a href="javascript:void(0)">42</a></li>
                                                        <li class="num43 "><a href="javascript:void(0)">43</a></li>
                                                        <li class="num44 "><a href="javascript:void(0)">44</a></li>
                                                        <li class="num45 "><a href="javascript:void(0)">45</a></li>
                                                        <li class="num46 "><a href="javascript:void(0)">46</a></li>
                                                        <li class="num47 "><a href="javascript:void(0)">47</a></li>
                                                        <li class="num48 "><a href="javascript:void(0)">48</a></li>
                                                        <li class="num49 "><a href="javascript:void(0)">49</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-3 text-center">
                <form action="{{ session()->has('userLogIn') ? route('user.newPlay') : route('admin.newPlay') }}" method="post">
                    @csrf
                    <input type="hidden" name="newPlayData" id="newPlayData">
                    <input type="submit" class="btn btn-primary btn-lg px-5" id="newPlay" value="Play">
                </form>
            </div>
        </div>
    </div>

    {{--1-49--}}
    
    
    <div class="col-12 bg_custom mt-5 py-5">
      <div class="container">
        <div class="container-fluid">
          <div class="row">
            <p class="col-12 h2 text-center py-3">Why are we worthy of your trust?</p>
            <div class="col-12 col-md-6 px-4 py-2">
              <div class="row bg-white round p-4">
                <div class="col-7">
                  <p class="h4">We have a license</p>
                  <p class="why_text">We have obtained the Curacao license, due to which we can offer you any games and the best lotteries in the world.</p>
                </div>
                <div class="col-5 text-end">
                  <img src="https://static.cdnland.com/new/images/svg/license.svg">
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6 px-4 py-2">
              <div class="row bg-white round p-4">
                <div class="col-7">
                  <p class="h4">We are always in touch!</p>
                  <p class="why_text">Our experts are ready to help you and answer any of your questions 24/7 via online chat, email, and even a phone call.</p>
                </div>
                <div class="col-5 text-end">
                  <img src="https://static.cdnland.com/new/images/svg/support.svg">
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6 px-4 py-2">
              <div class="row bg-white round p-4">
                <div class="col-7">
                  <p class="h4">We are 100% safe</p>
                  <p class="why_text">It's 100% safe to play with us! All your transactions are secured with 256-bit encryption, and we are PCI DSS certified.</p>
                </div>
                <div class="col-5 text-end">
                  <img src="https://static.cdnland.com/new/images/svg/secure.svg">
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6 px-4 py-2">
              <div class="row bg-white round p-4">
                <div class="col-7">
                  <p class="h4">The service is perfect</p>
                  <p class="why_text">We have been working since 2012! All this time, millions of players from all over the world have enjoyed our great service.</p>
                </div>
                <div class="col-5 text-end">
                  <img src="https://static.cdnland.com/new/images/svg/customer-success.svg">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <footer class="col-12 text-center bg_footer">
      <div class="col-12 bg-white p-4">
        <div class="container">
          <div class="h1 mb-0">We ❤️ it when you win!</div>
        </div>
      </div>
      <div class="col-12 p-4 pay_links">
        <div class="container">
          <div class="row">
            <div class="col"><a href="javascript:void(0)"><img src="https://static.cdnland.com/upload/images/bank/footer/visa.svg" class="blink_hover" alt="Visa"></a></div>
            <div class="col"><a href="javascript:void(0)"><img src="https://static.cdnland.com/upload/images/bank/footer/mastercard.svg" class="blink_hover" alt="Mastercard"></a></div>
            <div class="col"><a href="javascript:void(0)"><img src="https://static.cdnland.com/upload/images/bank/footer/maestro.svg" class="blink_hover" alt="Maestro"></a></div>
            <div class="col"><a href="javascript:void(0)"><img src="https://static.cdnland.com/upload/images/bank/footer/skrill.svg" class="blink_hover" alt="Skrill Wallet"></a></div>
            <div class="col"><a href="javascript:void(0)"><img src="https://static.cdnland.com/upload/images/bank/footer/trustly.svg" class="blink_hover" alt="Trustly"></a></div>
            <div class="col"><a href="javascript:void(0)"><img src="https://static.cdnland.com/upload/images/bank/footer/sticpay.svg" class="blink_hover" alt="SticPay"></a></div>
            <div class="col"><a href="javascript:void(0)"><img src="https://static.cdnland.com/upload/images/bank/footer/neteller.svg" class="blink_hover" alt="Neteller"></a></div>
          </div>
        </div>
      </div>
      <div class="col-12 py-5 footer_section border-bottom border-dark">
        <div class="container">
          <div class="row">
            <div class="col-12 col-sm-6 col-lg-3">
              <ul class="list-unstyled text-start">
                <li><a href="javascript:void(0)">About Us</a></li>
                <li><a href="javascript:void(0)">Support</a></li>
                <li><a href="javascript:void(0)">FAQ</a></li>
                <li><a href="javascript:void(0)">Invite a Fried</a></li>
                <li><a href="javascript:void(0)">Lottery Blog</a></li>
                <li><a href="javascript:void(0)">Affiliate Program</a></li>
              </ul>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
              <ul class="list-unstyled text-start">
                <li><a href="javascript:void(0)">Payment Methods</a></li>
                <li><a href="javascript:void(0)">Terms of Use</a></li>
                <li><a href="javascript:void(0)">Privacy Policy</a></li>
                <li><a href="javascript:void(0)">Responsible Gambling Policy</a></li>
                <li><a href="javascript:void(0)">Minoor Protection Policy</a></li>
                <li><a href="javascript:void(0)">Self-Exclusion Policy</a></li>
                <li><a href="javascript:void(0)">Know Your Customer</a></li>
              </ul>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
              <ul class="list-unstyled text-start lh-3 fs-6">
                <li><a href="javascript:void(0)" class="download_app p-3"><i class="fab fa-android"></i>&nbsp; Download on Android</a></li>
                <li class="textClr">Install our App!</li>
              </ul>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
              <ul class="list-unstyled text-start contact_us">
                <li><a href="javascript:void(0)"><i class="fas fa-phone-alt"></i>&nbsp; +371 6609 0444</a></li>
                <li><a href="javascript:void(0)"><i class="far fa-envelope"></i>&nbsp; Leave us a message</a></li>
                <li><a href="javascript:void(0)"><i class="far fa-comment-alt"></i>&nbsp; Online Chat</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 my-5">
        <div class="container">
          <div class="row text-start">
            <div class="col">
              <a href="https://pci.usd.de/compliance/6752-5829-20C2-975C-759B-3064/details_en.html" target="_blank" rel="nofollow">
                <img src="https://static.cdnland.com/new/images/footer/pci-dss.svg" class="blink" alt="PCI DSS Approved">
              </a>
            </div>
            <div class="col">
              <img src="https://static.cdnland.com/new/images/footer/ssl.svg" class="blink" alt="Comodo SSL">
            </div>
            <div class="col">
              <a href="https://safeweb.norton.com/report/show?url=www.agentlotto.com" target="_blank" rel="nofollow">
                <img src="https://static.cdnland.com/new/images/footer/norton.svg" class="blink" alt="Norton SafeWeb">
              </a>
            </div>
            <div class="col">
              <a href="https://www.siteadvisor.com/sites/www.agentlotto.com" target="_blank" rel="nofollow">
                <img src="https://static.cdnland.com/new/images/footer/mcafee.svg" class="blink" alt="SiteAdvisor">
              </a>
            </div>
            <div class="col">
              <a href="http://www.gambleaware.co.uk" target="_blank" rel="nofollow">
                <img src="https://static.cdnland.com/new/images/footer/begambleawareorg.svg" class="blink" alt="GambleAware">
              </a>
            </div>
            <div class="col">
              <a href="http://www.gamcare.org.uk" target="_blank" rel="nofollow">
                <img src="https://static.cdnland.com/new/images/footer/gamcare.svg" class="blink" alt="Gamcare">
              </a>
            </div>
            <div class="col">
              <a class="licensing-gaming-curacao" style="cursor: pointer;">
                <img src="https://static.cdnland.com/new/images/footer/curacao.svg" class="blink" alt="Gaming Curacao">
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 p-3 border-top border-dark">
        <div class="container">
          <p class="mb-0 text-white">© Copyright {{ date('Y') }} by lottomate.co.uk</p>
        </div>
      </div>
    </footer>
    <script src="{{ asset('/assets/js/jQuery-3.6.0.js') }}"></script>
    <script src="{{ asset('/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/assets/js/all.min.js') }}"></script>
    <script src="{{ asset('/assets/js/swiper-bundle.min.js') }}"></script>
    <script>
      "use strict";

      let dataSet1 = [];
      let dataSet2 = [];
      let dataSet3 = [];
      let dataSet4 = [];
      let dataSet5 = [];
      let dataSets = [];

      $('.lines').on('click', function(){
        $('.lines').removeClass('activeLine');
        $(this).addClass('activeLine');

        let lines = $(this).attr('data-value');
        let playBoxes = $('#play_slider .playBox').length;
        let boxes = lines - playBoxes;
        let playBox = '';

        if(playBoxes > lines){
          for(let i = boxes; i < 0; i++){
            $('#play_slider').children().last().remove();
          }
        }else{
          let k = playBoxes + 1;
          for(let i = 0; i < boxes; i++){
            playBox += `
              <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xxl-2 playBox">
                <div class="col-12 outerBox">
                  <div class="row">
                    <div class="owl-item active" style="width: auto; margin-right: 8px;">
                      <div class="number_box" data-num="1">
                        <div class="choose_number">
                          <div class="content_open">
                            <a href="#" class="clearBtn reset" title="Clear"><i class="fas fa-trash-alt"></i></a>
                            <a href="#" class="easyPick">Easy Pick</a>
                          </div>
                          <div class="choose_area">
                            <div class="box_list_number">
                              <div class="number ">${ k }</div>
                              <p class="choose_text mb-0">Pick 6 numbers</p>
                              <ul class="list_number">
                                <li class="num1 "><a href="javascript:void(0)">1</a></li>
                                <li class="num2 "><a href="javascript:void(0)">2</a></li>
                                <li class="num3 "><a href="javascript:void(0)">3</a></li>
                                <li class="num4 "><a href="javascript:void(0)">4</a></li>
                                <li class="num5 "><a href="javascript:void(0)">5</a></li>
                                <li class="num6 "><a href="javascript:void(0)">6</a></li>
                                <li class="num7 "><a href="javascript:void(0)">7</a></li>
                                <li class="num8 "><a href="javascript:void(0)">8</a></li>
                                <li class="num9 "><a href="javascript:void(0)">9</a></li>
                                <li class="num10 "><a href="javascript:void(0)">10</a></li>
                                <li class="num11 "><a href="javascript:void(0)">11</a></li>
                                <li class="num12 "><a href="javascript:void(0)">12</a></li>
                                <li class="num13 "><a href="javascript:void(0)">13</a></li>
                                <li class="num14 "><a href="javascript:void(0)">14</a></li>
                                <li class="num15 "><a href="javascript:void(0)">15</a></li>
                                <li class="num16 "><a href="javascript:void(0)">16</a></li>
                                <li class="num17 "><a href="javascript:void(0)">17</a></li>
                                <li class="num18 "><a href="javascript:void(0)">18</a></li>
                                <li class="num19 "><a href="javascript:void(0)">19</a></li>
                                <li class="num20 "><a href="javascript:void(0)">20</a></li>
                                <li class="num21 "><a href="javascript:void(0)">21</a></li>
                                <li class="num22 "><a href="javascript:void(0)">22</a></li>
                                <li class="num23 "><a href="javascript:void(0)">23</a></li>
                                <li class="num24 "><a href="javascript:void(0)">24</a></li>
                                <li class="num25 "><a href="javascript:void(0)">25</a></li>
                                <li class="num26 "><a href="javascript:void(0)">26</a></li>
                                <li class="num27 "><a href="javascript:void(0)">27</a></li>
                                <li class="num28 "><a href="javascript:void(0)">28</a></li>
                                <li class="num29 "><a href="javascript:void(0)">29</a></li>
                                <li class="num30 "><a href="javascript:void(0)">30</a></li>
                                <li class="num31 "><a href="javascript:void(0)">31</a></li>
                                <li class="num32 "><a href="javascript:void(0)">32</a></li>
                                <li class="num33 "><a href="javascript:void(0)">33</a></li>
                                <li class="num34 "><a href="javascript:void(0)">34</a></li>
                                <li class="num35 "><a href="javascript:void(0)">35</a></li>
                                <li class="num36 "><a href="javascript:void(0)">36</a></li>
                                <li class="num37 "><a href="javascript:void(0)">37</a></li>
                                <li class="num38 "><a href="javascript:void(0)">38</a></li>
                                <li class="num39 "><a href="javascript:void(0)">39</a></li>
                                <li class="num40 "><a href="javascript:void(0)">40</a></li>
                                <li class="num41 "><a href="javascript:void(0)">41</a></li>
                              </ul>
                            </div>                      
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            `;
            k++;
          }
          $('#play_slider').append(playBox);
        }
      });
      
      $(document).on('click', '.list_number li a', function(){
        let val = $(this).text();
        let active = $(this).filter('.active').length;
        let activeLen = $(this).parent().parent().find('.active').length;
        let number = $(this).parent().parent().parent().find('.number').text();
        let lines = $('.lines.activeLine').attr('data-value');

        if(activeLen < 6){
          $(this).addClass("active");

          if(number === '1'){
            dataSet1.push(val);
          }else if(number === '2'){
            dataSet2.push(val);
          }else if(number === '3'){
            dataSet3.push(val);
          }else if(number === '4'){
            dataSet4.push(val);
          }else if(number === '5'){
            dataSet5.push(val);
          }

          if(lines === '1'){
            dataSets = [dataSet1];
          }else if(lines === '3'){
            dataSets = [dataSet1, dataSet2, dataSet3];
          }else if(lines === '5'){
            dataSets = [dataSet1, dataSet2, dataSet3, dataSet4, dataSet5];
          }
          console.log(lines)
        }
        
        if(active === 1){
          $(this).removeClass("active");
          
          if(number === '1'){
            dataSet1 = $.grep(dataSet1, function(value){
              return value != val;
            });
          }else if(number === '2'){
            dataSet2 = $.grep(dataSet2, function(value){
              return value != val;
            });
          }else if(number === '3'){
            dataSet3 = $.grep(dataSet3, function(value){
              return value != val;
            });
          }else if(number === '4'){
            dataSet4 = $.grep(dataSet4, function(value){
              return value != val;
            });
          }else if(number === '5'){
            dataSet5 = $.grep(dataSet5, function(value){
              return value != val;
            });
          }

          if(lines === '1'){
            dataSets = [dataSet1];
          }else if(lines === '3'){
            dataSets = [dataSet1, dataSet2, dataSet3];
          }else if(lines === '5'){
            dataSets = [dataSet1, dataSet2, dataSet3, dataSet4, dataSet5];
          }
        }
      });

      $('#play').on('click', function(e){
        @if(!session()->has('userLogIn') && !session()->has('adminLogIn'))
          alert('To Play, Login Or Register');
          return false;
        @endif

        let check = true;

        if(dataSets.length === 0){
          alert('Please Pick 6 Numbers in Each Line');
          return false;
        }else{
          $.each(dataSets, function(i, val){
            console.log(val.length);
            if(val.length < 6){
              alert('Please Pick 6 Numbers in Each Line');
              check = false;
              return false;
            }
          });

          if(check === false){
            return false;
          }else{
            $('#playData').val(JSON.stringify(dataSets));
          }
        }
      });
    </script>
    
    <script>
      "use strict";

      let newDataSet1 = [];
      let newDataSet2 = [];
      let newDataSet3 = [];
      let newDataSet4 = [];
      let newDataSet5 = [];
      let newDataSet6 = [];
      let newDataSets = [];

      $('.newLines').on('click', function(){
        $('.newLines').removeClass('activeLine');
        $(this).addClass('activeLine');

        let lines = $(this).attr('data-value');
        let playBoxes = $('#new_play_slider .newPlayBox').length;
        let boxes = lines - playBoxes;
        let playBox = '';

        if(playBoxes > lines){
          for(let i = boxes; i < 0; i++){
            $('#new_play_slider').children().last().remove();
          }
        }else{
          let k = playBoxes + 1;
          for(let i = 0; i < boxes; i++){
            playBox += `
              <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xxl-2 newPlayBox">
                <div class="col-12 outerBox">
                  <div class="row">
                    <div class="owl-item active" style="width: auto; margin-right: 8px;">
                      <div class="number_box" data-num="1">
                        <div class="choose_number">
                          <div class="content_open">
                            <a href="#" class="clearBtn reset" title="Clear"><i class="fas fa-trash-alt"></i></a>
                            <a href="#" class="easyPick">Easy Pick</a>
                          </div>
                          <div class="choose_area">
                            <div class="box_list_number">
                              <div class="number ">${ k }</div>
                              <p class="choose_text mb-0">Pick 7 numbers</p>
                              <ul class="new_list_number">
                                <li class="num1 "><a href="javascript:void(0)">1</a></li>
                                <li class="num2 "><a href="javascript:void(0)">2</a></li>
                                <li class="num3 "><a href="javascript:void(0)">3</a></li>
                                <li class="num4 "><a href="javascript:void(0)">4</a></li>
                                <li class="num5 "><a href="javascript:void(0)">5</a></li>
                                <li class="num6 "><a href="javascript:void(0)">6</a></li>
                                <li class="num7 "><a href="javascript:void(0)">7</a></li>
                                <li class="num8 "><a href="javascript:void(0)">8</a></li>
                                <li class="num9 "><a href="javascript:void(0)">9</a></li>
                                <li class="num10 "><a href="javascript:void(0)">10</a></li>
                                <li class="num11 "><a href="javascript:void(0)">11</a></li>
                                <li class="num12 "><a href="javascript:void(0)">12</a></li>
                                <li class="num13 "><a href="javascript:void(0)">13</a></li>
                                <li class="num14 "><a href="javascript:void(0)">14</a></li>
                                <li class="num15 "><a href="javascript:void(0)">15</a></li>
                                <li class="num16 "><a href="javascript:void(0)">16</a></li>
                                <li class="num17 "><a href="javascript:void(0)">17</a></li>
                                <li class="num18 "><a href="javascript:void(0)">18</a></li>
                                <li class="num19 "><a href="javascript:void(0)">19</a></li>
                                <li class="num20 "><a href="javascript:void(0)">20</a></li>
                                <li class="num21 "><a href="javascript:void(0)">21</a></li>
                                <li class="num22 "><a href="javascript:void(0)">22</a></li>
                                <li class="num23 "><a href="javascript:void(0)">23</a></li>
                                <li class="num24 "><a href="javascript:void(0)">24</a></li>
                                <li class="num25 "><a href="javascript:void(0)">25</a></li>
                                <li class="num26 "><a href="javascript:void(0)">26</a></li>
                                <li class="num27 "><a href="javascript:void(0)">27</a></li>
                                <li class="num28 "><a href="javascript:void(0)">28</a></li>
                                <li class="num29 "><a href="javascript:void(0)">29</a></li>
                                <li class="num30 "><a href="javascript:void(0)">30</a></li>
                                <li class="num31 "><a href="javascript:void(0)">31</a></li>
                                <li class="num32 "><a href="javascript:void(0)">32</a></li>
                                <li class="num33 "><a href="javascript:void(0)">33</a></li>
                                <li class="num34 "><a href="javascript:void(0)">34</a></li>
                                <li class="num35 "><a href="javascript:void(0)">35</a></li>
                                <li class="num36 "><a href="javascript:void(0)">36</a></li>
                                <li class="num37 "><a href="javascript:void(0)">37</a></li>
                                <li class="num38 "><a href="javascript:void(0)">38</a></li>
                                <li class="num39 "><a href="javascript:void(0)">39</a></li>
                                <li class="num40 "><a href="javascript:void(0)">40</a></li>
                                <li class="num41 "><a href="javascript:void(0)">41</a></li>
                                <li class="num42 "><a href="javascript:void(0)">42</a></li>
                                <li class="num43 "><a href="javascript:void(0)">43</a></li>
                                <li class="num44 "><a href="javascript:void(0)">44</a></li>
                                <li class="num45 "><a href="javascript:void(0)">45</a></li>
                                <li class="num46 "><a href="javascript:void(0)">46</a></li>
                                <li class="num47 "><a href="javascript:void(0)">47</a></li>
                                <li class="num48 "><a href="javascript:void(0)">48</a></li>
                                <li class="num49 "><a href="javascript:void(0)">49</a></li>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            `;
            k++;
          }
          $('#new_play_slider').append(playBox);
        }
      });

      $(document).on('click', '.new_list_number li a', function(){
        let val = $(this).text();
        let active = $(this).filter('.active').length;
        let activeLen = $(this).parent().parent().find('.active').length;
        let number = $(this).parent().parent().parent().find('.number').text();
        let lines = $('.lines.activeLine').attr('data-value');

        if(activeLen < 7){
          $(this).addClass("active");

          if(number === '1'){
            newDataSet1.push(val);
          }else if(number === '2'){
              newDataSet2.push(val);
          }else if(number === '3'){
              newDataSet3.push(val);
          }else if(number === '4'){
              newDataSet4.push(val);
          }else if(number === '5'){
              newDataSet5.push(val);
          }else if(number === '6'){
              newDataSet6.push(val);
          }

          if(lines === '1'){
              newDataSets = [newDataSet1];
          }else if(lines === '3'){
              newDataSets = [newDataSet1, newDataSet2, newDataSet3];
          }else if(lines === '5'){
              newDataSets = [newDataSet1, newDataSet2, newDataSet3, newDataSet4, newDataSet5];
          }else if(lines === '6'){
              newDataSets = [newDataSet1, newDataSet2, newDataSet3, newDataSet4, newDataSet5, newDataSet6];
          }
          console.log(lines)
        }

        if(active === 1){
          $(this).removeClass("active");

          if(number === '1'){
              newDataSet1 = $.grep(newDataSet1, function(value){
              return value != val;
            });
          }else if(number === '2'){
              newDataSet2 = $.grep(newDataSet2, function(value){
              return value != val;
            });
          }else if(number === '3'){
              newDataSet3 = $.grep(newDataSet3, function(value){
              return value != val;
            });
          }else if(number === '4'){
              newDataSet4 = $.grep(newDataSet4, function(value){
              return value != val;
            });
          }else if(number === '5'){
              newDataSet5 = $.grep(newDataSet5, function(value){
              return value != val;
            });
          }else if(number === '6'){
              newDataSet5 = $.grep(newDataSet6, function(value){
              return value != val;
            });
          }

          if(lines === '1'){
              newDataSets = [newDataSet1];
          }else if(lines === '3'){
              newDataSets = [newDataSet1, newDataSet2, newDataSet3];
          }else if(lines === '5'){
              newDataSets = [newDataSet1, newDataSet2, newDataSet3, newDataSet4, newDataSet5];
          }else if(lines === '6'){
              newDataSets = [newDataSet1, newDataSet2, newDataSet3, newDataSet4, newDataSet5, newDataSet6];
          }
        }
      });

      $('#newPlay').on('click', function(e){
        @if(!session()->has('userLogIn') && !session()->has('adminLogIn'))
          alert('To Play, Login Or Register');
          return false;
        @endif

        let check = true;

        if(newDataSets.length === 0){
          alert('Please Pick 7 Numbers in Each Line');
          return false;
        }else{
          $.each(newDataSets, function(i, val){
            console.log(val.length);
            if(val.length < 7){
              alert('Please Pick 7 Numbers in Each Line');
              check = false;
              return false;
            }
          });

          if(check === false){
            return false;
          }else{
            $('#newPlayData').val(JSON.stringify(newDataSets));
          }
        }
      });
    </script>
  </body>
</html>
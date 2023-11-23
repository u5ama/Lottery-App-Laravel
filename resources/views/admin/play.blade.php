@php
  $activeuser = $adminInfo['name'];
  $k = -1;
  $check = false;
@endphp

<x-header :activeuser="$activeuser" />

<x-sidebar activepage="play" :activeuser="$activeuser" />

<div id="content">
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
      <button type="button" id="sidebarCollapse" class="btn btn-dark">
        <i class="fa-solid fa-bars"></i>
      </button>
    </div>
  </nav>
  <br><br>
  <div class="row">
    <div class="col-7">
      @if(Session::get('success'))
        <div class="alert alert-success">
          {{ Session::get('success') }}
        </div>
      @elseif(Session::get('fail'))
        <div class="alert alert-danger">
          {{ Session::get('fail') }}
        </div>
      @endif
      <form action="{{ route('admin.play') }}" method="post">
        <div class="row">
          @csrf
          <h5>Enter 6 numbers from 1-41:</h5>
          <input name="playData[]" type="number" class="col m-3" min="1" max="41" required>
          <input name="playData[]" type="number" class="col m-3" min="1" max="41" required>
          <input name="playData[]" type="number" class="col m-3" min="1" max="41" required>
          <input name="playData[]" type="number" class="col m-3" min="1" max="41" required>
          <input name="playData[]" type="number" class="col m-3" min="1" max="41" required>
          <input name="playData[]" type="number" class="col m-3" min="1" max="41" required>
        </div>
        @if(isset($winCombo))
          <input type="submit" name="play" class="bg-dark text-light rounded-2 px-2 py-1 mt-3" value="Play Again">
        @else
          <input type="submit" name="play" class="bg-dark text-light rounded-2 px-2 py-1 mt-3" value="Play">
        @endif
      </form>
    </div>
    <div class="col-5"></div>
  </div>
  @if(isset($winCombo))
    <div class="row mt-5 pt-5">
      <div class="col-7">
        <div class="row">
          <h5>Winning Combination:</h5>
          @foreach($winCombo as $value)
            <input type="number" class="col m-3" value="{{ $value }}" disabled>
          @endforeach
        </div>
          <div class="row">
            <h5>Matches:</h5>
            @if(isset($matches) && !empty($matches))
              @foreach($playData as $key => $value)
                @if(array_key_exists($key, $matches))
                  @if($key == ++$k)
                    <input type="number" class="col m-3 text-dark" style="background:#00800033" value="{{ $value }}" disabled>
                    @php $check = true; @endphp
                  @elseif($check)
                    <input type="number" class="col m-3" value="{{ $value }}" disabled>
                  @endif
                @elseif($check)
                  <input type="number" class="col m-3" value="{{ $value }}" disabled>
                @endif
              @endforeach
              @if($check === false)
                <div class="h6 p-2 ms-3 alert-danger">None</div>
              @endif
            @else
              <div class="h6 p-2 ms-3 alert-danger">None</div>
            @endif
        </div>
      </div>
      <div class="col-5"></div>
    </div>
  @endif
</div>

{{-- <script>
  "use strict";
  @if(isset($winCombo))
    if(window.history.replaceState){
      window.history.replaceState(null, null, window.location.href);
    }
  @endif
</script> --}}

<x-footer/>
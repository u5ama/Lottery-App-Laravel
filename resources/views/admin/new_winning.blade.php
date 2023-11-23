@php
  $activeuser = $adminInfo['name'];
@endphp

<x-header :activeuser="$activeuser" />

<x-sidebar activepage="new_winning" :activeuser="$activeuser" />

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
      <form action="{{ route('admin.new_winning') }}" method="post">
        @csrf
        <div class="row">
          <h5>Enter Numbers to make Winning Combination:</h5>
          <input name="adminWinning[]" type="number" class="col m-3" min="1" max="49" required>
          <input name="adminWinning[]" type="number" class="col m-3" min="1" max="49" required>
          <input name="adminWinning[]" type="number" class="col m-3" min="1" max="49" required>
          <input name="adminWinning[]" type="number" class="col m-3" min="1" max="49" required>
          <input name="adminWinning[]" type="number" class="col m-3" min="1" max="49" required>
          <input name="adminWinning[]" type="number" class="col m-3" min="1" max="49" required>
          <input name="adminWinning[]" type="number" class="col m-3" min="1" max="49" required>
        </div>
        <input type="submit" name="reserve" class="bg-dark text-light rounded-2 px-2 py-1 mt-3" value="Add / Update">
      </form>
    </div>
    <div class="col-5"></div>
  </div>
  <div class="row mt-2 pt-5">
        <div class="col-5">
            <form action="{{ route('admin.newStatus') }}" method="post">
                @csrf
                <div class="row">
                    <select name="combo" id="combo">
                        <option value="" disabled>Choose Combination</option>
                        <option {{ $status === 'admin' ? 'selected' : '' }} value="admin">Admin Combination</option>
                        <option {{  $status === 'auto' ? 'selected' : ''  }} value="auto">Auto Combination</option>
                    </select>
                    <input type="submit" name="reserve" class="bg-dark text-light rounded-2 px-2 py-1 mt-3" value="Update">
                </div>
            </form>
        </div>
    </div>
  @if(isset($currentReserved))
    <div class="row mt-5 pt-5">
      <div class="col-7">
        <div class="row">
          <h5>Current Combination:</h5>
          @foreach($currentReserved as $reserved)
            <input type="number" class="col m-3" value="{{ $reserved }}" disabled>
          @endforeach
        </div>
      </div>
      <div class="col-5"></div>
    </div>
  @endif
</div>

<x-footer/>

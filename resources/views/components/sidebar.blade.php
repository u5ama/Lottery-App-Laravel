@php
  if($activeuser === 'admin'){
    $user = 'Admin';
  }else{
    $user = 'User';
  }
@endphp
<div class="wrapper">
  <nav id="sidebar">
    <div class="sidebar-header">
      <h3>{{ $user }} Dashboard</h3>
    </div>
    @if($activeuser === 'admin')
      <ul class="list-unstyled components">
        <li class="@if (isset($activepage) && $activepage === 'reserve') active @endif">
          <a href="{{ route('admin.reserve') }}">Reserve</a>
        </li>
        <li class="@if (isset($activepage) && $activepage === 'winning') active @endif">
              <a href="{{ route('admin.winning') }}">6-Winning Combination</a>
          </li>
        <li class="@if (isset($activepage) && $activepage === 'combinations') active @endif">
          <a href="{{ route('admin.combinations') }}">Combinations</a>
        </li>
        <li class="@if (isset($activepage) && $activepage === 'new_combinations') active @endif">
          <a href="{{ route('admin.new_combinations') }}">New Combinations</a>
        </li>
         <li class="@if (isset($activepage) && $activepage === 'new_winning') active @endif">
              <a href="{{ route('admin.new_winning') }}">7-Winning Combination</a>
          </li>
        <li class="@if (isset($activepage) && $activepage === 'users') active @endif">
          <a href="{{ route('admin.users') }}">Users</a>
        </li>
        <li>
          <a href="{{ route('admin.logout') }}">Logout</a>
        </li>
      </ul>
    @else
      <ul class="list-unstyled components">
        <li class="@if (isset($activepage) && $activepage === 'play') active @endif">
          <a href="{{ route('user.play') }}">Play</a>
        </li>
        <li class="@if (isset($activepage) && $activepage === 'played') active @endif">
          <a href="{{ route('user.played') }}">Play Data</a>
        </li>
        <li>
          <a href="{{ route('user.logout') }}">Logout</a>
        </li>
      </ul>
    @endif
  </nav>
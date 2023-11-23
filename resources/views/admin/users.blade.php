@php
  $activeuser = $adminInfo['name'];
@endphp

<x-header :activeuser="$activeuser" />

<x-sidebar activepage="users" :activeuser="$activeuser" />

<style>
  @if(isset($users) && count($users) > 14)
    #sidebar{
      height: unset
    }
  @endif

  .pagination > li > a,
  .pagination > li > span{
    color: #262933 !important
  }

  .pagination > .active > a,
  .pagination > .active > a:focus,
  .pagination > .active > a:hover,
  .pagination > .active > span,
  .pagination > .active > span:focus,
  .pagination > .active > span:hover{
    background-color: #000 !important;
    border-color: #000 !important;
    color: #fff !important
  }
</style>

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
    <div class="col-7 admin ps-4">
      <table class="table table-bordered">
        <thead>
          <tr class="table-dark">
            <th scope="col">#</th>
            <th scope="col">Email</th>
            <th scope="col">Password</th>
            <th scope="col">Date/Time</th>
          </tr>
        </thead>
        <tbody>
          @if(isset($users))
            @foreach($users as $data)
            <tr>
              <th scope="row">{{ $data->id }}</th>
              <td>{{ $data->email }}</td>
              <td>{{ $data->pass }}</td>
              <td>{{ $data->created_at->format('Y-m-d g:i:s A') }}</td>
            </tr>
            @endforeach
          @else
            <h5>No Data</h5>
          @endif
        </tbody>
      </table>
      {{-- Pagination --}}
      @if(isset($users))
        <div class="d-flex justify-content-center">
          {!! $users->links() !!}
        </div>
      @endif
    </div>
    <div class="col-5"></div>
  </div>
</div>

<x-footer/>
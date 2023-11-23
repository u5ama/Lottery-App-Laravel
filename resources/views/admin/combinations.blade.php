@php
  $activeuser = $adminInfo['name'];
@endphp

<x-header :activeuser="$activeuser" />

<x-sidebar activepage="combinations" :activeuser="$activeuser" />

<style>
  @if((isset($combinations) && count($combinations) > 14) || (isset($filterReserved) && count($filterReserved) > 14) || (isset($filterConsecutive) && count($filterConsecutive) > 14))
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
        <div class="row mb-2">
          <div class="col-3 text-center">
            <a href="{{ url('/combinations') }}" class="d-flex justify-content-center h-100 {{ isset($combinations)? 'bg-dark':'bg-danger' }} text-light p-2 text-decoration-none">Remove Filter</a>
          </div>
          <div class="col-1"></div>
          <form action="{{ route('admin.filterReserved') }}" method="post" class="col-4">
            @csrf
            <button type="submit" class="col-12 {{ isset($filterReserved)? 'bg-success':'bg-dark' }} text-light p-2" name="filterReserved" style="border-right:1px solid #fff">Remove Admin Reserved</button>
          </form>
          <form action="{{ route('admin.filterConsecutive') }}" method="post" class="col-4">
            @csrf
            <button type="submit" class="col-12 {{ isset($filterConsecutive2)? 'bg-success':'bg-dark' }} text-light p-2" name="filterConsecutive" value="2" style="border-left:1px solid #fff">Remove 2 Consecutives</button>
          </form>
          <div class="col-4"></div>
          <form action="{{ route('admin.filterConsecutive') }}" method="post" class="col-4 mt-2">
            @csrf
            <button type="submit" class="col-12 {{ isset($filterConsecutive3)? 'bg-success':'bg-dark' }} text-light p-2" name="filterConsecutive" value="3" style="border-left:1px solid #fff">Remove 3 Consecutives</button>
          </form>
          <form action="{{ route('admin.filterConsecutive') }}" method="post" class="col-4 mt-2">
            @csrf
            <button type="submit" class="col-12 {{ isset($filterConsecutive4)? 'bg-success':'bg-dark' }} text-light p-2" name="filterConsecutive" value="4" style="border-left:1px solid #fff">Remove 4 Consecutives</button>
          </form>
          <div class="col-4"></div>
          <form action="{{ route('admin.filterConsecutive') }}" method="post" class="col-4 mt-2">
            @csrf
            <button type="submit" class="col-12 {{ isset($filterConsecutive5)? 'bg-success':'bg-dark' }} text-light p-2" name="filterConsecutive" value="5" style="border-left:1px solid #fff">Remove 5 Consecutives</button>
          </form>
          <form action="{{ route('admin.filterConsecutive') }}" method="post" class="col-4 mt-2">
            @csrf
            <button type="submit" class="col-12 {{ isset($filterConsecutive0)? 'bg-success':'bg-dark' }} text-light p-2" name="filterConsecutive" value="0" style="border-left:1px solid #fff">Remove No Consecutives</button>
          </form>
        </div>
      <table class="table table-bordered">
        <thead>
          <tr class="table-dark">
            <th scope="col">#</th>
            <th scope="col">Combinations</th>
          </tr>
        </thead>
        <tbody>
          @if(isset($combinations))
            @foreach($combinations as $data)
            <tr>
              <th scope="row">{{ $data->id }}</th>
              <td>{{ $data->combinations }}</td>
            </tr>
            @endforeach
          @elseif(isset($filterReserved))
            @foreach($filterReserved as $key => $data)
            <tr>
              <th scope="row">{{ $key+1 }}</th>
              <td>{{ json_encode($data) }}</td>
            </tr>
            @endforeach
          @elseif(isset($filterConsecutive2))
            @foreach($filterConsecutive2 as $key => $data)
            <tr>
              <th scope="row">{{ $key+1 }}</th>
              <td>{{ json_encode($data) }}</td>
            </tr>
            @endforeach
          @elseif(isset($filterConsecutive3))
            @foreach($filterConsecutive3 as $key => $data)
            <tr>
              <th scope="row">{{ $key+1 }}</th>
              <td>{{ json_encode($data) }}</td>
            </tr>
            @endforeach
          @elseif(isset($filterConsecutive4))
            @foreach($filterConsecutive4 as $key => $data)
            <tr>
              <th scope="row">{{ $key+1 }}</th>
              <td>{{ json_encode($data) }}</td>
            </tr>
            @endforeach
          @elseif(isset($filterConsecutive5))
            @foreach($filterConsecutive5 as $key => $data)
            <tr>
              <th scope="row">{{ $key+1 }}</th>
              <td>{{ json_encode($data) }}</td>
            </tr>
            @endforeach
          @elseif(isset($filterConsecutive0))
            @foreach($filterConsecutive0 as $key => $data)
            <tr>
              <th scope="row">{{ $key+1 }}</th>
              <td>{{ json_encode($data) }}</td>
            </tr>
            @endforeach
          @else
            <h5>No Data</h5>
          @endif
        </tbody>
      </table>
      {{-- Pagination --}}
      @if(isset($combinations))
        <div>
          {!! $combinations->links() !!}
        </div>
      @elseif(isset($filterReserved))
        <div>
          {!! $filterReserved->links() !!}
        </div>
        
      @elseif(isset($filterConsecutive2))
        <div>
          {!! $filterConsecutive2->links() !!}
        </div>
      @elseif(isset($filterConsecutive3))
        <div>
          {!! $filterConsecutive3->links() !!}
        </div>
      @elseif(isset($filterConsecutive4))
        <div>
          {!! $filterConsecutive4->links() !!}
        </div>
      @elseif(isset($filterConsecutive5))
        <div>
          {!! $filterConsecutive5->links() !!}
        </div>
      @elseif(isset($filterConsecutive0))
        <div>
          {!! $filterConsecutive0->links() !!}
        </div>
      @endif
    </div>
    <div class="col-5"></div>
  </div>
</div>

{{-- @push('custom')
  <script>
    "use strict";

    var base_url = window.location.origin;

    $('.filterReserved').on('click', function(){
      $.ajax({
        type: 'post',
        url: base_url+'/combinations',
        data: {
          filterReserved: 'filterReserved',
          _token: $('#tOken').val()
        },
        success: function(data){
        },
        error: function(data){
          console.log(data);
        }
      });
    });
    
    $('.filterConsecutive').on('click', function(){
      $.ajax({
        type: 'post',
        url: base_url+'/combinations',
        data: {
          filterConsecutive: 'filterConsecutive',
          _token: $('#tOken').val()
        },
        success: function(data){
        },
        error: function(data){
          console.log(data);
        }
      });
    });
  </script>
@endpush --}}

<x-footer/>
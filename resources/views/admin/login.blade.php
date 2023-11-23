<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Lottery App</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <style>
      body{
        position: relative;
        background: #f1f1f1;
      }
      .adminLogin{
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        width: 320px;
        height: 400px;
        overflow: hidden;
        background: #fff;
        position: absolute;
        padding: 26px 24px 46px;
        margin: 50px auto 0 auto;
        border: 1px solid #ccd0d4;
        box-shadow: 0 1px 3px rgba(0,0,0,.04);
      }
    </style>
  </head>
  <body>
    <div class="adminLogin">
      <h4>Admin Login</h4>
      <hr>
      <form action="{{ route('admin.check') }}" method="post">
        @if(Session::get('fail'))
        <div class="alert alert-danger">
          {{ Session::get('fail') }}
        </div>
        @endif
        @csrf
        <div class="mb-3">
          <label for="name" class="form-label">Username</label>
          <input type="text" class="form-control" name="name" placeholder="Username" value="{{ old('name') }}" id="name">
          <span class="text-danger">@error('name'){{ $message }} @enderror</span>
        </div>
        <div class="mb-3">
          <label for="pass" class="form-label">Password</label>
          <input type="password" class="form-control" name="pass" placeholder="Password" id="pass" autocomplete="off">
          <span class="text-danger">@error('pass'){{ $message }} @enderror</span>
        </div>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
          <button type="submit" class="btn btn-dark mt-4">Login</button>
        </div>
      </form>
    </div>
  </body>
</html>
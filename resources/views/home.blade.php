<x-header/>

<x-sidebar />

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
    <div class="col-7 admin">
      <div class="row">
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
</div>

<x-footer/>
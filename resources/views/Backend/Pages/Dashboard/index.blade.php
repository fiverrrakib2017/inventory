@extends('Backend.Layout.App')
@section('title','Dashboard | Admin Panel')

@section('content')
<div class="row">
  <div class="col-md-2 offset-md-10 mt-3 mb-2">
    <div>
      <select name="dateFilter" class="form-select" >
        <option label="Choose one"></option>
        <option value="today" selected>Today</option>
        <option value="last7days">Last 7 Days</option>
        <option value="this_month">This Month</option>
        <option value="last_month">Last Month</option>
        <option value="this_year">This Year</option>
        <option value="last_year">Last Year</option>
        <option value="last_two_years">Last 2 Years</option>
      </select>
    </div>
  </div>
</div>


  <div class="row">
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h3>150</h3>

            <p>Total Sales</p>
          </div>
          <div class="icon">
            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h3>53<sup style="font-size: 20px">%</sup></h3>

            <p>Total Purchase</p>
          </div>
          <div class="icon">
            <i class="fas fa-cart-plus fa-2x text-gray-300"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>44010</h3>

            <p>Total Customer Invoices</p>
          </div>
          <div class="icon">
            <i class="fas fa-file-invoice-dollar fa-2x text-gray-300"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h3>65000</h3>

            <p>Net Profit</p>
          </div>
          <div class="icon">
            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
  </div>  
  <div class="row">
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h3>150</h3>

            <p>Total Customers</p>
          </div>
          <div class="icon">
            <i class="fas fa-users fa-2x text-gray-300"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h3>53<sup style="font-size: 20px">%</sup></h3>

            <p>Total Suppliers</p>
          </div>
          <div class="icon">
            <i class="fas fa-truck fa-2x text-gray-300"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>44</h3>

            <p>Total Products</p>
          </div>
          <div class="icon">
            <i class="fas fa-boxes fa-2x text-gray-300"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
          <div class="inner">
            <h3>65</h3>

            <p>Total Stock</p>
          </div>
          <div class="icon">
            <i class="fas fa-box-open fa-2x text-gray-300"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
  </div>  
       
        
       
@endsection

@section('script')
  <script type="text/javascript"> 
    
  </script>
@endsection
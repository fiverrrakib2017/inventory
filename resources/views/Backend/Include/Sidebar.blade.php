<aside class="main-sidebar sidebar-dark-primary elevation-4">


    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('Backend/dist/img/avatar.png')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="{{route('admin.dashboard')}}" class="d-block">{{Auth::guard('admin')->user()->name}}</a>
        </div>
      </div>


      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item ">
            <a href="{{route('admin.dashboard')}}" class="nav-link ">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p> Dashboard  </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link ">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Customers
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('admin.customer.create')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create Customer</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.customer.index')}}" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Customer List</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-truck"></i>
              <p>
                Suppliers
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.supplier.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create Supplier</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.supplier.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Supplier List</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-box"></i>
              <p>
                Products
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('admin.brand.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Brand</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.category.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Category</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.product.stock.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Stock</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.product.color.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Color</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.product.size.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Size</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.unit.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Units</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.products.create')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create Products</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.products.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Products List</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-shopping-cart"></i>
              <p>
                Sale's
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.customer.invoice.create_invoice') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create Sale's</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.customer.invoice.show_invoice')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sale's Invoice</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-shopping-bag"></i>
              <p>
                Purchase
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('admin.supplier.invoice.create_invoice')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create Purchase</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.supplier.invoice.show_invoice')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Purchase Invoice</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.supplier.invoice.create_invoice_report')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Purchase Report</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-file-invoice-dollar"></i>
              <p>
              Accounts Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('admin.master_ledger.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Master Ledger</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.ledger.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Ledger</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.sub_ledger.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sub Ledger</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.transaction.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Transaction</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.transaction.report.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Transaction Report</p>
                </a>
              </li>
            </ul>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

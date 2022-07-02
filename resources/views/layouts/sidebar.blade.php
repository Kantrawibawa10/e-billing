@section('sidebar')   
<div id="sidebar" class="active">
  <div class="sidebar-wrapper active">
      <div class="sidebar-header">
          <div class="d-flex justify-content-between">
              <div class="logo d-flex py-4" style="line-height: 1px;">
                <i class="bi bi-layout-wtf" style="font-size: 30px;"></i>
                <p class="mx-4 pt-3 mb-0 pb-0" style="font-size: 30px; line-height: 1px;">e-Billing</p>
              </div>
              <div class="toggler">
                  <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
              </div>
          </div>
      </div>
      <div class="sidebar-menu">
        <ul class="menu">

          <li class="sidebar-item active">
            <a href="{{ route('dashboard') }}" class='sidebar-link'>
              <i class="bi bi-grid-fill"></i>
              <span>Dashboard</span>
            </a>
          </li>

        
          <li class="sidebar-title">Menu</li>
              

          
          <li class="sidebar-item  has-sub">
            <a href="#" class='sidebar-link'>
              <i class="bi bi-folder-fill"></i>
              <span>Master Data</span>
            </a>
            
            <ul class="submenu">

              <li class="submenu-item ">

                <a href="{{ route('pelanggan') }}">
                  <i class="bi bi-people-fill"></i> 
                  Pelanggan
                </a>

              </li>

              <li class="submenu-item ">
                <a href="{{ route('paket') }}">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-router-fill" viewBox="0 0 16 16">
                    <path d="M5.525 3.025a3.5 3.5 0 0 1 4.95 0 .5.5 0 1 0 .707-.707 4.5 4.5 0 0 0-6.364 0 .5.5 0 0 0 .707.707Z"/>
                    <path d="M6.94 4.44a1.5 1.5 0 0 1 2.12 0 .5.5 0 0 0 .708-.708 2.5 2.5 0 0 0-3.536 0 .5.5 0 0 0 .707.707Z"/>
                    <path d="M2.974 2.342a.5.5 0 1 0-.948.316L3.806 8H1.5A1.5 1.5 0 0 0 0 9.5v2A1.5 1.5 0 0 0 1.5 13H2a.5.5 0 0 0 .5.5h2A.5.5 0 0 0 5 13h6a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5h.5a1.5 1.5 0 0 0 1.5-1.5v-2A1.5 1.5 0 0 0 14.5 8h-2.306l1.78-5.342a.5.5 0 1 0-.948-.316L11.14 8H4.86L2.974 2.342ZM2.5 11a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1Zm4.5-.5a.5.5 0 1 1 1 0 .5.5 0 0 1-1 0Zm2.5.5a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1Zm1.5-.5a.5.5 0 1 1 1 0 .5.5 0 0 1-1 0Zm2 0a.5.5 0 1 1 1 0 .5.5 0 0 1-1 0Z"/>
                    <path d="M8.5 5.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0Z"/>
                  </svg>
                  Paket
                </a>
              </li>

            </ul>
          </li>


          <li class="sidebar-item  has-sub">
            <a href="#" class='sidebar-link'>
              <i class="bi bi-card-heading"></i>
              <span>e-Billing</span>
            </a>

            <ul class="submenu ">
              <li class="submenu-item ">
                <a href="{{ route('billing') }}">
                  <i class="bi bi-receipt-cutoff"></i>
                  e-Billing
                </a>
              </li>

              <li class="submenu-item ">
                <a href="{{ route('invoice') }}">
                  <i class="bi bi-receipt"></i> 
                  Invoice
                </a>
              </li>

            </ul>
          </li>

          <li class="sidebar-item  has-sub">
            <a href="#" class='sidebar-link'>
              <i class="bi bi-sliders"></i>
              <span>System Default</span>
            </a>

            <ul class="submenu ">
              <li class="submenu-item ">
                <a href="{{ route('system') }}"><i class="bi bi-gear-fill"></i> Setting</a>
              </li>
            </ul>

          </li>

          <li class="sidebar-title">Users</li>

          <li class="sidebar-item  has-sub">
            <a href="#" class='sidebar-link'>
              <i class="bi bi-person-lines-fill"></i>
              <span>User Management</span>
            </a>

            <ul class="submenu ">
              <li class="submenu-item ">
                <a href="{{ route('user') }}">
                  <i class="bi bi-person-circle"></i>
                  Users
                </a>    
              </li>


              {{-- <li class="submenu-item ">
                <a href="{{-- route('user') "><i class="bi bi-ui-checks"></i> Role</a>
              </li>

              <li class="submenu-item ">
                <a href="form-element-input.html"><i class="bi bi-sliders"></i> Page Setting</a>
              </li> --}}

            </ul>
          </li>

          <li class="sidebar-item mt-5">
            <form action="{{ route('logout') }}" method="post" class="d-flex justify-content-center btn btn-danger">
              @csrf
              <button class="bg-transparent text-white" style="border: hidden;" type="submit">
                  Logout
              </button>
            </form>   
          </li>

        </ul>
      </div>
      <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
  </div>
</div>
@endsection
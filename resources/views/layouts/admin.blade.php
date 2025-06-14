  <!DOCTYPE html>
  <html lang="id">

  <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>@yield('title', 'Admin Dashboard') - Gourmet Palace</title>

      <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" type="text/css">
      <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

      <link href="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.4/css/sb-admin-2.min.css" rel="stylesheet">
      
      @stack('styles')

      <style>
          :root {
              --theme-primary: #8b5a2b;
              --theme-secondary: #1a1a1a;
              --theme-accent: #c19a6b;
              --theme-light: #f8f5f2;
          }

          /* 1. Sidebar */
          .sidebar.toggled {
              width: 120px !important;
          }
          .bg-gradient-primary {
              background-color: var(--theme-secondary);
              background-image: none;
          }
          .sidebar-dark .nav-item .nav-link {
              color: rgba(255, 255, 255, 0.6);
          }
          .sidebar-dark .nav-item.active .nav-link,
          .sidebar-dark .nav-item .nav-link:hover {
              color: white;
              background-color: rgba(139, 90, 43, 0.2);
          }
          .sidebar-dark .nav-item.active .nav-link i,
          .sidebar-dark .nav-item .nav-link:hover i {
              color: white;
          }
          .sidebar-brand, .sidebar-dark .sidebar-brand:hover {
              color: white;
          }
          .sidebar-brand .sidebar-brand-icon i {
              color: var(--theme-accent) !important;
          }
          .sidebar-dark hr.sidebar-divider {
              border-top: 1px solid rgba(255, 255, 255, 0.1);
          }
          
          /* 2. Latar Belakang Konten Utama */
          #content-wrapper, .sticky-footer {
              background-color: var(--theme-light);
          }

          /* 3. Tombol dan Link Utama */
          .btn-primary {
              background-color: var(--theme-primary);
              border-color: var(--theme-primary);
          }
          .btn-primary:hover {
              background-color: #7a4f25;
              border-color: #7a4f25;
          }
          a, .page-item.active .page-link {
              color: var(--theme-primary);
          }
          .page-item.active .page-link {
              background-color: var(--theme-primary);
              border-color: var(--theme-primary);
          }
          a:hover, .page-link:hover {
              color: #7a4f25;
          }
          
          /* 4. Judul dan Teks Utama */
          .text-primary, .card-header .font-weight-bold {
              color: var(--theme-primary) !important;
          }
          .h3, .h1, h1, h2, h3, h4, h5, h6 {
              color: #333;
          }
      </style>
  </head>

  <body id="page-top">

      <div id="wrapper">

          <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

              <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.menu-items.index') }}">
                  <div class="sidebar-brand-icon rotate-n-15">
                      <i class="fas fa-utensils"></i>
                  </div>
                  <div class="sidebar-brand-text mx-3">Gourmet Admin</div>
              </a>
          
              <hr class="sidebar-divider my-0">
          
              <hr class="sidebar-divider">
          
              <div class="sidebar-heading">
                  Manajemen
              </div>
          
              <li class="nav-item {{ request()->routeIs('admin.menu-items.*') ? 'active' : '' }}">
                  <a class="nav-link" href="{{ route('admin.menu-items.index') }}">
                      <i class="fas fa-fw fa-utensils"></i>
                      <span>Kelola Menu</span></a>
              </li>
          
              <li class="nav-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                  <a class="nav-link" href="{{ route('admin.orders.index') }}">
                      <i class="fas fa-fw fa-receipt"></i>
                      <span>Kelola Pesanan</span></a>
              </li>
          
              <hr class="sidebar-divider d-none d-md-block">
          
              <div class="text-center d-none d-md-inline">
                  <button class="rounded-circle border-0" id="sidebarToggle"></button>
              </div>
          
          </ul>
          <div id="content-wrapper" class="d-flex flex-column">

              <div id="content">

                  <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                      <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                          <i class="fa fa-bars"></i>
                      </button>
                      <ul class="navbar-nav ml-auto">
                          <li class="nav-item dropdown no-arrow">
                              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name ?? 'Admin' }}</span>
                                  <img class="img-profile rounded-circle" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'A') }}&background=4e73df&color=fff">
                              </a>
                              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                  <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                      <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                      Logout
                                  </a>
                              </div>
                          </li>
                      </ul>
                  </nav>
                  @yield('content')
                  </div>
              <footer class="sticky-footer bg-white">
                  <div class="container my-auto">
                      <div class="copyright text-center my-auto">
                          <span>Copyright &copy; Gourmet Palace {{ date('Y') }}</span>
                      </div>
                  </div>
              </footer>
          </div>
          </div>
      <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="logoutModalLabel">Anda yakin ingin keluar?</h5>
                      <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                  </div>
                  <div class="modal-body">Pilih "Logout" untuk mengakhiri sesi Anda.</div>
                  <div class="modal-footer">
                      <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                      <form action="{{ route('logout') }}" method="POST">
                          @csrf
                          <button type="submit" class="btn btn-primary">Logout</button>
                      </form>
                  </div>
              </div>
          </div>
      </div>

      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.4/js/sb-admin-2.min.js"></script>
      
      @stack('scripts')
  </body>
  </html>
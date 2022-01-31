
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Book my Meal</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{url('backend')}}/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="{{url('backend')}}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{url('backend')}}/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="{{url('backend')}}/dist/css/custom.css">
  <link rel="stylesheet" href="{{url('backend')}}/dist/css/datepicker.css">
  <link rel="stylesheet" href="{{url('backend')}}/plugins/ekko-lightbox/ekko-lightbox.css">
  <link rel="stylesheet" href="{{url('backend')}}/dist/css/bootstrap-tagsinput.css">
  <link rel="stylesheet" href="{{url('backend')}}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="{{url('backend')}}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="{{url('backend')}}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="{{url('backend')}}/plugins/summernote/summernote-bs4.min.css">
  <link rel="stylesheet" href="{{url('backend')}}/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="{{url('backend')}}/plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="{{url('backend')}}/plugins/toastr/toastr.min.css">
  <link rel="stylesheet" href="{{url('backend')}}/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <link rel="stylesheet" href="{{url('backend')}}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <script src="{{url('backend')}}/plugins/jquery/jquery.min.js"></script>
  <!-- <script  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBvGtx-OK6fIz6-eVSmXvJjanVLk6BmhPU&libraries=places"></script> -->
  <script  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDSal-T1hfCkiyAz2gnTJHjSKH0Y8xJApE&libraries=places"></script>

  <!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>

<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->

<script>
  // Your web app's Firebase configuration
  var firebaseConfig = {
    apiKey: "AIzaSyD7VCxqkcHf4iD3TYUoDw1v7U2vxJ50IYc",
    authDomain: "orline-77071.firebaseapp.com",
    projectId: "orline-77071",
    storageBucket: "orline-77071.appspot.com",
    messagingSenderId: "91844164155",
    appId: "1:91844164155:web:50e0fe2ecca49f26797a1e"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
</script>

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
     
      <li class="nav-item">
        
         <a class=" btn-sm btn customBtn" href="{{ route('logout') }}" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();"> {{ __('Logout') }}</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
      </li>
     
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{url('/')}}" class="brand-link">
      <img src="{{url('backend')}}/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Book my Meal</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{url('backend')}}/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ucfirst(Auth()->user()->name)}}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
         @auth()
         @if(Auth()->user()->role == 1)
        <li class="nav-item">
            <a href="{{url('/admin/dashboard')}}" class="nav-link {{(url()->current() == url('/admin/dashboard')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li> 

          <li class="nav-item">
            <a href="{{url('/admin/profile')}}" class="nav-link {{(url()->current() == url('/admin/profile')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Profile
              </p>
            </a>
          </li> 

          <li class="nav-item">
            <a href="{{url('/admin/send-user-notification')}}" class="nav-link {{(url()->current() == url('/admin/send-user-notification')) ? 'active' : '' }}">
              <i class="fa fa-bell" aria-hidden="true"></i> &nbsp;
              <p>
                Send Notification
              </p>
            </a>
          </li> 


         
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fa fa-male" aria-hidden="true"></i> &nbsp;
              <p>
                Users Listing
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item">
                <a href="{{url('delivery-boy-list')}}" class="nav-link {{(url()->current() == url('/delivery-boy-list')) ? 'active' : '' }}">
               <i class="far fa-circle nav-icon"></i>
              <p>
              Delivery boy Listing
              </p>
            </a>
              </li>
              <li class="nav-item">
                <a href="{{url('appuser-list')}}" class="nav-link {{(url()->current() == url('appuser-list')) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>App User Listing</p>
                </a>
              </li>
            </ul>
          </li> 


          <li class="nav-item">
            <a href="{{url('products-list')}}" class="nav-link  {{(url()->current() == url('/products-list')) ? 'active' : '' }}">
              <i class="fab fa-product-hunt"></i> &nbsp;
              <p>
              Product Listing 
              </p>
            </a>
          </li>  

          <li class="nav-item">
          <a href="{{url('/kitchen-list')}}" class="nav-link  {{(url()->current() == url('/kitchen-list')) ? 'active' : '' }}">
              <i class="fa fa-archive" aria-hidden="true"></i> &nbsp;
              <p>
              Kitchen
              </p>
            </a>
          </li>  

          <li class="nav-item">
            <a href="{{url('/admin/addon')}}" class="nav-link  {{(url()->current() == url('/admin/addon')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-list"></i>
              <p>
              Add on
              </p>
            </a>
          </li>  


          <li class="nav-item">
                <a href="{{url('banner-list')}}" class="nav-link  {{(url()->current() == url('/banner-list')) ? 'active' : '' }}">
                 <i class="fa fa-file-image" aria-hidden="true"></i> &nbsp;
                  <p>Banner Listing</p>
                </a>
              </li>

                  <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fa fa-cog" aria-hidden="true"></i> &nbsp;
              <p>
                Setting
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item">
                <a href="{{url('/shipping-list')}}" class="nav-link {{(url()->current() == url('/shipping-list')) ? 'active' : '' }}">
               <i class="far fa-circle nav-icon"></i>
              <p>Shipping</p>
            </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/order-schedule-list')}}" class="nav-link {{(url()->current() == url('order-schedule-list')) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Order Accept Listing</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{url('/service-location-list')}}" class="nav-link {{(url()->current() == url('service-location-list')) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Service Location</p>
                </a>
              </li>

            </ul>
          </li> 
                
         <li class="nav-item">
              <a href="{{url('coupon-list')}}" class="nav-link  {{(url()->current() == url('/coupon-list')) ? 'active' : '' }}">
               <i class="nav-icon fas fa-list"></i>
                <p>Coupon Listing</p>
              </a>
            </li>  

          <li class="nav-item">
            <a href="{{url('category-list')}}" class="nav-link  {{(url()->current() == url('/category-list')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-list"></i>
              <p>Category </p>
            </a>
          </li> 


          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fa fa-shopping-cart" aria-hidden="true"></i> &nbsp;
              <p>
                Order
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item">
                <a href="{{url('admin/order-list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Order Listing</p>
                </a>
              </li>
               <li class="nav-item">
                <a href="{{url('admin/pending-order-list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Order Placed list</p>
                </a>
              </li>
            </ul>
          </li> 


        @else
        <li class="nav-item menu-open">
            <a href="{{url('/user/dashboard')}}" class="nav-link {{(url()->current() == url('/user/dashboard')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard </p>
            </a>
          </li>
         
                    <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-list"></i>
              <p>
                Users Listing
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item">
                <a href="{{url('appuser-list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>App User Listing</p>
                </a>
              </li>
            </ul>
          </li> 


          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-list"></i>
              <p>
                Product
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item">
                <a href="{{url('products-list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Product Listing</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('brands-list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Brand Listing</p>
                </a>
              </li> 

              <li class="nav-item">
                <a href="{{url('offer-list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Offers Listing</p>
                </a>
              </li>

             <!--   <li class="nav-item">
                <a href="{{url('advertise-list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Advertisement Listing</p>
                </a>
              </li> -->
              
            </ul>
          </li>  

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-list"></i>
              <p>
                Category
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item">
                <a href="{{url('category-list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Category Listing</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('subcategory-list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>SubCategory Listing</p>
                </a>
              </li>
            </ul>
          </li> 


          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-list"></i>
              <p>
                Order
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Order Listing</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Cancel Listing</p>
                </a>
              </li>
               <li class="nav-item">
                <a href="{{url('admin/pending-order-list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Order Placed list</p>
                </a>
              </li>
            </ul>
          </li> 

<!--           <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-list"></i>
              <p>
                Blog
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item">
                <a href="{{url('blog-list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Blog Listing</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('blog-category')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Blog Category</p>
                </a>
              </li>
            </ul>
          </li>  -->

     
         @endif
        @endauth
        
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   
    <!-- /.content-header -->

    <!-- Main content -->
    @yield('content')
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; {{date('Y')}} <a href="https://adminlte.io">Book my Meal</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->

<!-- Bootstrap 4 -->
<script src="{{url('backend')}}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="{{url('backend')}}/dist/js/adminlte.min.js"></script>
<script src="{{url('backend')}}/dist/js/datepicker.js"></script>
<script src="{{url('backend')}}/dist/js/bootstrap-tagsinput.min.js"></script>

<!-- DataTables  & Plugins -->
<script src="{{url('backend')}}/plugins/moment/moment.min.js"></script>
<script src="{{url('backend')}}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{url('backend')}}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{url('backend')}}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{url('backend')}}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{url('backend')}}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{url('backend')}}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{{url('backend')}}/plugins/jszip/jszip.min.js"></script>
<script src="{{url('backend')}}/plugins/pdfmake/pdfmake.min.js"></script>
<script src="{{url('backend')}}/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
<script src="{{url('backend')}}/plugins/pdfmake/vfs_fonts.js"></script>
<script src="{{url('backend')}}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{url('backend')}}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{{url('backend')}}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="{{url('backend')}}/plugins/summernote/summernote-bs4.min.js"></script>
<script src="{{url('backend')}}/plugins/select2/js/select2.full.min.js"></script>
<script src="{{url('backend')}}/plugins/toastr/toastr.min.js"></script>
<script src="{{url('backend')}}/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="{{url('backend')}}/plugins/daterangepicker/daterangepicker.js"></script>
<script src="{{url('backend')}}/plugins/chart.js/Chart.min.js"></script>

<script type="text/javascript">
  $(document).on('click', '[data-toggle="lightbox"]', function(event) {
      event.preventDefault();
      $(this).ekkoLightbox({
        alwaysShowClose: true
      });
    });
    
  $(".table").DataTable({
      "responsive": true,
      "ordering": false,
  })

  $("#table").DataTable({
    "paging": false,
    "ordering": false,
    "searching": false
  })

  $('.select2').select2();


  $(function () {
    $('#summernote').summernote({
       placeholder: 'Product Description',
        tabsize: 2,
        height: 200
    })

    $('.summernote').summernote({
       placeholder: 'Description',
        tabsize: 2,
        height: 200
    })
  })

$('.tags').tagsinput();
var nowDate = new Date();
var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);

$('.offerDate').daterangepicker({
  "singleDatePicker": true,
  "drops": 'up',
  minDate : today,
  locale: {
    format: 'DD-MM-YYYY'
  }
})

$(".offerDate2"). datepicker({ 
  "format": "yyyy", 
  "viewMode": "years", 
  "minViewMode": "years", 
  "autoclose" : true 
})


$('.timeSchedule').daterangepicker({
    "singleDatePicker": true,
      timePicker: true,
      timePicker24Hour: false,
      timePickerIncrement: 1,
      locale: {
          format: 'HH:mm'
      }
  }).on('show.daterangepicker', function (ev, picker) {
      picker.container.find(".calendar-table").hide();
  });


$('.bannerDate').daterangepicker({
  "singleDatePicker": true,
  "drops": 'up',

/*  minDate : today,*/
  locale: {
    "format": 'DD-MM-YYYY'
  }
})

</script>


<script type="text/javascript">
    function initialize() {
        var input = document.getElementById('address');
        var autocomplete = new google.maps.places.Autocomplete(input);
        google.maps.event.addListener(autocomplete, 'place_changed', function () {
          var place = autocomplete.getPlace();
          document.getElementById('lat').value = place.geometry.location.lat();
          document.getElementById('lang').value = place.geometry.location.lng();
        });
    }
    google.maps.event.addDomListener(window, 'load', initialize); 
</script>

    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Default Modal</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>One fine body&hellip;</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

</body>
</html>

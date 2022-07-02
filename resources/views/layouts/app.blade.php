<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-Billing</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/bootstrap.css">

    <link rel="stylesheet" href="../assets/vendors/iconly/bold.css">

    <link rel="stylesheet" href="../assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="../assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/app.css">
    <link rel="stylesheet" href="../assets/css/search.css">
    <link rel="shortcut icon" href="../assets/images/logo/logo.png"  type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="../assets2/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body>
    <div id="app">
      {{-- sidebar content start  --}}
      @yield('sidebar')
      {{-- sidebar content start  --}}


        <div id="main">
          {{-- main content start --}}
          @yield('content')

          {{-- main content end --}}

          {{-- footer content start --}}
          <footer>
            <div class="footer clearfix mb-0 text-muted">
                <div class="float-start">
                    <p>2021 &copy; Mazer</p>
                </div>
                <div class="float-end">
                  <p>Crafted with <span class="text-danger"><i class="bi bi-heart"></i></span> by <a
                  href="http://ahmadsaugi.com">A. Saugi</a></p>
                </div>
            </div>
          </footer>
          {{-- footer content start --}}

        </div>
    </div>


    <!-- Scroll to Top Button-->
    <style>
      #btn-back-to-top {
        position: fixed;
        bottom: 20px;
        right: 20px;
        display: none;
      }
    </style>
    
    <button
        type="button"
        class="btn btn-primary btn-floating btn-lg"
        id="btn-back-to-top"
        >
        <i class="fas fa-arrow-up"></i>
    </button>

    <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    {{-- <script src="../assets/js/bootstrap.bundle.min.js"></script> --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>



    <!-- Page level plugins -->
    <script src="{{URL::to('assets2/dataTables/datatables.min.js')}}"></script>
    <script src="{{URL::to('assets2/dataTables/dataTables.bootstrap4.min.js')}}"></script>



    <!-- Page level custom scripts -->
    {{-- <script src="../assets2/js/demo/datatables-demo.js"></script> --}}

    <script src="../assets/vendors/apexcharts/apexcharts.js"></script>
    <script src="../assets/js/pages/dashboard.js"></script>

    <script src="../assets/vendors/apexcharts/apexcharts.js"></script>
    <script src="../assets/js/pages/dashboard.js"></script>

    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/moment.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    {{-- <script>
      $(document).ready(function(){
          $('#example').DataTable({
              ordering: false,
              info: false,
              retrieve: true,
              // paging: false,
              // pageLength: 25,
              // responsive: true,
              dom: '<"html5buttons"B>lTfgitp',
              buttons: [
                  // { extend: 'copy'},
                  {extend: 'csv'},
                  {extend: 'excel', title: 'ExampleFile'},
                  {extend: 'pdf', title: 'ExampleFile'},

                  {extend: 'print',
                   customize: function (win){
                      $(win.document.body).addClass('white-bg');
                      $(win.document.body).css('font-size', '10px');

                      $(win.document.body).find('table')
                      .addClass('compact')
                      .css('font-size', 'inherit');
                  }
                  }
              ]
          });
      });

  </script> --}}

  

  


  
    <script>
      //Get the button
      let mybutton = document.getElementById("btn-back-to-top");

      // When the user scrolls down 20px from the top of the document, show the button
      window.onscroll = function () {
        scrollFunction();
      };

      function scrollFunction() {
        if (
          document.body.scrollTop > 20 ||
          document.documentElement.scrollTop > 20
        ) {
          mybutton.style.display = "block";
        } else {
          mybutton.style.display = "none";
        }
      }
      // When the user clicks on the button, scroll to the top of the document
      mybutton.addEventListener("click", backToTop);

      function backToTop() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
      }
    </script>
</body>

</html>
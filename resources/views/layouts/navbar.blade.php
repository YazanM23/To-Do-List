<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <meta charset="UTF-8">
    <title>My Todo List</title>

    <!-- MDB Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.1/mdb.min.css" rel="stylesheet">

    <!-- MDB Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.1/mdb.min.js"></script>

    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Datepicker CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <style>
        #list1 .select {
            border-color: transparent;
            width:15%;
        }
        #list1 .select:focus {
            border-color: transparent;
            box-shadow: none;
            width:15%;
        }
        #list1 .form-control[readonly]:not([disabled]) {
            background-color: #fbfbfb;
            width:15%;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
          <a class="navbar-brand" href="{{route('tasks',1)}}">To-Do List</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="{{route('tasks',1)}}">All Tasks</a>
              </li>
            </ul>

            <form class="d-flex" method="GET" action="{{route('search')}}">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name='search'>
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form>

            <!-- Logout button -->
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline-block ms-3">
              @csrf
              <button type="submit" class="btn btn-outline-danger">
                <i class="fas fa-sign-out-alt"></i> Logout
              </button>
            </form>
          </div>
        </div>
      </nav>

      @yield('content')
@yield('pagination')
</body>

<!-- JS libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

<script>
    // Initialize the datepicker when clicking on the date icon
    $(document).ready(function(){
        $('.datepicker-trigger').click(function() {
            $('#datepicker').datepicker('show');
        });

        // Initialize the datepicker
        $('#datepicker').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true,
            todayHighlight: true
        });

        // Initialize MDB select elements
        $('.select').each(function() {
            new mdb.Select(this);
        });
    });
</script>

</html>

@extends('layouts.navbar')
@section('content')
<section class="vh-100">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col">
                <div class="card" id="list1" style="border-radius: .75rem; background-color: #eff1f2;">
                    <div class="card-body py-4 px-4 px-md-5">

                        <p class="h1 text-center mt-3 mb-4 pb-3 ">
                            <i class="fa-solid fa-user"></i>
                            <u>Dashboard</u>
                        </p>
                      
                     

                    

                        <hr class="my-4">

                        <div class="d-flex justify-content-end align-items-center mb-4 pt-2 pb-3">
                            <p class="small mb-0 me-2 text-muted">Filter</p>
                            <form method="GET" action="{{ route('dashboardFilter') }}" style="width: 360px; display: flex;">
                                <select style="width: 180px;" class="select form-control" name="status" onchange="this.form.submit()">
                                    <option value="All" {{ request('status') == 'All' ? 'selected' : '' }}>All</option>
                                    <option value="LoggedIn" {{ request('status') == 'LoggedIn' ? 'selected' : '' }}>Logged In</option>
                                    <option value="LoggedOut" {{ request('status') == 'LoggedOut' ? 'selected' : '' }}>Logged Out</option>
                                    <option value="CreateTask" {{ request('status') == 'CreateTask' ? 'selected' : '' }}>Task Created</option>
                                    <option value="UpdatedTask" {{ request('status') == 'UpdatedTask' ? 'selected' : '' }}>Task Upadated</option>
                                </select>

                                <p class="small mb-0 ms-4 me-2 text-muted" style="margin-top:7px;">Sort</p>
                                <select class="select form-control" style="width: 180px" name="sort" onchange="this.form.submit()">
                                    <option value="Added_date" {{ request('sort') == 'Added_date' ? 'selected' : '' }}>Added date</option>
                                    
                                </select>

                                <input type="hidden" name="sort_order" id="sort_order" value="{{ request('sort_order', 'asc') }}">
                                <a href="#!" id="toggleSort" style="color: #23af89; margin-top: 5px;" data-mdb-tooltip-init title="Sort Order">
                                    <i id="sortIcon" class="fas {{ request('sort_order', 'asc') === 'asc' ? 'fa-sort-amount-down-alt' : 'fa-sort-amount-up-alt' }} ms-2"></i>
                                </a>
                            </form>
                        </div>
                      

                    
         
                        <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                              <th>Order</th>
                              <th>User ID</th>
                              <th>Action Type</th>
                              <th>Action date</th>
                          
                          
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $log)
                            <tr>
                              <td>{{ $loop->iteration }}</td>
                              <td>{{$log->user_id}}</td>
                              <td>{{$log->action_type}}</td>
                              <td>{{$log->created_at}}</td>
                          
                          
                            </tr>
                            @endforeach
                         
                            </tbody>
                          </table>
                          


                    </div>
                  
                </div>
            </div>
        </div>
    </div>
   
</section>

<script>
    document.getElementById('toggleSort').addEventListener('click', function (event) {
        event.preventDefault();
        var sortOrderInput = document.getElementById('sort_order');
        var sortIcon = document.getElementById('sortIcon');
        
        if (sortOrderInput.value === 'asc') {
            sortOrderInput.value = 'desc';
            sortIcon.classList.remove('fa-sort-amount-down-alt');
            sortIcon.classList.add('fa-sort-amount-up-alt');
        } else {
            sortOrderInput.value = 'asc';
            sortIcon.classList.remove('fa-sort-amount-up-alt');
            sortIcon.classList.add('fa-sort-amount-down-alt');
        }

        this.closest('form').submit();
    });
</script>

<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>

  // Enable pusher logging - don't include this in production
  Pusher.logToConsole = true;

  var pusher = new Pusher('d5d9b4d5972336172a10', {
    cluster: 'eu'
  });

  var channel = pusher.subscribe('my-channel');
  channel.bind('my-event', function(data) {
    alert(JSON.stringify(data));

  });
</script>

<script>
 function validationCheck(){
    var file = document.getElementById("idFile").files[0];
    var fileExtension = file.name.split('.').pop();
    if (file) { 
      var fileSize = file.size*0.000001;
      if((fileSize>1 || fileSize<0.5)&& (fileExtension=='jpg' || fileExtension=='png' || fileExtension=='jpeg') ){
        addButton.disabled = true;
        document.getElementById("statusLabel").innerHTML ="Your file should be 0.5-1 MB "+" Your File size: " + fileSize + "MB ";
      }
      else if(fileSize>2 && (fileExtension=='pdf' || fileExtension=='docx')){
        addButton.disabled = true;
        document.getElementById("statusLabel").innerHTML ="Your file should be 0-2 MB "+" Your File size: " + fileSize + "MB ";

      }
      else{
        addButton.disabled = false;
        document.getElementById("statusLabel").innerHTML ="";
      }
      
    } else {
      document.getElementById("statusLabel").innerHTML = "No file selected";
    }
  }

</script>

@endsection
@section('pagination')
<div class="d-flex justify-content-center mt-4">
    {{ $data->appends(request()->except('page'))->links() }}

</div>
    <style>
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 10px;
        border-radius: 8px;
        background-color: #fff;

        list-style-type: none;
    }
    
    .pagination__numbers,
    .pagination__btn,
    .pagination__dots {
        margin: 0 5px;
        padding: 10px 15px;
        font-size: 16px;
        cursor: pointer;
        border-radius: 5px;
        background-color: #eff1f2;
        color: var(--greyDark);
        transition: background-color 0.3s ease;
    }
    
    .pagination__numbers.active {
        background-color: #23adad;
        color: white;
        font-weight: 600;
    }
    
    .pagination__btn i {
        color: var(--greyDark);
    }
    
    .pagination__btn.disabled i {
        color: #cbe0dd; /* Lighter for disabled state */
        cursor: not-allowed;
    }
    
    .pagination__numbers:hover,
    .pagination__btn:hover i {
        background-color: #23adad;
        color: white;
    }
    
    .pagination__dots {
        pointer-events: none;
        color: var(--greyLight);
    }
    

    </style>
@endsection
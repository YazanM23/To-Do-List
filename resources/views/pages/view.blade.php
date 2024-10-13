
    @extends('layouts.navbar')
    @section('content')
    <div class="card mt-4">
        <div class="card-header">
            Task Info
        </div>
        <div class="card-body">
            <h5 class="card-title">Title: {{$task->title}}</h5>
            <p class="card-text">Status: {{$task->status}}</p>
            <p class="card-text">Description: {{$task->description}}</p>
            <br>
            <hr>
            <p class="card-text" >Due Date: {{$task->deadline}}</p>
            <p class="card-text">Created At: {{$task->created_at}}</p>
            <p class="card-text" >Updated At: {{$task->updated_at}}</p>
     
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            Task Creator Info
        </div>
        <div class="card-body">
            <h5 class="card-title">Name: {{$user->name}}</h5>
            <p class="card-text">Email: {{$user->email}}</p>
            
        </div>
    </div> 
    
    @endsection
    
   

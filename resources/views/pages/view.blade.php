
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
            <p class="card-text" >Deadline Date: {{$task->deadline}}</p>
            <p class="card-text">Created At: {{$task->created_at}}</p>
            <p class="card-text" >Updated At: {{$task->updated_at}}</p>
            @if ($task->files)
                file:{{$task->files}}<br>
                @if($task->file_type=='jpg'||$task->file_type=='jpeg'||$task->file_type=='png')
               <img src="{{ asset("storage/$task->files") }}" style="width:200px;height:200px">

</from>


                extension:{{$task->file_type}}
                @endif
                @if(($task->file_type=='pdf'||$task->file_type=='docx'))
                <iframe src="{{ asset("storage/$task->files") }}" width="100%" height="600px"></iframe>

                @endif
                <br>
                <br>
                <form method="POST" action="{{route('download',$task->id)}}">
                    @csrf
                    <input type="hidden" name="file" value="{{$task->files}}">
                    <button type="submit" class="btn btn-success">Download File</button>
                </form>
            @endif
           
     
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
    
   

@extends('layouts.navbar');
@section('content')
<form method="POST" action="{{route('update', $task->id)}}" style="margin-left:1%;margin-top:2%; width:40%;">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label class="form-label">Title</label>
        <input name="title" type="text" value="{{$task->title}}" class="form-control" >
    </div>
    <div class="mb-3">
        <label  class="form-label">Description:</label>
        <textarea name="description" class="form-control"  rows="3">{{$task->description}}</textarea>
    </div>
    <div class="mb-3" style="display: flex">
        <label  class="form-label" style="margin-right: 1%;margin-top:1%;">Status</label>
        <select name="status"  class="select form-control" style="width:180px">
            <option value="Pending" {{ $task->status == 'Pending' ? 'selected' : '' }}>Pending</option>
        <option value="Completed" {{ $task->status == 'Completed' ? 'selected' : '' }}>Completed</option>
        </select>
    </div>
    <label  class="form-label">Deadline</label>
    <div class="mb-3" style="display: flex">
        <input type="text" class="form-control datepicker" id="datepicker" name="picker" placeholder="Select date" value="{{ old('picker') }}"readonly style="width: 180px;">
        
        <a href="#!" data-mdb-tooltip-init title="Set due date" style="margin-left:20px;margin-top:2.5%;">
            <i class="fas fa-calendar-alt fa-lg me-3 datepicker-trigger"></i>
        </a>
        
    </div><br>

    <button class="btn btn-primary" type="submit">Update</button>
</form>
@if($task->files!=null)
<form action="{{route('deleteFile', $task->id)}}" method="POST">
    @csrf
    @method('DELETE')
    <input type="hidden" name="file" value="{{$task->files}}">
    <button class="btn btn-danger" type="submit">Delete File</button>
</form>

@endif

@endsection
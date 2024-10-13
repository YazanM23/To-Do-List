@extends('layouts.navbar');
@section('content')
<form method="POST" action="{{route('update', $task->id)}}">
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
    <div class="mb-3">
        <label  class="form-label">Status</label>
        <select name="status"  >
            <option value="Pending" {{ $task->status == 'Pending' ? 'selected' : '' }}>Pending</option>
        <option value="Completed" {{ $task->status == 'Completed' ? 'selected' : '' }}>Completed</option>
        </select>
    </div>
    <div class="mb-3">
        <label  class="form-label">Deadline</label>
        <a href="#!" data-mdb-tooltip-init title="Set due date" style="margin-left:20px">
            <i class="fas fa-calendar-alt fa-lg me-3 datepicker-trigger"></i>
        </a>
        <input type="text" class="form-control datepicker" id="datepicker" name="picker" placeholder="Select date" value="{{ old('picker') }}" hidden>
        
    </div>

    <button class="btn btn-primary" type="submit">Update</button>
</form>

@endsection
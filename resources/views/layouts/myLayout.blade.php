@extends('layouts.navbar')
@section('content')
<section class="vh-100">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col">
                <div class="card" id="list1" style="border-radius: .75rem; background-color: #eff1f2;">
                    <div class="card-body py-4 px-4 px-md-5">

                        <p class="h1 text-center mt-3 mb-4 pb-3 text-primary">
                            <i class="fas fa-check-square me-1"></i>
                            <u>To-Do List</u>
                        </p>

                        <div class="pb-2">
                            <div class="card">
                                <div class="card-body">
                                    <form action="{{route('add')}}" method="POST">
                                        @csrf
                                        <div class="d-flex flex-row align-items-center" style="width: 100%;">
                                            <div style="width: 100%;">
                                                <!-- Title input -->
                                                <input type="text" class="form-control form-control-lg" name="title" id="exampleFormControlInput1"
                                                       placeholder="New Title...">
                                                <br>
                                                <!-- Description input -->
                                                <textarea class="form-control form-control-lg" name="description" id="exampleFormControlTextarea1" placeholder="Description..." rows="2"></textarea>
                                            </div>

                                            <!-- Datepicker icon with input -->
                                            <a href="#!" data-mdb-tooltip-init title="Set due date" style="margin-left:20px">
                                                <i class="fas fa-calendar-alt fa-lg me-3 datepicker-trigger"></i>
                                            </a>
                                            <input type="text" class="form-control datepicker" id="datepicker" name="picker" placeholder="Select date" hidden value=" ">

                                            <div>
                                                <button type="submit" class="btn btn-primary">Add</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end align-items-center mb-4 pt-2 pb-3">
                            <p class="small mb-0 me-2 text-muted">Filter</p>
                            <form method="GET" action="{{route('filter')}}" style="width: 360px; display: flex;">
                                <select style="width: 180px;" class="select form-control" name="status" onchange="this.form.submit()">
                                    <option value="All" {{ request('status') == 'All' ? 'selected' : '' }}>All</option>
                                    <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                </select>

                                <p class="small mb-0 ms-4 me-2 text-muted" style="margin-top:7px;">Sort</p>
                                <select class="select form-control" style="width: 180px" name="sort" onchange="this.form.submit()">
                                    <option value="Added_date" {{ request('sort') == 'Added_date' ? 'selected' : '' }}>Added date</option>
                                    <option value="Deadline_date" {{ request('sort') == 'Deadline_date' ? 'selected' : '' }}>Deadline date</option>
                                </select>

                                <input type="hidden" name="sort_order" id="sort_order" value="{{ request('sort_order', 'asc') }}">
                                <a href="#!" id="toggleSort" style="color: #23af89; margin-top: 5px;" data-mdb-tooltip-init title="Sort Order">
                                    <i id="sortIcon" class="fas {{ request('sort_order', 'asc') === 'asc' ? 'fa-sort-amount-down-alt' : 'fa-sort-amount-up-alt' }} ms-2"></i>
                                </a>
                            </form>
                        </div>

                        <!-- Loop through tasks -->
                        @foreach ($data as $task)
                        <ul class="list-group list-group-horizontal rounded-0 bg-transparent">
                            <li class="list-group-item d-flex align-items-center ps-0 pe-3 py-1 rounded-0 border-0 bg-transparent">
                                <div class="form-check">
                                    <form action="{{ route('updateStatus', $task->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input class="form-check-input me-0" type="checkbox" 
                                               onchange="this.form.submit()" 
                                               {{ $task->status == 'Completed' ? 'checked' : '' }} 
                                               aria-label="..." />
                                    </form>
                                </div>
                            </li>
                            <li class="list-group-item px-3 py-1 d-flex align-items-center flex-grow-1 border-0 bg-transparent">
                                <p class="lead fw-normal mb-0">{{ $task->title }}</p>
                            </li>
                            <li class="list-group-item ps-3 pe-0 py-1 rounded-0 border-0 bg-transparent">
                                <div class="d-flex flex-row justify-content-end mb-1">
                                    <a href="tasks/{{ $task->id }}/view" class="text-info" data-mdb-tooltip-init title="View todo" style="margin-right: 10px;">
                                        <i class="fa-solid fa-eye" style="color: black"></i>
                                    </a>
                                    <a href="tasks/{{ $task->id }}/edit" class="text-info" data-mdb-tooltip-init title="Edit todo">
                                        <i class="fas fa-pencil-alt me-3"></i>
                                    </a>
                                    <form action="{{ route('delete', $task->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link text-danger p-0" data-mdb-tooltip-init title="Delete todo">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                                <div class="text-end text-muted">
                                    <a href="#!" class="text-muted" data-mdb-tooltip-init title="Created date">
                                        <p class="small mb-0"><i class="fas fa-info-circle me-2"></i>{{ $task->deadline }}</p>
                                    </a>
                                </div>
                            </li>
                        </ul>

                        @if (\Carbon\Carbon::now()->format('Y-m-d') == \Carbon\Carbon::parse($task->deadline)->format('Y-m-d'))
                            <div class="alert alert-warning mt-2">
                                Reminder: The deadline for this task is today!
                            </div>
                        @endif

                        @endforeach
                        
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
@endsection

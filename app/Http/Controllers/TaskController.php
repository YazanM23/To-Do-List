<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use App\Models\User;
use App\Models\Reminders;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use View;
use function Laravel\Prompts\error;

class TaskController extends Controller
{
    //
    function getAllTasks()
    {

        $user = Auth::user();
        if ($user != null) {
            $tasks = Tasks::where('user_id', $user->id)->get();
        } else {
            return response()->json(['error' => 'Please Login']);
        }

        if ($tasks) {
            $reminders = Reminders::all();
            $reminderTasks = [];

            foreach ($reminders as $reminder) {
                $task = Tasks::where('id', $reminder->task_id)->where('user_id', $user->id)->first();
                if ($task) {
                    $reminderTasks[] = $task;
                }
            }

            return view('layouts.myLayout', ['data' => $tasks, 'Reminder' => $reminderTasks]);
        }


        return view('layouts.myLayout');
    }

    function getTaskDetails($id)
    {
        $task = Tasks::where('id', $id)->first();
        if ($task) {
            $file = [];
            $user = Auth::user();
            $userInfo = User::where('id', $user->id)->first();

            if ($task->files) {
                $file = Storage::get("$task->files");
            }


            return view('pages.view', ['task' => $task, 'user' => $userInfo, 'image', 'file' => $file]);
        }
        return view('pages.view');
    }



    function deleteTask($id)
    {
        $task = Tasks::where('id', $id)->first();
        if ($task) {
            $reminder = Reminders::where('task_id', $task->id);
            if ($reminder) {
                $reminder->delete();
            }

            $task->delete();
        }
        return to_route('tasks');
    }


    function createTask(Request $request)
    {
        if ($request->input('title') != null  && $request->picker != null) {
            $task = new Tasks();

            $task->user_id = Auth::user()->id;
            $task->title = $request->input('title');
            $task->description = $request->input('description');
            $task->status = "Pending";

            $task->deadline = \Carbon\Carbon::createFromFormat('d/m/Y', $request->picker)->format('Y-m-d');

            if ($request->file) {

                $filereq = $request->file;

                $fileExtension = $filereq->getClientOriginalExtension();

                if ($fileExtension == 'jpg' || $fileExtension == 'jpeg' || $fileExtension == 'png') {
                    $request->validate(['file' => 'required|file|mimes:jpg,png,jpeg|max:2048|min:512']);
                } else {

                    try {
                        $request->validate([
                            'file' => 'required|file|mimes:pdf,docx|max:2048'
                        ]);
                    } catch (\Illuminate\Validation\ValidationException $e) {
                        @dd(ini_get(option: 'upload_max_filesize'), ini_get('post_max_size'));
                    }
                }
                $filesStorage =  Storage::putFile('myStorage', $filereq);
                $task->files = $filesStorage;
                $task->file_type = $fileExtension;
            }
            $task->save();
        }
        return to_route('tasks');
    }


    function editTaskDetails($id)
    {
        $task = Tasks::where('id', $id)->first();
        if ($task) {
            $user = Auth::user();
            $userInfo = User::where('id', $user->id)->first();

            return view('pages.edit', ['task' => $task, 'user' => $userInfo]);
        }
        return view('pages.edit');
    }
    function updateTaskDetails($id)
    {
        if (request()->title != null  && request()->status != null) {
            $task = Tasks::where('id', $id)->first();
            $task->title = request()->title;
            $task->description = request()->description;
            $task->status = request()->status;
            if (request()->picker) {
                $task->deadline = \Carbon\Carbon::createFromFormat('d/m/Y', request()->picker)->format('Y-m-d');
            }
            $task->save();
            return to_route('tasks');
        }

        return to_route('tasks.edit', $id);
    }
    public function updateStatus($id)
    {
        $task = Tasks::where('id', $id)->first();
        if ($task) {

            if ($task->status == 'Pending') {
                $task->status = 'Completed';
                $task->completed_at = \Carbon\Carbon::now();
            } else {
                $task->status = 'Pending';
            }

            $task->save();
        }


        return to_route('tasks');
    }

    function filterTasks(Request $request)
    {

        $user = Auth::user();
        $status = $request->input('status');
        $sort = $request->input('sort');
        $sort_order = $request->input('sort_order');

        $reminders = Reminders::all();
        $reminderTasks = [];

        foreach ($reminders as $reminder) {
            $task = Tasks::where('id', $reminder->task_id)->where('user_id', $user->id)->first();
            if ($task) {
                $reminderTasks[] = $task;
            }
        }

        if ($status == 'All' && $sort == 'Added_date') {


            $tasks = Tasks::where('user_id', $user->id)->orderBy('created_at', $sort_order)->get();
            if ($tasks) {
                return view('layouts.myLayout', ['data' => $tasks, 'status' => $status, 'Reminder' => $reminderTasks]);
            } else {
                return to_route('tasks');
            }
        } else  if ($status == 'All' && $sort == 'Deadline_date') {


            $tasks = Tasks::where('user_id', $user->id)->orderBy('deadline', $sort_order)->get();
            if ($tasks) {
                return view('layouts.myLayout', ['data' => $tasks, 'status' => $status, 'Reminder' => $reminderTasks]);
            } else {
                return to_route('tasks');
            }
        } else {
            if ($sort == 'Added_date') {
                $tasks = Tasks::where('user_id', $user->id)->where('status', $status)->orderBy('created_at', $sort_order)->get();

                if ($tasks) {
                    return view('layouts.myLayout', ['data' => $tasks, 'status' => $status, 'Reminder' => $reminderTasks]);
                } else {
                    return to_route('tasks');
                }
            } else if ($sort == 'Deadline_date') {
                $tasks = Tasks::where('user_id', $user->id)->where('status', $status)->orderBy('deadline', $sort_order)->get();
                if ($tasks) {
                    return view('layouts.myLayout', ['data' => $tasks, 'status' => $status, 'Reminder' => $reminderTasks]);
                } else {
                    return to_route('tasks');
                }
            }
        }
    }

    function searchTasks(Request $request)
    {
        $word = $request->input('search');
        $user = Auth::user();
        $reminders = Reminders::all();
        $reminderTasks = [];

        foreach ($reminders as $reminder) {
            $task = Tasks::where('id', $reminder->task_id)->where('user_id', $user->id)->first();
            if ($task) {
                $reminderTasks[] = $task;
            }
        }
        if ($user != null) {
            $tasks = Tasks::where('user_id', $user->id)->whereLike('title', '%' . $word . '%')->get();
        } else {
            return error('Please Login');
        }
        if ($tasks) {

            return view('layouts.myLayout', ['data' => $tasks, 'Reminder' => $reminderTasks]);
        }
        return view('layouts.myLayout');
    }
}

<?php

namespace App\Http\Controllers;
use App\Models\Tasks;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use View;
use function Laravel\Prompts\error;

class TaskController extends Controller
{
    //
    function getAllTasks()
    {
        $user = Auth::user();
        if($user!=null){
        $tasks=Tasks::where('user_id',$user->id)->get();
        }
    else{
        return error('Please Login');
    }
        if($tasks){
 
return view('layouts.myLayout',['data'=>$tasks]);
        }
        return view('layouts.myLayout');
    }

    function getTaskDetails($id){
        $task=Tasks::where('id',$id)->first();
        if($task){
 $user=Auth::user();
 $userInfo=User::where('id',$user->id)->first();
return view('pages.view',['task'=>$task,'user'=>$userInfo]);
        }
        return view('pages.view');
    }



    function deleteTask($id){
        $task=Tasks::where('id',$id)->first();
        if($task){
 $task->delete();
        }
        return to_route('tasks');
    }


    function createTask(Request $request){
        $task=new Tasks();
        $task->user_id = Auth::user()->id;
        $task->title = $request->input('title');
        $task->description = $request->input('description');
        $task->status= "Pending";
        $task->deadline = \Carbon\Carbon::createFromFormat('d/m/Y', $request->picker)->format('Y-m-d');

    $task->save();
    return to_route('tasks');
    }


    function editTaskDetails($id){
    $task=Tasks::where('id',$id)->first();
        if($task){
 $user=Auth::user();
 $userInfo=User::where('id',$user->id)->first();

return view('pages.edit',['task'=>$task,'user'=>$userInfo]);
        }
        return view('pages.edit');


    }
    function updateTaskDetails($id){
        $task=Tasks::where('id',$id)->first();
        $task->title= request()->title;
        $task->description = request()->description;
        $task->status= request()->status;
if(request()->picker){
    $task->deadline = \Carbon\Carbon::createFromFormat('d/m/Y', request()->picker)->format('Y-m-d');

}
        $task->save();
        
        return to_route('tasks');
    }
    public function updateStatus($id)
    {
        $task = Tasks::where('id',$id)->first();
     if($task){
       
        if($task->status == 'Pending'){
            $task->status='Completed';
        }
        else{
            $task->status='Pending';
        }
        $task->save();
     }
    
    
        return to_route('tasks');
    }

    function filterTasks(Request $request){

        $user = Auth::user();
        $status = $request->input('status');
        $sort = $request->input('sort');
        $sort_order=$request->input('sort_order');


        if($status == 'All' && $sort=='Added_date'){
       

            $tasks=Tasks::where('user_id',$user->id)->orderBy('created_at',$sort_order)->get();
      if($tasks){
                return view('layouts.myLayout',['data'=>$tasks,'status' => $status]);
            }
            else{
                return to_route('tasks');
            }
        }
        else  if($status == 'All' && $sort=='Deadline_date'){
       

            $tasks=Tasks::where('user_id',$user->id)->orderBy('deadline',$sort_order)->get();
      if($tasks){
                return view('layouts.myLayout',['data'=>$tasks,'status' => $status]);
            }
            else{
                return to_route('tasks');
            }
        }
        
        else{
            if($sort=='Added_date'){
                $tasks=Tasks::where('user_id',$user->id)->where('status',$status)->orderBy('created_at',$sort_order)->get();
                if($tasks){
                          return view('layouts.myLayout',['data'=>$tasks,'status' => $status]);
                      }
                      else{
                          return to_route('tasks');
                      }
            } else if( $sort== 'Deadline_date'){
                $tasks=Tasks::where('user_id',$user->id)->where('status',$status)->orderBy('deadline',$sort_order)->get();
                if($tasks){
                          return view('layouts.myLayout',['data'=>$tasks,'status' => $status]);
                      }
                      else{
                          return to_route('tasks');
                      }
       
        }
    }
    
}

function searchTasks(Request $request){
    $word=$request->input('search');
    $user = Auth::user();
    if($user!=null){
    $tasks=Tasks::where('user_id',$user->id)->whereLike('title','%'.$word.'%')->get();
    }
else{
    return error('Please Login');
}
    if($tasks){

return view('layouts.myLayout',['data'=>$tasks]);
    }
    return view('layouts.myLayout');
}
}
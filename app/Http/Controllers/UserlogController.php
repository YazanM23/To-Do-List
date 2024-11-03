<?php

namespace App\Http\Controllers;



use App\Models\Tasks;
use App\Models\Userlog;
use Illuminate\Http\Request;


class UserlogController extends Controller
{
    //

    public function viewInformations()
    {
        $infomations = Userlog::paginate(5);


        return view('layouts.dashboard', ['data' => $infomations]);
    }



    function filterLogs(Request $request)
    {


        $status = $request->input('status');
        $sort = $request->input('sort');
        $sort_order = $request->input('sort_order');

        if ($status == 'All') {


            $log = Userlog::orderBy('created_at', $sort_order)->paginate(5);
            if ($log) {
                return view('layouts.dashboard', ['data' => $log, 'status' => $status]);
            } else {
                return to_route('dashboardFilter');
            }
        } else {
            if ($sort == 'Added_date') {
                $tasks = Userlog::where('action_type', $status)->orderBy('created_at', $sort_order)->paginate(5);

                if ($tasks) {
                    return view('layouts.dashboard', ['data' => $tasks, 'status' => $status]);
                } else {
                    return to_route('dashboard');
                }
            }
        }
    }
    function searchLogs(Request $request)
    {
        $word = $request->input('search');


        $log = Tasks::whereLike('action_type', '%' . $word . '%')->paginate(5);

        if ($log) {

            return view('layouts.dashboard', ['data' => $log]);
        }
        return view('layouts.dashboard');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tasks;
use Illuminate\Support\Facades\Storage;

class StorageController extends Controller
{
    //

    function downloadFile($id)
    {
        $task = Tasks::where('id', $id)->first();
        $file = $task->files;
        return Storage::download($file);
    }
    function deleteFile($id)
    {
        $task = Tasks::where('id', $id)->first();
        $file = $task->files;
        $task->files = null;
        $task->file_type = null;
        $task->save();
        Storage::delete($file);
        return to_route('edit', ['id' => $id]);
    }
    function getPhoto($path)
    {



        return Storage::get("$path");
    }
}

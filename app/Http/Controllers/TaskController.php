<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller {
    public function TaskList( Request $request ) {
        $id = $request->user()->id;
        return Task::where( 'user_id', $id )->get();
    }

    public function TaskCreate( Request $request ) {
        $task = Task::create( [
            'user_id'     => $request->user()->id,
            'title'       => $request->input( 'title' ),
            'description' => $request->input( 'description' ),
            'status'      => $request->input( 'status' ),
            'priority'    => $request->input( 'priority' ),
        ] );

        return response()->json( ['message' => 'Task Created Successfully', 'status' => true, 'data' => $task] );
    }
}

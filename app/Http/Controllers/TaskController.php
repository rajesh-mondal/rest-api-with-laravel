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

    public function TaskUpdate( Request $request, $id ) {
        $task = Task::where( 'id', $id )
            ->where( 'user_id', $request->user()->id )
            ->first();

        $task->update( [
            'title'       => $request->input( 'title' ),
            'description' => $request->input( 'description' ),
            'status'      => $request->input( 'status' ),
            'priority'    => $request->input( 'priority' ),
        ] );

        return response()->json( ['message' => 'Task Updated Successfully', 'status' => true, 'data' => $task] );
    }

    public function TaskDelete( Request $request, $id ) {
        $task = Task::where( 'id', $id )
            ->where( 'user_id', $request->user()->id )
            ->first();

        $task->delete();

        return response()->json( ['message' => 'Task Deleted Successfully', 'status' => true, 'data' => $task] );
    }

    public function TaskSummary( Request $request ) {
        $task = Task::where( 'user_id', $request->user()->id )->get();

        $summary = [
            'total'       => $task->count(),
            'by_status'   => $task->groupBy( 'status' )->map->count(),
            'by_priority' => $task->groupBy( 'priority' )->map->count(),
        ];

        return response()->json( ['message' => 'Task Summary Displayed', 'status' => true, 'data' => $summary] );
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\TaskNotes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskNotesController extends Controller
{
    public function index()
    {
        $task_notes = TaskNotes::all();
        $token = $task_notes->createToken('auth_token')->plainTextToken;
        return response()->json([
            'status'=> 200,
            'tasks'=>$task_notes,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'task_id'=>'required',
            'subject'=>'required|max:191',
            'attachment'=>'required|max:191',
            'notes'=>'required',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=> 422,
                'validate_err'=> $validator->errors(),
            ]);
        }
        else
        {
            $task_notes = new TaskNotes;
            $task_notes->task_id = $request->input('task_id');
            $task_notes->subject = $request->input('subject');
            $task_notes->attachment = $request->input('attachment');
            $task_notes->notes = $request->input('notes');
            $task_notes->save();

            $token = $task_notes->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status'=> 200,
                'message'=>'Notes added successfully',
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        }

    }

    public function edit($id)
    {
        $task_notes = TaskNotes::find($id);
        if($task_notes)
        {
            $token = $task_notes->createToken('auth_token')->plainTextToken;
            return response()->json([
                'status'=> 200,
                'tasks' => $task_notes,
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        }
        else
        {
            return response()->json([
                'status'=> 404,
                'message' => 'No notes found',
            ]);
        }

    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'task_id'=>'required',
            'subject'=>'required|max:191',
            'attachment'=>'required|max:191',
            'notes'=>'required',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=> 422,
                'validationErrors'=> $validator->errors(),
            ]);
        }
        else
        {
            $task_notes = TaskNotes::find($id);
            if($task_notes)
            {
                $task_notes->task_id = $request->input('task_id');
                $task_notes->subject = $request->input('subject');
                $task_notes->attachment = $request->input('attachment');
                $task_notes->notes = $request->input('notes');
                $task_notes->update();

                $token = $task_notes->createToken('auth_token')->plainTextToken;

                return response()->json([
                    'status'=> 200,
                    'message'=>'Notes updated successfully',
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                ]);
            }
            else
            {
                return response()->json([
                    'status'=> 404,
                    'message' => 'No notes found',
                ]);
            }
        }
    }

    public function destroy($id)
    {
        $task_notes = TaskNotes::find($id);
        if($task_notes)
        {
            $task_notes->delete();
            $token = $task_notes->createToken('auth_token')->plainTextToken;
            return response()->json([
                'status'=> 200,
                'message'=>'Notes deleted successfully',
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        }
        else
        {
            return response()->json([
                'status'=> 404,
                'message' => 'No notes found',
            ]);
        }
    }
}

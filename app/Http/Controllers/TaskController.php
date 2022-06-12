<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskNotes;
use App\Models\NotesAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    public function index()
    {
        // $tasks = Task::all();notes_attachments 
        $tasks = Task::withCount('task_notes')->orderBy('task_notes_count', 'DESC')->orderByRaw("FIELD(priority,'High','Medium','Low')")->with('task_notes')->get();
        return response()->json([
            'status'=> 200,
            'tasks'=>$tasks,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'subject'=>'required|max:191',
            'description'=>'required',
            'start_date'=>'required|date_format:Y-m-d H:i:s',
            'end_date'=>'required|date_format:Y-m-d H:i:s|after:start_date',
            'status'=>'required',
            'priority'=>'required',
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
            $tasks = new Task;
            $tasks->subject = $request->input('subject');
            $tasks->description = $request->input('description');
            $tasks->start_date = $request->input('start_date');
            $tasks->end_date = $request->input('end_date');
            $tasks->status = $request->input('status');
            $tasks->priority = $request->input('priority');
            $tasks->save();
			$tasks->id;
			
            foreach($request->input('notes') as $data){
                $taskNotes = new TaskNotes;
                $taskNotes->task_id = $tasks->id;
                $taskNotes->subject = $data['subject'];
                $taskNotes->notes = $data['notes'];
                $taskNotes->save();
                $taskNotes->id;

                $allowedfileExtension=['pdf','jpg','png'];
                $files = $data['attachment'];
                // $files = $request->file($data['attachment']);
				
				foreach ($files as $file) {   
                    $url = $file;
                    $contents = file_get_contents($url);
                    $name = substr($url, strrpos($url, '/') + 1);
                    Storage::put($name, $contents);
                    
                    $save = new NotesAttachment();
                    $save->notes_id = $taskNotes->id;;
                    $save->title = $name;
                    $save->path = '';
                    $save->save();
				}
            }

            $token = $tasks->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status'=> 200,
                'message'=>'Task added successfully',
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        }

    }

}

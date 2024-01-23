<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\Note;
use App\Http\Requests\NoteRequest;

class NoteController extends Controller
{
    public function index(Request $request)
    {
        $notes = Note::select('id', 'ref_no', 'name', 'message', 'received_by', 'message_for','created_at');
        if ($request->ajax()) {
            return Datatables::of($notes)
                ->addIndexColumn()
                ->addColumn('message', function($row){
                    return \Str::limit($row->message, 20, '...');
                })
                ->addColumn('action', function($row){
                    $btn = '
                    <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" title="Delete" class="btn btn-sm btn-danger del deleteButton">Delete </a>';
                    return $btn;
                })
                ->addColumn('created_at', function($row){
                    if(! $row->created_at){
                        return '';
                    }
                    else
                    {
                        return $row->created_at->diffForHumans();
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('note.index', compact('notes'));
    }
    public function store(NoteRequest $request)
    {
        Note::create([
            'ref_no' => $request->refNo,
            'name' => auth()->user()->username,
            'message' => $request->msg,
            'received_by' => $request->receivedBy,
            'message_for' => $request->msgFor,
        ]);

        return response()->json([
            'message' => 'Note saved successfully.'
        ], 201);
    }
    public function destroy($id)
    {
        $note = Note::find($id);
        if(! $note) {
            return response()->json([
                'error' => 'Note not found, Please refresh the web page.'
            ], 404);
        }
        $note->delete();

        return response()->json([
            'message' => 'Note deleted successfully.'
        ], 201);

    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'notes' => Auth::user()->notes
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedNote = $request->validate([
            'title' => ['required', 'string'],
            'content' => ['required', 'string']
        ]);
        $validatedNote['user_id'] = Auth::user()->id;

        $savedNote = Note::create($validatedNote);
        return response()->json([
            'status' => 'success',
            'message' => 'Note added',
            'note' => $savedNote
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        if (Auth::user()->id !== $note->user_id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized!'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'note' => $note
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note)
    {
        if (Auth::user()->id !== $note->user_id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized!'
            ]);
        }


        $validatedNote = $request->validate([
            'title' => ['required', 'string'],
            'content' => ['required', 'string'],
        ]);

        $updated = $note->update($validatedNote); //returns true if updated successfully, or you could've just used ->save() to update too
        if (!$updated) {
            return response()->json([
                'status' => 'error',
                'message' => 'Update failed'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Note updated',
            'note' => $note->fresh() //get the fresh version of this note
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        if (Auth::user()->id !== $note->user_id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized!'
            ]);
        }
        $note->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Note deleted',
            'note' => $note, //the note instance still exists in php for now and will be gone after this controller method finishes, but in db its gone
        ], 201);
    }
}

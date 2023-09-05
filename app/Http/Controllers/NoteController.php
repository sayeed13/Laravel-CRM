<?php

namespace App\Http\Controllers;

use App\Exports\NotesExport;
use App\Models\Lead;
use App\Models\Note;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class NoteController extends Controller
{
    /**
     * Export filterable Notes
     */
    public function exportNotes(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        return Excel::download(new NotesExport($startDate, $endDate), 'notes_export.xlsx');
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leads = Lead::with(['notes' => function ($query) {
                            return $query->select('lead_id', 'text')->latest();
                        }, 'agent'])
                        ->latest()
                        ->paginate(50);
                        
        return view('note.note-list', compact('leads'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Note $note)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        //
    }
}

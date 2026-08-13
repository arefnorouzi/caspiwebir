<?php

namespace App\Http\Controllers;

use App\Http\Requests\Ticket\TicketStatusRequest;
use App\Models\SubTicket;
use App\Models\Ticket;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\TicketStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Inertia\Response
    {
        try {
            $model = new Ticket;
            $models = $model->all_items(search_text: $request->search ?? '');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $models = [];
        }
        $statuses = TicketStatus::get(['id', 'name']);
        return Inertia::render('admin/ticket/Index', [
            'models' => $models, 'search_text' => $request->search ?? '', 'statuses' => $statuses]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Inertia\Response
    {
        return Inertia::render('admin/ticket/Create', []);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request): \Illuminate\Http\RedirectResponse
    {
        try {
            $validated = $request->validated();
            Ticket::create($validated);
            Inertia::flash(['message' => config('messages.created')]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Inertia::flash(['message' => config('messages.error')]);
            return to_route('admin.ticket.index')->withErrors($e->getMessage());
        }
        return to_route('admin.ticket.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        $ticket->load(['user', 'sub_tickets', 'status']);
        $statuses = TicketStatus::get(['id', 'name']);
        return Inertia::render("admin/ticket/Show", [
            'ticket' => $ticket, 'statuses' => $statuses
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket): \Inertia\Response
    {
        return Inertia::render('admin/ticket/Edit', ['model' => $ticket]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket): \Illuminate\Http\RedirectResponse
    {
        DB::beginTransaction();
        try {
            $description = str_replace(PHP_EOL,"<br>", $request['description']);
            $ticket->sub_tickets()->create([
                'description' =>  $description,
                'user_id' => auth()->id(),
                'ticket_id' => $ticket->id
            ]);
            $ticket->status_id = 4;
            $ticket->update();
            DB::commit();

        }
        catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return back()->withErrors($e->getMessage())->with('error',config('messages.error') );
        }
        return back()->with('message',  config('messages.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket): \Illuminate\Http\RedirectResponse
    {
        $ticket->delete();
        Inertia::flash(['message' => config('messages.deleted')]);
        return back();
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(Ticket $ticket): \Illuminate\Http\RedirectResponse
    {
        $ticket->restore();
        Inertia::flash(['message' => config('messages.restored')]);
        return back();
    }

    /**
     * Force Delete the specified resource from storage.
     */
    public function force_delete(Ticket $ticket): \Illuminate\Http\RedirectResponse
    {
        $ticket->forceDelete();
        Inertia::flash(['message' => config('messages.deleted')]);
        return back();
    }

    public function toggle_status(TicketStatusRequest $request, Ticket $ticket): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validated();
        $ticket->status_id = $validated['status_id'];
        $ticket->update();
        return back()->with(['message' => 'وضعیت درخواست تغییر کرد']);
    }
}

<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ticket\ReplyTicketRequest;
use App\Http\Requests\Ticket\StoreTicketRequest;
use App\Models\Department;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class UserTicketController extends Controller
{
    public function index()
    {
        try {
            $tickets = Ticket::where('user_id', auth()->id())
                ->with(['status', 'department'])
                ->orderby('updated_at', 'desc')
                ->paginate(10, [
                    'id', 'title', 'status_id', 'department_id', 'created_at', 'updated_at'
                ]);
        }
        catch (\Exception $e) {
            Log::error($e->getMessage());
            $tickets = [];
        }
        return Inertia::render('dashboard/ticket/Index', ['models' => $tickets]);
    }

    public function create()
    {
        $departments = Department::where('status', 1)->get(['id', 'name']);
        return Inertia::render('dashboard/ticket/Create', ['departments' => $departments]);

    }

    public function show(Ticket $ticket)
    {
        if ($ticket->user_id != auth()->id())
        {
            return redirect()->route('dashboard.ticket.index');
        }
        $ticket->load(['sub_tickets', 'status']);
        return Inertia::render('dashboard/ticket/Show', ['ticket' => $ticket]);
    }

    public function store(StoreTicketRequest $request)
    {
        $request = $request->validated();
        try {
            $open_tickets_count = Ticket::where('user_id', auth()->id())->where('status_id', '<', 5)->count();
            if ($open_tickets_count > 3)
            {
                return response()->json(['message' => "شما $open_tickets_count درخواست باز دارید. در حال حاضر امکان ارسال درخواست جدید برای شما وجود ندارد."], 400);
            }
            $ticket = Ticket::create([
                'user_id' => auth()->id(),
                'status_id' => 1,
                'department_id' => $request['department_id'],
                'title' => $request['title'],
                'description' => str_replace(PHP_EOL,"<br>", $request['description']),
                'secret_message' => $request['secret_message'] ?? null,
                'level' => $request['level']
            ]);


            return response()->json(['ticket_id' => $ticket->id], 201);

        }
        catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'خطایی در ارسال درخواست پشتیبانی رخ داد'], 400);
        }
    }

    public function update(ReplyTicketRequest $request, Ticket $ticket)
    {
        $request = $request->validated();
        if ($ticket->user_id != auth()->id())
        {
            return response()->json(['message' => 'درخواست نامعتبر'], 403);
        }
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

            return response()->json(status: 201);

        }
        catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return response()->json(['message' => 'اطلاعات وارد شده نامعتبر است.'], 400);
        }
    }
}

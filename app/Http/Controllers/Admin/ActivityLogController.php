<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::query();

        // search
        if ($search = $request->q) {

            $query->where(function ($q) use ($search) {

                $q->where('user_name', 'like', "%{$search}%")
                  ->orWhere('user_email', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");

            });
        }

        // action filter
        if ($action = $request->action) {

            $query->where('action', $action);

        }

        // from date
        if ($from = $request->from) {

            $query->whereDate('created_at', '>=', $from);

        }

        // to date
        if ($to = $request->to) {

            $query->whereDate('created_at', '<=', $to);

        }

        $logs = $query
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view(
            'admin.activity-logs.index',
            compact(
                'logs',
                'search',
                'action',
                'from',
                'to'
            )
        );
    }
}
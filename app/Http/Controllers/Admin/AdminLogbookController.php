<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Logbook;
use Illuminate\Http\Request;

class AdminLogbookController extends Controller
{
    public function index(Request $request)
    {
        $query = Logbook::with('intern');

        if ($request->filled('q')) {
            $q = '%' . $request->input('q') . '%';
            $query->whereHas('intern', function ($sub) use ($q) {
                $sub->where('name', 'like', $q)->orWhere('institution', 'like', $q);
            });
        }
        if ($request->filled('date_from')) {
            $query->whereDate('date', '>=', $request->date('date_from'));
        }
        if ($request->filled('date_to')) {
            $query->whereDate('date', '<=', $request->date('date_to'));
        }

        $logbooks = $query->orderByDesc('date')->paginate(20)->withQueryString();

        return view('admin.logbook.index', compact('logbooks'));
    }
}



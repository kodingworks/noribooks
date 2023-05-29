<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('admin/dashboard/index', [
            "title" => 'Accounting | Dashboard'
        ]);
    }
}

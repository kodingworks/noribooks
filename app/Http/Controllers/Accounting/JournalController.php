<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class Journal extends Controller
{
    public function index() {
        return Inertia::render('admin/accounting/journal/index', [
            "title" => 'Accounting | Journal'
        ]);
    }
}

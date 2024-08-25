<?php

namespace App\Controllers;

use App\Models\MustahikModel;
use App\Models\CalonMustahikModel;

class DashboardController extends BaseController
{
    public function index(): string
    {
        $data = [
            'title' => 'Dashboard',
            'active_menu' => 'dashboard',
            'active_submenu' => '',
        ];
        return view('dashboard/index', $data);
    }
}

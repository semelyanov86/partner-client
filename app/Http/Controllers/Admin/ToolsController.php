<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class ToolsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('tool_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.tools.index');
    }

    public function maintenanceDown()
    {
        \Illuminate\Support\Facades\Artisan::call('down');

        return redirect()->route('admin.tools.index')->withMessage('Личный кабинет заблокирован');
    }

    public function maintenanceUp()
    {
        \Illuminate\Support\Facades\Artisan::call('up');

        return redirect()->route('admin.tools.index')->withMessage('Личный кабинет разблокирован');
    }

    public function clearCache()
    {
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        \Illuminate\Support\Facades\Artisan::call('config:clear');

        return redirect()->route('admin.tools.index')->withMessage('Кэш очищен');
    }
}

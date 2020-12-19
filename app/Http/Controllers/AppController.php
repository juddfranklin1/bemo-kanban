<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Spatie\DbDumper\Databases\PostgreSql;

class AppController extends Controller
{
    public function index (Request $request) {
        return view('index');
    }

    public function dbDump (Request $request) {
        $now = Carbon::now()->toDateTimeLocalString();
        $filePath = Str::kebab(config('app.name')) . $now . '.sql';
        PostgreSql::create()
            ->setDbName(config('database.connections.pgsql.database'))
            ->setUserName(config('database.connections.pgsql.username'))
            ->setPassword(config('database.connections.pgsql.password'))
            ->setHost(config('database.connections.pgsql.host'))
            ->dumpToFile($filePath);

        return response()->download($filePath);
    }
}

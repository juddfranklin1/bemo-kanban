<?php

namespace App\Http\Controllers;

use App\Models\Column;
use Illuminate\Http\Request;

class ColumnController extends Controller
{
    public function index(Request $request) {
        return Column::all()->loadMissing('cards');
    }

    public function store(Request $request) {
        $column = new Column();
        $column->title = $request->title;
        $column->save();

        return $column;
    }

    public function show(Request $request, $column) {
        return Column::where('id',$column)->first();
    }

    public function destroy($column)
    {
        $columnItem = Column::find($column);
        $columnItem->delete();
        return $column;
    }

    public function update(Request $request, $column) {
        $columnItem = Column::findOrFail($column);
        $columnItem->title = $request->title;
        $columnItem->save();
        return $column;
    }
}

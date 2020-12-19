<?php

namespace App\Http\Controllers;

use App\Models\Column;
use Illuminate\Http\Request;

class ColumnController extends Controller
{
    public function index(Request $request) {
        // Load all columns with cards and nested column data for ease of moving cards
        $cols = Column::with('cards.column')->orderBy('sort_order')->get();
        $cols->each(function($col) use ($request) {
            $this->show($request, $col->id);
        });
        $updatedCols = Column::with('cards.column')->orderBy('sort_order')->get();
        return $updatedCols;
    }

    public function store(Request $request) {
        $column = new Column();
        $column->title = $request->title;
        $column->sort_order = count(Column::all());
        $column->save();

        return $column;
    }

    public function show(Request $request, $column) {
        $col = Column::with('cards.column')->firstWhere('id',$column);
        $col->cards->each(function($card, $index) {// Clean up sort order
            $card->sort_order = $index;
            $card->save();
        });
        $updatedCol = Column::with('cards.column')->firstWhere('id',$column);

        return $updatedCol;
    }

    public function destroy($column)
    {
        $columnItem = Column::find($column);
        $columnItem->cards()->delete();
        $columnItem->delete();
        $columns = Column::all();
        $columns->each(function($col, $index) {
            $col->sort_order = $index;
            $col->save();
        });
        return $column;
    }

    public function update(Request $request, $column) {
        $columnItem = Column::findOrFail($column);
        $columnItem->title = $request->title;
        $columnItem->save();
        return $column;
    }
}

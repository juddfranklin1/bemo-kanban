<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Column;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function index(Request $request) {
        return Card::all()->with('column');
    }

    public function store(Request $request) {
        $col = Column::firstWhere('id', $request->column_id);
        $card = new Card();
        $card->title = $request->title;
        $card->content = $request->content;
        $card->column_id = $request->column_id;
        $card->sort_order = 0;
        $col->cards->each(function($colCard){
            $colCard->sort_order = $colCard->sort_order + 1;
            $colCard->save();
        });
        $card->save();

        return $card->loadMissing('column');
    }

    public function show(Request $request, $card) {
        return Card::with('column')->findOrFail($card)->first();
    }

    public function destroy($card)
    {
        $cardItem = Card::find($card);
        $cardItem->delete();
        return $card;
    }

    public function update(Request $request, $card) {
        $cardItem = Card::with('column')->findOrFail($card);
        $cardItem->title = $request->title;
        $cardItem->content = $request->content;
        $cardItem->column_id = $request->column_id;
        $cardItem->sort_order = $request->sort_order;
        $cardItem->save();
        return $cardItem;
    }
}

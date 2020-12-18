<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function index(Request $request) {
        return Card::all();
    }

    public function store(Request $request) {
        $card = new Card();
        $card->title = $request->title;
        $card->content = $request->content;
        $card->column_id = $request->column_id;
        $card->save();

        return $card;
    }

    public function show(Request $request, $card) {
        return Card::where('id',$id)->first();
    }

    public function destroy($card)
    {
        $cardItem = Card::find($card);
        $cardItem->delete();
        return $card;
    }

    public function update(Request $request, $card) {
        $cardItem = Card::findOrFail($card);
        $cardItem->title = $request->title;
        $cardItem->content = $request->content;
        $cardItem->column_id = $request->column_id;
        $cardItem->save();
        return $card;
    }
}

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
        $prevSortOrder = $cardItem->sort_order;
        $cardItem->title = $request->title;
        $cardItem->content = $request->content;
        $cardItem->column_id = $request->column_id;
        $cardItem->sort_order = $request->sort_order;
        $cardItem->save();
        $updatedCardItem = Card::with('column.cards')->findOrFail($card);
        $colCards = $updatedCardItem->column->cards;

        // Update Sort Order
        $colCards->each(function($colCard) use ($updatedCardItem, $prevSortOrder, $colCards) {
            if($colCard->id !== $updatedCardItem->id) {
                if($updatedCardItem->sort_order === $colCard->sort_order) {// Need to change the sort order
                    $newSortOrder = $prevSortOrder !== $colCard->sort_order ? $prevSortOrder : count($colCards) - 1;
                    $colCard->sort_order = $newSortOrder;
                    $colCard->save();
                }
            }
        });

        return $cardItem;
    }
}

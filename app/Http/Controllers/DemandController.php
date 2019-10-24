<?php

namespace App\Http\Controllers;

use App\Models\Demand;
use App\Models\DemandItem;
use App\Models\DemandList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DemandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $page = "request";
        $items = DemandItem::all();
        return view('demand.list', compact(['page', 'items']));
    }

    public function getDemandTable()
    {
        $role = Auth::user()->role_id;
        $demands = Demand::with(['demand_list.demand_item', 'creator']);
        if ($role === 2) { // manager
            $demands = $demands->where('status', 0);
        } else if ($role === 3) { // dirut
            $demands = $demands->where('status', 1);
        }
        $demands = $demands->get();
        $demandHistories = Demand::with(['demand_list.demand_item', 'creator'])->where('status','>',1)->get();
        return view('demand.table', compact(['demands', 'demandHistories']));
    }

    public function getItemTable()
    {
        $demand_items = DemandItem::all();
        $demand_item_used = DemandList::select('demand_item_id')->groupBy('demand_item_id')->get();
        $item_used = [];
        foreach ($demand_item_used as $item) {
            array_push($item_used, $item->demand_item_id);
        }
        return view('demand.table-item', compact(['demand_items', 'item_used']));
    }

    public function createItem(Request $request)
    {
        $itemCreated = DemandItem::create([
            'name' => $request->input('name'),
            'desc' => $request->input('desc')
        ]);
        return response()->json([
            "message" => "success",
            "data" => $itemCreated
        ]);
    }

    public function getItemData(Request $request)
    {
        $item = DemandItem::find($request->input('id'));
        return response()->json([
            "message" => "success",
            "data" => $item
        ]);
    }

    public function editItem(Request $request)
    {
        $item = DemandItem::find($request->input('id'));
        $item->name = $request->input('name');
        $item->desc = $request->input('desc');
        $item->save();
        return response()->json([
            "message" => "success",
            "data" => $item
        ]);
    }

    public function deleteItem(Request $request)
    {
        $item = DemandItem::find($request->input('id'));
        $item->delete();
        return response()->json([
            "message" => "success",
            "data" => $item
        ]);
    }

    public function createDemand(Request $request) {
        $demandCreated = Demand::create([
            'ppn' => $request->input('ppn'),
            'materai' => $request->input('materai'),
            'note' => $request->input('note'),
            'created_by' => Auth::user()->id
        ]);
        $id = $demandCreated->id;
        $demandItemCreated = DemandList::create([
            'demand_id' => $id,
            'demand_item_id' => $request->input('item'),
            'price' => $request->input('price'),
            'quantity' => $request->input('quantity'),
        ]);
        $demand = Demand::with(['demand_list'])->get();
        return response()->json([
            "message" => "success",
            "data" => $demand
        ]);
    }
}

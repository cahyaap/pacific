<?php

namespace App\Http\Controllers;

use App\Models\Demand;
use App\Models\DemandItem;
use App\Models\DemandList;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App;

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
        // if ($role === 2) { // manager
        //     $demands = $demands->where('status', 0);
        // } else if ($role === 3) { // dirut
        //     $demands = $demands->where('status', 1);
        // }
        $demands = $demands->orderBy('id', 'desc')->get();
        $demandHistories = Demand::with(['demand_list.demand_item', 'creator'])->where('status','>',1)->get();
        $demandTotals = DemandList::groupBy('demand_id')->selectRaw('SUM(price*quantity) as total, demand_id')->get();
        $totals = [];
        foreach ($demandTotals as $demandTotal) {
            $totals[$demandTotal->demand_id] = $demandTotal->total;
        }
        return view('demand.table', compact(['demands', 'demandHistories', 'totals']));
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

    public function getDemandData(Request $request) {
        $demand = Demand::with(['demand_list.demand_item', 'creator'])->where('id', $request->input('id'))->get();
        return response()->json([
            "message" => "success",
            "data" => $demand
        ]);
    }

    public function editDemand(Request $request) {
        $demand = Demand::find($request->input('id'));
        $demand->ppn = $request->input('ppn');
        $demand->materai = $request->input('materai');
        $demand->note = $request->input('note');
        $demand->created_by = Auth::user()->id;
        $demand->save();

        $demandList = DemandList::where('demand_id', $request->input('id'))->update([
            'demand_item_id' => $request->input('item'),
            'price' => $request->input('price'),
            'quantity' => $request->input('quantity')
        ]);

        return response()->json([
            "message" => "success",
            "demandUpdated" => $demand,
            "demandListUpdated" => $demandList
        ]);
    }

    public function deleteDemand(Request $request)
    {
        $demand = Demand::find($request->input('id'))->delete();
        DemandList::where('demand_id', $request->input('id'))->delete();
        return response()->json([
            "message" => "success",
            "data" => $demand
        ]);
    }

    public function approveOrReject(Request $request) {
        $approveOrReject = $request->input('approveOrReject');
        $demand = Demand::find($request->input('id'));
        $status = $demand->status;
        if ($approveOrReject === "approve"){
            $demand->status = $status + 1;
        } else {
            $demand->status = 9;
        }
        $demand->updated_at = now();
        $demand->save();
        if ($demand->status === 2) {
            Payment::create([
                "demand_id" => $demand->id
            ]);
        }
        return response()->json([
            "message" => "success",
            "data" => $demand
        ]);
    }

    public function printDemand($id) {
        $demand = Demand::with(['demand_list.demand_item', 'creator'])->where('id', $id)->get();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('demand.print', compact(['demand']));
        return $pdf->stream();
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\WorldcraftStock;
use App\PickupPoint;
use App\Product;

class WorldcraftStockController extends Controller
{
    public function get_stocks(Request $request) {
      
        $pick_up_points = PickupPoint::where('pick_up_status', 1)
            ->with(['stock' => function ($query) use ($request) {
                $query->where('sku_id', $request->sku);
            }])
            ->orderBy('name', 'asc')
            ->get()->map(function ($query) {
                if ($query->stock != null) {
                    $stock_quantity = max($query->stock->quantity, 0);
                    $query->stock->quantity = $stock_quantity;
                }
                
                return $query;
            });
           
        $stocklist = [
            'list' => $pick_up_points
        ];
        
       

        return $stocklist;
    }
}

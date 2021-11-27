<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        return Inertia::render('Orders/Index', [
            //that should give orders, and count
            'orders' => auth()->user()->orders()
                ->with('product:id,name', 'inventory:id,sku')
                ->search($request->search)
                ->paginate(),
            'stats' => auth()->user()->orders()
                    ->search($request->search)
                    ->toBase()
                    ->selectRaw("sum(total_cents) as total_sales_sum")
                    ->selectRaw("avg(total_cents) as avg_sales_sum")
                    ->first(),
            // return the search back, so we have it for the textfield
            'filters' => $request->only('search')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $this->authorize('view', $order);

        return Inertia::render('Orders/Show', [
            'order' => $order
            ->load('product:id,name,brand', 'inventory:id,sku,color,size')
        ]);
    }

    /**
     * Display a breakdown of orders per state.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function breakdown(Request $request)
    {

        return Inertia::render('Orders/Breakdown', [
            'breakdown' => auth()->user()->orders()
                    ->toBase()
                    ->select('state')
                    ->selectRaw("count(case when order_status = 'Fulfulled' then 1 end) as fulfulled")
                    ->selectRaw("count(case when order_status = 'Shipped' then 1 end) as shipped")
                    ->selectRaw("count(case when order_status = 'Paid' then 1 end) as paid")
                    ->selectRaw("count(case when order_status = 'Open' then 1 end) as open")
                    ->selectRaw("count(case when order_status = 'Pending' then 1 end) as pending")
                    ->groupBy('state')
                    ->orderBy('state', 'ASC')
                    ->paginate()
        ]);
    }
}

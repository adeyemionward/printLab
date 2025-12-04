<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\InventoryCategory;
use App\Models\InventoryItem;
use App\Models\StockLog;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    public function list()
    {
        try {
            $items = InventoryItem::with('category')->where('user_id',Auth::id())->get();
            $suppliers = Supplier::where('company_id', app('company_id'))->get();
            $users = User::where('company_id', app('company_id'))->where('user_type',User::COMPANY)->get();

            return view('company.inventory.list', compact('items','suppliers','users'));
        } catch (\Exception $e) {
            return back()->with('flash_error', 'Failed to fetch inventory: ' . $e->getMessage());
        }
    }

    public function create()
    {
          $inventoryCategories =  InventoryCategory::where('company_id', app('company_id'))->get();
        //   dd($categories);
        return view('company.inventory.add', compact('inventoryCategories'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'item_name' => 'required|string|max:255|unique:inventory_items,item_name',
                'unit' => 'nullable|string|max:50',
                'min_stock' => 'nullable|integer|min:0',
                'description' => 'nullable|string',
            ]);

            $item = new InventoryItem();
            $item->user_id = Auth::id();
            $item->item_name = $request->item_name;
            $item->unit = $request->unit;
            $item->min_stock = $request->min_stock ?? 0;
            $item->description = $request->description;
            $item->current_stock = 0;
            $item->inventory_category_id = $request->inventory_category_id;
            $item->save();

            return redirect()->route('company.inventory.list')
                             ->with('flash_success', 'Inventory item created successfully.');
        } catch (\Exception $e) {
            return back()->with('flash_error', 'Failed to create inventory item: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $item = InventoryItem::findOrFail($id);

            $request->validate([
                'item_name' => 'required|string|max:255|unique:inventory_items,item_name,'.$item->id,
                'unit' => 'nullable|string|max:50',
                'min_stock' => 'nullable|integer|min:0',
                'description' => 'nullable|string',
            ]);

            $item->item_name = $request->item_name;
            $item->unit = $request->unit;
            $item->min_stock = $request->min_stock ?? $item->min_stock;
            $item->description = $request->description;
            $item->save();

            return back()->with('flash_success', 'Inventory item updated successfully.');
        } catch (\Exception $e) {
            return back()->with('flash_error', 'Failed to update inventory item: ' . $e->getMessage());
        }
    }

    public function addStock(Request $request, $id)
    {
        try {
            $item = InventoryItem::findOrFail($id);

            $request->validate([
                'quantity' => 'required|integer|min:1',
                'note' => 'nullable|string',
            ]);

            $previousStock = $item->current_stock;
            $qtyChange = $request->quantity;

            $item->current_stock += $qtyChange;
            $item->save();

            StockLog::create([
                'item_id' => $item->id,
                'user_id' => Auth::id(),
                'supplier_id' => $request->supplier_id,
                'previous_stock' => $previousStock,
                'qty_change' => $qtyChange,
                'current_stock' => $item->current_stock,
                'type' => 'IN',
                'note' => $request->note,
            ]);

            return back()->with('flash_success', 'Stock added successfully.');
        } catch (\Exception $e) {
            return back()->with('flash_error', 'Failed to add stock: ' . $e->getMessage());
        }
    }

    public function removeStock(Request $request, $id)
    {
        try {
            $item = InventoryItem::findOrFail($id);

            $request->validate([
                'quantity' => 'required|integer|min:1|max:'.$item->current_stock,
                'note' => 'nullable|string',
            ]);

            $previousStock = $item->current_stock;
            $qtyChange = $request->quantity;

            $item->current_stock -= $qtyChange;
            $item->save();

            StockLog::create([
                'item_id' => $item->id,
                'user_id' => Auth::id(),
                'receiver_id' => $request->receiver_id, //staff receiver
                'previous_stock' => $previousStock,
                'qty_change' => $qtyChange,
                'current_stock' => $item->current_stock,
                'type' => 'OUT',
                'note' => $request->note,
            ]);

            return back()->with('flash_success', 'Stock removed successfully.');
        } catch (\Exception $e) {
            return back()->with('flash_error', 'Failed to remove stock: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $item = InventoryItem::findOrFail($id);
            $item->delete();

            return back()->with('flash_success', 'Inventory item deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('flash_error', 'Failed to delete inventory item: ' . $e->getMessage());
        }
    }

    public function logs($id)
    {
        try {
            $item = InventoryItem::findOrFail($id);
            $logs = StockLog::where('item_id', $item->id)->orderBy('created_at', 'desc')->get();

            return view('company.inventory.logs', compact('item', 'logs'));
        } catch (\Exception $e) {
            return back()->with('flash_error', 'Failed to fetch stock logs: ' . $e->getMessage());
        }
    }
}

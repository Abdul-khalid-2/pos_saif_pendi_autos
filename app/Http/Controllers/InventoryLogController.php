<?php

namespace App\Http\Controllers;

use App\Models\InventoryLog;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Branch;
use Illuminate\Http\Request;

class InventoryLogController extends Controller
{
    public function index()
    {
        $logs = InventoryLog::with(['product', 'variant', 'branch', 'user'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->sortByDesc('created_at');

        return view('admin.inventory.index', compact('logs'));
    }

    public function create()
    {
        $products = Product::where('track_inventory', true)->get();
        $branches = Branch::all();

        return view('admin.inventory.create', compact('products', 'branches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'required|exists:product_variants,id',
            'branch_id' => 'required|exists:branches,id',
            'quantity_change' => 'required|integer',
            'reference_type' => 'required|string|max:50',
            'reference_id' => 'nullable|integer',
            'notes' => 'nullable|string',
        ]);

        // Get current stock
        $variant = ProductVariant::findOrFail($validated['variant_id']);
        $newQuantity = $variant->current_stock + $validated['quantity_change'];

        // Create log
        $log = InventoryLog::create([
            'tenant_id' => auth()->user()->tenant_id,
            'product_id' => $validated['product_id'],
            'variant_id' => $validated['variant_id'],
            'branch_id' => $validated['branch_id'],
            'quantity_change' => $validated['quantity_change'],
            'new_quantity' => $newQuantity,
            'reference_type' => $validated['reference_type'],
            'reference_id' => $validated['reference_id'],
            'notes' => $validated['notes'],
            'user_id' => auth()->id(),
        ]);

        // Update variant stock
        $variant->update(['current_stock' => $newQuantity]);

        return redirect()->route('inventory-logs.index')
            ->with('success', 'Inventory adjustment logged successfully.');
    }

    public function destroy(InventoryLog $inventoryLog)
    {
        // Check if this log can be deleted (e.g., not from a purchase/sale)
        if ($inventoryLog->reference_type !== 'manual') {
            return redirect()->route('inventory-logs.index')
                ->with('error', 'Only manual adjustments can be deleted.');
        }

        // Reverse the stock change
        $variant = ProductVariant::find($inventoryLog->variant_id);
        if ($variant) {
            $variant->update([
                'current_stock' => $variant->current_stock - $inventoryLog->quantity_change
            ]);
        }

        $inventoryLog->delete();

        return redirect()->route('inventory-logs.index')
            ->with('success', 'Inventory log deleted successfully.');
    }

    // AJAX method to get variants for a product
    public function getVariants(Product $product)
    {
        return response()->json($product->variants);
    }

    // In InventoryLogController.php or create a new StockAlertController.php
    public function lowStockAlerts()
    {
        $tenantId = auth()->user()->tenant_id;

        // Get variants that are below reorder level
        $lowStockVariants = ProductVariant::with(['product.category', 'product.supplier'])
            ->whereHas('product', function ($query) use ($tenantId) {
                $query->where('tenant_id', $tenantId)
                    ->where('track_inventory', true);
            })
            ->whereColumn('current_stock', '<=', \DB::raw('products.reorder_level'))
            ->join('products', 'product_variants.product_id', '=', 'products.id')
            ->select('product_variants.*', 'products.reorder_level', 'products.name as product_name')
            ->orderBy('current_stock')
            ->paginate(20);

        // Get out of stock items
        $outOfStockVariants = ProductVariant::with(['product.category', 'product.supplier'])
            ->whereHas('product', function ($query) use ($tenantId) {
                $query->where('tenant_id', $tenantId)
                    ->where('track_inventory', true);
            })
            ->where('current_stock', '<=', 0)
            ->paginate(20);

        // Get summary statistics
        $summary = [
            'total_low_stock' => ProductVariant::whereHas('product', function ($query) use ($tenantId) {
                $query->where('tenant_id', $tenantId)
                    ->where('track_inventory', true);
            })
                ->whereColumn('current_stock', '<=', \DB::raw('products.reorder_level'))
                ->join('products', 'product_variants.product_id', '=', 'products.id')
                ->count(),

            'total_out_of_stock' => ProductVariant::whereHas('product', function ($query) use ($tenantId) {
                $query->where('tenant_id', $tenantId)
                    ->where('track_inventory', true);
            })
                ->where('current_stock', '<=', 0)
                ->count(),

            'total_products_tracking' => Product::where('tenant_id', $tenantId)
                ->where('track_inventory', true)
                ->count(),
        ];

        return view('admin.inventory.low-stock-alerts', compact(
            'lowStockVariants',
            'outOfStockVariants',
            'summary'
        ));
    }

    // Optional: Create a JSON API endpoint for dashboard widgets
    public function lowStockCount()
    {
        $tenantId = auth()->user()->tenant_id;

        $count = ProductVariant::whereHas('product', function ($query) use ($tenantId) {
            $query->where('tenant_id', $tenantId)
                ->where('track_inventory', true);
        })
            ->whereColumn('current_stock', '<=', \DB::raw('products.reorder_level'))
            ->join('products', 'product_variants.product_id', '=', 'products.id')
            ->count();

        return response()->json([
            'count' => $count,
            'message' => $count . ' items need attention'
        ]);
    }
}

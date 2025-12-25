<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Customer;
use App\Models\Sale;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::withCount('sales')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.customer.index', compact('customers'));
    }

    public function create()
    {
        return view('admin.customer.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:customers,email',
            'phone' => 'required|string|max:20|unique:customers,phone',
            'address' => 'nullable|string',
            'tax_number' => 'nullable|string|max:50',
            'customer_group' => 'required|string|in:retail,wholesale,vip',
            'credit_limit' => 'nullable|numeric|min:0',
        ]);
        if ($request->filled('references_json')) {
            $validated['references'] = json_decode($request->references_json, true);
        }

        $validated['tenant_id'] = auth()->user()->tenant_id;
        $validated['balance'] = 0;

        Customer::create($validated);

        return redirect()->route('customers.index')
            ->with('success', 'Customer created successfully.');
    }

    public function show(Customer $customer)
    {
        // Get customer's recent sales
        $sales = Sale::with(['items.product', 'items.variant'])
            ->where('customer_id', $customer->id)
            ->orderBy('created_at', 'desc')
            // ->take(10)
            ->get();

        // Calculate total spent
        $totalSpent = Sale::where('customer_id', $customer->id)
            ->sum('total_amount');

        return view('admin.customer.show', compact('customer', 'sales', 'totalSpent'));
    }

    public function edit(Customer $customer)
    {
        return view('admin.customer.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:customers,email,' . $customer->id,
            'phone' => 'required|string|max:20|unique:customers,phone,' . $customer->id,
            'address' => 'nullable|string',
            'tax_number' => 'nullable|string|max:50',
            'customer_group' => 'required|string|in:retail,wholesale,vip',
            'credit_limit' => 'nullable|numeric|min:0',
            'balance_adjustment' => 'nullable|numeric|min:0',
            'balance_operation' => 'nullable|string|in:add,subtract,set',
        ]);
        if ($request->filled('references_json')) {
            $validated['references'] = json_decode($request->references_json, true);
        } else {
            $validated['references'] = [];
        }

        // Handle balance adjustment if provided
        if ($request->filled('balance_adjustment') && $request->filled('balance_operation')) {
            $amount = (float) $request->balance_adjustment;
            $operation = $request->balance_operation;

            switch ($operation) {
                case 'add':
                    $customer->balance += $amount;
                    break;
                case 'subtract':
                    $customer->balance -= $amount;
                    break;
                case 'set':
                    $customer->balance = $amount;
                    break;
            }
            // $customer->save();
        }

        // Update all other fields
        $customer->update($validated);

        return redirect()->route('customers.show', $customer->id)
            ->with('success', 'Customer updated successfully.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', 'Customer deleted successfully.');
    }


    public function invoice(Customer $customer)
    {
        // Get all sales for this customer
        $sales = Sale::where('customer_id', $customer->id)
            ->with(['items', 'payments'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate total spent
        $totalSpent = $sales->sum('total_amount');
        
        // Calculate total paid
        $totalPaid = $sales->sum('amount_paid');
        
        // Calculate total dues
        $totalDues = $totalSpent - $totalPaid;

        $business = Business::first();

        return view('admin.customer.invoice', compact('customer', 'sales', 'totalSpent', 'totalPaid', 'totalDues', 'business'));
    }

    public function downloadInvoice(Customer $customer)
    {
        // Get all sales for this customer
        $sales = Sale::where('customer_id', $customer->id)
                    ->with(['items', 'payments'])
                    ->orderBy('created_at', 'desc')
                    ->get();

        // Calculate totals
        $totalSpent = $sales->sum('total_amount');
        $totalPaid = $sales->sum('amount_paid');
        $totalDues = $totalSpent - $totalPaid;

        // Get business information
        $business = Business::first();
        $pdf = PDF::loadView('admin.customer.invoice-pdf', compact('customer',  'sales', 'totalSpent', 'totalPaid', 'totalDues', 'business'));
        
        return $pdf->download('invoice-'.$customer->id.'-'.now()->format('Ymd').'.pdf');
    }

    public function getReferences(Customer $customer)
    {
        $references = $customer->references ?? [];
        
        return response()->json([
            'references' => $references,
            'customer_name' => $customer->name
        ]);
    }

    public function referenceInvoice(Customer $customer, $reference = 'all', Request $request)
    {
        // Get date range from request
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));

        // Convert dates to Carbon instances
        $startDate = Carbon::parse($startDate)->startOfDay();
        $endDate = Carbon::parse($endDate)->endOfDay();

        // Get all sales for this customer within date range
        $query = Sale::where('customer_id', $customer->id)
                    ->whereBetween('sale_date', [$startDate, $endDate])
                    ->with(['items', 'payments']);
        
        // Filter by reference if not 'all'
        if ($reference !== 'all') {
            $query->whereHas('payments', function ($q) use ($reference) {
                $q->where('reference', $reference);
            });
        }
        
        $sales = $query->orderBy('created_at', 'desc')->get();

        // Calculate totals
        $totalSpent = $sales->sum('total_amount');
        $totalPaid = $sales->sum('amount_paid');
        $totalDues = $totalSpent - $totalPaid;
        
        // Calculate reference-specific totals if not 'all'
        if ($reference !== 'all') {
            $referenceSpent = $totalSpent;
            $referencePaid = $totalPaid;
            // $sales->sum(function($sale) use ($reference) {  // Fixed: Added use($reference)
            //     return $sale->payments->where('reference', $reference)->sum('amount');
            // });
            // $referenceDues = $referenceSpent - $referencePaid;
            $referenceDues = $referenceSpent - $totalPaid;
        } else {
            $referenceSpent = $totalSpent;
            $referencePaid = $totalPaid;
            $referenceDues = $totalDues;
        }

        $business = Business::first();

        // Remove dd('testing') and return the view
        return view('admin.customer.reference-invoice', compact(
            'customer', 
            'sales', 
            'totalSpent', 
            'totalPaid', 
            'totalDues',
            'business',
            'reference',
            'referenceSpent',
            'referencePaid',
            'referenceDues',
            'startDate',
            'endDate'
        ));
    }

    public function downloadReferenceInvoice(Customer $customer, $reference = 'all', Request $request)
    {
        // Get date range from request
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));

        // Convert dates to Carbon instances
        $startDate = Carbon::parse($startDate)->startOfDay();
        $endDate = Carbon::parse($endDate)->endOfDay();

        // Get all sales for this customer within date range
        $query = Sale::where('customer_id', $customer->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with(['items', 'payments']);

        // Filter by reference if not 'all'
        if ($reference !== 'all') {
            $query->whereHas('payments', function($q) use ($reference) {
                $q->where('reference', $reference);
            });
        }
        
        $sales = $query->orderBy('created_at', 'desc')->get();

        // Calculate totals
        $totalSpent = $sales->sum('total_amount');
        $totalPaid = $sales->sum('amount_paid');
        $totalDues = $totalSpent - $totalPaid;
        
        // Calculate reference-specific totals if not 'all'
        if ($reference !== 'all') {
            $referenceSpent = $totalSpent;
            $referencePaid = $totalPaid;
            // $sales->sum(function($sale) use ($reference) {
            //     return $sale->payments->where('reference', $reference)->sum('amount');
            // });
            // $referenceDues = $referenceSpent - $referencePaid;
            $referenceDues = $referenceSpent - $totalPaid;
        } else {
            $referenceSpent = $totalSpent;
            $referencePaid = $totalPaid;
            $referenceDues = $totalDues;
        }

        $business = Business::first();

        // Use the new PDF view for references
        $pdf = PDF::loadView('admin.customer.reference-invoice-pdf', compact(
            'customer', 
            'sales', 
            'totalSpent', 
            'totalPaid', 
            'totalDues',
            'business',
            'reference',
            'referenceSpent',
            'referencePaid',
            'referenceDues',
            'startDate',
            'endDate'
        ));

        // Create filename with dates
        $dateSuffix = $startDate->format('Ymd') . '-' . $endDate->format('Ymd');
        $filename = $reference === 'all'
            ? 'invoice-' . $customer->id . '-' . $dateSuffix . '.pdf'
            : 'invoice-' . $customer->id . '-' . Str::slug($reference) . '-' . $dateSuffix . '.pdf';
        
        return $pdf->download($filename);
    }
}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @if($reference !== 'all')
            {{ $reference }} Invoice - {{ $customer->name }}
        @else
            Customer Invoice - {{ $customer->name }}
        @endif
    </title>
    <style>
        /* Ultra Compact, PDF-friendly CSS */
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            line-height: 1.2;
            margin: 0;
            padding: 0;
            font-size: 10px;
        }
        
        .invoice-container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 5px;
        }
        
        /* Compact Header */
        .invoice-header {
            background: #4a90e2;
            color: white;
            padding: 10px 15px;
            text-align: center;
            margin-bottom: 10px;
        }
        
        .invoice-header h1 {
            font-size: 18px;
            font-weight: bold;
            margin: 0 0 3px 0;
            line-height: 1.1;
        }
        
        .invoice-header p {
            margin: 0;
            opacity: 0.9;
            font-size: 11px;
        }
        
        /* Main content */
        .invoice-body {
            padding: 10px;
        }
        
        .info-title {
            font-weight: bold;
            color: #4a90e2;
            margin-bottom: 6px;
            font-size: 12px;
            line-height: 1.1;
        }
        
        /* Utility classes */
        .text-success {
            color: #28a745;
        }
        
        .text-danger {
            color: #dc3545;
        }
        
        .text-center {
            text-align: center;
        }
        
        .mb-0 {
            margin-bottom: 0 !important;
        }
        
        .mb-1 {
            margin-bottom: 3px;
        }
        
        .mb-2 {
            margin-bottom: 6px;
        }
        
        .mb-3 {
            margin-bottom: 9px;
        }
        
        .mt-2 {
            margin-top: 6px;
        }
        
        .mt-3 {
            margin-top: 9px;
        }
        
        .mt-4 {
            margin-top: 12px;
        }
        
        .mt-5 {
            margin-top: 15px;
        }
        
        /* Print-specific styles */
        @media print {
            body {
                margin: 0;
                padding: 0;
                font-size: 9px;
            }
            
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="invoice-header">
            
                @if($reference !== 'all')
                    <h1>NEW PAK PINDI AUTOS</h1>
                    <h4>{{ strtoupper($reference) }}</h4>
                @else
                    <h1>NEW PAK PINDI AUTOS</h1>
                @endif
            
            <p>
                @if($reference !== 'all')
                    Summary of transactions for {{ $customer->name }} at {{ $reference }}
                @else
                    Summary of all transactions with {{ $customer->name }}
                @endif
            </p>
        </div>
        
        <!-- Main Content -->
        <div class="invoice-body">
            <!-- Company and Customer Info -->
            <div style="width: 100%; overflow: hidden; margin-bottom: 12px;">
                <!-- Business Information -->
                <div style="width: 48%; float: left;">
                    <div style="background: #f5f5f5; border-left: 3px solid #4a90e2; border-radius: 3px; padding: 8px;">
                        <div style="font-weight: bold; color: #4a90e2; margin-bottom: 6px; font-size: 11px; line-height: 1.1;">
                            Business Information
                        </div>
                        <div style="margin-bottom: 5px; font-size: 10px;">
                            <strong>{{ $business->name ?? 'Your Business Name' }}</strong>
                        </div>
                        <div style="margin-bottom: 3px; font-size: 9px;">{{ $business->address ?? '123 Business Street' }}</div>
                        <div style="margin-bottom: 3px; font-size: 9px;">Phone: {{ $business->phone ?? '123-456-7890' }}</div>
                        <div style="margin-bottom: 3px; font-size: 9px;">Email: {{ $business->email ?? 'business@example.com' }}</div>
                    </div>
                </div>
                
                <!-- Spacer -->
                <div style="width: 4%; float: left;"></div>
                
                <!-- Customer Information -->
                <div style="width: 48%; float: left;">
                    <div style="background: #e9f7fe; border-left: 3px solid #34c759; border-radius: 3px; padding: 8px;">
                        <div style="font-weight: bold; color: #34c759; margin-bottom: 6px; font-size: 11px; line-height: 1.1;">
                            @if($reference !== 'all')
                                Customer Information - {{ $reference }}
                            @else
                                Customer Information
                            @endif
                        </div>
                        <div style="margin-bottom: 5px; font-size: 10px;">
                            <strong>{{ $customer->name }}</strong>
                        </div>
                        @if($reference !== 'all')
                        <div style="margin-bottom: 3px; font-size: 9px;">
                            <strong>Location: {{ $reference }}</strong>
                        </div>
                        @endif
                        <div style="margin-bottom: 3px; font-size: 9px;">{{ $customer->address ?? 'No address provided' }}</div>
                        <div style="margin-bottom: 3px; font-size: 9px;">Phone: {{ $customer->phone }}</div>
                        <div style="margin-bottom: 3px; font-size: 9px;">Email: {{ $customer->email ?? 'N/A' }}</div>
                    </div>
                </div>
                
                <div style="clear: both;"></div>
            </div>
            
            <!-- Summary Cards -->
            <div style="width: 100%; overflow: hidden; margin: 12px 0;">
                <div style="width: 48%; float: left; margin-right: 2%;">
                    <!-- Purchase Summary Card -->
                    <div style="border: 1px solid #ddd; border-radius: 3px; overflow: hidden;">
                        <div style="background: #4a90e2; color: white; padding: 6px; font-weight: bold; font-size: 10px;">
                            @if($reference !== 'all')
                                Location Purchase Summary
                            @else
                                Purchase Summary
                            @endif
                        </div>
                        <div style="padding: 8px;">
                            <div style="display: table; width: 100%; padding: 4px 0; border-bottom: 1px solid #eee; font-size: 9px;">
                                <span style="display: table-cell; color: #666; width: 60%;">Total Orders:</span>
                                <span style="display: table-cell; text-align: right; font-weight: bold; width: 40%;">
                                    {{ $sales->count() }}
                                </span>
                            </div>
                            <div style="display: table; width: 100%; padding: 4px 0; border-bottom: 1px solid #eee; font-size: 9px;">
                                <span style="display: table-cell; color: #666; width: 60%;">Total Purchases:</span>
                                <span style="display: table-cell; text-align: right; font-weight: bold; width: 40%;">
                                    {{ number_format($referenceSpent, 2) }}
                                </span>
                            </div>
                            <div style="display: table; width: 100%; padding: 4px 0; font-size: 9px;">
                                <span style="display: table-cell; color: #666; width: 60%;">Total Payments:</span>
                                <span style="display: table-cell; text-align: right; font-weight: bold; width: 40%;">
                                    {{ number_format($referencePaid, 2) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div style="width: 48%; float: left;">
                    <!-- Balance Summary Card -->
                    <div style="border: 1px solid #ddd; border-radius: 3px; overflow: hidden;">
                        <div style="background: #4a90e2; color: white; padding: 6px; font-weight: bold; font-size: 10px;">
                            @if($reference !== 'all')
                                Location Balance Summary
                            @else
                                Balance Summary
                            @endif
                        </div>
                        <div style="padding: 8px;">
                            <div style="display: table; width: 100%; padding: 4px 0; border-bottom: 1px solid #eee; font-size: 9px;">
                                <span style="display: table-cell; color: #666; width: 60%;">Current Balance:</span>
                                <span style="display: table-cell; text-align: right; font-weight: bold; width: 40%; {{ $customer->balance >= 0 ? 'color: #28a745;' : 'color: #dc3545;' }}">
                                    {{ number_format($customer->balance, 2) }}
                                </span>
                            </div>
                            <div style="display: table; width: 100%; padding: 4px 0; border-bottom: 1px solid #eee; font-size: 9px;">
                                <span style="display: table-cell; color: #666; width: 60%;">
                                    @if($reference !== 'all')
                                        {{ $reference }} Dues:
                                    @else
                                        Total Dues:
                                    @endif
                                </span>
                                <span style="display: table-cell; text-align: right; font-weight: bold; width: 40%; {{ $referenceDues >= 0 ? 'color: #dc3545;' : 'color: #28a745;' }}">
                                    {{ number_format($referenceDues, 2) }}
                                </span>
                            </div>
                            <div style="display: table; width: 100%; padding: 4px 0; font-size: 9px;">
                                <span style="display: table-cell; color: #666; width: 60%;">Last Order:</span>
                                <span style="display: table-cell; text-align: right; font-weight: bold; width: 40%;">
                                    @if($sales->count() > 0)
                                        {{ $sales->first()->created_at->format('M d, Y') }}
                                    @else
                                        N/A
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div style="clear: both;"></div>
            </div>
            
            <!-- Transactions -->
            <div style="font-size: 11px; font-weight: bold; margin: 12px 0 8px 0; padding-bottom: 5px; border-bottom: 1px solid #4a90e2; line-height: 1.1;">
                Transaction History
                @if($reference !== 'all')
                    <span style="font-weight: normal; color: #666;">(Filtered by: {{ $reference }})</span>
                @endif
            </div>
            
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 12px; font-size: 8px;">
                <thead>
                    <tr>
                        <th style="background: #4a90e2; color: white; padding: 6px 4px; text-align: left; font-weight: bold; border: 1px solid #4a90e2;">Date</th>
                        <th style="background: #4a90e2; color: white; padding: 6px 4px; text-align: left; font-weight: bold; border: 1px solid #4a90e2;">Invoice #</th>
                        <th style="background: #4a90e2; color: white; padding: 6px 4px; text-align: left; font-weight: bold; border: 1px solid #4a90e2;">Amount</th>
                        <th style="background: #4a90e2; color: white; padding: 6px 4px; text-align: left; font-weight: bold; border: 1px solid #4a90e2;">Paid</th>
                        <th style="background: #4a90e2; color: white; padding: 6px 4px; text-align: left; font-weight: bold; border: 1px solid #4a90e2;">Balance</th>
                        <th style="background: #4a90e2; color: white; padding: 6px 4px; text-align: left; font-weight: bold; border: 1px solid #4a90e2;">Status</th>
                        @if($reference === 'all')
                        <th style="background: #4a90e2; color: white; padding: 6px 4px; text-align: left; font-weight: bold; border: 1px solid #4a90e2;">Reference</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales as $sale)
                        <tr>
                            <td style="padding: 5px 4px; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd; font-size: 8px;">{{ $sale->created_at->format('d/m/y') }}</td>
                            <td style="padding: 5px 4px; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd; font-size: 8px;">{{ $sale->invoice_number }}</td>
                            <td style="padding: 5px 4px; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd; font-size: 8px; text-align: right;">{{ number_format($sale->total_amount, 0) }}</td>
                            <td style="padding: 5px 4px; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd; font-size: 8px; text-align: right;">{{ number_format($sale->amount_paid, 0) }}</td>
                            <td style="padding: 5px 4px; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd; font-size: 8px; text-align: right;">{{ number_format($sale->total_amount - $sale->amount_paid, 0) }}</td>
                            <td style="padding: 5px 4px; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd; font-size: 8px;">
                                @if($sale->status == 'completed')
                                    <span style="padding: 2px 4px; border-radius: 8px; font-size: 7px; font-weight: bold; background: #d4edda; color: #155724; display: inline-block;">Completed</span>
                                @elseif($sale->status == 'pending')
                                    <span style="padding: 2px 4px; border-radius: 8px; font-size: 7px; font-weight: bold; background: #fff3cd; color: #856404; display: inline-block;">Pending</span>
                                @else
                                    <span style="padding: 2px 4px; border-radius: 8px; font-size: 7px; font-weight: bold; background: #f8d7da; color: #721c24; display: inline-block;">Cancelled</span>
                                @endif
                            </td>
                            @if($reference === 'all')
                            <td style="padding: 5px 4px; border-bottom: 1px solid #ddd; font-size: 8px;">
                                @if($sale->payments->count() > 0 && $sale->payments->first()->reference)
                                    {{ $sale->payments->first()->reference }}
                                @else
                                    N/A
                                @endif
                            </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $reference === 'all' ? '7' : '6' }}" style="padding: 10px; text-align: center; border: 1px solid #ddd; font-size: 9px;">
                                @if($reference !== 'all')
                                    No transactions found for {{ $reference }}
                                @else
                                    No transactions found
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            <!-- Notes -->
            <div style="background: #f9f9f9; padding: 8px; border-radius: 3px; margin: 12px 0; font-size: 8px;">
                <div style="font-weight: bold; color: #4a90e2; margin-bottom: 5px; font-size: 9px;">
                    Important Notes
                </div>
                <ul style="margin: 0; padding-left: 15px; line-height: 1.2;">
                    @if($reference !== 'all')
                        <li style="margin-bottom: 3px;">This statement reflects all transactions for {{ $customer->name }} at <strong>{{ $reference }}</strong> as of {{ now()->format('d/m/Y') }}.</li>
                    @else
                        <li style="margin-bottom: 3px;">This statement reflects all transactions with {{ $customer->name }} as of {{ now()->format('d/m/Y') }}.</li>
                    @endif
                    <li style="margin-bottom: 3px;">Please make payments to clear outstanding balances by the due date.</li>
                    <li style="margin-bottom: 3px;">For any discrepancies, please contact our accounts department within 7 days.</li>
                    <li style="margin-bottom: 3px;">Late payments may be subject to interest charges as per our terms.</li>
                </ul>
            </div>
            
            <!-- Signatures -->
            <div style="margin-top: 10px; padding-top: 10px; border-top: 1px dashed #ccc; font-size: 9px;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <!-- Customer Signature -->
                        <td style="width: 45%; vertical-align: top; padding: 3px;">
                            <div style="margin-bottom: 3px;"><strong>Customer Signature</strong></div>
                            <div style="width: 100%; height: 1px; background: #333; margin-top: 30px;"></div>
                            <div style="margin-top: 5px; font-size: 8px; color: #666;">
                                Name: {{ $customer->name }}
                                @if($reference !== 'all')
                                    <br>Location: {{ $reference }}
                                @endif
                            </div>
                        </td>
                        
                        <!-- Spacer -->
                        <td style="width: 10%;"></td>
                        
                        <!-- Authorized Signature -->
                        <td style="width: 45%; vertical-align: top; padding: 3px;">
                            <div style="margin-bottom: 3px;"><strong>Authorized Signature</strong></div>
                            <div style="width: 100%; height: 1px; background: #333; margin-top: 30px;"></div>
                            <div style="margin-top: 8px; font-size: 9px;">
                                <strong>{{ $business->name ?? 'Your Business Name' }}</strong>
                            </div>
                            <div style="margin-top: 3px; font-size: 8px; color: #666;">
                                Date: {{ now()->format('d/m/Y') }}
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            
            <!-- Footer -->
            <div style="text-align: center; margin-top: 12px; padding-top: 10px; border-top: 1px solid #ddd; color: #666; font-size: 8px;">
                <p style="margin: 0 0 3px 0;">Thank you for your business!</p>
                <p style="margin: 0;">Generated on {{ now()->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Invoice - {{ $customer->name }}</title>
    <style>
        /* Ultra Compact, PDF-friendly CSS */
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            line-height: 1.2; /* Reduced from 1.4 */
            margin: 0;
            padding: 0;
            font-size: 10px; /* Reduced base font size */
        }
        
        .invoice-container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 5px; /* Reduced from 0 */
        }
        
        /* Compact Header */
        .invoice-header {
            background: #4a90e2;
            color: white;
            padding: 10px 15px; /* Reduced from 20px */
            text-align: center;
            margin-bottom: 10px; /* Reduced */
        }
        
        .invoice-header h1 {
            font-size: 18px; /* Reduced from 24px */
            font-weight: bold;
            margin: 0 0 3px 0; /* Reduced */
            line-height: 1.1;
        }
        
        .invoice-header p {
            margin: 0;
            opacity: 0.9;
            font-size: 11px; /* Reduced */
        }
        
        /* Main content */
        .invoice-body {
            padding: 10px; /* Reduced from 20px */
        }
        
        .info-title {
            font-weight: bold;
            color: #4a90e2;
            margin-bottom: 6px; /* Reduced from 10px */
            font-size: 12px; /* Reduced from 16px */
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
            margin-bottom: 3px; /* Reduced from 5px */
        }
        
        .mb-2 {
            margin-bottom: 6px; /* Reduced from 10px */
        }
        
        .mb-3 {
            margin-bottom: 9px; /* Reduced from 15px */
        }
        
        .mt-2 {
            margin-top: 6px; /* Reduced from 10px */
        }
        
        .mt-3 {
            margin-top: 9px; /* Reduced from 15px */
        }
        
        .mt-4 {
            margin-top: 12px; /* Reduced from 20px */
        }
        
        .mt-5 {
            margin-top: 15px; /* Reduced from 25px */
        }
        
        /* Print-specific styles */
        @media print {
            body {
                margin: 0;
                padding: 0;
                font-size: 9px; /* Even smaller for print */
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
            <h1>CUSTOMER STATEMENT</h1>
            <p>Summary of all transactions with {{ $customer->name }}</p>
        </div>
        
        <!-- Main Content -->
        <div class="invoice-body">
            <!-- Company and Customer Info - Ultra Compact -->
            <div style="width: 100%; overflow: hidden; margin-bottom: 12px;"> <!-- Reduced margin -->
                <!-- Business Information -->
                <div style="width: 48%; float: left;">
                    <div style="background: #f5f5f5; border-left: 3px solid #4a90e2; border-radius: 3px; padding: 8px;"> <!-- Reduced padding -->
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
                    <div style="background: #e9f7fe; border-left: 3px solid #34c759; border-radius: 3px; padding: 8px;"> <!-- Reduced padding -->
                        <div style="font-weight: bold; color: #34c759; margin-bottom: 6px; font-size: 11px; line-height: 1.1;">
                            Customer Information
                        </div>
                        <div style="margin-bottom: 5px; font-size: 10px;">
                            <strong>{{ $customer->name }}</strong>
                        </div>
                        <div style="margin-bottom: 3px; font-size: 9px;">{{ $customer->address ?? 'No address provided' }}</div>
                        <div style="margin-bottom: 3px; font-size: 9px;">Phone: {{ $customer->phone }}</div>
                        <div style="margin-bottom: 3px; font-size: 9px;">Email: {{ $customer->email ?? 'N/A' }}</div>
                    </div>
                </div>
                
                <div style="clear: both;"></div>
            </div>
            
            <!-- Summary Cards - Ultra Compact -->
            <div style="width: 100%; overflow: hidden; margin: 12px 0;"> <!-- Reduced margin -->
                {{-- <div style="width: 32%; float: left; margin-right: 2%;">
                    <!-- Customer Details Card -->
                    <div style="border: 1px solid #ddd; border-radius: 5px; overflow: hidden;">
                        <div style="background: #4a90e2; color: white; padding: 10px; font-weight: bold;">
                            Customer Details
                        </div>
                        <div style="padding: 15px;">
                            <div class="summary-item" style="display: table; width: 100%; padding: 8px 0; border-bottom: 1px solid #eee;">
                                <span class="summary-label" style="display: table-cell; color: #666;">Customer Since:</span>
                                <span class="summary-value" style="display: table-cell; text-align: right; font-weight: bold;">
                                    @if($sales->count() > 0)
                                        {{ $sales->last()->created_at->format('M d, Y') }}
                                    @else
                                        N/A
                                    @endif
                                </span>
                            </div>
                            <div class="summary-item" style="display: table; width: 100%; padding: 8px 0; border-bottom: 1px solid #eee;">
                                <span class="summary-label" style="display: table-cell; color: #666;">Customer Group:</span>
                                <span class="summary-value" style="display: table-cell; text-align: right; font-weight: bold;">
                                    {{ ucfirst($customer->customer_group) }}
                                </span>
                            </div>
                            <div class="summary-item" style="display: table; width: 100%; padding: 8px 0;">
                                <span class="summary-label" style="display: table-cell; color: #666;">Credit Limit:</span>
                                <span class="summary-value" style="display: table-cell; text-align: right; font-weight: bold;">
                                    {{ number_format($customer->credit_limit, 2) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div style="width: 48%; float: left; margin-right: 2%;">
                    <!-- Purchase Summary Card -->
                    <div style="border: 1px solid #ddd; border-radius: 3px; overflow: hidden;">
                        <div style="background: #4a90e2; color: white; padding: 6px; font-weight: bold; font-size: 10px;"> <!-- Reduced padding -->
                            Purchase Summary
                        </div>
                        <div style="padding: 8px;"> <!-- Reduced padding -->
                            <div style="display: table; width: 100%; padding: 4px 0; border-bottom: 1px solid #eee; font-size: 9px;"> <!-- Reduced padding -->
                                <span style="display: table-cell; color: #666; width: 60%;">Total Orders:</span>
                                <span style="display: table-cell; text-align: right; font-weight: bold; width: 40%;">
                                    {{ $sales->count() }}
                                </span>
                            </div>
                            <div style="display: table; width: 100%; padding: 4px 0; border-bottom: 1px solid #eee; font-size: 9px;"> <!-- Reduced padding -->
                                <span style="display: table-cell; color: #666; width: 60%;">Total Purchases:</span>
                                <span style="display: table-cell; text-align: right; font-weight: bold; width: 40%;">
                                    {{ number_format($totalSpent, 2) }}
                                </span>
                            </div>
                            <div style="display: table; width: 100%; padding: 4px 0; font-size: 9px;"> <!-- Reduced padding -->
                                <span style="display: table-cell; color: #666; width: 60%;">Total Payments:</span>
                                <span style="display: table-cell; text-align: right; font-weight: bold; width: 40%;">
                                    {{ number_format($totalPaid, 2) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div style="width: 48%; float: left;">
                    <!-- Balance Summary Card -->
                    <div style="border: 1px solid #ddd; border-radius: 3px; overflow: hidden;">
                        <div style="background: #4a90e2; color: white; padding: 6px; font-weight: bold; font-size: 10px;"> <!-- Reduced padding -->
                            Balance Summary
                        </div>
                        <div style="padding: 8px;"> <!-- Reduced padding -->
                            <div style="display: table; width: 100%; padding: 4px 0; border-bottom: 1px solid #eee; font-size: 9px;"> <!-- Reduced padding -->
                                <span style="display: table-cell; color: #666; width: 60%;">Current Balance:</span>
                                <span style="display: table-cell; text-align: right; font-weight: bold; width: 40%; {{ $customer->balance >= 0 ? 'color: #28a745;' : 'color: #dc3545;' }}">
                                    {{ number_format($customer->balance, 2) }}
                                </span>
                            </div>
                            <div style="display: table; width: 100%; padding: 4px 0; border-bottom: 1px solid #eee; font-size: 9px;"> <!-- Reduced padding -->
                                <span style="display: table-cell; color: #666; width: 60%;">Total Dues:</span>
                                <span style="display: table-cell; text-align: right; font-weight: bold; width: 40%; {{ $totalDues >= 0 ? 'color: #dc3545;' : 'color: #28a745;' }}">
                                    {{ number_format($totalDues, 2) }}
                                </span>
                            </div>
                            <div style="display: table; width: 100%; padding: 4px 0; font-size: 9px;"> <!-- Reduced padding -->
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
            
            <!-- Transactions - Ultra Compact -->
            <div style="font-size: 11px; font-weight: bold; margin: 12px 0 8px 0; padding-bottom: 5px; border-bottom: 1px solid #4a90e2; line-height: 1.1;">
                Transaction History
            </div>
            
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 12px; font-size: 8px;"> <!-- Reduced font size -->
                <thead>
                    <tr>
                        <th style="background: #4a90e2; color: white; padding: 6px 4px; text-align: left; font-weight: bold; border: 1px solid #4a90e2;">Date</th>
                        <th style="background: #4a90e2; color: white; padding: 6px 4px; text-align: left; font-weight: bold; border: 1px solid #4a90e2;">Invoice #</th>
                        <th style="background: #4a90e2; color: white; padding: 6px 4px; text-align: left; font-weight: bold; border: 1px solid #4a90e2;">Amount</th>
                        <th style="background: #4a90e2; color: white; padding: 6px 4px; text-align: left; font-weight: bold; border: 1px solid #4a90e2;">Paid</th>
                        <th style="background: #4a90e2; color: white; padding: 6px 4px; text-align: left; font-weight: bold; border: 1px solid #4a90e2;">Balance</th>
                        <th style="background: #4a90e2; color: white; padding: 6px 4px; text-align: left; font-weight: bold; border: 1px solid #4a90e2;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales as $sale)
                        <tr>
                            <td style="padding: 5px 4px; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd; font-size: 8px;">{{ $sale->created_at->format('d/m/y') }}</td> <!-- Shorter date format -->
                            <td style="padding: 5px 4px; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd; font-size: 8px;">{{ $sale->invoice_number }}</td>
                            <td style="padding: 5px 4px; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd; font-size: 8px; text-align: right;">{{ number_format($sale->total_amount, 0) }}</td> <!-- No decimals -->
                            <td style="padding: 5px 4px; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd; font-size: 8px; text-align: right;">{{ number_format($sale->amount_paid, 0) }}</td> <!-- No decimals -->
                            <td style="padding: 5px 4px; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd; font-size: 8px; text-align: right;">{{ number_format($sale->total_amount - $sale->amount_paid, 0) }}</td> <!-- No decimals -->
                            <td style="padding: 5px 4px; border-bottom: 1px solid #ddd; font-size: 8px;">
                                @if($sale->status == 'completed')
                                    <span style="padding: 2px 4px; border-radius: 8px; font-size: 7px; font-weight: bold; background: #d4edda; color: #155724; display: inline-block;">Completed</span>
                                @elseif($sale->status == 'pending')
                                    <span style="padding: 2px 4px; border-radius: 8px; font-size: 7px; font-weight: bold; background: #fff3cd; color: #856404; display: inline-block;">Pending</span>
                                @else
                                    <span style="padding: 2px 4px; border-radius: 8px; font-size: 7px; font-weight: bold; background: #f8d7da; color: #721c24; display: inline-block;">Cancelled</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding: 10px; text-align: center; border: 1px solid #ddd; font-size: 9px;">No transactions found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            <!-- Notes - Compact -->
            <div style="background: #f9f9f9; padding: 8px; border-radius: 3px; margin: 12px 0; font-size: 8px;"> <!-- Reduced padding and font -->
                <div style="font-weight: bold; color: #4a90e2; margin-bottom: 5px; font-size: 9px;">
                    Important Notes
                </div>
                <ul style="margin: 0; padding-left: 15px; line-height: 1.2;">
                    <li style="margin-bottom: 3px;">This statement reflects all transactions with {{ $customer->name }} as of {{ now()->format('d/m/Y') }}.</li> <!-- Shorter date -->
                    <li style="margin-bottom: 3px;">Please make payments to clear outstanding balances by the due date.</li>
                    <li style="margin-bottom: 3px;">For any discrepancies, please contact our accounts department within 7 days.</li>
                    <li style="margin-bottom: 3px;">Late payments may be subject to interest charges as per our terms.</li>
                </ul>
            </div>
            
            <!-- Signatures - Compact -->
            <div style="margin-top: 10px; padding-top: 10px; border-top: 1px dashed #ccc; font-size: 9px;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <!-- Customer Signature -->
                        <td style="width: 45%; vertical-align: top; padding: 3px;">
                            <div style="margin-bottom: 3px;"><strong>Customer Signature</strong></div>
                            <div style="width: 100%; height: 1px; background: #333; margin-top: 30px;"></div>
                            <div style="margin-top: 5px; font-size: 8px; color: #666;">
                                Name: {{ $customer->name }}
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
            
            <!-- Footer - Compact -->
            <div style="text-align: center; margin-top: 12px; padding-top: 10px; border-top: 1px solid #ddd; color: #666; font-size: 8px;">
                <p style="margin: 0 0 3px 0;">Thank you for your business!</p>
                <p style="margin: 0;">Generated on {{ now()->format('d/m/Y H:i') }}</p> <!-- Shorter date/time format -->
            </div>
        </div>
    </div>
</body>
</html>
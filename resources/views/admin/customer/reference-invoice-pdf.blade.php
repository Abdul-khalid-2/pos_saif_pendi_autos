<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @if($reference !== 'all')
            {{ $reference }} Statement - {{ $customer->name }}
        @else
            Customer Statement - {{ $customer->name }}
        @endif
    </title>
    <style>
        @page {
            margin: 0.5cm;
            size: A4 portrait;
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Helvetica', 'Arial', 'DejaVu Sans', sans-serif;
            color: #333;
            line-height: 1.2;
            font-size: 10px;
            background: #fff;
            padding: 5px;
        }
        
        .invoice-container {
            width: 100%;
            max-width: 710px;
            margin: 0 auto;
            padding: 5px;
        }
        
        /* Header Section */
        .header-section {
            display: table;
            width: 100%;
            margin-bottom: 8px;
            padding-bottom: 8px;
            border-bottom: 2px solid #dee2e6;
        }
        
        .header-left {
            display: table-cell;
            vertical-align: middle;
            width: 70%;
        }
        
        .header-right {
            display: table-cell;
            vertical-align: top;
            text-align: right;
            width: 30%;
        }
        
        .business-name {
            font-size: 20px;
            color: #2e3e5c;
            margin: 0 0 3px 0;
            font-weight: bold;
        }
        
        .business-tagline {
            font-style: italic;
            font-weight: bold;
            color: #9a5700;
            font-size: 11px;
            margin: 0 0 5px 0;
        }
        
        .business-contact {
            margin: 1px 0;
            font-size: 9px;
            color: #444;
        }
        
        .person-label {
            font-size: 11px;
            color: #2e3e5c;
            font-weight: bold;
            margin: 3px 0 1px 0;
        }
        
        .person-name {
            color: #ff8717;
            margin: 0;
            font-size: 10px;
        }
        
        /* Statement Title */
        .statement-title {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin: 0 0 5px 0;
            text-transform: uppercase;
        }
        
        .statement-meta {
            display: table;
            width: 100%;
            margin-bottom: 8px;
        }
        
        .meta-left, .meta-right {
            display: table-cell;
            vertical-align: top;
            width: 50%;
        }
        
        .meta-right {
            text-align: right;
        }
        
        /* Status Badges */
        .status-badge {
            padding: 2px 6px;
            border-radius: 12px;
            font-size: 8px;
            font-weight: bold;
            display: inline-block;
        }
        
        .badge-success {
            background: #d4edda;
            color: #155724;
        }
        
        .badge-danger {
            background: #f8d7da;
            color: #721c24;
        }
        
        .badge-warning {
            background: #fff3cd;
            color: #856404;
        }
        
        .badge-info {
            background: #e9f7fe;
            color: #0c5460;
        }
        
        /* Customer Info */
        .customer-info {
            display: table;
            width: 100%;
            margin-bottom: 8px;
            border-spacing: 0 8px;
        }
        
        .info-box {
            display: table-cell;
            vertical-align: top;
            width: 48%;
            padding-right: 8px;
        }
        
        .info-spacer {
            display: table-cell;
            width: 4%;
        }
        
        .info-label {
            font-weight: bold;
            font-size: 10px;
            margin-bottom: 4px;
            color: #2e3e5c;
        }
        
        .info-value {
            padding: 6px;
            border: 1px solid #eee;
            border-radius: 3px;
            background: #f9f9f9;
            font-size: 9px;
        }
        
        /* Summary Cards */
        .summary-cards {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 12px;
        }
        
        .summary-card {
            flex: 1;
            min-width: 180px;
            padding: 8px;
            border: 1px solid #dee2e6;
            border-radius: 3px;
            background: #f8f9fa;
        }
        
        .card-title {
            font-size: 10px;
            font-weight: bold;
            color: #2e3e5c;
            margin-bottom: 6px;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 4px;
        }
        
        .summary-item {
            display: flex;
            justify-content: space-between;
            padding: 3px 0;
            font-size: 9px;
        }
        
        .summary-label {
            color: #666;
        }
        
        .summary-value {
            font-weight: 600;
        }
        
        .text-success {
            color: #155724 !important;
        }
        
        .text-danger {
            color: #721c24 !important;
        }
        
        /* Date Range */
        .date-range {
            background: #e7f1ff;
            padding: 6px 8px;
            border-radius: 3px;
            margin-bottom: 8px;
            border-left: 3px solid #0d6efd;
            font-size: 9px;
        }
        
        .date-range strong {
            color: #0d6efd;
        }
        
        /* Transaction Table */
        .transaction-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            font-size: 9px;
        }
        
        .transaction-table th {
            background: #f5f5f5;
            padding: 6px 4px;
            text-align: left;
            border: 1px solid #dee2e6;
            font-weight: bold;
            color: #2e3e5c;
            font-size: 9px;
        }
        
        .transaction-table td {
            padding: 5px 4px;
            border: 1px solid #dee2e6;
        }
        
        .text-end {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        /* Section Title */
        .section-title {
            margin: 10px 0 6px 0;
            font-size: 12px;
            font-weight: bold;
            color: #2e3e5c;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 4px;
        }
        
        /* Notes Section */
        .notes-section {
            background-color: #f8f9fa;
            padding: 8px;
            border-radius: 3px;
            margin-top: 10px;
            border-left: 3px solid #dee2e6;
            font-size: 9px;
        }
        
        .notes-section h5 {
            font-size: 11px;
            color: #2e3e5c;
            margin-bottom: 6px;
        }
        
        .notes-section ul {
            margin: 0;
            padding-left: 15px;
            font-size: 9px;
        }
        
        /* Signature Area */
        .signature-area {
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px dashed #ccc;
            font-size: 9px;
        }
        
        .signature-box {
            width: 48%;
            float: left;
            padding-right: 10px;
        }
        
        .signature-box:last-child {
            padding-right: 0;
            padding-left: 10px;
            float: right;
        }
        
        .signature-line {
            width: 100%;
            height: 1px;
            background: #333;
            margin-top: 20px;
        }
        
        /* Footer */
        .footer {
            margin-top: 12px;
            padding-top: 8px;
            border-top: 1px solid #dee2e6;
            font-size: 9px;
            color: #666;
            text-align: center;
            clear: both;
        }
        
        /* Utility Classes */
        .compact {
            margin: 1px 0;
            font-size: 9px;
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
        
        .mt-2 {
            margin-top: 6px;
        }
        
        .mt-3 {
            margin-top: 9px;
        }
        
        /* Print Optimization */
        @media print {
            body {
                margin: 0;
                padding: 0;
                font-size: 9px;
            }
            
            .invoice-container {
                box-shadow: none;
                border: none;
                padding: 0;
                max-width: 100%;
            }
            
            .header-section {
                page-break-inside: avoid;
            }
            
            .transaction-table {
                page-break-inside: avoid;
            }
            
            .summary-cards {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header Section -->
        <div class="header-section">
            <div class="header-left">
                <div style="display: table;">
                    @if($business->logo_path)
                    <div style="display: table-cell; vertical-align: middle; padding-right: 10px;">
                        <img src="{{ public_path('backend/'.$business->logo_path) }}" alt="Logo" style="width: 60px; height: auto;">
                    </div>
                    @endif
                    <div style="display: table-cell; vertical-align: middle;">
                        <h1 class="business-name">NEW PAK PINDI AUTOS</h1>
                        <p class="business-tagline">IMPORTERS - WHOLESALERS<br>SPARE PARTS</p>
                        <p class="business-contact">{{ $business->address ?? '123 Business Street' }}</p>
                        <p class="business-contact">Email: {{ $business->email ?? 'business@example.com' }}</p>
                    </div>
                </div>
            </div>
            <div class="header-right">
                <p class="person-label">Proprietor:</p>
                <p class="person-name">Habib Ur Rehman</p>
                <p class="business-contact">0318-1068585<br>0344-2070722</p>
                
                <p class="person-label" style="margin-top: 5px;">Manager:</p>
                <p class="person-name">Saif Ur Rehman</p>
                <p class="business-contact">0315-1026553</p>
            </div>
        </div>

        <!-- Date Range -->
        <div class="date-range">
            <div>
                <strong>Statement Period:</strong> 
                {{ $startDate->format('M d, Y') }} to {{ $endDate->format('M d, Y') }}
            </div>
        </div>

        <!-- Statement Title -->
        <div class="statement-meta mb-2">
            <div class="meta-left">
                @if($reference !== 'all')
                    <h2 class="statement-title">{{ strtoupper($reference) }} - STATEMENT</h2>
                @else
                    <h2 class="statement-title">CUSTOMER STATEMENT</h2>
                @endif
                <p class="compact">Customer: <strong>{{ $customer->name }}</strong></p>
                <p class="compact">Statement Date: {{ now()->format('M d, Y') }}</p>
            </div>
            <div class="meta-right">
                {{-- <p class="compact">Current Balance: 
                    <span class="status-badge {{ $customer->balance >= 0 ? 'badge-danger' : 'badge-success' }}">
                        {{ number_format($customer->balance, 2) }}
                    </span>
                </p> --}}
                <p class="compact">Total Transactions: {{ $sales->count() }}</p>
                {{-- @if($reference !== 'all')
                <p class="compact">Location: <span class="badge-info status-badge">{{ $reference }}</span></p>
                @endif --}}
            </div>
        </div>

        <!-- Customer Info -->
        <div class="customer-info">
            <div class="info-box">
                <div class="info-label">CUSTOMER INFORMATION</div>
                <div class="info-value">
                    <strong>{{ $customer->name }}</strong><br>
                    @if($customer->address)
                    {{ $customer->address }}<br>
                    @endif
                    Phone: {{ $customer->phone }}<br>
                    @if($customer->email)
                    Email: {{ $customer->email }}<br>
                    @endif
                    {{-- Group: <span class="badge-info status-badge">{{ ucfirst($customer->customer_group) }}</span> --}}
                </div>
            </div>
            <div class="info-spacer"></div>
            <div class="info-box">
                {{-- <div class="info-label">
                    @if($reference !== 'all')
                    {{ $reference }} SUMMARY
                    @else
                    ACCOUNT SUMMARY
                    @endif
                </div>
                <div class="info-value">
                    Credit Limit: {{ number_format($customer->credit_limit, 2) }}<br>
                    @if($reference !== 'all')
                    {{ $reference }} Dues: 
                    <span class="{{ $referenceDues >= 0 ? 'text-danger' : 'text-success' }}">
                        {{ number_format($referenceDues, 2) }}
                    </span><br>
                    @endif
                    Customer Since: 
                    @if($sales->count() > 0)
                        {{ $sales->last()->created_at->format('M d, Y') }}
                    @else
                        N/A
                    @endif
                </div> --}}
            </div>
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
                                    {{-- {{ number_format($referencePaid, 2) }} --}}
                                    {{ number_format($totalPaid, 2) }}
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

        <!-- Transaction History -->
        <h3 class="section-title">Transaction History</h3>
        
        <table class="transaction-table">
            <thead>
                <tr>
                    <th style="width: 12%;">Date</th>
                    <th style="width: 18%;">Invoice #</th>
                    <th style="width: 14%;" class="text-end">Amount</th>
                    <th style="width: 14%;" class="text-end">Paid</th>
                    <th style="width: 14%;" class="text-end">Balance</th>
                    <th style="width: 14%;">Payment Status</th>
                    @if($reference === 'all')
                    <th style="width: 14%;">Reference</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($sales as $sale)
                    <tr>
                        <td>{{ $sale->created_at->format('d/m/y') }}</td>
                        <td>{{ $sale->invoice_number }}</td>
                        <td class="text-end">{{ number_format($sale->total_amount, 0) }}</td>
                        <td class="text-end">{{ number_format($sale->amount_paid, 0) }}</td>
                        <td class="text-end">{{ number_format($sale->total_amount - $sale->amount_paid, 0) }}</td>
                        <td>
                            @if($sale->payment_status == 'paid')
                                <span class="status-badge badge-success">Paid</span>
                            @elseif($sale->payment_status == 'partial')
                                <span class="status-badge badge-warning">Partial</span>
                            @else
                                <span class="status-badge badge-danger">{{$sale->payment_status}}</span>
                            @endif
                        </td>
                        @if($reference === 'all')
                        <td>
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
                        <td colspan="{{ $reference === 'all' ? '7' : '6' }}" class="text-center" style="padding: 10px;">
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

        <!-- Notes Section -->
        <div class="notes-section">
            <h5>Important Notes</h5>
            <ul class="mb-0">
                @if($reference !== 'all')
                    <li>This statement reflects all transactions for {{ $customer->name }} at <strong>{{ $reference }}</strong> as of {{ now()->format('d/m/Y') }}.</li>
                @else
                    <li>This statement reflects all transactions with {{ $customer->name }} as of {{ now()->format('d/m/Y') }}.</li>
                @endif
                <li>Please make payments to clear outstanding balances by the due date.</li>
                <li>For any discrepancies, please contact our accounts department within 7 days.</li>
                <li>Late payments may be subject to interest charges as per our terms.</li>
            </ul>
        </div>

        <!-- Signature Area -->
        <div class="signature-area">
            <div class="signature-box">
                <div><strong>Customer Signature</strong></div>
                <div class="signature-line"></div>
                <div class="mt-2">
                    <strong>{{ $customer->name }}</strong><br>
                    @if($reference !== 'all')
                    <span class="compact">Location: {{ $reference }}</span><br>
                    @endif
                    <span class="compact">Date: {{ now()->format('d/m/Y') }}</span>
                </div>
            </div>
            
            <div class="signature-box">
                <div><strong>Authorized Signature</strong></div>
                <div class="signature-line"></div>
                <div class="mt-2">
                    <strong>{{ $business->name ?? 'NEW PAK PINDI AUTOS' }}</strong><br>
                    <span class="compact">Proprietor: Habib Ur Rehman</span><br>
                    <span class="compact">Date: {{ now()->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p class="mb-0">Thank you for your business!</p>
            <p class="mb-0">Generated on {{ now()->format('d/m/Y H:i') }}</p>
        </div>
    </div>
</body>
</html>
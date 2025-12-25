<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Customer Summary - {{ $customer->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
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
            font-family: 'Segoe UI', 'DejaVu Sans', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            font-size: 12px;
            line-height: 1.4;
            background: #f8f9fa;
            padding: 10px;
        }
        
        .invoice-container {
            width: 100%;
            max-width: 710px;
            margin: 0 auto;
            padding: 15px;
            background: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border: 1px solid #dee2e6;
        }
        
        .header-section {
            display: table;
            width: 100%;
            margin-bottom: 15px;
            padding-bottom: 15px;
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
        
        .business-info {
            overflow: hidden;
            padding-left: 15px;
        }
        
        .business-name {
            font-size: 24px;
            color: #2e3e5c;
            margin: 0 0 5px 0;
            font-weight: bold;
        }
        
        .business-tagline {
            font-style: italic;
            font-weight: bold;
            color: #9a5700;
            font-size: 13px;
            margin: 0 0 8px 0;
        }
        
        .business-contact {
            margin: 2px 0;
            font-size: 11px;
            color: #444;
        }
        
        .person-label {
            font-size: 13px;
            color: #2e3e5c;
            font-weight: bold;
            margin: 5px 0 2px 0;
        }
        
        .person-name {
            color: #ff8717;
            margin: 0;
            font-size: 12px;
        }
        
        .compact {
            margin: 2px 0;
            font-size: 11px;
        }
        
        .statement-title {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin: 0 0 10px 0;
            text-transform: uppercase;
        }
        
        .statement-meta {
            display: table;
            width: 100%;
            margin-bottom: 10px;
        }
        
        .meta-left, .meta-right {
            display: table-cell;
            vertical-align: top;
            width: 50%;
        }
        
        .meta-right {
            text-align: right;
        }
        
        .status-badge {
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 11px;
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
        
        .badge-primary {
            background: #e9f7fe;
            color: #0c5460;
        }
        
        .customer-info {
            display: table;
            width: 100%;
            margin-bottom: 15px;
            border-spacing: 0 10px;
        }
        
        .info-box {
            display: table-cell;
            vertical-align: top;
            width: 48%;
            padding-right: 10px;
        }
        
        .info-spacer {
            display: table-cell;
            width: 4%;
        }
        
        .info-label {
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 5px;
            color: #2e3e5c;
        }
        
        .info-value {
            padding: 8px;
            border: 1px solid #eee;
            border-radius: 4px;
            background: #f9f9f9;
            font-size: 11px;
        }
        
        .summary-cards {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .summary-card {
            flex: 1;
            min-width: 200px;
            padding: 12px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            background: #f8f9fa;
        }
        
        .summary-card .card-title {
            font-size: 12px;
            font-weight: bold;
            color: #2e3e5c;
            margin-bottom: 8px;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 5px;
        }
        
        .summary-item {
            display: flex;
            justify-content: space-between;
            padding: 4px 0;
            font-size: 11px;
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
        
        .transaction-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 11px;
        }
        
        .transaction-table th {
            background: #f5f5f5;
            padding: 8px;
            text-align: left;
            border: 1px solid #dee2e6;
            font-weight: bold;
            color: #2e3e5c;
        }
        
        .transaction-table td {
            padding: 8px;
            border: 1px solid #dee2e6;
        }
        
        .text-end {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .section-title {
            margin: 15px 0 8px 0;
            font-size: 14px;
            font-weight: bold;
            color: #2e3e5c;
        }
        
        .notes-section {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 4px;
            margin-top: 15px;
            border-left: 4px solid #dee2e6;
        }
        
        .notes-section h5 {
            font-size: 13px;
            color: #2e3e5c;
            margin-bottom: 8px;
        }
        
        .notes-section ul {
            margin: 0;
            padding-left: 15px;
            font-size: 11px;
        }
        
        .signature-area {
            margin-top: 25px;
            padding-top: 15px;
            border-top: 1px dashed #ccc;
        }
        
        .footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #dee2e6;
            font-size: 11px;
            color: #666;
            text-align: center;
        }
        
        .action-buttons {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #dee2e6;
        }
        
        @media print {
            body {
                background: #fff;
                padding: 0;
            }
            
            .invoice-container {
                box-shadow: none;
                border: none;
                padding: 0;
                max-width: 100%;
            }
            
            .no-print {
                display: none !important;
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
    <!-- Action Buttons (Non-printable) -->
    <div class="action-buttons no-print">
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-2"></i>Back to Customer
            </a>
            <div>
                <button onclick="window.print()" class="btn btn-primary btn-sm me-2">
                    <i class="fas fa-print me-2"></i>Print Summary
                </button>
                <a href="{{ route('customers.invoice.download', $customer->id) }}" class="btn btn-success btn-sm">
                    <i class="fas fa-file-pdf me-2"></i>Download PDF
                </a>
            </div>
        </div>
    </div>

    <div class="invoice-container">
        <!-- Header Section -->
        <div class="header-section">
            <div class="header-left">
                <div style="display: table;">
                    @if($business->logo_path)
                    <div style="display: table-cell; vertical-align: middle; padding-right: 15px;">
                        <img src="{{ public_path('backend/'.$business->logo_path) }}" alt="Logo" style="width: 80px; height: auto;">
                    </div>
                    @endif
                    <div class="business-info" style="display: table-cell; vertical-align: middle;">
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
                
                <p class="person-label" style="margin-top: 8px;">Manager:</p>
                <p class="person-name">Saif Ur Rehman</p>
                <p class="business-contact">0315-1026553</p>
            </div>
        </div>

        <!-- Statement Title Section -->
        <div class="statement-meta">
            <div class="meta-left">
                <h2 class="statement-title">CUSTOMER SUMMARY</h2>
                <p class="compact">Customer: <strong>{{ $customer->name }}</strong></p>
                <p class="compact">Summary Date: {{ now()->format('M d, Y') }}</p>
            </div>
            <div class="meta-right">
                {{-- <p class="compact">Current Balance: 
                    <span class="status-badge {{ $customer->balance >= 0 ? 'badge-danger' : 'badge-success' }}">
                        {{ number_format($customer->balance, 2) }}
                    </span>
                </p> --}}
                <p class="compact">Total Transactions: {{ $sales->count() }}</p>
            </div>
        </div>

        <!-- Customer Info Section -->
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
                </div>
            </div>
            <div class="info-spacer"></div>
            <div class="info-box">
                {{-- <div class="info-label">ACCOUNT SUMMARY</div>
                <div class="info-value">
                    Customer Since: 
                    @if($sales->count() > 0)
                        {{ $sales->last()->created_at->format('M d, Y') }}
                    @else
                        N/A
                    @endif<br>
                    Customer Group: <span class="badge-primary status-badge">{{ ucfirst($customer->customer_group) }}</span><br>
                    Credit Limit: {{ number_format($customer->credit_limit, 2) }}
                </div> --}}
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="summary-cards">
            {{-- <div class="summary-card">
                <div class="card-title">
                    <i class="fas fa-id-card me-1"></i>CUSTOMER DETAILS
                </div>
                <div class="summary-item">
                    <span class="summary-label">Customer Since:</span>
                    <span class="summary-value">
                        @if($sales->count() > 0)
                            {{ $sales->last()->created_at->format('M d, Y') }}
                        @else
                            N/A
                        @endif
                    </span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Customer Group:</span>
                    <span class="summary-value">
                        <span class="badge-primary status-badge">{{ ucfirst($customer->customer_group) }}</span>
                    </span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Credit Limit:</span>
                    <span class="summary-value">{{ number_format($customer->credit_limit, 2) }}</span>
                </div>
            </div> --}}
            
            <div class="summary-card">
                <div class="card-title">
                    <i class="fas fa-chart-line me-1"></i>PURCHASE SUMMARY
                </div>
                <div class="summary-item">
                    <span class="summary-label">Total Orders:</span>
                    <span class="summary-value">{{ $sales->count() }}</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Total Purchases:</span>
                    <span class="summary-value">{{ number_format($totalSpent, 2) }}</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Total Payments:</span>
                    <span class="summary-value">{{ number_format($totalPaid, 2) }}</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Last Order:</span>
                    <span class="summary-value">
                        @if($sales->count() > 0)
                            {{ $sales->first()->created_at->format('M d, Y') }}
                        @else
                            N/A
                        @endif
                    </span>
                </div>
            </div>
            
            <div class="summary-card">
                <div class="card-title">
                    <i class="fas fa-wallet me-1"></i>BALANCE SUMMARY
                </div>
                <div class="summary-item">
                    <span class="summary-label">Current Balance:</span>
                    <span class="summary-value {{ $customer->balance >= 0 ? 'text-danger' : 'text-success' }}">
                        {{ number_format($customer->balance, 2) }}
                    </span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Total Dues:</span>
                    <span class="summary-value {{ $totalDues >= 0 ? 'text-danger' : 'text-success' }}">
                        {{ number_format($totalDues, 2) }}
                    </span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Net Position:</span>
                    <span class="summary-value {{ $customer->balance < 0 ? 'text-success' : ($customer->balance == 0 ? 'text-info' : 'text-danger') }}">
                        {{ $customer->balance < 0 ? 'Credit' : ($customer->balance == 0 ? 'Settled' : 'Debit') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Transaction History -->
        <h3 class="section-title">
            <i class="fas fa-file-invoice me-2"></i>Transaction History
        </h3>
        
        <div class="table-responsive">
            <table class="transaction-table">
                <thead>
                    <tr>
                        <th style="width: 15%;">Date</th>
                        <th style="width: 20%;">Invoice #</th>
                        <th style="width: 15%;" class="text-end">Amount</th>
                        <th style="width: 15%;" class="text-end">Paid</th>
                        <th style="width: 15%;" class="text-end">Balance</th>
                        <th style="width: 20%;">Payment Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sales as $sale)
                    <tr>
                        <td>{{ $sale->created_at->format('M d, Y') }}</td>
                        <td>{{ $sale->invoice_number }}</td>
                        <td class="text-end">{{ number_format($sale->total_amount, 2) }}</td>
                        <td class="text-end">{{ number_format($sale->amount_paid, 2) }}</td>
                        <td class="text-end">{{ number_format($sale->total_amount - $sale->amount_paid, 2) }}</td>
                        <td>
                            <span class="status-badge badge-{{ $sale->payment_status == 'paid' ? 'success' : ($sale->payment_status == 'partial' ? 'warning' : 'danger') }}">
                                {{ ucfirst($sale->payment_status) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                    @if($sales->count() == 0)
                    <tr>
                        <td colspan="6" class="text-center py-4">No transactions found</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Notes Section -->
        <div class="notes-section">
            <h5><i class="fas fa-info-circle me-2"></i>Important Notes</h5>
            <ul class="mb-0">
                <li>This statement reflects all transactions with {{ $customer->name }} as of {{ now()->format('F j, Y') }}.</li>
                <li>Please make payments to clear outstanding balances by the due date.</li>
                <li>For any discrepancies, please contact our accounts department within 7 days.</li>
                <li>Late payments may be subject to interest charges as per our terms.</li>
            </ul>
        </div>

        <!-- Signature Area -->
        <div class="signature-area">
            <div style="display: table; width: 100%;">
                <div style="display: table-cell; width: 50%;">
                    <p class="compact">Customer Signature:</p>
                    <div style="height: 30px; border-bottom: 1px solid #ccc; width: 80%;"></div>
                    <div class="compact mt-2">
                        <strong>{{ $customer->name }}</strong><br>
                        Date: {{ now()->format('M d, Y') }}
                    </div>
                </div>
                <div style="display: table-cell; width: 50%; text-align: right;">
                    <p class="compact">Authorized Signature:</p>
                    <div style="height: 30px; border-bottom: 1px solid #ccc; width: 80%; margin-left: auto;"></div>
                    <div class="compact mt-2">
                        <strong>{{ $business->name ?? 'NEW PAK PINDI AUTOS' }}</strong><br>
                        Date: {{ now()->format('M d, Y') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p class="mb-0">Thank you for your business!</p>
            <p class="mb-0">Generated on {{ now()->format('F j, Y \a\t h:i A') }}</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
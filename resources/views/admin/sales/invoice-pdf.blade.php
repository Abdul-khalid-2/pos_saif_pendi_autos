<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $sale->invoice_number }}</title>
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
            font-family: 'DejaVu Sans', sans-serif;
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
        .invoice-title-section {
            margin-bottom: 15px;
        }
        .invoice-title {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin: 0 0 10px 0;
            text-transform: uppercase;
        }
        .invoice-meta {
            display: table;
            width: 100%;
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
        }
        .info-spacer {
            display: table-cell;
            width: 4%;
        }
        .info-label {
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 5px;
        }
        .info-value {
            padding: 8px;
            border: 1px solid #eee;
            border-radius: 4px;
            background: #f9f9f9;
            font-size: 11px;
        }
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 11px;
        }
        .invoice-table th {
            background: #f5f5f5;
            padding: 8px;
            text-align: left;
            border: 1px solid #dee2e6;
            font-weight: bold;
        }
        .invoice-table td {
            padding: 8px;
            border: 1px solid #dee2e6;
        }
        .text-end {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .invoice-totals {
            width: 30%;
            max-width: 280px;
            margin-left: auto;
            margin-right: 0;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 11px;
        }
        .invoice-totals td {
            padding: 6px;
            border: 1px solid #dee2e6;
        }
        .invoice-totals td:first-child {
            font-weight: bold;
            background: #f5f5f5;
        }
        .section-title {
            margin: 15px 0 8px 0;
            font-size: 14px;
            font-weight: bold;
        }
        .invoice-footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #dee2e6;
            font-size: 11px;
        }
        .footer-content {
            display: table;
            width: 100%;
        }
        
        /* Urdu Font Solution */
        @font-face {
            font-family: 'Jameel Noori Nastaleeq';
            src: url('https://cdn.rawgit.com/abdulqadir123/urdu-fonts/4e6a37e6/Jameel%20Noori%20Nastaleeq.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        
        .urdu-note {
            font-family: 'Jameel Noori Nastaleeq', 'Noto Nastaliq Urdu', 'Jameel Noori Nastaleeq Kasheeda', 'Urdu Naskh Asiatype', serif;
            direction: rtl;
            margin: 0;
            font-size: 15px;
            color: #1e2b5a;
            display: table-cell;
            vertical-align: middle;
            /* width: 70%; */
            padding-right: 15px;
            line-height: 1.8;
        }
        
        .signature {
            /* display: table-cell; */
            vertical-align: middle;
            text-align: right;
            /* width: 30%; */
            display: ruby-text;
        }
        .signature-line {
            border-top: 1px solid #1e2b5a;
            width: 120px;
            margin-top: 5px;
            display: inline-block;
        }
        .img-fluid {
            max-width: 100%;
            height: auto;
        }
        
        /* Print-specific styles */
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
            .header-section {
                page-break-inside: avoid;
            }
            .invoice-table {
                page-break-inside: avoid;
            }
            .invoice-totals {
                page-break-inside: avoid;
            }
            
            /* Ensure Urdu font works in print */
            .urdu-note {
                font-family: 'Jameel Noori Nastaleeq', 'Noto Nastaliq Urdu', serif;
            }
        }
        
        .solution-info {
            background-color: #f8f9fa;
            border-left: 4px solid #0d6efd;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        
        .solution-info h3 {
            margin-top: 0;
            color: #0d6efd;
        }
        
        .code-block {
            background-color: #f1f1f1;
            padding: 15px;
            border-radius: 4px;
            font-family: monospace;
            white-space: pre-wrap;
            margin: 15px 0;
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
                        <div style="display: table-cell; vertical-align: middle; padding-right: 15px;">
                            <img src="{{ public_path('backend/'.$business->logo_path) }}" alt="Logo" style="width: 80px; height: auto;">
                        </div>
                    @endif
                    <div class="business-info" style="display: table-cell; vertical-align: middle;">
                        <h1 class="business-name">{{ $business->name }}<sup>®</sup></h1>
                        <p class="business-tagline">Spare Parts Dealer</p>
                        <p class="business-contact">{{ $business->address }}</p>
                        <p class="business-contact">Email: {{ $business->email }}</p>
                    </div>
                </div>
            </div>
            <div class="header-right">
                <p class="person-label">Proprietor:</p>
                <p class="person-name">Muhammad Asif</p>
                <p class="compact">0333-2460463</p>
                
                <p class="person-label" style="margin-top: 8px;">Manager:</p>
                <p class="person-name">Muhammad Naeem Iqbal</p>
                <p class="compact">{{ $business->phone }}</p>
                <p class="compact">0318-4905315</p>
            </div>
        </div>

        <!-- Invoice Title Section -->
        <div class="invoice-title-section">
            <h2 class="invoice-title">INVOICE</h2>
            <div class="invoice-meta">
                <div class="meta-left">
                    <p class="compact">Invoice #: {{ $sale->invoice_number }}</p>
                    <p class="compact">Date: {{ $sale->sale_date->format('M d, Y') }}</p>
                </div>
                <div class="meta-right">
                    <p class="compact">Status: 
                    <span class="status-badge badge-{{ $sale->status == 'completed' ? 'success' : 'danger' }}">
                        {{ ucfirst($sale->status) }}
                    </span>
                    </p>
                    <p class="compact">Payment: 
                    <span class="status-badge badge-{{ $sale->payment_status == 'paid' ? 'success' : ($sale->payment_status == 'partial' ? 'warning' : 'danger') }}">
                        {{ ucfirst($sale->payment_status) }}
                    </span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Customer Info Section -->
        <div class="customer-info">
                <div class="info-box">
                    <div class="info-label">BILL TO</div>
                    <div class="info-value">
                        <strong>Customer:</strong> 
                            @if($sale->customer)
                                {{ $sale->customer->name }}
                            @elseif($sale->walk_in_customer_info && isset($sale->walk_in_customer_info['name']))
                                {{ $sale->walk_in_customer_info['name'] }} 
                                @if(isset($sale->walk_in_customer_info['phone']))
                                    ({{ $sale->walk_in_customer_info['phone'] }})
                                @endif
                            @else
                                Walk-in Customer
                            @endif
                        <br>
                        @if($sale->customer && $sale->customer->address)
                            {{ $sale->customer->address }}<br>
                        @endif
                        @if($sale->customer && $sale->customer->phone)
                            Phone: {{ $sale->customer->phone }}<br>
                        @endif
                        @if($sale->customer && $sale->customer->tax_number)
                            Tax ID: {{ $sale->customer->tax_number }}
                        @endif
                    </div>
                </div>
            <div class="info-spacer"></div>
            <div class="info-box">
                <div class="info-label">SOLD BY</div>
                <div class="info-value">
                    <strong>{{ $sale->user->name }}</strong><br>
                    {{ $sale->branch->name }}<br>
                    {{ $sale->branch->address }}
                </div>
            </div>
        </div>

        <!-- Items Table -->
        <table class="invoice-table">
            <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 35%;">Item</th>
                    <th style="width: 20%;">number / size</th>
                    <th style="width: 10%;">Qty</th>
                    <th style="width: 15%;">Unit Price</th>
                    <th style="width: 15%;" class="text-end">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sale->items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <!-- 
                        <td>{{-- 
                        $item->product->name --}}</td> 
                    -->
                    <td>{{ $item->variant ? $item->variant->name : 'no name' }}</td>
                    <td>{{ $item->variant ? $item->variant->sku : 'm/z' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->unit_price, 2) }}</td>
                    {{-- <td>{{ number_format($item->tax_amount, 2) }}</td>
                    <td>{{ number_format($item->discount_amount, 2) }}</td> --}}
                    <td class="text-right">{{ number_format($item->total_price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals Section -->
        <table class="invoice-totals">
            <tr>
                <td>Subtotal:</td>
                <td class="text-end">{{ number_format($sale->subtotal, 2) }}</td>
            </tr>
            @if($sale->tax_amount > 0)
            <tr>
                <td>Tax:</td>
                <td class="text-end">{{ number_format($sale->tax_amount, 2) }}</td>
            </tr>
            @endif
            @if($sale->discount_amount > 0)
            <tr>
                <td>Discount:</td>
                <td class="text-end">-{{ number_format($sale->discount_amount, 2) }}</td>
            </tr>
            @endif
            <tr>
                <td><strong>Total Amount:</strong></td>
                <td class="text-end"><strong>{{ number_format($sale->total_amount, 2) }}</strong></td>
            </tr>
            <tr>
                <td>Amount Paid:</td>
                <td class="text-end">{{ number_format($sale->amount_paid, 2) }}</td>
            </tr>
            @if($sale->change_amount > 0)
            <tr>
                <td>Change Due:</td>
                <td class="text-end">{{ number_format($sale->change_amount, 2) }}</td>
            </tr>
            @endif
            @if($sale->remaining_balance > 0)
            <tr>
                <td>Balance Due:</td>
                <td class="text-edn">{{ number_format($sale->remaining_balance, 2) }}</td>
            </tr>
            @endif
        </table>

        <!-- Payment History (only if exists) -->
        @if($sale->payments->count() > 0)
        <h3 class="section-title">Payment History</h3>
        <table class="invoice-table">
            <thead>
                <tr>
                    <th style="width: 25%;">Date</th>
                    <th style="width: 25%;">Method</th>
                    <th style="width: 25%;">Amount</th>
                    <th style="width: 25%;">Reference</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sale->payments as $payment)
                <tr>
                    <td>{{ $payment->created_at->format('M d, Y') }}</td>
                    <td>{{ $payment->paymentMethod->name }}</td>
                    <td>{{ number_format($payment->amount, 2) }}</td>
                    <td>{{ $payment->reference ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        <!-- Notes -->
        @if($sale->notes)
        <h3 class="section-title">Notes</h3>
        <p style="font-size: 11px; margin: 5px 0 10px 0;">{{ $sale->notes }}</p>
        @endif

        <!-- Footer -->
        <div class="invoice-footer">
            @if ($business->receipt_footer)
                <img src="{{ public_path('backend/'.$business->receipt_footer) }}" alt="Footer" style="width: 100%; height: auto; max-height: 80px; object-fit: contain;">
            @else
                <div class="footer-content">
                    <p class="urdu-note">
                        Note: Purchased goods are returnable and exchangeable, provided they are not damaged.
                    </p>
                    <div class="signature">
                        {{-- <p style="margin: 0; color: #d2691e; font-size: 12px;"><br>
                        <span style="font-size: 14px;">M.D. Autos</span></p> --}}
                        <br>
                        <div class="signature-line"></div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
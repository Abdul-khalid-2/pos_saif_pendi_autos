<div class="modal fade" id="invoiceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Invoice #{{ $sale->invoice_number }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Vertical Receipt Container -->
                <div class="receipt-container" style="width: 300px; margin: 0 auto; font-family: Arial, sans-serif; padding: 10px; font-size: 14px; line-height: 1.4;">
                    <!-- Business Header -->
                    <div style="text-align: center; margin-bottom: 10px; border-bottom: 1px dashed #ccc; padding-bottom: 10px;">
                        @if($business->logo_path)
                        <img src="{{ asset('backend/'.$business->logo_path) }}" alt="Logo" style="max-height: 50px; margin-bottom: 5px;">
                        @endif
                        <h3 style="margin: 5px 0; font-size: 16px;">{{ $business->name }}</h3>
                        <p style="margin: 3px 0; font-size: 12px;">{{ $business->address }}</p>
                        <p style="margin: 3px 0; font-size: 12px;">Tel: {{ $business->phone }}</p>
                    </div>

                    <!-- Receipt Info -->
                    <div style="margin-bottom: 10px; border-bottom: 1px dashed #ccc; padding-bottom: 10px;">
                        <div style="display: flex; justify-content: space-between;">
                            <span><strong>Date:</strong></span>
                            <span>{{ $sale->sale_date->format('d/m/Y H:i') }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span><strong>Invoice #:</strong></span>
                            <span>{{ $sale->invoice_number }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span><strong>Cashier:</strong></span>
                            <span>{{ $sale->user->name }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span><strong>Branch:</strong></span>
                            <span>{{ $sale->branch->name }}</span>
                        </div>
                    </div>

                    <!-- Customer Info -->
                    <div style="margin-bottom: 10px; border-bottom: 1px dashed #ccc; padding-bottom: 10px;">
                        <p style="margin: 5px 0;"><strong>CUSTOMER:</strong></p>
                        @if($sale->customer)
                        <p style="margin: 3px 0;">{{ $sale->customer->name }}</p>
                        @if($sale->customer->phone)
                        <p style="margin: 3px 0;">Tel: {{ $sale->customer->phone }}</p>
                        @endif
                        @elseif($sale->walk_in_customer_info)
                        <p style="margin: 3px 0;">{{ $sale->walk_in_customer_info['name'] ?? 'Walk-in Customer' }}</p>
                        @if(isset($sale->walk_in_customer_info['phone']))
                        <p style="margin: 3px 0;">Tel: {{ $sale->walk_in_customer_info['phone'] }}</p>
                        @endif
                        @else
                        <p style="margin: 3px 0;">Walk-in Customer</p>
                        @endif
                    </div>

                    <!-- Items List -->
                    <div style="margin-bottom: 10px; border-bottom: 1px dashed #ccc;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th style="text-align: left; padding: 3px 0; border-bottom: 1px dashed #ccc;">Item</th>
                                    <th style="text-align: right; padding: 3px 0; border-bottom: 1px dashed #ccc;">Qty×Price</th>
                                    <th style="text-align: right; padding: 3px 0; border-bottom: 1px dashed #ccc;">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sale->items as $item)
                                <tr>
                                    <td style="text-align: left; padding: 3px 0; font-size: 13px;">
                                        {!! $item->variant ? $item->variant->name .'</br>'. $item->variant->sku : 'Default' !!}
                                    </td>
                                    <td style="text-align: right; padding: 3px 0; font-size: 13px;">
                                        {{ $item->quantity }}×{{ number_format($item->unit_price, 2) }}
                                    </td>
                                    <td style="text-align: right; padding: 3px 0; font-size: 13px;">
                                        {{ number_format($item->total_price, 2) }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Totals -->
                    <div style="margin-bottom: 10px;">
                        <div style="display: flex; justify-content: space-between;">
                            <span>Subtotal:</span>
                            <span>{{ number_format($sale->subtotal, 2) }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span>Tax:</span>
                            <span>{{ number_format($sale->tax_amount, 2) }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span>Discount:</span>
                            <span>-{{ number_format($sale->discount_amount, 2) }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; font-weight: bold; border-top: 1px dashed #ccc; margin-top: 5px; padding-top: 5px;">
                            <span>TOTAL:</span>
                            <span>{{ number_format($sale->total_amount, 2) }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span>Amount Paid:</span>
                            <span>{{ number_format($sale->amount_paid, 2) }}</span>
                        </div>
                        @if($sale->change_amount > 0)
                        <div style="display: flex; justify-content: space-between;">
                            <span>Change:</span>
                            <span>{{ number_format($sale->change_amount, 2) }}</span>
                        </div>
                        @endif
                    </div>

                    <!-- Payment Method -->
                    <div style="margin-bottom: 10px; border-bottom: 1px dashed #ccc; padding-bottom: 10px;">
                        <p style="margin: 5px 0;"><strong>Payment Method:</strong></p>
                        <p style="margin: 3px 0;">
                            {{ $sale->payments->first()->paymentMethod->name ?? 'N/A' }}
                            @if($sale->payments->first()->reference ?? false)
                            (Ref: {{ $sale->payments->first()->reference }})
                            @endif
                        </p>
                    </div>

                    <!-- Footer -->
                    <div style="text-align: center; font-size: 12px;">
                        <p style="margin: 5px 0;">Thank you for your purchase!</p>
                        @if($business->receipt_footer)
                        <img src="{{ asset('backend/'.$business->receipt_footer) }}" alt="Footer" style="max-width: 100%;">
                        @else
                        <p style="font-family: 'Jameel Noori Nastaleeq', 'Noto Nastaliq Urdu', serif; direction: rtl; margin: 5px 0;">
                            نوٹ: خریدا ہوا مال واپس اور تبدیل ہوتا ہے، بشرطیکہ خراب نہ ہو۔
                        </p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="printReceipt">
                    <i class="las la-print"></i> Print Receipt
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('printReceipt').addEventListener('click', function() {
        // Create a completely clean HTML for printing
        const printContent = `
            <!DOCTYPE html>
            <html>
            <head>
                <title>Receipt - {{ $sale->invoice_number }}</title>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <style>
                    /* COMPLETELY REMOVE ALL MARGINS AND PADDING */
                    @page {
                        size: 80mm 150mm; /* Thermal paper size: 80mm wide, auto height */
                        margin: 0 !important;
                        padding: 0 !important;
                        margin-top: 0 !important;
                        margin-bottom: 0 !important;
                        margin-left: 0 !important;
                        margin-right: 0 !important;
                    }
                    
                    /* RESET EVERYTHING */
                    html, body {
                        width: 80mm !important;
                        min-width: 80mm !important;
                        max-width: 80mm !important;
                        height: auto !important;
                        margin: 5px !important;
                        padding: 5px !important;
                        border: 0 !important;
                        font-family: 'Courier New', monospace !important;
                        font-size: 11px !important;
                        line-height: 1 !important;
                        background: white !important;
                        color: black !important;
                        overflow: hidden !important;
                        -webkit-print-color-adjust: exact !important;
                        print-color-adjust: exact !important;
                    }
                    
                    /* RECEIPT CONTAINER - EXACT THERMAL PAPER WIDTH */
                    .thermal-receipt {
                        width: 80mm !important;
                        min-width: 80mm !important;
                        max-width: 80mm !important;
                        margin: 10px auto !important;
                        padding: 10px !important;
                        box-sizing: border-box !important;
                        position: relative !important;
                        left: 0 !important;
                        top: 0 !important;
                    }
                    
                    /* ALL ELEMENTS INSIDE - NO MARGINS, MINIMAL PADDING */
                    .thermal-receipt * {
                        margin: 0 !important;
                        padding: 0 !important;
                        box-sizing: border-box !important;
                        font-family: inherit !important;
                    }
                    
                    /* SPECIFIC ELEMENT STYLES */
                    .thermal-receipt .header {
                        text-align: center;
                        padding: 2px 0 !important;
                        border-bottom: 1px solid #000;
                        margin-bottom: 2px !important;
                    }
                    
                    .thermal-receipt .header img {
                        max-height: 35px !important;
                        max-width: 70mm !important;
                        display: block;
                        margin: 0 auto 1px !important;
                    }
                    
                    .thermal-receipt .header h3 {
                        font-size: 13px !important;
                        font-weight: bold;
                        margin: 0 0 1px 0 !important;
                        padding: 0 !important;
                    }
                    
                    .thermal-receipt .header p {
                        font-size: 10px !important;
                        margin: 0 !important;
                        padding: 0 !important;
                        line-height: 1.1 !important;
                    }
                    
                    /* INFO ROWS - SIMPLE TABLES */
                    .info-row {
                        display: table !important;
                        width: 100% !important;
                        table-layout: fixed !important;
                        margin: 1px 0 !important;
                    }
                    
                    .info-label {
                        display: table-cell !important;
                        width: 40% !important;
                        text-align: left !important;
                        font-weight: bold !important;
                        font-size: 10px !important;
                    }
                    
                    .info-value {
                        display: table-cell !important;
                        width: 60% !important;
                        text-align: right !important;
                        font-size: 10px !important;
                    }
                    
                    /* DIVIDERS */
                    .divider {
                        border-top: 1px dashed #000;
                        margin: 2px 0 !important;
                        padding: 0 !important;
                        height: 0 !important;
                    }
                    
                    /* ITEMS TABLE */
                    .items-table {
                        width: 100% !important;
                        border-collapse: collapse !important;
                        margin: 2px 0 !important;
                        font-size: 10px !important;
                    }
                    
                    .items-table th,
                    .items-table td {
                        padding: 1px 0 !important;
                        border: none !important;
                    }
                    
                    .items-table th {
                        border-bottom: 1px solid #000 !important;
                    }
                    
                    .items-table td:first-child {
                        width: 50% !important;
                        text-align: left !important;
                    }
                    
                    .items-table td:nth-child(2) {
                        width: 20% !important;
                        text-align: center !important;
                    }
                    
                    .items-table td:last-child {
                        width: 30% !important;
                        text-align: right !important;
                    }
                    
                    /* TOTALS */
                    .total-row {
                        display: table !important;
                        width: 100% !important;
                        table-layout: fixed !important;
                        margin: 1px 0 !important;
                    }
                    
                    .total-label {
                        display: table-cell !important;
                        width: 60% !important;
                        text-align: left !important;
                        font-size: 10px !important;
                    }
                    
                    .total-value {
                        display: table-cell !important;
                        width: 40% !important;
                        text-align: right !important;
                        font-size: 10px !important;
                    }
                    
                    .grand-total {
                        border-top: 2px solid #000 !important;
                        border-bottom: 2px solid #000 !important;
                        margin: 2px 0 !important;
                        padding: 2px 0 !important;
                        font-weight: bold !important;
                        font-size: 11px !important;
                    }
                    
                    /* FOOTER */
                    .footer {
                        text-align: center;
                        margin-top: 3px !important;
                        padding-top: 2px !important;
                        border-top: 1px solid #000;
                        font-size: 10px !important;
                    }
                    
                    /* PRINT-SPECIFIC OVERRIDES */
                    @media print {
                        /* FORCE NO MARGINS */
                        @page {
                            size: 80mm auto !important;
                            margin: 0mm !important;
                            margin-top: 0mm !important;
                            margin-bottom: 0mm !important;
                            margin-left: 0mm !important;
                            margin-right: 0mm !important;
                        }
                        
                        /* HIDE EVERYTHING EXCEPT RECEIPT */
                        body * {
                            visibility: hidden;
                        }
                        
                        .thermal-receipt, 
                        .thermal-receipt * {
                            visibility: visible !important;
                        }
                        
                        .thermal-receipt {
                            position: absolute !important;
                            left: 0 !important;
                            top: 0 !important;
                            width: 90mm !important;
                        }
                        
                        /* HIDE PRINT BUTTONS */
                        .no-print {
                            display: none !important;
                        }
                    }
                </style>
            </head>
            <body>
                <div class="thermal-receipt">
                    <!-- Header -->
                    <div class="header">
                    
                        <h3>{{ strtoupper($business->name) }}</h3>
                        <p>{{ $business->address }}</p>
                        <p>Tel: {{ $business->phone }}</p>
                    </div>
                    
                    <!-- Receipt Info -->
                    <div class="info-row">
                        <span class="info-label">Date:</span>
                        <span class="info-value">{{ $sale->sale_date->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Invoice:</span>
                        <span class="info-value">{{ $sale->invoice_number }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Cashier:</span>
                        <span class="info-value">{{ $sale->user->name }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Branch:</span>
                        <span class="info-value">{{ $sale->branch->name }}</span>
                    </div>
                    
                    <div class="divider"></div>
                    
                    <!-- Customer -->
                    <div style="text-align: center; margin: 1px 0; font-weight: bold; font-size: 10px;">
                        CUSTOMER
                    </div>
                    @if($sale->customer)
                    <div class="info-row">
                        <span class="info-label">Name:</span>
                        <span class="info-value">{{ strtoupper($sale->customer->name) }}</span>
                    </div>
                    @if($sale->customer->phone)
                    <div class="info-row">
                        <span class="info-label">Phone:</span>
                        <span class="info-value">{{ $sale->customer->phone }}</span>
                    </div>
                    @endif
                    @else
                    <div class="info-row">
                        <span class="info-label">Customer:</span>
                        <span class="info-value">WALK-IN</span>
                    </div>
                    @endif
                    
                    <div class="divider"></div>
                    
                    <!-- Items -->
                    <table class="items-table">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Qty</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sale->items as $item)
                            <tr>
                                <td style="text-align: left; font-size: 9px;">
                                    {{ $item->variant ? $item->variant->name : 'N/A' }}
                                    @if($item->variant && $item->variant->sku)
                                    <br><span style="font-size: 8px;">{{ $item->variant->sku }}</span>
                                    @endif
                                </td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->total_price, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <div class="divider"></div>
                    
                    <!-- Totals -->
                    <div class="total-row">
                        <span class="total-label">Subtotal:</span>
                        <span class="total-value">{{ number_format($sale->subtotal, 2) }}</span>
                    </div>
                    @if($sale->tax_amount > 0)
                    <div class="total-row">
                        <span class="total-label">Tax:</span>
                        <span class="total-value">{{ number_format($sale->tax_amount, 2) }}</span>
                    </div>
                    @endif
                    @if($sale->discount_amount > 0)
                    <div class="total-row">
                        <span class="total-label">Discount:</span>
                        <span class="total-value">-{{ number_format($sale->discount_amount, 2) }}</span>
                    </div>
                    @endif
                    
                    <div class="total-row grand-total">
                        <span class="total-label">TOTAL:</span>
                        <span class="total-value">{{ number_format($sale->total_amount, 2) }}</span>
                    </div>
                    
                    <div class="total-row">
                        <span class="total-label">Paid:</span>
                        <span class="total-value">{{ number_format($sale->amount_paid, 2) }}</span>
                    </div>
                    @if($sale->change_amount > 0)
                    <div class="total-row">
                        <span class="total-label">Change:</span>
                        <span class="total-value">{{ number_format($sale->change_amount, 2) }}</span>
                    </div>
                    @endif
                    
                    <!-- Footer -->
                    <div class="footer">
                        <p>Thank you for your business!</p>
                        <p>{{ now()->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
                
                <script>
                    // Force print immediately and close
                    window.onload = function() {
                        // Try to remove browser print margins
                        try {
                            var style = document.createElement('style');
                            style.innerHTML = '@page { margin: 0 !important; }';
                            document.head.appendChild(style);
                        } catch(e) {}
                        
                        // Small delay then print
                        setTimeout(function() {
                            window.print();
                        }, 50);
                        
                        // Close after print
                        window.onafterprint = function() {
                            setTimeout(function() {
                                window.close();
                            }, 100);
                        };
                    };
                <\/script>
            </body>
            </html>
        `;
        
        // Open in a very small window to force thermal paper size
        const printWindow = window.open('', '_blank', 'width=350,height=600');
        printWindow.document.write(printContent);
        printWindow.document.close();
    });
</script>
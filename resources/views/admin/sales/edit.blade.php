<x-app-layout>
    @push('css')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css')}}">
    @endpush

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4 class="card-title">Edit Sale #{{ $sale->invoice_number }}</h4>
                        <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-light">Cancel</a>
                    </div>
                    <div class="card-body">
                        <form id="saleForm" action="{{ route('sales.update', $sale->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <!-- Basic Information -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Invoice Number *</label>
                                        <input type="text" name="invoice_number" class="form-control"
                                            value="{{ $sale->invoice_number }}" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Date *</label>
                                        <input type="date" name="sale_date" class="form-control" 
                                            value="{{ $sale->sale_date->format('Y-m-d') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Branch *</label>
                                        <select name="branch_id" class="form-control" required>
                                            <option value="">Select Branch</option>
                                            @foreach($branches as $branch)
                                                <option value="{{ $branch->id }}" {{ $sale->branch_id == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Customer Selection -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Customer</label>
                                        <select name="customer_id" class="form-control">
                                            <option value="">Walk-in Customer</option>
                                            @foreach($customers as $customer)
                                                <option value="{{ $customer->id }}" {{ $sale->customer_id == $customer->id ? 'selected' : '' }}>
                                                    {{ $customer->name }} ({{ $customer->phone }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Sale Items -->
                                <div class="col-md-12">
                                    <h5>Sale Items</h5>
                                    <div id="saleItems">
                                        @foreach($sale->items as $index => $item)
                                        <div class="row item-row mb-3">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <select name="items[{{ $index }}][product_id]" class="form-control product-select" required>
                                                        <option value="">Select Product</option>
                                                        @foreach($products as $product)
                                                            <option value="{{ $product->id }}" 
                                                                {{ $item->product_id == $product->id ? 'selected' : '' }}>
                                                                {{ $product->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <select name="items[{{ $index }}][variant_id]" class="form-control variant-select">
                                                        <option value="">Select Variant</option>
                                                        @if($item->variant_id)
                                                            @foreach($item->product->variants as $variant)
                                                                <option value="{{ $variant->id }}" 
                                                                    {{ $item->variant_id == $variant->id ? 'selected' : '' }}
                                                                    data-price="{{ $variant->selling_price }}"
                                                                    data-cost="{{ $variant->purchase_price }}">
                                                                    {{ $variant->name }} ({{ $variant->sku }}) - Stock: {{ $variant->current_stock }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <input type="number" name="items[{{ $index }}][quantity]" class="form-control" 
                                                        min="1" value="{{ $item->quantity }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <input type="number" step="0.01" name="items[{{ $index }}][unit_price]" 
                                                        class="form-control unit-price" min="0" value="{{ $item->unit_price }}" required>
                                                    <input type="hidden" name="items[{{ $index }}][cost_price]" 
                                                        class="cost-price" value="{{ $item->cost_price }}">
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" class="btn btn-danger remove-item">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <button type="button" id="addItem" class="btn btn-primary">
                                        <i class="las la-plus mr-2"></i>Add Item
                                    </button>
                                </div>
                                
                                <!-- Discount Field -->
                                <div class="col-md-12 mt-3">
                                    <div class="form-group">
                                        <label>Discount Amount</label>
                                        <input type="number" step="0.01" name="discount_amount" class="form-control" 
                                            id="discountInput" min="0" value="{{ $sale->discount_amount }}">
                                    </div>
                                </div>
                                
                                <!-- Payment Information -->
                                <div class="col-md-12 mt-4">
                                    <h5>Payment Information</h5>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Payment Method *</label>
                                                <select name="payment_method_id" class="form-control" required>
                                                    <option value="">Select Method</option>
                                                    @foreach($paymentMethods as $method)
                                                        <option value="{{ $method->id }}" 
                                                            {{ $sale->payments->first() && $sale->payments->first()->payment_method_id == $method->id ? 'selected' : '' }}>
                                                            {{ $method->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Amount Paid *</label>
                                                <input type="number" step="0.01" name="amount_paid" class="form-control" 
                                                    min="0" value="{{ $sale->amount_paid }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Payment Reference / Location</label>
                                                <div id="payment-reference-container">
                                                    <!-- Dynamic content will be loaded here -->
                                                    @php
                                                        $currentReference = $sale->payments->first() ? $sale->payments->first()->reference : '';
                                                        $customerHasReferences = $sale->customer && !empty($sale->customer->references);
                                                    @endphp
                                                    
                                                    @if($customerHasReferences)
                                                        <!-- If customer has references, show dropdown -->
                                                        <select name="payment_reference" id="payment-reference-select" class="form-control">
                                                            <option value="">Select Location/Reference</option>
                                                            <option value="other" {{ !in_array($currentReference, $sale->customer->references ?? []) && $currentReference ? 'selected' : '' }}>
                                                                Other (Manual Value)
                                                            </option>
                                                            @foreach($sale->customer->references as $reference)
                                                                <option value="{{ $reference }}" {{ $currentReference == $reference ? 'selected' : '' }}>
                                                                    {{ $reference }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <input type="text" name="manual_reference" id="manual-reference-input" 
                                                            class="form-control mt-2" 
                                                            placeholder="Enter manual reference"
                                                            value="{{ !in_array($currentReference, $sale->customer->references ?? []) && $currentReference ? $currentReference : '' }}"
                                                            style="{{ in_array($currentReference, $sale->customer->references ?? []) || !$currentReference ? 'display: none;' : '' }}">
                                                    @else
                                                        <!-- If no references or walk-in customer, show simple input -->
                                                        <input type="text" name="payment_reference" class="form-control"
                                                            value="{{ $currentReference }}"
                                                            placeholder="Enter reference or location (optional)">
                                                    @endif
                                                </div>
                                                <small class="text-muted">
                                                    <i class="fas fa-info-circle"></i> Optional: For location-based billing
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Summary -->
                                <div class="col-md-12 mt-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <p><strong>Subtotal:</strong> <span id="subtotal">{{ number_format($sale->subtotal, 2) }}</span></p>
                                                    <p><strong>Tax:</strong> <span id="taxAmount">{{ number_format($sale->tax_amount, 2) }}</span></p>
                                                    <p><strong>Discount:</strong> <span id="discountAmount">{{ number_format($sale->discount_amount, 2) }}</span></p>
                                                </div>
                                                <div class="col-md-4">
                                                    <p><strong>Total Amount:</strong> <span id="totalAmount">{{ number_format($sale->total_amount, 2) }}</span></p>
                                                    <p><strong>Amount Paid:</strong> <span id="displayAmountPaid">{{ number_format($sale->amount_paid, 2) }}</span></p>
                                                    <p><strong>Change Due:</strong> <span id="changeAmount">{{ number_format($sale->change_amount, 2) }}</span></p>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Notes</label>
                                                        <textarea name="notes" class="form-control" rows="3">{{ $sale->notes }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-12 mt-3">
                                    <button type="submit" class="btn btn-primary">Update Sale</button>
                                    <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-light">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('js')
    <!-- Backend Bundle JavaScript -->
    <script src="{{ asset('backend/assets/js/backend-bundle.min.js') }}"></script>

    <!-- Table Treeview JavaScript -->
    <script src="{{ asset('backend/assets/js/table-treeview.js') }}"></script>

    <!-- Chart Custom JavaScript -->
    <script src="{{ asset('backend/assets/js/customizer.js') }}"></script>

    <!-- Chart Custom JavaScript -->
    <script async src="{{ asset('backend/assets/js/chart-custom.js') }}"></script>

    <!-- app JavaScript -->
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>
    @endpush
    @push('js')
    <script>
    $(document).ready(function() {
        let itemCount = {{ count($sale->items) }};
        
        // Add new item row
        $('#addItem').click(function() {
            const newRow = `
                <div class="row item-row mb-3">
                    <div class="col-md-5">
                        <div class="form-group">
                            <select name="items[${itemCount}][product_id]" class="form-control product-select" required>
                                <option value="">Select Product</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="items[${itemCount}][variant_id]" class="form-control variant-select">
                                <option value="">Select Variant</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <input type="number" name="items[${itemCount}][quantity]" class="form-control" min="1" value="1" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="number" step="0.01" name="items[${itemCount}][unit_price]" class="form-control unit-price" min="0" required>
                            <input type="hidden" name="items[${itemCount}][cost_price]" class="cost-price">
                        </div>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger remove-item">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </div>
                </div>`;
            
            $('#saleItems').append(newRow);
            itemCount++;
        });
        
        // Remove item row
        $(document).on('click', '.remove-item', function() {
            if ($('.item-row').length > 1) {
                $(this).closest('.item-row').remove();
                calculateTotals();
            }
        });
        
        // Load variants when product changes
        $(document).on('change', '.product-select', function() {
            const productId = $(this).val();
            const variantSelect = $(this).closest('.item-row').find('.variant-select');
            const unitPriceInput = $(this).closest('.item-row').find('.unit-price');
            const costPriceInput = $(this).closest('.item-row').find('.cost-price');
            
            if (productId) {
                $.get(`/inventory-logs/variants/${productId}`, function(variants) {
                    variantSelect.empty().append('<option value="">Select Variant</option>');
                    
                    variants.forEach(variant => {
                        variantSelect.append(`<option value="${variant.id}" 
                            data-price="${variant.selling_price}" 
                            data-cost="${variant.purchase_price}">
                            ${variant.name} (${variant.sku}) - Stock: ${variant.current_stock}
                        </option>`);
                    });
                    
                    // If there's only one variant, select it by default
                    if (variants.length === 1) {
                        variantSelect.val(variants[0].id).trigger('change');
                    }
                });
            } else {
                variantSelect.empty().append('<option value="">Select Variant</option>');
                unitPriceInput.val('');
                costPriceInput.val('');
            }
        });
        
        // Set unit price when variant changes
        $(document).on('change', '.variant-select', function() {
            const selectedOption = $(this).find('option:selected');
            const unitPriceInput = $(this).closest('.item-row').find('.unit-price');
            const costPriceInput = $(this).closest('.item-row').find('.cost-price');
            
            if (selectedOption.data('price')) {
                unitPriceInput.val(selectedOption.data('price'));
                costPriceInput.val(selectedOption.data('cost'));
            } else {
                unitPriceInput.val('');
                costPriceInput.val('');
            }
            
            calculateTotals();
        });
        
        // Calculate totals when quantity, price or discount changes
        $(document).on('input', 'input[name*="quantity"], input[name*="unit_price"], #discountInput', function() {
            calculateTotals();
        });
        
        // Update display when amount paid changes
        $('input[name="amount_paid"]').on('input', function() {
            const amountPaid = parseFloat($(this).val()) || 0;
            const totalAmount = parseFloat($('#totalAmount').text()) || 0;
            const changeDue = Math.max(0, amountPaid - totalAmount);
            
            $('#displayAmountPaid').text(amountPaid.toFixed(2));
            $('#changeAmount').text(changeDue.toFixed(2));
        });
        
        // Calculate all totals
        function calculateTotals() {
            let subtotal = 0;
            let taxAmount = 0;
            
            $('.item-row').each(function() {
                const quantity = parseFloat($(this).find('input[name*="quantity"]').val()) || 0;
                const unitPrice = parseFloat($(this).find('input[name*="unit_price"]').val()) || 0;
                const itemTotal = quantity * unitPrice;
                subtotal += itemTotal;
            });
            
            const discountAmount = parseFloat($('#discountInput').val()) || 0;
            const totalAmount = subtotal + taxAmount - discountAmount;
            const amountPaid = parseFloat($('input[name="amount_paid"]').val()) || 0;
            const changeDue = Math.max(0, amountPaid - totalAmount);
            
            $('#subtotal').text(subtotal.toFixed(2));
            $('#taxAmount').text(taxAmount.toFixed(2));
            $('#discountAmount').text(discountAmount.toFixed(2));
            $('#totalAmount').text(totalAmount.toFixed(2));
            $('#changeAmount').text(changeDue.toFixed(2));
        }
    });


    // Function to load customer references
    function loadCustomerReferences(customerId) {
        console.log('Loading references for customer:', customerId);
        
        if (!customerId || customerId === '') {
            // For walk-in customers or no customer selected
            resetToInputField();
            return;
        }
        
        // Get current reference value
        const currentReference = $('input[name="payment_reference"]').val() || 
                                $('#payment-reference-select').val() ||
                                '{{ $sale->payments->first() ? $sale->payments->first()->reference : "" }}';
        
        console.log('Current reference:', currentReference);
        
        // Show loading state
        $('#payment-reference-container').html(`
            <div class="input-group">
                <select class="form-control" disabled>
                    <option>Loading references...</option>
                </select>
                <div class="input-group-append">
                    <span class="input-group-text">
                        <i class="fas fa-spinner fa-spin"></i>
                    </span>
                </div>
            </div>
        `);
        
        // Make AJAX call to get customer references
        $.ajax({
            url: '/customer/' + customerId + '/references',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                console.log('API Response:', response);
                
                if (response.references && response.references.length > 0) {
                    // Customer has references, show dropdown
                    let options = '<option value="">Select Location/Reference</option>';
                    options += '<option value="other">Other (Manual Value)</option>';
                    
                    response.references.forEach(function(reference) {
                        const selected = currentReference === reference ? 'selected' : '';
                        options += `<option value="${reference}" ${selected}>${reference}</option>`;
                    });
                    
                    $('#payment-reference-container').html(`
                        <select name="payment_reference" id="payment-reference-select" class="form-control">
                            ${options}
                        </select>
                        <input type="text" name="manual_reference" id="manual-reference-input" 
                            class="form-control mt-2" 
                            placeholder="Enter manual reference"
                            style="display: none;">
                    `);
                    
                    // Show manual input if current reference is not in list or is "other"
                    if (currentReference && !response.references.includes(currentReference)) {
                        $('#payment-reference-select').val('other');
                        $('#manual-reference-input').show().val(currentReference);
                    }
                    
                    // Handle dropdown change
                    $('#payment-reference-select').on('change', function() {
                        if ($(this).val() === 'other') {
                            $('#manual-reference-input').show().focus();
                            // Clear any previous payment_reference values
                            $('input[name="payment_reference"]').remove();
                            // Add a hidden input with the manual value
                            const manualValue = $('#manual-reference-input').val();
                            if (manualValue) {
                                $('#saleForm').append(`<input type="hidden" name="payment_reference" value="${manualValue}">`);
                            }
                        } else {
                            $('#manual-reference-input').hide();
                            // Clear any previous payment_reference values
                            $('input[name="payment_reference"]').remove();
                            // Add a hidden input with the selected value
                            $('#saleForm').append(`<input type="hidden" name="payment_reference" value="${$(this).val()}">`);
                        }
                    });
                    
                    // Update form data when manual input changes
                    $('#manual-reference-input').on('input', function() {
                        // Remove old payment_reference inputs
                        $('input[name="payment_reference"]').remove();
                        // Add new one with current value
                        const value = $(this).val();
                        if (value) {
                            $('#saleForm').append(`<input type="hidden" name="payment_reference" value="${value}">`);
                        }
                    });
                    
                    // Trigger change event on page load if needed
                    if ($('#payment-reference-select').val() === 'other') {
                        $('#payment-reference-select').trigger('change');
                    }
                    
                } else {
                    // Customer has no references, show input field
                    resetToInputField(currentReference);
                    
                    // Show info message
                    showNoReferencesMessage();
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                // On error, show input field
                resetToInputField(currentReference);
                showErrorMessage();
            }
        });
    }

    // Reset to simple input field
    function resetToInputField(value = '') {
        console.log('Resetting to input field with value:', value);
        $('#payment-reference-container').html(`
            <input type="text" name="payment_reference" class="form-control"
                value="${value}"
                placeholder="Enter reference or location (optional)">
        `);
        // Clear any old hidden inputs
        $('input[name="payment_reference"][type="hidden"]').remove();
        // Ensure the visible input is properly named
        $('input[name="payment_reference"][type="text"]').attr('name', 'payment_reference');
    }

    // Show message when customer has no references
    function showNoReferencesMessage() {
        $('.text-muted').html(`
            <i class="fas fa-info-circle text-info"></i> 
            <span class="text-info">Customer has no saved references</span>
        `);
    }

    // Show error message
    function showErrorMessage() {
        $('.text-muted').html(`
            <i class="fas fa-exclamation-triangle text-warning"></i> 
            <span class="text-warning">Failed to load references</span>
        `);
    }

    // Handle customer selection change
    $('select[name="customer_id"]').on('change', function() {
        const customerId = $(this).val();
        console.log('Customer changed to:', customerId);
        loadCustomerReferences(customerId);
    });

    // Initialize on page load
    $(document).ready(function() {
        const customerId = $('select[name="customer_id"]').val();
        console.log('Initial customer ID:', customerId);
        loadCustomerReferences(customerId);
        
        // Handle form submission to ensure proper reference value
        $('#saleForm').on('submit', function(e) {
            console.log('Form submitting...');
            
            let finalReference = '';
            
            // Check if we're using dropdown or input
            if ($('#payment-reference-select').length > 0) {
                const selectedValue = $('#payment-reference-select').val();
                console.log('Dropdown selected:', selectedValue);
                
                if (selectedValue === 'other') {
                    finalReference = $('#manual-reference-input').val() || '';
                } else {
                    finalReference = selectedValue || '';
                }
                
                // Remove any existing payment_reference inputs and add the correct one
                $('input[name="payment_reference"]').remove();
                if (finalReference) {
                    $(this).append(`<input type="hidden" name="payment_reference" value="${finalReference}">`);
                }
                
            } else {
                // Using simple input field
                finalReference = $('input[name="payment_reference"]').val() || '';
                console.log('Input field value:', finalReference);
            }
            
            console.log('Final reference to submit:', finalReference);
            
            // Continue with form submission (no need to prevent default)
        });
    });


    // Initialize on page load
    $(document).ready(function() {
        const customerId = $('select[name="customer_id"]').val();
        loadCustomerReferences(customerId);
        
        // Handle form submission to ensure proper reference value
        $('#saleForm').on('submit', function(e) {
            e.preventDefault();
            
            let finalReference = '';
            
            // Check if we're using dropdown or input
            if ($('#payment-reference-select').length > 0) {
                const selectedValue = $('#payment-reference-select').val();
                
                if (selectedValue === 'other') {
                    finalReference = $('#manual-reference-input').val() || '';
                } else {
                    finalReference = selectedValue || '';
                }
                
                // Remove any existing payment_reference inputs and add the correct one
                $('input[name="payment_reference"]').remove();
                $(this).append(`<input type="hidden" name="payment_reference" value="${finalReference}">`);
                
            } else {
                // Using simple input field
                finalReference = $('input[name="payment_reference"]').val() || '';
            }
            
            // Submit the form
            this.submit();
        });
    });

    // Handle manual reference input
    $(document).on('input', '#manual-reference-input', function() {
        // Update the actual payment_reference value
        const value = $(this).val();
        $('input[name="payment_reference"]').val(value);
    });
    </script>
    @endpush
</x-app-layout>
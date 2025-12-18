<x-app-layout>
    @push('css')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css')}}">
    <link rel="stylesheet" href="{{ asset('backend/assets/admin/custome-style/creater_order.css')}}">
    @endpush

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4 class="card-title">Edit Order #{{ $order->order_number }}</h4>
                        <div>
                            <span class="badge bg-primary me-2">Branch: {{ $currentBranch->name ?? 'Not Selected' }}</span>
                            <span class="badge bg-secondary">User: {{ auth()->user()->name }}</span>
                            <span class="order-status-badge status-{{ $order->status }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="orderForm" method="POST" action="{{ route('orders.update', $order->id) }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="order_number" value="{{ $order->order_number }}">
                            <input type="hidden" name="branch_id" value="{{ $currentBranch->id ?? '' }}">
                            
                            <!-- Hidden fields for summary data -->
                            <input type="hidden" name="subtotal" id="formSubtotal" value="{{ $order->subtotal }}">
                            <input type="hidden" name="tax_amount" id="formTaxAmount" value="{{ $order->tax_amount }}">
                            <input type="hidden" name="discount_amount" id="formDiscountAmount" value="{{ $order->discount_amount }}">
                            <input type="hidden" name="total_amount" id="formTotalAmount" value="{{ $order->total_amount }}">
                            <input type="hidden" name="customer_id" id="formCustomerId" value="{{ $order->customer_id ?? 0 }}">
                            <input type="hidden" name="status" id="formStatus" value="{{ $order->status }}">
                            <input type="hidden" name="storage_type" id="formStorageType" value="{{ $order->storage_type }}">
                            
                            <div class="pos-container">
                                <!-- Product Selection Area -->
                                <div class="product-area">
                                    <!-- Barcode Scanner -->
                                    <div class="barcode-scanner mb-3">
                                        <div class="input-group">
                                            <input type="text" id="barcodeInput" class="form-control" 
                                                placeholder="Scan barcode or search product..." autofocus>
                                        </div>
                                    </div>
                                    
                                    <!-- Category Tabs -->
                                    <div class="category-tabs-container">
                                        <div class="category-nav-arrow left">
                                            <i class="las la-angle-left"></i>
                                        </div>
                                        <div class="category-tabs" id="categoryTabs">
                                            <div class="category-tab search_active active" data-category-id="">All Products</div>
                                            <!-- Categories will be loaded via AJAX -->
                                        </div>
                                        <div class="category-nav-arrow right">
                                            <i class="las la-angle-right"></i>
                                        </div>
                                    </div>
                                    
                                    <!-- Product Grid -->
                                    <div class="product-grid" id="productGrid">
                                        <!-- Products will be loaded via AJAX -->
                                        <div class="text-center py-5">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Cart Container -->
                                <div class="cart-container">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Customer</label>
                                            <div class="input-group">
                                                <select name="customer_id" id="customerSelect" class="form-control select2-customer">
                                                    <option value="Walk-in-Customer" {{ !$order->customer_id ? 'selected' : '' }}>Walk-in Customer</option>
                                                    @foreach($customers as $customer)
                                                        <option value="{{ $customer->id }}" 
                                                            {{ $order->customer_id == $customer->id ? 'selected' : '' }}>
                                                            {{ $customer->name ??"" }} ({{ $customer->phone }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-outline-secondary" id="addCustomCustomer">
                                                        <i class="las la-user-plus"></i> New Customer
                                                    </button>
                                                </div>
                                            </div>
                                            <div id="customCustomerContainer" class="mt-2" style="display: {{ $order->walk_in_customer_info ? 'block' : 'none' }};">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input type="text" name="custom_customer_name" id="customCustomerName" 
                                                            class="form-control" placeholder="Customer Name"
                                                            value="{{ $order->walk_in_customer_info ? $order->walk_in_customer_info['name'] : '' }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" name="custom_customer_phone" id="customCustomerPhone" 
                                                            class="form-control" placeholder="Phone Number"
                                                            value="{{ $order->walk_in_customer_info ? $order->walk_in_customer_info['phone'] : '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="cart-items" id="cartItems">                                        @if(count($order->items) > 0)
                                            @foreach($order->items as $index => $item)
                                                <div class="cart-item" data-index="{{ $index }}">
                                                    <div>
                                                        <div class="fw-bold">{{ $item->product->name ?? "----"}}</div>
                                                        @if($item->variant)
                                                            <div class="small text-muted">{{ $item->variant->name ??"" }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="cart-item-controls">
                                                        <button class="btn btn-sm btn-outline-secondary decrement">
                                                            <i class="las la-minus"></i>
                                                        </button>
                                                        <input type="number" min="1" class="form-control form-control-sm quantity-input" 
                                                            value="{{ $item->quantity }}" style="width:80px">
                                                        <button class="btn btn-sm btn-outline-secondary increment">
                                                            <i class="las la-plus"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-danger remove-item ms-2">
                                                            <i class="las la-times"></i>
                                                        </button>
                                                    </div>
                                                    <div class="text-end">
                                                        <div>Rs {{ number_format($item->unit_price * $item->quantity, 2) }}</div>
                                                        <div class="small text-muted">Rs {{ number_format($item->unit_price, 2) }} each</div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="text-muted text-center py-5">Your cart is empty</div>
                                        @endif
                                    </div>
                                    
                                    <div class="cart-summary">
                                        <div class="summary-row">
                                            <span>Subtotal:</span>
                                            <span id="cartSubtotal">Rs {{ number_format($order->subtotal, 2) }}</span>
                                        </div>
                                        <div class="summary-row">
                                            <span>Tax:</span>
                                            <span id="cartTax">Rs {{ number_format($order->tax_amount, 2) }}</span>
                                        </div>
                                        <div class="summary-row">
                                            <span>Discount:</span>
                                            <div class="input-group input-group-sm">
                                                <input type="number" step="0.01" min="0" id="cartDiscount" class="form-control" 
                                                    value="{{ number_format($order->discount_amount, 2) }}">
                                                <span class="input-group-text">Rs</span>
                                            </div>
                                        </div>
                                        <div class="summary-row fw-bold fs-5">
                                            <span>Total:</span>
                                            <span id="cartTotal">Rs {{ number_format($order->total_amount, 2) }}</span>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label>Notes</label>
                                            <textarea name="notes" class="form-control" rows="2">{{ $order->notes }}</textarea>
                                        </div>
                                        
                                        <div class="order-actions row g-1 g-lg-3">
                                            <div class="px-3 mb-2" style="width: 50%">
                                                <button type="button" class="btn btn-danger w-100" id="clearCartBtn">
                                                    <i class="las la-trash"></i> Clear
                                                </button>
                                            </div>

                                            <div class="px-3 mb-2" style="width: 50%">
                                                <button type="button" class="btn btn-secondary w-100" id="saveDraftBtn">
                                                    <i class="las la-save"></i> Save Draft
                                                </button>
                                            </div>

                                            <div class="col-6 mb-2 col-md-3 col-lg-12 col-xl-12">
                                                <button type="button" class="btn btn-primary w-100" id="confirmOrderBtn">
                                                    <i class="las la-check"></i> Update Order
                                                </button>
                                            </div>

                                            <div class="col-6 col-md-3 col-lg-12 col-xl-12">
                                                @if($order->status === 'confirmed')
                                                    <button type="button" class="btn btn-success w-100 mb-2" id="completeOrderBtn">
                                                        <i class="las la-check-circle"></i> Complete Sale
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-success w-100 mb-2" id="completeOrderBtn" disabled>
                                                        <i class="las la-check-circle"></i> Complete Sale
                                                    </button>
                                                @endif
                                            </div>
                                            
                                            @if($order->status === 'draft')
                                            <div class="col-6 col-md-3 col-lg-12 col-xl-12">
                                                <button type="button" class="btn btn-warning w-100 mb-2" id="cancelOrderBtn">
                                                    <i class="las la-times-circle"></i> Cancel Order
                                                </button>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="cartItemsData">
                                <!-- Hidden fields for cart items -->
                                @foreach($order->items as $index => $item)
                                    <input type="hidden" name="items[{{ $index }}][product_id]" value="{{ $item->product_id }}">
                                    <input type="hidden" name="items[{{ $index }}][variant_id]" value="{{ $item->variant_id }}">
                                    <input type="hidden" name="items[{{ $index }}][quantity]" value="{{ $item->quantity }}">
                                    <input type="hidden" name="items[{{ $index }}][unit_price]" value="{{ $item->unit_price }}">
                                    <input type="hidden" name="items[{{ $index }}][cost_price]" value="{{ $item->cost_price }}">
                                @endforeach
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Variant Selection Modal -->
    <div class="modal fade" id="variantModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="popup text-left">
                        <div class="modal-header">
                            <h5 class="modal-title">Select Variant</h5>
                            <div class="btn btn-primary" data-dismiss="modal" aria-label="Close">x</div>
                        </div>
                        <div class="content create-workform bg-body" >
                            <div class="px-3 pt-3">
                                <input type="text" id="variantSearchInput" class="form-control" placeholder="Search variants...">
                            </div>
                            <div class="py-3" id="variantModalBody">
                                <!-- Variant options will be loaded here -->
                            </div>
                            <div class="col-lg-12 mt-4">
                                <div class="d-flex flex-wrap">
                                    <div class="btn btn-primary mr-4" data-dismiss="modal">Close</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- New Customer Modal -->
    <div class="modal fade" id="customerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" class="form-control" id="newCustomerName">
                    </div>
                    <div class="mb-3">
                        <label>Phone</label>
                        <input type="text" class="form-control" id="newCustomerPhone">
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" class="form-control" id="newCustomerEmail">
                    </div>
                    <div class="mb-3">
                        <label>Address</label>
                        <textarea class="form-control" id="newCustomerAddress"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveCustomerBtn">Save</button>
                </div>
            </div>
        </div>
    </div>

    @push('js')
    <script src="{{ asset('backend/assets/js/backend-bundle.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/table-treeview.js') }}"></script>
    <script src="{{ asset('backend/assets/js/customizer.js') }}"></script>
    <script async src="{{ asset('backend/assets/js/chart-custom.js') }}"></script>
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            // Global variables to store products and categories
            let allProducts = [];
            let allCategories = [];
            let currentBranch = null;
            let allCustomers = [];

            // Cart object to manage cart operations
            const cart = {
                items: [],
                orderId: "{{ $order->id }}",
                status: "{{ $order->status }}",
                storageType: "{{ $order->storage_type }}",
                
                // Initialize cart with existing order items
                init: function() {
                    @foreach($order->items as $index => $item)
                        this.items.push({
                            productId: "{{ $item->product_id }}",
                            variantId: "{{ $item->variant_id }}",
                            quantity: {{ $item->quantity }},
                            price: {{ $item->unit_price }},
                            costPrice: {{ $item->cost_price }},
                            name: "{{ $item->product->name ??"" }}",
                            variantName: "{{ $item->variant ? $item->variant->name : '' }}"
                        });
                    @endforeach
                    this.updateCart();
                },
                
                // Add item to cart
                addItem: function(productId, variantId, quantity = 1, price, costPrice, name, variantName) {
                    price = typeof price === 'string' ? parseFloat(price) : price;
                    costPrice = typeof costPrice === 'string' ? parseFloat(costPrice) : costPrice;
                    
                    const existingItem = this.items.find(item => 
                        item.productId === productId && item.variantId === variantId
                    );
                    
                    if (existingItem) {
                        existingItem.quantity += quantity;
                    } else {
                        this.items.push({
                            productId,
                            variantId,
                            quantity,
                            price,
                            costPrice,
                            name,
                            variantName
                        });
                    }
                    
                    this.updateCart();
                },
                
                // Remove item from cart
                removeItem: function(index) {
                    this.items.splice(index, 1);
                    this.updateCart();
                },
                // Update item quantity
                updateQuantity: function(index, quantity) {
                    if (quantity <= 0) {
                        this.removeItem(index);
                    } else {
                        this.items[index].quantity = quantity;
                    }
                    this.updateCart();
                },
                // Clear cart
                clear: function() {
                    this.items = [];
                    $('#cartDiscount').val('0');
                    this.updateCart();
                },
                
                // Calculate cart totals
                calculateTotals: function() {
                    let subtotal = 0;
                    let tax = 0;
                    
                    this.items.forEach(item => {
                        subtotal += item.price * item.quantity;
                    });
                    
                    const discount = parseFloat($('#cartDiscount').val()) || 0;
                    const total = subtotal + tax - discount;
                    
                    return { subtotal, tax, discount, total };
                },
                // Update cart UI
                updateCart: function() {
                    const cartItemsEl = $('#cartItems');
                    
                    if (this.items.length === 0) {
                        cartItemsEl.html('<div class="text-muted text-center py-5">Your cart is empty</div>');
                    } else {
                        let html = '';
                        
                        this.items.forEach((item, index) => {
                            html += `
                                <div class="cart-item" data-index="${index}">
                                    <div>
                                        <div class="fw-bold">${item.name}</div>
                                        ${item.variantName ? `<div class="small text-muted">${item.variantName}</div>` : ''}
                                    </div>
                                    <div class="cart-item-controls">
                                        <button class="btn btn-sm btn-outline-secondary decrement">
                                            <i class="las la-minus"></i>
                                        </button>
                                        <input type="number" min="1" class="form-control form-control-sm quantity-input" 
                                            value="${item.quantity}" style="width:80px">
                                        <button class="btn btn-sm btn-outline-secondary increment">
                                            <i class="las la-plus"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger remove-item ms-2">
                                            <i class="las la-times"></i>
                                        </button>
                                    </div>
                                    <div class="text-end">
                                        <div>Rs ${(item.price * item.quantity).toFixed(2)}</div>
                                        <div class="small text-muted">Rs ${item.price.toFixed(2)} each</div>
                                    </div>
                                </div>
                            `;
                        });
                        cartItemsEl.html(html);
                    }
                    
                    const totals = this.calculateTotals();
                    $('#cartSubtotal').text('Rs ' + totals.subtotal.toFixed(2));
                    $('#cartTax').text('Rs ' + totals.tax.toFixed(2));
                    $('#cartTotal').text('Rs ' + totals.total.toFixed(2));
                    
                    $('#formSubtotal').val(totals.subtotal);
                    $('#formTaxAmount').val(totals.tax);
                    $('#formDiscountAmount').val(totals.discount);
                    $('#formTotalAmount').val(totals.total);
                    
                    this.updateFormData();
                    this.updateUI();
                },

                // Update hidden form fields
                updateFormData: function() {
                    $('#formCustomerId').val($('#customerSelect').val());
                    
                    let itemsHtml = '';
                    this.items.forEach((item, index) => {
                        itemsHtml += `
                            <input type="hidden" name="items[${index}][product_id]" value="${item.productId}">
                            <input type="hidden" name="items[${index}][variant_id]" value="${item.variantId}">
                            <input type="hidden" name="items[${index}][quantity]" value="${item.quantity}">
                            <input type="hidden" name="items[${index}][unit_price]" value="${item.price}">
                            <input type="hidden" name="items[${index}][cost_price]" value="${item.costPrice}">
                        `;
                    });
                    $('#cartItemsData').html(itemsHtml);
                },

                // Set order status
                setStatus: function(status) {
                    this.status = status;
                    $('#formStatus').val(status);
                    this.updateUI();
                },

                // Set storage type
                setStorageType: function(type) {
                    this.storageType = type;
                    $('#formStorageType').val(type);
                },

                // Update UI based on status
                updateUI: function() {
                    $('#saveDraftBtn').prop('disabled', this.status === 'completed');
                    $('#confirmOrderBtn').prop('disabled', this.status === 'completed');
                    $('#completeOrderBtn').prop('disabled', this.status !== 'confirmed');
                    $('#cancelOrderBtn').prop('disabled', this.status !== 'draft');
                    
                    if (this.status === 'confirmed') {
                        $('.order-status-badge').removeClass('status-draft status-confirmed status-completed status-cancelled')
                            .addClass('status-confirmed')
                            .text('Confirmed');
                    }
                },

                getFormData: function() {
                    const formData = {
                        _method: 'PUT', // For Laravel method spoofing
                        customer_id: $('#customerSelect').val(),
                        subtotal: parseFloat($('#formSubtotal').val()),
                        tax_amount: parseFloat($('#formTaxAmount').val()),
                        discount_amount: parseFloat($('#formDiscountAmount').val()),
                        total_amount: parseFloat($('#formTotalAmount').val()),
                        status: this.status,
                        storage_type: this.storageType,
                        notes: $('textarea[name="notes"]').val(),
                        items: []
                    };
                    
                    // Handle custom customer info
                    if ($('#customCustomerContainer').is(':visible')) {
                        formData.custom_customer_name = $('#customCustomerName').val();
                        formData.custom_customer_phone = $('#customCustomerPhone').val();
                    }
                    
                    // Add items
                    this.items.forEach((item, index) => {
                        formData.items.push({
                            product_id: item.productId,
                            variant_id: item.variantId,
                            quantity: item.quantity,
                            unit_price: item.price,
                            cost_price: item.costPrice
                        });
                    });
                    
                    return formData;
                },


                // Save order (update)
                saveOrder: function() {
                    const formData = this.getFormData();
                    const url = `/orders/${this.orderId}`;
                     const csrfToken = $('meta[name="csrf-token"]').attr('content');
                    return $.ajax({
                        url: url,
                        type: 'PUT',
                        data: JSON.stringify(formData),
                        contentType: 'application/json',
                        processData: false,
                        headers: { 'X-CSRF-TOKEN': csrfToken },
                        success: (response) => {
                            if (response.order) {
                                this.status = response.order.status;
                                this.storageType = response.order.storage_type;
                                
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Order Updated',
                                    text: `Order #${response.order.order_number} has been updated`,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                            this.updateUI();
                        },
                        error: (xhr) => {
                            let errorMessage = 'An error occurred while updating the order';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            
                            Swal.fire({
                                icon: 'error',
                                title: 'Update Failed',
                                text: errorMessage,
                            });
                        }
                    });
                },

                // Complete order (convert to sale)
                completeOrder: function() {
                    const $btn = $('#completeOrderBtn');
                    $btn.prop('disabled', true);
                    $btn.html('<i class="las la-spinner la-spin"></i> Processing...');
                    
                    $.ajax({
                        url: `/orders/${this.orderId}/complete`,
                        type: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: (response) => {
                            if (response.success) {
                                this.status = 'completed';
                                this.updateUI();
                                
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Order Completed',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 2000
                                }).then(() => {
                                    if (response.print_url) {
                                        window.open(response.print_url, '_blank');
                                    }
                                    // Redirect to orders list after completion
                                    setTimeout(() => {
                                        window.location.href = "{{ route('orders.index') }}";
                                    }, 500);
                                });
                            }
                        },
                        error: (xhr) => {
                            $btn.prop('disabled', false);
                            $btn.html('<i class="las la-check-circle"></i> Complete Sale');
                            
                            let errorMessage = 'An error occurred while completing the order';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            
                            Swal.fire({
                                icon: 'error',
                                title: 'Completion Failed',
                                text: errorMessage,
                            });
                        }
                    });
                },

            // Cancel order
            cancelOrder: function() {
                Swal.fire({
                    title: 'Cancel Order?',
                    text: 'Are you sure you want to cancel this order? This action cannot be undone.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, cancel order',
                    cancelButtonText: 'No, keep order'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/orders/${this.orderId}/cancel`,
                            type: 'POST',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: (response) => {
                                if (response.success) {
                                    this.status = 'cancelled';
                                    this.updateUI();
                                    
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Order Cancelled',
                                        text: response.message,
                                        showConfirmButton: false,
                                        timer: 1500
                                    }).then(() => {
                                        // Redirect to orders list after cancellation
                                        window.location.href = "{{ route('orders.index') }}";
                                    });
                                }
                            },
                            error: (xhr) => {
                                let errorMessage = 'An error occurred while cancelling the order';
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMessage = xhr.responseJSON.message;
                                }
                                
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Cancellation Failed',
                                    text: errorMessage,
                                });
                            }
                        });
                    }
                });
            }
            };

            // Initialize the POS system
            function initializePOS() {
            loadAllData().then(() => {
                renderCategories();
                renderProducts();
                initializeEventHandlers();
                cart.init(); // Initialize cart with order items
            });
            }

            // Load all initial data
            function loadAllData() {
            return $.get("{{ route('allProducts') }}", function(response) {
                allProducts = response.products;
                allCategories = response.categories;
                currentBranch = response.currentBranch;
                allCustomers = response.customers;
                
                // Update customer dropdown
                updateCustomerDropdown();
                
                // Update branch info in header
                updateBranchInfo();
            }).fail(function(error) {
                console.error("Error loading data:", error);
                Swal.fire({
                    icon: 'error',
                    title: 'Loading Failed',
                    text: 'Failed to load products and categories'
                });
            });
            }

            // Render categories in the tabs
            function renderCategories() {
            let html = '<div class="category-tab search_active active" data-category-id="">All Products</div>';

            allCategories.forEach(category => {
                html += `<div class="category-tab" data-category-id="${category.id}">${category.name}</div>`;
            });

            $('#categoryTabs').html(html);
            }

            // Render products in the grid
            function renderProducts(filterCategoryId = '', searchTerm = '') {
                let filteredProducts = allProducts;

                // Filter by category if specified
                if (filterCategoryId) {
                    filteredProducts = allProducts.filter(product => product.category_id == filterCategoryId);
                }

                // Filter by search term if specified
                if (searchTerm) {
                    const term = searchTerm.toLowerCase();
                    filteredProducts = filteredProducts.filter(product => {
                        // Check product name
                        if (product.name.toLowerCase().includes(term)) return true;
                        
                        // Check variants
                        return product.variants.some(variant => {
                            // Check variant name or barcode
                            return variant.name.toLowerCase().includes(term) || 
                                (variant.barcode && variant.barcode.toLowerCase().includes(term));
                        });
                    });
                }

                let html = '';

                if (filteredProducts.length === 0) {
                    html = '<div class="text-muted text-center py-5">No products found</div>';
                } else {
                    filteredProducts.forEach(product => {
                        const hasVariants = product.variants.length > 1;
                        
                        // FIXED: Ensure we parse the price as a number before using toFixed()
                        let price = '';
                        if (!hasVariants && product.variants[0]?.selling_price) {
                            const sellingPrice = parseFloat(product.variants[0].selling_price) || 0;
                            price = `Rs ${sellingPrice.toFixed(2)}`;
                        }
                        
                        // Handle image path
                        let imagePath = "{{ asset('backend/assets/images/no_image.png') }}";
                        try {
                            if (product.image_paths) {
                                const parsedPaths = typeof product.image_paths === 'string' 
                                    ? JSON.parse(product.image_paths) 
                                    : product.image_paths;
                                if (Array.isArray(parsedPaths) && parsedPaths.length > 0) {
                                    imagePath = parsedPaths[0].startsWith('http') ? parsedPaths[0] : '/backend/' + parsedPaths[0];
                                }
                            }
                        } catch (e) {
                            console.error("Error parsing image paths:", e);
                        }

                        html += `
                            <div class="product-card" data-product-id="${product.id}" 
                                data-category-id="${product.category_id}"
                                data-variants="${hasVariants ? 'true' : 'false'}">
                                <img src="${imagePath}" alt="${product.name}" 
                                    onerror="this.src='/backend/assets/images/no_image.png'">
                                <div class="product-name">${product.name}</div>
                                ${hasVariants ? 
                                    `<div class="text-muted small">${product.variants.length} variants</div>` : 
                                    `<div class="product-price">${price}</div>`}
                            </div>
                        `;
                    });
                }

                $('#productGrid').html(html);
            }

            // Update customer dropdown
            function updateCustomerDropdown() {
            let html = '<option value="Walk-in-Customer" {{ !$order->customer_id ? 'selected' : '' }}>Walk-in Customer</option>';

            allCustomers.forEach(customer => {
                html += `<option value="${customer.id}" ${cart.customerId == customer.id ? 'selected' : ''}>${customer.name} (${customer.phone})</option>`;
            });

            $('#customerSelect').html(html);
            }

            // Update branch info in header
            function updateBranchInfo() {
            if (currentBranch) {
                $('.branch-info').text(`Branch: ${currentBranch.name}`);
            }
            }

            // Initialize event handlers
            function initializeEventHandlers() {
            // Category tab click
            $(document).on('click', '.category-tab', function() {
                $('.category-tab').removeClass('active');
                $(this).addClass('active');
                
                const categoryId = $(this).data('category-id');
                renderProducts(categoryId);
            });

            // Product card click handler
            $(document).on('click', '.product-card', function() {
                const productId = $(this).data('product-id');
                const hasVariants = $(this).data('variants');
                
                if (hasVariants) {
                    showVariantModel(productId);
                } else {
                    const productName = $(this).find('.product-name').text();
                    const price = parseFloat($(this).find('.product-price').text().replace('Rs ', ''));
                    
                    $.get(`/products/${productId}`, function(product) {
                        const variant = product.variants[0];
                        cart.addItem(
                            productId, 
                            variant.id, 
                            1, 
                            variant.selling_price, 
                            variant.purchase_price,
                            product.name,
                            variant.name
                        );
                    });
                }
            });

            // Search input
            $('#barcodeInput').on('keyup', function(e) {
                const searchTerm = $(this).val().trim();
                $('.category-tab').removeClass('active');
                $('.search_active').addClass('active');
                renderProducts('', searchTerm);
            });

            // Variant selection in modal
            $(document).on('click', '.variant-option', function() {
                cart.addItem(
                    $(this).data('product-id'),
                    $(this).data('variant-id'),
                    1,
                    $(this).data('price'),
                    $(this).data('cost'),
                    $(this).data('name'),
                    $(this).data('variant-name')
                );
                $('#variantModal').modal('hide');
            });

            // Cart item controls
            $(document).on('click', '.remove-item', function() {
                const index = $(this).closest('.cart-item').data('index');
                cart.removeItem(index);
            });

            $(document).on('click', '.increment', function() {
                const index = $(this).closest('.cart-item').data('index');
                const currentQty = parseInt($(this).siblings('.quantity-input').val());
                cart.updateQuantity(index, currentQty + 1);
            });

            $(document).on('click', '.decrement', function() {
                const index = $(this).closest('.cart-item').data('index');
                const currentQty = parseInt($(this).siblings('.quantity-input').val());
                cart.updateQuantity(index, currentQty - 1);
            });

            $(document).on('change', '.quantity-input', function() {
                const index = $(this).closest('.cart-item').data('index');
                const newQty = parseInt($(this).val());
                cart.updateQuantity(index, newQty);
            });

            // Discount input
            $('#cartDiscount').on('change', function() {
                cart.updateCart();
            });

            // Clear cart button
            $('#clearCartBtn').on('click', function() {
                Swal.fire({
                    title: 'Clear Cart?',
                    text: 'Are you sure you want to clear all items from the cart?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, clear it!',
                    cancelButtonText: 'No, keep items'
                }).then((result) => {
                    if (result.isConfirmed) {
                        cart.clear();
                    }
                });
            });

            // Save as draft button
            $('#saveDraftBtn').on('click', function() {
                if (cart.items.length === 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Empty Cart',
                        text: 'Please add items to the order before saving'
                    });
                    return;
                }
                
                cart.setStatus('draft');
                cart.setStorageType('database');
                cart.saveOrder();
            });

            // Update order button
            $('#confirmOrderBtn').on('click', function() {
                if (cart.items.length === 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Empty Cart',
                        text: 'Please add items to the order before updating'
                    });
                    return;
                }

                   $(this).prop("disabled", true);
                        Swal.fire({
                            title: 'Update Order?',
                            text: 'This will update the order with the current changes',
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonText: 'Yes, update',
                            cancelButtonText: 'Cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $(this).html('<i class="las la-spinner la-spin"></i> Processing...');
                                
                                // Determine the appropriate status based on current status
                                let newStatus = cart.status;
                                if (cart.status === 'draft') {
                                    newStatus = 'confirmed';
                                }
                                
                                cart.setStatus(newStatus);
                                cart.setStorageType('database');
                                
                                cart.saveOrder().then(() => {
                                    $(this).prop('disabled', false);
                                    $(this).html('<i class="las la-check"></i> Update Order');
                                    
                                    // Show success message
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Order Updated',
                                        text: 'Order has been successfully updated',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                }).catch(() => {
                                    $(this).prop('disabled', false);
                                    $(this).html('<i class="las la-check"></i> Update Order');
                                });
                            } else {
                                $(this).prop('disabled', false);
                            }
                        });
                    });
                    // Complete order button
            $('#completeOrderBtn').on('click', function() {
                Swal.fire({
                    title: 'Complete Order?',
                    text: 'This will convert the order to a sale and update inventory',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Complete Sale',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        cart.completeOrder();
                    }
                });
            });
                        
            // Cancel order button
            $('#cancelOrderBtn').on('click', function() {
                cart.cancelOrder();
            });

            // Customer selection
            $('#addCustomCustomer').click(function() {
                $('#customCustomerContainer').toggle();
                if ($('#customCustomerContainer').is(':visible')) {
                    $(this).html('<i class="las la-user-minus"></i> Cancel');
                    $('#customerSelect').val('Walk-in-Customer').trigger('change');
                } else {
                    $(this).html('<i class="las la-user-plus"></i> New Customer');
                    $('#customCustomerName').val('');
                    $('#customCustomerPhone').val('');
                }
            });

            $('#customerSelect').on('change', function() {
                if ($(this).val() !== 'Walk-in-Customer') {
                    $('#customCustomerContainer').hide();
                    $('#addCustomCustomer').html('<i class="las la-user-plus"></i> New Customer');
                    $('#customCustomerName').val('');
                    $('#customCustomerPhone').val('');
                }
                $('#formCustomerId').val($(this).val());
            });
            // New customer modal
            $('#saveCustomerBtn').click(function() {
                const name = $('#newCustomerName').val();
                const phone = $('#newCustomerPhone').val();
                const email = $('#newCustomerEmail').val();
                const address = $('#newCustomerAddress').val();
                
                if (!name || !phone) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Missing Information',
                        text: 'Please provide at least name and phone number'
                    });
                    return;
                }
                
                $.post('/customers', {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    name: name,
                    phone: phone,
                    email: email,
                    address: address
                }, function(response) {
                    if (response.success) {
                        // Add new customer to dropdown and select it
                        $('#customerSelect').append(
                            $('<option>', {
                                value: response.customer.id,
                                text: response.customer.name + ' (' + response.customer.phone + ')',
                                selected: true
                            })
                        );
                        
                        // Close modal
                        $('#customerModal').modal('hide');
                        
                        // Clear form
                        $('#newCustomerName').val('');
                        $('#newCustomerPhone').val('');
                        $('#newCustomerEmail').val('');
                        $('#newCustomerAddress').val('');
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Customer Added',
                            text: 'New customer has been added successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                }).fail(function(xhr) {
                    let errorMessage = 'Failed to add customer';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessage
                    });
                });
            });
            }

            function showVariantModel(productId) {
                // Create and show loader before making the request
                const loaderHtml = `
                    <div class="advanced-loader">
                        <div class="loader-backdrop"></div>
                        <div class="loader-content">
                            <div class="spinner-container">
                                <div class="spinner">
                                    <div class="spinner-circle spinner-circle-outer"></div>
                                    <div class="spinner-circle spinner-circle-inner"></div>
                                    <div class="spinner-circle spinner-circle-single-1"></div>
                                    <div class="spinner-circle spinner-circle-single-2"></div>
                                </div>
                            </div>
                            <div class="loader-text">Loading variants...</div>
                            <div class="progress-container">
                                <div class="progress-bar"></div>
                            </div>
                        </div>
                    </div>
                `;
                
                $('body').append(loaderHtml);
                
                // Start progress bar animation
                const progressBar = $('.progress-bar');
                let progress = 0;
                const progressInterval = setInterval(() => {
                    progress += 5;
                    progressBar.css('width', `${Math.min(progress, 90)}%`);
                }, 200);

                let url = "{{ route('products.variants', ':id') }}";
                url = url.replace(':id', productId);

                $.get(url, function(variants) {
                    clearInterval(progressInterval);
                    progressBar.css('width', '100%');
                    
                    // Add slight delay for smooth transition
                    setTimeout(() => {
                        $('.advanced-loader').fadeOut(300, function() {
                            $(this).remove();
                        });
                        
                        let modalBody = '';
                        variants.forEach(variant => {
                            modalBody += `
                                <div class="mb-2 variant-option" 
                                    data-product-id="${productId}"
                                    data-variant-id="${variant.id}"
                                    data-price="${variant.selling_price}"
                                    data-cost="${variant.purchase_price}"
                                    data-name="${variant.product?.name || ''}"
                                    data-variant-name="${variant.name}"
                                    data-search-text="${(variant.name + ' ' + variant.sku + ' ' + variant.selling_price).toLowerCase()}">
                                    <div class="d-flex justify-content-between align-items-center p-2 border rounded">
                                        <div>
                                            <strong>${variant.name}</strong>
                                            <div class="small" style="font-size:20px"> ${variant.sku}</div>
                                        </div>
                                        <div>
                                            <div>Rs ${parseFloat(variant.selling_price).toFixed(2)}</div>
                                            <div class="small text-muted">Stock: ${variant.current_stock}</div>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });
                        
                        $('#variantModalBody').html(modalBody);
                        
                        // Initialize search functionality
                        $('#variantSearchInput').on('input', function() {
                            const searchTerm = $(this).val().toLowerCase();
                            $('.variant-option').each(function() {
                                const searchText = $(this).data('search-text');
                                $(this).toggle(searchText.includes(searchTerm));
                            });
                        });
                        
                        var modal = new bootstrap.Modal(document.getElementById('variantModal'));
                        modal.show();
                        
                        // Focus on search input when modal is shown
                        $('#variantModal').on('shown.bs.modal', function() {
                            $('#variantSearchInput').focus();
                        });
                        
                    }, 300);
                    
                }).fail(function(error) {
                    clearInterval(progressInterval);
                    $('.loader-text').text('Failed to load variants');
                    $('.spinner-container').html('<i class="fas fa-exclamation-circle error-icon"></i>');
                    progressBar.css('width', '100%').addClass('error');
                    
                    setTimeout(() => {
                        $('.advanced-loader').fadeOut(300, function() {
                            $(this).remove();
                        });
                        
                        console.error("Error loading variants:", error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to load product variants'
                        });
                    }, 1000);
                });
                }

                // Initialize the POS system
                initializePOS();

                jQuery(document).ready(function() {
                    jQuery(".wrapper-menu").addClass("open");
                    jQuery("body").addClass("sidebar-main");
                });
        
            });        
                    
        </script>

    @endpush
</x-app-layout>
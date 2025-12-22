<x-app-layout>
    @push('css')
        <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.ico') }}" />
        <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css') }}">
    @endpush

    <div class="container-fluid add-form-list">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Edit Customer: {{ $customer->name }}</h4>
                        </div>
                        <div>
                            <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye mr-1"></i> View
                            </a>
                            <a href="{{ route('customers.index') }}" class="btn btn-sm btn-light">
                                <i class="fas fa-arrow-left mr-1"></i> Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('customers.update', $customer->id) }}" method="POST" data-toggle="validator">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card mb-3">
                                        <div class="card-header bg-light">
                                            <h5 class="mb-0">Customer References (Optional)</h5>
                                            <p class="mb-0 text-muted" style="font-size: 12px;">Add delivery locations or reference points for billing</p>
                                        </div>
                                        <div class="card-body">
                                            <div class="alert alert-info mb-3">
                                                <small><i class="fas fa-info-circle mr-2"></i> This is for customers who need separate billing for different locations/people. For direct customers, leave this empty.</small>
                                            </div>
                                            
                                            <div id="reference-fields">
                                                @if(!empty($customer->references))
                                                    @foreach($customer->references as $reference)
                                                        <div class="reference-item row mb-2">
                                                            <div class="col-md-11">
                                                                <input type="text" class="form-control reference-input" 
                                                                    value="{{ $reference }}" 
                                                                    placeholder="e.g., Karachi Office, Mr. Ali, Vehicle ABC-123">
                                                            </div>
                                                            <div class="col-md-1">
                                                                <button type="button" class="btn btn-sm btn-danger remove-reference">
                                                                    <i class="fas fa-times"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                            
                                            <div class="form-group mt-3">
                                                <button type="button" class="btn btn-sm btn-primary" id="add-reference">
                                                    <i class="fas fa-plus mr-1"></i> Add Reference
                                                </button>
                                                <button type="button" class="btn btn-sm btn-secondary" id="clear-references">
                                                    <i class="fas fa-trash mr-1"></i> Clear All
                                                </button>
                                            </div>
                                            
                                            <!-- Hidden field to store JSON data -->
                                            <input type="hidden" name="references_json" id="references_json" 
                                                value="{{ !empty($customer->references) ? json_encode($customer->references) : '[]' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Name *</label>
                                        <input type="text" name="name" class="form-control" 
                                            placeholder="Enter Name" value="{{ old('name', $customer->name) }}" required>
                                        <div class="help-block with-errors"></div>
                                        @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control" 
                                            placeholder="Enter Email" value="{{ old('email', $customer->email) }}">
                                        @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phone *</label>
                                        <input type="text" name="phone" class="form-control" 
                                            placeholder="Enter Phone" value="{{ old('phone', $customer->phone) }}" required>
                                        <div class="help-block with-errors"></div>
                                        @error('phone') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tax Number</label>
                                        <input type="text" name="tax_number" class="form-control" 
                                            placeholder="Enter Tax Number" value="{{ old('tax_number', $customer->tax_number) }}">
                                        @error('tax_number') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Customer Group *</label>
                                        <select name="customer_group" class="selectpicker form-control" data-style="py-0" required>
                                            <option value="retail" {{ old('customer_group', $customer->customer_group) == 'retail' ? 'selected' : '' }}>Retail</option>
                                            <option value="wholesale" {{ old('customer_group', $customer->customer_group) == 'wholesale' ? 'selected' : '' }}>Wholesale</option>
                                            <option value="vip" {{ old('customer_group', $customer->customer_group) == 'vip' ? 'selected' : '' }}>VIP</option>
                                        </select>
                                        @error('customer_group') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Credit Limit</label>
                                        <input type="number" name="credit_limit" class="form-control" 
                                            placeholder="Enter Credit Limit" 
                                            value="{{ old('credit_limit', $customer->credit_limit) }}" step="0.01">
                                        @error('credit_limit') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <textarea name="address" class="form-control" rows="3">{{ old('address', $customer->address) }}</textarea>
                                        @error('address') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Balance Adjustment</label>
                                        <div class="input-group">
                                            <select name="balance_operation" class="form-control" style="max-width: 120px;">
                                                <option value="add">Add</option>
                                                <option value="subtract">Subtract</option>
                                                <option value="set">Set To</option>
                                            </select>
                                            <input type="number" name="balance_adjustment" class="form-control" 
                                                placeholder="Amount" step="0.01" min="0">
                                        </div>
                                        <small class="form-text text-muted">
                                            Current balance: {{ number_format($customer->balance, 2) }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">
                                <i class="fas fa-save mr-1"></i> Update Customer
                            </button>
                            <button type="reset" class="btn btn-danger">
                                <i class="fas fa-undo mr-1"></i> Reset
                            </button>
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

        <script>
            $(document).ready(function() {
                // Initialize selectpicker
                $('.selectpicker').selectpicker();
                
                // Balance adjustment calculation
                $('[name="balance_operation"]').change(function() {
                    const operation = $(this).val();
                    const currentBalance = parseFloat({{ $customer->balance }});
                    const adjustmentInput = $('[name="balance_adjustment"]');
                    
                    if (operation === 'set') {
                        adjustmentInput.val(currentBalance.toFixed(2));
                    } else {
                        adjustmentInput.val('');
                    }
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                // Template for new reference field
                const referenceTemplate = `
                    <div class="reference-item row mb-2">
                        <div class="col-md-11">
                            <input type="text" class="form-control reference-input" 
                                placeholder="e.g., Karachi Office, Mr. Ali, Vehicle ABC-123">
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-sm btn-danger remove-reference">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                `;
                
                // Add reference field
                $('#add-reference').click(function() {
                    $('#reference-fields').append(referenceTemplate);
                    updateReferencesJson();
                });
                
                // Remove reference field
                $(document).on('click', '.remove-reference', function() {
                    $(this).closest('.reference-item').remove();
                    updateReferencesJson();
                });
                
                // Clear all references
                $('#clear-references').click(function() {
                    if (confirm('Are you sure you want to clear all references?')) {
                        $('#reference-fields').empty();
                        $('#references_json').val('[]');
                    }
                });
                
                // Update references on input change
                $(document).on('input', '.reference-input', function() {
                    updateReferencesJson();
                });
                
                // Update the hidden JSON field
                function updateReferencesJson() {
                    const references = [];
                    $('.reference-input').each(function() {
                        const value = $(this).val().trim();
                        if (value) {
                            references.push(value);
                        }
                    });
                    $('#references_json').val(JSON.stringify(references));
                }
                
                // Initialize if there are existing references
                updateReferencesJson();
            });
        </script>
    @endpush
</x-app-layout>
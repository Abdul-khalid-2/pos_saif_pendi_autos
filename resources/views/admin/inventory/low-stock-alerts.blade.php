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
                <div class="d-flex flex-wrap flex-wrap align-items-center justify-content-between mb-4">
                    <div>
                        <h4 class="mb-3">Low Stock Alerts</h4>
                        <p class="mb-0">Monitor products that need restocking.<br> Take action before items run out of stock.</p>
                    </div>
                    <div>
                        <a href="{{ route('inventory-logs.create') }}" class="btn btn-primary add-list">
                            <i class="las la-plus mr-1"></i> Quick Adjustment
                        </a>
                        <a href="{{ route('purchases.create') }}" class="btn btn-success add-list">
                            <i class="las la-shopping-cart mr-1"></i> Create Purchase Order
                        </a>
                    </div>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="col-lg-4">
                <div class="card bg-warning bg-soft">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-warning mb-2">Low Stock Items</h6>
                                <h2 class="mb-0">{{ $summary['total_low_stock'] }}</h2>
                                <p class="mb-0">Below reorder level</p>
                            </div>
                            <div class="align-self-center">
                                <i class="las la-exclamation-triangle text-warning" style="font-size: 3rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card bg-danger bg-soft">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-danger mb-2">Out of Stock</h6>
                                <h2 class="mb-0">{{ $summary['total_out_of_stock'] }}</h2>
                                <p class="mb-0">Need immediate attention</p>
                            </div>
                            <div class="align-self-center">
                                <i class="las la-ban text-danger" style="font-size: 3rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card bg-primary bg-soft">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-primary mb-2">Inventory Tracking</h6>
                                <h2 class="mb-0">{{ $summary['total_products_tracking'] }}</h2>
                                <p class="mb-0">Products being monitored</p>
                            </div>
                            <div class="align-self-center">
                                <i class="las la-clipboard-check text-primary" style="font-size: 3rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Out of Stock Section -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title text-danger mb-0">
                            <i class="las la-ban mr-2"></i> Out of Stock
                        </h5>
                        <span class="badge badge-danger">{{ $outOfStockVariants->total() }} Items</span>
                    </div>
                    <div class="card-body">
                        @if($outOfStockVariants->isEmpty())
                            <div class="text-center py-4">
                                <i class="las la-check-circle text-success" style="font-size: 3rem;"></i>
                                <h5 class="mt-3 text-success">Great! No items are out of stock.</h5>
                                <p class="text-muted">All items have sufficient stock.</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="bg-danger-light text-uppercase">
                                        <tr>
                                            <th>Product</th>
                                            <th>Variant</th>
                                            <th>SKU</th>
                                            <th>Category</th>
                                            <th>Supplier</th>
                                            <th>Current Stock</th>
                                            <th>Reorder Level</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($outOfStockVariants as $variant)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @php
                                                        $imagePath = null;
                                                        if ($variant->product->image_paths) {
                                                            $parsedPaths = is_string($variant->product->image_paths) 
                                                                ? json_decode($variant->product->image_paths, true) 
                                                                : $variant->product->image_paths;
                                                            if ($parsedPaths && is_array($parsedPaths) && count($parsedPaths) > 0) {
                                                                $imagePath = $parsedPaths[0];
                                                            }
                                                        }
                                                    @endphp
                                                    @if($imagePath)
                                                        <img src="{{ asset('storage/' . $imagePath) }}" 
                                                             class="rounded me-3" 
                                                             style="width: 40px; height: 40px; object-fit: cover;"
                                                             onerror="this.src='{{ asset('backend/assets/images/no_image.png') }}'">
                                                    @else
                                                        <img src="{{ asset('backend/assets/images/no_image.png') }}" 
                                                             class="rounded me-3" 
                                                             style="width: 40px; height: 40px; object-fit: cover;">
                                                    @endif
                                                    <div>
                                                        <h6 class="mb-0">{{ $variant->product->name }}</h6>
                                                        <small class="text-muted">{{ $variant->product->sku }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $variant->name }}</td>
                                            <td>
                                                <span class="badge badge-light">{{ $variant->sku }}</span>
                                            </td>
                                            <td>{{ $variant->product->category->name ?? 'N/A' }}</td>
                                            <td>{{ $variant->product->supplier->name ?? 'N/A' }}</td>
                                            <td>
                                                <span class="badge badge-danger">{{ $variant->current_stock }}</span>
                                            </td>
                                            <td>
                                                <span class="badge badge-warning">{{ $variant->product->reorder_level ?? 5 }}</span>
                                            </td>
                                            <td>
                                                <span class="badge badge-danger">Out of Stock</span>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('inventory-logs.create', ['product_id' => $variant->product_id, 'variant_id' => $variant->id]) }}" 
                                                       class="btn btn-sm btn-primary" 
                                                       data-toggle="tooltip" 
                                                       title="Add Stock">
                                                        <i class="las la-plus"></i>
                                                    </a>
                                                    <a href="{{ route('purchases.create', ['product_id' => $variant->product_id]) }}" 
                                                       class="btn btn-sm btn-success"
                                                       data-toggle="tooltip"
                                                       title="Create Purchase">
                                                        <i class="las la-shopping-cart"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if($outOfStockVariants->hasPages())
                                <div class="mt-3">
                                    {{ $outOfStockVariants->links() }}
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>

            <!-- Low Stock Section -->
            <div class="col-lg-12 mt-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title text-warning mb-0">
                            <i class="las la-exclamation-triangle mr-2"></i> Low Stock Items
                        </h5>
                        <span class="badge badge-warning">{{ $lowStockVariants->total() }} Items</span>
                    </div>
                    <div class="card-body">
                        @if($lowStockVariants->isEmpty())
                            <div class="text-center py-4">
                                <i class="las la-check-circle text-success" style="font-size: 3rem;"></i>
                                <h5 class="mt-3 text-success">All stock levels are good!</h5>
                                <p class="text-muted">No items are below reorder level.</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="bg-warning-light text-uppercase">
                                        <tr>
                                            <th>Product</th>
                                            <th>Variant</th>
                                            <th>SKU</th>
                                            <th>Category</th>
                                            <th>Supplier</th>
                                            <th>Current Stock</th>
                                            <th>Reorder Level</th>
                                            <th>Deficit</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($lowStockVariants as $variant)
                                        @php
                                            $deficit = ($variant->product->reorder_level ?? 5) - $variant->current_stock;
                                            $percentage = min(100, ($variant->current_stock / ($variant->product->reorder_level ?? 5)) * 100);
                                            $statusColor = $percentage < 25 ? 'danger' : ($percentage < 50 ? 'warning' : 'info');
                                        @endphp
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @php
                                                        $imagePath = null;
                                                        if ($variant->product->image_paths) {
                                                            $parsedPaths = is_string($variant->product->image_paths) 
                                                                ? json_decode($variant->product->image_paths, true) 
                                                                : $variant->product->image_paths;
                                                            if ($parsedPaths && is_array($parsedPaths) && count($parsedPaths) > 0) {
                                                                $imagePath = $parsedPaths[0];
                                                            }
                                                        }
                                                    @endphp
                                                    @if($imagePath)
                                                        <img src="{{ asset('storage/' . $imagePath) }}" 
                                                             class="rounded me-3" 
                                                             style="width: 40px; height: 40px; object-fit: cover;"
                                                             onerror="this.src='{{ asset('backend/assets/images/no_image.png') }}'">
                                                    @else
                                                        <img src="{{ asset('backend/assets/images/no_image.png') }}" 
                                                             class="rounded me-3" 
                                                             style="width: 40px; height: 40px; object-fit: cover;">
                                                    @endif
                                                    <div>
                                                        <h6 class="mb-0">{{ $variant->product->name }}</h6>
                                                        <small class="text-muted">{{ $variant->product->sku }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $variant->name }}</td>
                                            <td>
                                                <span class="badge badge-light">{{ $variant->sku }}</span>
                                            </td>
                                            <td>{{ $variant->product->category->name ?? 'N/A' }}</td>
                                            <td>{{ $variant->product->supplier->name ?? 'N/A' }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="me-2">{{ $variant->current_stock }}</span>
                                                    <div class="progress flex-grow-1" style="height: 6px;">
                                                        <div class="progress-bar bg-{{ $statusColor }}" 
                                                             role="progressbar" 
                                                             style="width: {{ $percentage }}%"
                                                             aria-valuenow="{{ $percentage }}" 
                                                             aria-valuemin="0" 
                                                             aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge badge-warning">{{ $variant->product->reorder_level ?? 5 }}</span>
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ $deficit > 10 ? 'danger' : 'warning' }}">
                                                    {{ $deficit }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ $statusColor }}">
                                                    {{ $percentage < 25 ? 'Critical' : ($percentage < 50 ? 'Low' : 'Warning') }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('inventory-logs.create', ['product_id' => $variant->product_id, 'variant_id' => $variant->id]) }}" 
                                                       class="btn btn-sm btn-primary" 
                                                       data-toggle="tooltip" 
                                                       title="Add Stock">
                                                        <i class="las la-plus"></i>
                                                    </a>
                                                    <a href="{{ route('purchases.create', ['product_id' => $variant->product_id]) }}" 
                                                       class="btn btn-sm btn-success"
                                                       data-toggle="tooltip"
                                                       title="Create Purchase">
                                                        <i class="las la-shopping-cart"></i>
                                                    </a>
                                                    <a href="{{ route('products.edit', $variant->product_id) }}" 
                                                       class="btn btn-sm btn-info"
                                                       data-toggle="tooltip"
                                                       title="Edit Product">
                                                        <i class="las la-edit"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if($lowStockVariants->hasPages())
                                <div class="mt-3">
                                    {{ $lowStockVariants->links() }}
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            {{-- <div class="col-lg-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="las la-bolt mr-2"></i> Quick Actions
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <i class="las la-file-import text-primary" style="font-size: 2rem;"></i>
                                        <h6 class="mt-2 mb-1">Bulk Restock</h6>
                                        <p class="text-muted small mb-2">Import stock updates</p>
                                        <a href="#" class="btn btn-sm btn-outline-primary">Import</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <i class="las la-print text-info" style="font-size: 2rem;"></i>
                                        <h6 class="mt-2 mb-1">Print Report</h6>
                                        <p class="text-muted small mb-2">Generate PDF report</p>
                                        <button onclick="window.print()" class="btn btn-sm btn-outline-info">Print</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <i class="las la-bell text-warning" style="font-size: 2rem;"></i>
                                        <h6 class="mt-2 mb-1">Alert Settings</h6>
                                        <p class="text-muted small mb-2">Configure notifications</p>
                                        <a href="#" class="btn btn-sm btn-outline-warning">Settings</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <i class="las la-chart-bar text-success" style="font-size: 2rem;"></i>
                                        <h6 class="mt-2 mb-1">Stock Analysis</h6>
                                        <p class="text-muted small mb-2">View stock trends</p>
                                        <a href="{{ route('reports.stock') }}" class="btn btn-sm btn-outline-success">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
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

    </script>
    @endpush
</x-app-layout>
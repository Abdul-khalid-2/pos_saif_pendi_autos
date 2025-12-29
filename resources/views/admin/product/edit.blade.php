<x-app-layout>
    @push('css')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css"/>
    @endpush

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Edit Product</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Product Name *</label>
                                        <input type="text" name="name" class="form-control" value="{{ old('name', $product->name ?? '') }}" required>
                                        @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>SKU *</label>
                                        <input type="text" name="sku" class="form-control" value="{{ old('sku', $product->sku ?? '') }}" required>
                                        @error('sku') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Barcode</label>
                                        <input type="text" name="barcode" class="form-control" value="{{ old('barcode', $product->barcode ?? '') }}">
                                        @error('barcode') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Category</label>
                                        <select name="category_id" class="selectpicker form-control" data-style="py-0">
                                            <option value="">Select Category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Brand</label>
                                        <select name="brand_id" class="selectpicker form-control" data-style="py-0">
                                            <option value="">Select Brand</option>
                                            @foreach($brands as $brand)
                                                <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id ?? '') == $brand->id ? 'selected' : '' }}>
                                                    {{ $brand->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('brand_id') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Supplier</label>
                                        <select name="supplier_id" class="selectpicker form-control" data-style="py-0">
                                            <option value="">Select Supplier</option>
                                            @foreach($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}" {{ old('supplier_id', $product->supplier_id ?? '') == $supplier->id ? 'selected' : '' }}>
                                                    {{ $supplier->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('supplier_id') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea name="description" class="form-control" rows="3">{{ old('description', $product->description ?? '') }}</textarea>
                                        @error('description') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status *</label>
                                        <select name="status" class="selectpicker form-control" data-style="py-0" required>
                                            <option value="active" {{ old('status', $product->status ?? 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ old('status', $product->status ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        @error('status') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Taxable</label>
                                        <select name="is_taxable" class="selectpicker form-control" data-style="py-0">
                                            <option value="1" {{ old('is_taxable', $product->is_taxable ?? 1) ? 'selected' : '' }}>Yes</option>
                                            <option value="0" {{ !old('is_taxable', $product->is_taxable ?? 1) ? 'selected' : '' }}>No</option>
                                        </select>
                                        @error('is_taxable') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Track Inventory</label>
                                        <select name="track_inventory" class="selectpicker form-control" data-style="py-0">
                                            <option value="1" {{ old('track_inventory', $product->track_inventory ?? 1) ? 'selected' : '' }}>Yes</option>
                                            <option value="0" {{ !old('track_inventory', $product->track_inventory ?? 1) ? 'selected' : '' }}>No</option>
                                        </select>
                                        @error('track_inventory') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Reorder Level</label>
                                        <input type="number" name="reorder_level" class="form-control" 
                                               value="{{ old('reorder_level', $product->reorder_level ?? 5) }}" min="0">
                                        @error('reorder_level') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Product Images</label>
                                        <div class="dropzone" id="productImagesDropzone"></div>
                                        <input type="hidden" name="image_paths" id="imagePaths" value="{{ old('image_paths', $product->image_paths ?? '[]') }}">
                                        @error('image_paths') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Update Product</button>
                            <a href="{{ route('products.index') }}" class="btn btn-danger">Cancel</a>
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
    
    <!-- Dropzone JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
    
    <script>
        // Initialize Dropzone for image uploads
        Dropzone.autoDiscover = false;
        
        $(document).ready(function() {
            let uploadedImages = [];
            
            // Parse existing images safely
            @if(isset($product) && $product->image_paths)
                try {
                    uploadedImages = JSON.parse(@json($product->image_paths));
                } catch(e) {
                    console.error('Error parsing image paths:', e);
                    uploadedImages = [];
                }
            @endif
            
            // Initialize dropzone
            let myDropzone = new Dropzone("#productImagesDropzone", {
                url: "{{ route('products.upload-image') }}",
                paramName: "image",
                maxFilesize: 2, // MB
                maxFiles: 10, // Limit number of files
                acceptedFiles: "image/*",
                addRemoveLinks: true,
                dictRemoveFile: "Remove",
                dictCancelUpload: "Cancel",
                dictDefaultMessage: "Drop files here or click to upload",
                dictFileTooBig: "File is too big .",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(file, response) {
                    console.log('Upload success:', response);
                    if (response.path) {
                        uploadedImages.push(response.path);
                        $('#imagePaths').val(JSON.stringify(uploadedImages));
                        file.name = response.path; // Store path in file name
                    }
                },
                error: function(file, response) {
                    console.error('Upload error:', response);
                    if (typeof response === 'string') {
                        try {
                            response = JSON.parse(response);
                        } catch(e) {
                            console.error('Parse error:', e);
                        }
                    }
                    let message = response.message || response.error || 'Upload failed';
                    file.previewElement.classList.add("dz-error");
                    $(file.previewElement).find('.dz-error-message').text(message);
                },
                removedfile: function(file) {
                    let path = file.name;
                    
                    console.log('Removing file:', path);
                    
                    // Remove from server
                    $.ajax({
                        url: "{{ route('products.remove-image') }}",
                        type: 'DELETE',
                        data: {
                            path: path,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            console.log('Remove success:', response);
                        },
                        error: function(xhr) {
                            console.error('Remove error:', xhr.responseText);
                        }
                    });
                    
                    // Remove from local array
                    const index = uploadedImages.indexOf(path);
                    if (index !== -1) {
                        uploadedImages.splice(index, 1);
                        $('#imagePaths').val(JSON.stringify(uploadedImages));
                    }
                    
                    // Remove preview
                    return file.previewElement.remove();
                },
                init: function() {
                    // Load existing images if editing
                    @if(isset($product) && $product->image_paths)
                        try {
                            let existingImages = JSON.parse(@json($product->image_paths));
                            console.log('Loading existing images:', existingImages);
                            
                            if (Array.isArray(existingImages)) {
                                existingImages.forEach(function(image) {
                                    if (image) {
                                        console.log('Adding image:', image);
                                        let mockFile = { 
                                            name: image, 
                                            size: 12345,
                                            accepted: true
                                        };
                                        
                                        this.emit("addedfile", mockFile);
                                        // Use proper URL for thumbnail
                                        let imageUrl = "{{ asset('backend') }}/" + image;
                                        console.log('Thumbnail URL:', imageUrl);
                                        this.emit("thumbnail", mockFile, imageUrl);
                                        this.emit("complete", mockFile);
                                    }
                                }.bind(this));
                            }
                        } catch(e) {
                            console.error('Error loading existing images:', e);
                        }
                    @endif
                    
                    // Set initial value for hidden input
                    $('#imagePaths').val(JSON.stringify(uploadedImages));
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
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
                <div class="d-flex flex-wrap justify-content-between mb-4">
                    <div>
                        <h4 class="mb-3">{{ __('messages.message_details') }}</h4>
                        <p class="mb-0">View and manage contact message details</p>
                    </div>
                    <div>
                        <span class="badge badge-{{ $message->is_read ? 'success' : 'warning' }}">
                            {{ $message->is_read ? __('messages.read') : __('messages.unread') }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold text-dark">{{ __('messages.name') }}</label>
                                    <p class="form-control-plaintext">{{ $message->name }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold text-dark">{{ __('messages.email') }}</label>
                                    <p class="form-control-plaintext">
                                        <a href="mailto:{{ $message->email }}">{{ $message->email }}</a>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold text-dark">{{ __('messages.phone') }}</label>
                                    <p class="form-control-plaintext">
                                        {{ $message->phone ?: 'N/A' }}
                                        @if($message->phone)
                                        <a href="tel:{{ $message->phone }}" class="ml-2 text-primary">
                                            <i class="ri-phone-line"></i>
                                        </a>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold text-dark">{{ __('messages.date') }}</label>
                                    <p class="form-control-plaintext">
                                        {{ $message->created_at->format('M d, Y H:i') }}
                                        <small class="text-muted">({{ $message->created_at->diffForHumans() }})</small>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-bold text-dark">{{ __('messages.message') }}</label>
                                    <div class="border p-3 rounded bg-light">
                                        <p class="mb-0" style="white-space: pre-wrap;">{{ $message->message }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <a href="{{ route('messages.index') }}" class="btn btn-secondary mr-2">
                                        <i class="ri-arrow-left-line mr-1"></i> {{ __('messages.back_to_list') }}
                                    </a>

                                    @if($message->is_read)
                                    <form action="{{ route('messages.markAsUnread', $message->id) }}" method="POST" class="mr-2">
                                        @csrf
                                        <button type="submit" class="btn btn-warning">
                                            <i class="ri-mail-unread-line mr-1"></i> {{ __('messages.mark_as_unread') }}
                                        </button>
                                    </form>
                                    @else
                                    <form action="{{ route('messages.markAsRead', $message->id) }}" method="POST" class="mr-2">
                                        @csrf
                                        <button type="submit" class="btn btn-success">
                                            <i class="ri-mail-check-line mr-1"></i> {{ __('messages.mark_as_read') }}
                                        </button>
                                    </form>
                                    @endif

                                    <a href="mailto:{{ $message->email }}?subject=Re: Your message from {{ $message->name }}" class="btn btn-primary">
                                        <i class="ri-reply-line mr-1"></i> Reply
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Message Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-{{ $message->is_read ? 'success' : 'warning' }} rounded-circle p-2 mr-3">
                                <i class="ri-mail-{{ $message->is_read ? 'check' : 'unread' }}-line text-white"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Status</h6>
                                <span class="text-muted">{{ $message->is_read ? 'Read' : 'Unread' }}</span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-info rounded-circle p-2 mr-3">
                                <i class="ri-calendar-event-line text-white"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Received</h6>
                                <span class="text-muted">{{ $message->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary rounded-circle p-2 mr-3">
                                <i class="ri-time-line text-white"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Time</h6>
                                <span class="text-muted">{{ $message->created_at->format('H:i A') }}</span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center">
                            <div class="bg-secondary rounded-circle p-2 mr-3">
                                <i class="ri-user-line text-white"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Contact</h6>
                                <span class="text-muted">{{ $message->name }}</span>
                            </div>
                        </div>
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
</x-app-layout>
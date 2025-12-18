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
                        <h4 class="mb-3">{{ __('messages.contact_messages') }}</h4>
                        <p class="mb-0">Manage all customer contact messages</p>
                    </div>

                </div>
            </div>
            <div class="col-lg-12">
                <div class="table-responsive rounded mb-3">
                    <table class="data-tables table mb-0 tbl-server-info">
                        <thead class="bg-white text-uppercase">
                            <tr>
                                <th>{{ __('messages.status') }}</th>
                                <th>{{ __('messages.name') }}</th>
                                <th>{{ __('messages.email') }}</th>
                                <th>{{ __('messages.phone') }}</th>
                                <th>{{ __('messages.message') }}</th>
                                <th>{{ __('messages.date') }}</th>
                                <th>{{ __('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($messages as $message)
                            <tr class="{{ $message->is_read ? '' : 'bg-light' }}">
                                <td>
                                    @if($message->is_read)
                                    <span class="badge badge-success">{{ __('messages.read') }}</span>
                                    @else
                                    <span class="badge badge-warning">{{ __('messages.unread') }}</span>
                                    @endif
                                </td>
                                <td>{{ $message->name }}</td>
                                <td>{{ $message->email }}</td>
                                <td>{{ $message->phone ?? 'N/A' }}</td>
                                <td>{{ Str::limit($message->message, 50) }}</td>
                                <td>{{ $message->created_at->format('M d, Y H:i') }}</td>
                                <td>
                                    <div class="d-flex align-items-center list-action">
                                        <a href="{{ route('messages.show', $message->id) }}" class="badge badge-info mr-2" data-toggle="tooltip" title="View">
                                            <i class="ri-eye-line mr-0"></i>
                                        </a>
                                        @if($message->is_read)
                                        <form action="{{ route('messages.markAsUnread', $message->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="badge badge-warning mr-2 border-0" data-toggle="tooltip" title="Mark as Unread">
                                                <i class="ri-mail-unread-line mr-0"></i>
                                            </button>
                                        </form>
                                        @else
                                        <form action="{{ route('messages.markAsRead', $message->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="badge badge-success mr-2 border-0" data-toggle="tooltip" title="Mark as Read">
                                                <i class="ri-mail-check-line mr-0"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
        // Initialize tooltips
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
    @endpush
</x-app-layout>
@if ($searchResults->isNotEmpty())
    <h3 id="search-results d-flex flex-column">Search Results:</h3>
    @foreach ($searchResults as $user)
        <div class="list-group-item">
            <div class="d-flex align-items-center">
                @if ($user->profile && $user->profile->profile_picture)
                    <img src="{{ asset('uploads/profile/' . $user->profile->profile_picture) }}" alt="Avatar"
                        class="mr-3">
                @else
                    <!-- Default Avatar Image -->
                    <img src="{{ asset('path/to/default/avatar.png') }}" alt="Default Avatar" class="mr-3">
                @endif
                <div class="info">
                    <p>{{ $user->firstname . ' ' . $user->lastname }} - {{ $user->email }} - {{ $user->mobile_number }}
                    </p>
                    <span class="username1">{{ '@' . $user->username }}</span>
                </div>
                <a href="{{ route('user.Profile', ['user_id' => $user->id]) }}" class="view-button">
                    View
                </a>
            </div>
        </div>
    @endforeach
    <!-- Previous and Next Buttons -->
    <div class="pagination-container ">
        @if ($searchResults->onFirstPage())
            <button class="btn" disabled>Prev</button>
        @else
            <a href="{{ $searchResults->previousPageUrl() }}" class="btn">Prev</a>
        @endif

        <!-- Current Page Number -->
        <span class="page-number">{{ $searchResults->currentPage() }}</span>

        @if ($searchResults->hasMorePages())
            <a href="{{ $searchResults->nextPageUrl() }}" class="btn">Next</a>
        @else
            <button class="btn" disabled>Next</button>
        @endif
    </div>
@else
    <p>No users found.</p>
@endif

<script>
    $(document).ready(function() {
        $('#searchInput').on('input', function() {
            let searchTerm = $(this).val();
            if (searchTerm.length > 0) {
                $.ajax({
                    url: '{{ route('search') }}',
                    method: 'GET',
                    data: {
                        search: searchTerm
                    },
                    success: function(response) {
                        $('#search-results-container').html(response);
                    }
                });
            } else {
                $('#search-results-container').html('<p>No users found.</p>');
            }
        });
    });
</script>

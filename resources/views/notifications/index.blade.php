<x-app-layout>
    <div class="container">
        <h2>Sales Notifications</h2>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @forelse ($notifications as $notification)
            <div class="notification-item">
                <strong>Sale ID: {{ $notification->sale_id }}</strong><br>
                <strong>Is 220 Days Exceeded:</strong> {{ $notification->is220 ? 'Yes' : 'No' }}<br>
                <strong>Is 330 Days Exceeded:</strong> {{ $notification->is330 ? 'Yes' : 'No' }}<br>
                <small>Created at: {{ $notification->created_at->diffForHumans() }}</small><br>
                <hr>
            </div>
        @empty
            <p>No notifications found.</p>
        @endforelse
    </div>

</x-app-layout>
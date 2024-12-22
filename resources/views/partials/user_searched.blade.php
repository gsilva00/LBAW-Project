<a href="{{ route('profile', ['username' => $user->username]) }}">
    <div class="user-search-container">
        <img src="{{ asset('images/profile/' . $user->profile_picture) }}" class="user-profile-picture-admin" alt="Searched user's profile picture">
        <p> {{ $user->display_name }} </p>
        <span class="small-text">{{ $user->username }}</span>
    </div>
</a>
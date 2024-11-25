<li class="user-tile">
    <div class="profile-container">
        <img src="{{ asset('images/profile/' . $user->profile_picture) }}" alt="profile_picture" class="user-profile-picture">
        <div class="profile-info">
            <h2>{{ $user->display_name }}</h2>

            <a href="{{ route('profile.edit', ['username' => $user->username]) }}">
                <button class="large-rectangle small-text greyer">Edit Profile</button>
            </a>
            <form action="{{ route('profile.delete', ['id' => $user->id]) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE') <!-- HTML forms don't directly support DELETE -->
                <button type="submit" class="large-rectangle small-text greyer">Delete This Account</button>
            </form>
        </div>
    </div>
</li>
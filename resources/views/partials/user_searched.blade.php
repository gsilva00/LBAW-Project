<div class="profile-container-admin">
    <img src="{{ asset('images/profile/' . $user->profile_picture) }}" class="user-profile-picture-admin" alt="Searched user's profile picture">

    <div class="profile-info">
        <h2>
            <a href="{{ route('profile', ['username' => $user->username]) }}">
                {{ $user->display_name }}
            </a>
        </h2>
    </div>
</div>
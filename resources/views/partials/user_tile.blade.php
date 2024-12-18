<div class="profile-container-admin">
    <img src="{{ asset('images/profile/' . $user->profile_picture) }}" class="user-profile-picture-admin" alt="User's profile picture" >

    <div class="profile-info">
        <h2>
            <a href="{{ route('profile', ['username' => $user->username]) }}">
                {{ $user->display_name }}
            </a>
        </h2>
        <a href="{{ route('editProfile', ['username' => $user->username]) }}" class="large-rectangle small-text greyer">
            Edit Profile
        </a>
        <form method="POST" action="{{ route('deleteProfile', ['id' => $user->id]) }}" style="display:inline;">
            @csrf
            <button type="submit" class="large-rectangle small-text greyer">Delete This Account</button>
        </form>
    </div>
</div>
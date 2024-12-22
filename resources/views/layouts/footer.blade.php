<footer>
    <a class="{{ Route::currentRouteName() == 'features' ? 'active' : '' }}" href="{{ route('features') }}"><h2>Features</h2></a>
    <a class="{{ Route::currentRouteName() == 'contacts' ? 'active' : '' }}" href="{{ route('contacts') }}">
        <h2>Contacts</h2>
    </a>
    <a class="{{ Route::currentRouteName() == 'aboutUs' ? 'active' : '' }}" href="{{ route('aboutUs') }}"><h2>About Us</h2></a>
    <h2 id="rights-reserved">{{ config('app.name', 'Laravel') }}, 2024 <i class='bx bx-copyright' ></i> All rights reserved</h2>
</footer>
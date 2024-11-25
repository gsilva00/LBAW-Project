<form class="dropdown-item" action="{{ route('search') }}" method="GET">
    <input type="search" name="search" placeholder="Search" aria-label="Search">
    <button type="submit">Search</button>
    <button type="button" id="add-filters-button">Filters</button>
</form>
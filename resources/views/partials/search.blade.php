<button type="button" id="search-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="button-for-search">
    <i class='bx bx-search'></i>
</button>
<div class="dropdown-menu" id="search-menu" aria-labelledby="search-button">
    <form class="dropdown-item" action="{{ route('search') }}" method="GET">
        <div class="search-container">
            <button class="p" type="button" id="filter-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="button-for-filter">
                <i class='bx bx-filter-alt'></i>
                <span>Filters</span>
            </button>
            <input type="search" name="search" placeholder="Search" aria-label="Search">
            <button class="p" type="submit"><span>Search</span></button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Action</a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
        </div>
        <div id="filter-options">
            <div class="filter-option">
                <label for="tag-input"><span>Tags</span></label>
                <input type="text" id="tag-input" placeholder="Type to search tags...">
                <div id="tag-suggestions" class="suggestions"></div>
                <div id="selected-tags" class="selected selected-maxwidth"></div>
            </div>

            <div class="filter-option">
                <label for="topic-input"><span>Topics</span></label>
                <input type="text" id="topic-input" placeholder="Type to search topics...">
                <div id="topic-suggestions" class="suggestions"></div>
                <div id="selected-topics" class="selected selected-maxwidth"></div>
            </div>
        </div>
    </form>

</div>
<script>
    window.tags = @json($tags);
    window.topics = @json($topics);
</script>

@section('scripts')
    <script src="{{ asset('js/filterdropdown.js') }}"></script>
@endsection
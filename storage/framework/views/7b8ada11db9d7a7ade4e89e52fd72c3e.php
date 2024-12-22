<button type="button" id="search-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="button-for-search">
    <i class='bx bx-search'></i>
</button>
<div class="dropdown-menu" id="search-menu" aria-labelledby="search-button">
    <form class="dropdown-item" action="<?php echo e(route('search')); ?>" method="GET">
        <div class="search-container">
        <button class="p" type="button" id="search-select-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="button-for-search-selection">
                <i class='bx bx-filter'></i>
                <span>Search By</span>
            </button>
            <div class="dropdown-menu" id="search-select-menu">
                    <input id="search-select-article" type="radio" name="search-select" value="article" checked="checked">
                    <label for="search-select-article" > Article </label>
                    <input id="search-select-user" type="radio" name="search-select" value="user">
                    <label for="search-select-user" > User </label>
                    <input id="search-select-comment" type="radio" name="search-select" value="comment">
                    <label for="search-select-comment" > Comment </label>
            </div>
            <button class="p" type="button" id="filter-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="button-for-filter">
                <i class='bx bx-filter-alt'></i>
                <span>Filters</span>
            </button>
            <input type="search" name="search" placeholder="Search" aria-label="Search">
            <button class="p greener" type="submit"><span>Search</span></button>
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
    window.tags = <?php echo json_encode($tags, 15, 512) ?>;
    window.topics = <?php echo json_encode($topics, 15, 512) ?>;
</script>

<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('js/filterdropdown.js')); ?>"></script>
<?php $__env->stopSection(); ?><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/partials/search.blade.php ENDPATH**/ ?>
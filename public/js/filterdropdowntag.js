document.addEventListener('DOMContentLoaded', function() {
    const filterButton = document.getElementById('filter-button');
    const filterDropdownMenu = filterButton.parentElement.nextElementSibling;

    filterButton.addEventListener('click', function() {
        event.stopPropagation();
        filterDropdownMenu.classList.toggle('show');
    });

    // Close the dropdown if clicked outside
    window.addEventListener('click', function(event) {
        if (!filterButton.contains(event.target) && !filterDropdownMenu.contains(event.target)) {
            filterDropdownMenu.classList.remove('show');
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const tags = window.tags;
    const tagInput = document.getElementById('tag-input');
    const tagSuggestions = document.getElementById('tag-suggestions');
    const selectedTags = document.getElementById('selected-tags');

    tagInput.addEventListener('input', function() {
        const query = tagInput.value.toLowerCase();
        tagSuggestions.innerHTML = '';

        if (query.length > 0) {
            const filteredTags = tags.filter(tag => tag.name.toLowerCase().includes(query));
            filteredTags.forEach(tag => {
                const suggestion = document.createElement('div');
                suggestion.classList.add('suggestion');
                const tagSpan = document.createElement('span');
                tagSpan.classList.add('small-text');
                tagSpan.innerText = tag.name;
                suggestion.appendChild(tagSpan);


                suggestion.addEventListener('click', function() {
                    event.preventDefault();
                    event.stopPropagation();
                    addTag(tag,tagSuggestions);
                    tagInput.value = '';
                    tagSuggestions.innerHTML = '';
                });

                tagSuggestions.appendChild(suggestion);
                if (tagSuggestions.children.length > 0) {
                    tagSuggestions.classList.add('show');
                }
            });
        }
    });

    function addTag(tag,tagSuggestions) {
        const topicSuggestions = document.getElementById('topic-suggestions');

        const existingTags = Array.from(selectedTags.getElementsByClassName('tag-block'));
        if (existingTags.some(tagBlock => tagBlock.querySelector('span').innerText.trim() === tag.name)) {
            return;
        }


        const tagBlock = document.createElement('div');
        tagBlock.classList.add('tag-block');
        tagBlock.classList.add('block');
        const tagSpan = document.createElement('span');
        tagSpan.classList.add('small-text');
        tagSpan.innerText = tag.name;
        tagBlock.appendChild(tagSpan);

        const removeButton = document.createElement('button');
        removeButton.classList.add('remove');
        removeButton.innerHTML = '&times;';
        removeButton.addEventListener('click', function() {
            event.stopPropagation();
            selectedTags.removeChild(tagBlock);

            if (selectedTags.children.length === 0) {
                topicSuggestions.classList.remove('tag-open');
            }
        });

        tagBlock.appendChild(removeButton);
        selectedTags.appendChild(tagBlock);

        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'tags[]';
        hiddenInput.value = tag.id;
        tagBlock.appendChild(hiddenInput);

        if (selectedTags.children.length > 0) {
            topicSuggestions.classList.add('tag-open');
        }

        tagSuggestions.classList.remove('show');
    }
});
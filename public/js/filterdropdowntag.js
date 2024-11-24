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

                suggestion.addEventListener('click', function(event) {
                    event.preventDefault();
                    event.stopPropagation();
                    addTag(tag);
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

    function addTag(tag) {
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
        removeButton.addEventListener('click', function(event) {
            event.stopPropagation();
            selectedTags.removeChild(tagBlock);
            updateHiddenInputs();
        });

        tagBlock.appendChild(removeButton);
        selectedTags.appendChild(tagBlock);

        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'tags[]';
        hiddenInput.value = tag.name;
        tagBlock.appendChild(hiddenInput);

        updateHiddenInputs();
    }

    function updateHiddenInputs() {
        const hiddenInputs = selectedTags.querySelectorAll('input[type="hidden"]');
        hiddenInputs.forEach(input => input.remove());

        const tagBlocks = selectedTags.getElementsByClassName('tag-block');
        Array.from(tagBlocks).forEach(tagBlock => {
            const tagName = tagBlock.querySelector('span').innerText.trim();
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'tags[]';
            hiddenInput.value = tagName;
            selectedTags.appendChild(hiddenInput);
        });
    }
});
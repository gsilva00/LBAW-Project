// Clicking on the X icon on the user feedback closes it
function closeMessage() {
    const messageButton = document.getElementById("close-message-button");
    if (messageButton) {
      const message = messageButton.parentElement;
      message.style.display = "none";
    }
}

function showReportUserPopup(userId) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const url = `/user/${userId}/report-modal`;
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
        .then(response => response.text())
        .then(html => {
            var popupContainer = document.createElement('div');
            popupContainer.innerHTML = html;
            document.body.appendChild(popupContainer);
            openPopUp();
            submitReportUser();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to load report user popup. See console for details.');
        });
}

function submitReportUser() {
    const reportReason = document.getElementById('reportReason');
    const reportCategory = document.getElementById('reportCategory');
    const submitButton = document.getElementById('submitReportButton');
    const maxLength = 300;

    reportReason.addEventListener('input', function () {
        const charCount = reportReason.value.length;
        if (charCount > maxLength) {
            reportReason.value = reportReason.value.substring(0, maxLength);
        }
        document.getElementById('charCountFeedback').textContent = `${charCount}/${maxLength} characters`;
    });

    submitButton.addEventListener('click', function () {
        const charCount = reportReason.value.length;
        if (charCount > maxLength) {
            alert('Reason for reporting cannot exceed 300 characters.');
            return;
        }

        const description = reportReason.value;
        const type = reportCategory.value;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const url = submitButton.getAttribute('data-action-url');

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                description: description,
                type: type
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closePopUp();
                } else {
                    alert('Failed to submit report. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to submit report. See console for details.');
            });
    });
}

document.getElementById('report-user-button').addEventListener('click', function() {
    const userId = document.querySelector('.profile-wrapper').getAttribute('data-user-id');
    showReportUserPopup(userId);
});


function openPopUp() {
    const popup = document.getElementById('reportArticlePopup');
    if (popup) {
        popup.style.display = 'flex';
    } else {
        console.error('Popup element not found');
    }
}

function closePopUp() {
    const popup = document.getElementById('reportArticlePopup');
    if (popup) {
        popup.style.display = 'none';
        popup.remove();
    } else {
        console.error('Popup element not found');
    }
}

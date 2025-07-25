document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('quote-form');
    const modal = document.getElementById('quote-success-modal');
    const closeModal = document.getElementById('close-quote-modal');

    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(form);
            formData.append('action', 'submit_quote_form');

            fetch(quoteForm.ajax_url, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'X-WP-Nonce': quoteForm.nonce
                },
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        modal.classList.add('show');
                        form.reset();

                        // Optional: Fire Meta Pixel event here
                        if (typeof fbq !== 'undefined') {
                            fbq('track', 'Lead');
                        }
                    } else {
                        alert(data.data || 'There was an error.');
                    }
                })
                .catch(err => {
                    alert('Submission failed. Please try again later.');
                    console.error(err);
                });
        });
    }

    if (closeModal) {
        closeModal.addEventListener('click', function () {
            modal.classList.remove('show');
        });
    }
});
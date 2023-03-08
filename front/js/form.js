(() => {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    const forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }

            form.classList.add('was-validated')
        }, false)
    })
})()

// Verifies if jQuery is active 
$(document).ready(function () {
    $('.needs-validation').submit(function (e) {
        e.preventDefault();

        var formData = new FormData(this);

        fetch('../back/register.php', {
            method: 'POST',
            body: formData,
        })
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {
                if (data.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.message,
                    })
                }
                else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: data.message,
                    })
                }
            });
    });
});
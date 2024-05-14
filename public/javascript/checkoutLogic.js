document.addEventListener('DOMContentLoaded', function () {
    const cardRadio = document.getElementById('card');
    const mbwayRadio = document.getElementById('mb-way');

    const cardInfo = document.querySelector('.card-info');
    const mbwayInfo = document.querySelector('.mbway-info');

    const confirmButton = document.getElementById('confirm-order');
    const cancelButton = document.querySelector('.cancel-button');

    const deliveryInfo = document.querySelector('.delivery-information-inputs');

    const successMessage = document.getElementById('success-message');
    const closeButton = document.getElementById('close-button');

    cardRadio.addEventListener('change', function () {
        if (cardRadio.checked) {
            cardInfo.style.display = 'grid';
            mbwayInfo.style.display = 'none';
            mbwayRadio.checked = false;
            confirmButton.style.display = 'inline-block';
            cancelButton.style.display = 'inline-block';
        }
    });

    mbwayRadio.addEventListener('change', function () {
        if (mbwayRadio.checked) {
            mbwayInfo.style.display = 'grid';
            cardInfo.style.display = 'none';
            cardRadio.checked = false;
            confirmButton.style.display = 'inline-block';
            cancelButton.style.display = 'inline-block';

        }
    });

    confirmButton.addEventListener('click', function () {
        let isValid;
        isValid = validateInputs(deliveryInfo)

        if(isValid) {
            if (cardRadio.checked) {
                isValid = validateInputs(cardInfo);
            }
            else {
                isValid = validateInputs(mbwayInfo);
            }

            if (isValid) {
                const confirmation = confirm('Are you sure you want to proceed with the checkout?');

                if (confirmation) {
                    successMessage.style.display = 'block';
                }
                return;
            }
            else {
                alert('Please fill in all required fields.');
            }
        }
        else {
            alert('Please fill in all required fields.');
        }
    });

    closeButton.addEventListener('click', function() {
        let request = new XMLHttpRequest();
        request.open("POST", "../actions/action_remove_item.php", true);
        request.onload = function() {
            successMessage.style.display = 'none';
            window.location.href = '../pages/index.php';
        }

        request.send()
    });

    function validateInputs(container) {
        const inputs = container.querySelectorAll('input[required]');
        for (let input of inputs) {
            if (!input.value.trim()) {
                return false;
            }
        }
        return true;
    }
});


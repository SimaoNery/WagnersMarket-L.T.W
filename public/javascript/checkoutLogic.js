const cardRadio = document.getElementById('card');
    const mbwayRadio = document.getElementById('mb-way');

    const cardInfo = document.querySelector('.card-info');
    const mbwayInfo = document.querySelector('.mbway-info');

    const confirmButton = document.getElementById('confirm-order');
    const cancelButton = document.querySelector('.cancel-button');

    const deliveryInfo = document.querySelector('.delivery-information-inputs');

    const successMessage = document.getElementById('success-message');
    const closeButton = document.getElementById('close-button');

    if(cardRadio) {
        cardRadio.addEventListener('change', function () {
            if (cardRadio.checked) {
                cardInfo.style.display = 'grid';
                mbwayInfo.style.display = 'none';
                mbwayRadio.checked = false;
                confirmButton.style.display = 'inline-block';
                cancelButton.style.display = 'inline-block';
            }
        });
    }

    if (mbwayRadio) {
        mbwayRadio.addEventListener('change', function () {
            if (mbwayRadio.checked) {
                mbwayInfo.style.display = 'grid';
                cardInfo.style.display = 'none';
                cardRadio.checked = false;
                confirmButton.style.display = 'inline-block';
                cancelButton.style.display = 'inline-block';

            }
        });
    }

    if (confirmButton) {
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
    }

    if (closeButton) {
        closeButton.addEventListener('click', function() {
            let request = new XMLHttpRequest();
            request.open("POST", "../actions/action_remove_item.php", true);
            request.onload = function() {
                successMessage.style.display = 'none';
                window.location.href = '../pages/index.php';
            }

            request.send()
        });
    }


    function validateInputs(container) {
        const inputs = container.querySelectorAll('input[required]');
        for (let input of inputs) {
            if (!input.value.trim()) {
                return false;
            }
        }
        return true;
    }


    if (confirmButton) {
        confirmButton.addEventListener('click', async function () {
            let isValid
            isValid = validateInputs(deliveryInfo)

            if(isValid) {
                if (cardRadio.checked) {
                    isValid = validateInputs(cardInfo)
                }
                else {
                    isValid = validateInputs(mbwayInfo)
                }

                const firstName = document.getElementById('first-name').value
                const lastName = document.getElementById('last-name').value
                const address = document.getElementById('address').value
                const postalCode = document.getElementById('postal-code').value
                const paymentOption = document.querySelector('input[name="payment-option"]:checked').value
                const csrf = document.getElementById('csrf').value
                const buyerId = document.getElementById('user-id').value


                const items = []
                document.querySelectorAll('.items-checkout-card').forEach(itemCard => {
                    items.push({
                        itemId: itemCard.getAttribute('data-item-id')
                    })
                })

                const subTotal = parseFloat(document.getElementById('subtotal-span-checkout').innerText)
                const shippingCosts = parseFloat(document.getElementById('shipping-cost-span-checkout').innerText)
                const total = subTotal + shippingCosts

                const transactionData = encodeForAjax({
                    csrf: csrf,
                    buyerId: buyerId,
                    firstName: firstName,
                    lastName: lastName,
                    address: address,
                    postalCode: postalCode,
                    paymentOption: paymentOption,
                    items: items,
                    totalPrice: total,
                    shippingCosts: shippingCosts,
                    shippingAddress: `${address}, ${postalCode}`
                })

                await addTransaction(transactionData)

            }
        })
    }

    function addTransaction(transactionData) {

        fetch('../actions/action_checkout.php', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: transactionData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage(data.success, true)
                }
                else {
                    showMessage(data.error, false)
                }
            })
            .catch(error => {
                console.error('Error:', error)
            })
    }
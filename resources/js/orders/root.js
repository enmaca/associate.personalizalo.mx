console.log('resources/js/order/root.js Loaded')
window.createOrder = () => {
    console.log('createOrder Executed');
}

window.setValueDE = (selector, value, enable) => {
    let inputE = document.querySelector(selector);
    inputE.value = value;
    inputE.disabled = !enable;
}

window.goToOrder = (order_id) => {
    window.location.href = '/orders/' + order_id;
}

window.submitNewOrderFrom = () => {
    let form2submit = document.getElementById('NewOrderFrom');
    form2submit.classList.add('was-validated');
    if (form2submit.checkValidity() === true) {
        form2submit.submit();
    }
}

document.getElementById('customerMobileId').addEventListener('change', (event) => {
    event.preventDefault();
    console.log('inputChange');
});

window.addEventListener('uxmal:tomselect:initialized', function (e) {
    console.log('uxmal:tomselect:initialized', e.detail.items);
    if (e.detail.items.customerIdId) {
        e.detail.items.customerIdId.on('change', function (value) {
            console.log('Changed to Value', value);
            if ( !value ){
                //document.querySelector('input[name=customerId]').value = 'new';
                setValueDE('input[name=customerMobile]', '', true);
                setValueDE('input[name=customerName]', '', true);
                setValueDE('input[name=customerLastName]', '', true);
                setValueDE('input[name=customerEmail]', '', true);
            } else if( value > 0 ){
                const url = '/customer/' + value + '?context=by_name_mobile_email';
                fetch(url)
                    .then(response => {
                        // Check if the request was successful
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();  // Parse the JSON data from the response
                    })
                    .then(data => {
                        // Assuming the data contains a property 'newValue' which you want to set as the input value
                        console.log('response data => ', data);
                        //document.querySelector('input[name=customerId]').value = value;
                        setValueDE('input[name=customerMobile]', data.mobile, false);
                        setValueDE('input[name=customerName]', data.name, false);
                        setValueDE('input[name=customerLastName]', data.last_name, false);
                        setValueDE('input[name=customerEmail]', data.email, false);
                    })
                    .catch(error => {
                        console.error('There was a problem with the fetch operation:', error.message);
                    });
            }
            return value;
        });
    }
});





import {Modal} from "bootstrap";
import {uxmal} from "../workshop.js";

console.log('resources/js/order/root.js Loaded')

const setValueDE = (selector, value, enable) => {
    let inputE = document.querySelector(selector);
    inputE.value = value;
    inputE.disabled = !enable;
}

document.getElementById('customerMobileId').addEventListener('change', (event) => {
    event.preventDefault();
    console.log('inputChange');
});

window.onChangeSelectedByNameMobileEmail = function onChangeSelectedByNameMobileEmail(value) {
    console.log('onChangeSelectedByNameMobileEmail:', value);

}

document.addEventListener("livewire:initialized", function () {
    uxmal.init(document);

    uxmal.Buttons.on('createOrderId', 'click', (event) => {
        uxmal.Modals.show('customerSearchByMobileId');
    });

    uxmal.Modals.onChild('customerSearchByMobileId', '.uxmal-modal-save-button', 'click', (event) => {
        uxmal.Forms.submit('NewOrderFrom', {}, (elementName, data) => {
            const edit_order_url = uxmal.buildRoute('web_get_orders', data.result.order_id);
            window.location.assign(edit_order_url);
        })
    });

    uxmal.Selects.on('customerIdId', 'change', (customer_hashid) => {
        if (!customer_hashid) {
            setValueDE('input[name=customerMobile]', '', true);
            setValueDE('input[name=customerName]', '', true);
            setValueDE('input[name=customerLastName]', '', true);
            setValueDE('input[name=customerEmail]', '', true);
        } else {
            const url = uxmal.buildRoute('api_get_customer', customer_hashid);
            fetch(url)
                .then(response => {
                    // Check if the request was successful
                    if (!response.ok) {
                        if (respose.fail)
                            return uxmal.alert(response.fail, 'danger');
                        else if (response.warning)
                            return uxmal.alert(response.warning, 'warning');
                    }
                    return response.json();  // Parse the JSON data from the response
                })
                .then(data => {
                    setValueDE('input[name=customerMobile]', data.result.mobile, false);
                    setValueDE('input[name=customerName]', data.result.name, false);
                    setValueDE('input[name=customerLastName]', data.result.last_name, false);
                    setValueDE('input[name=customerEmail]', data.result.email, false);
                })
                .catch(error => {
                    uxmal.alert(error.message, 'danger');
                });
        }
    });

    const orderEditButtonsEl = uxmal.Tables.get('ordersTableId').element.querySelectorAll("[data-workshop-order-edit]");

    orderEditButtonsEl.forEach(function (element) {
        element.onclick = function (event) {
            if (event.currentTarget) {
                const order_id = event.currentTarget.attributes['data-row-id'].value;
                const edit_order_url = uxmal.buildRoute('web_get_orders', order_id);
                window.location.assign(edit_order_url);
            }
        };
    });

    const orderChangeButtonsEl = uxmal.Tables.get('ordersTableId').element.querySelectorAll("[data-workshop-order-change]");
    orderChangeButtonsEl.forEach(function (element) {
        element.onclick = function (event) {
            if (event.currentTarget) {
                const order_id = event.currentTarget.attributes['data-row-id'].value;
                console.log('orderChangeButtonsEl', order_id);
            }
        };
    });

});



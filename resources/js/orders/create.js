import {Modal} from "../../../public/enmaca/laravel-uxmal/libs/bootstrap/js/bootstrap.esm.min.js";

window.customer_id = null;
window.order_id = null;

console.log('resources/js/order/create.js Loaded')
window.onChangeSelectedProductToAdd = function (value) {
    console.log('onChangeSelectedProductToAdd:', value);
    uxmalSetCardLoading('productCard', true);
    Livewire.dispatch('select-by-digital-art-body::product.changed', {product: value});
}

window.onChangeSelectedLaborCostByName = function (value) {
    console.log('onChangeSelectedLaborCostByName:', value);
}

window.onChangeSelectedMaterialByNameSkuDesc = function (value) {
    console.log('onChangeSelectedMaterialByNameSkuDesc:', value);
    uxmalSetCardLoading('dynamicCard', true);
    Livewire.dispatch('add-material-to-order::material.changed', {material: value});
}

window.onChangeSelectedMfgAreaByName = function (value) {
    console.log('onChangeSelectedMfgAreaByName:', value);
}

window.onChangeSelectedMfgDeviceByName = function (value) {
    console.log('onChangeSelectedMfgDeviceByName:', value);
}

window.onChangeSelectedMfgOverHeadByName = function (value) {
    console.log('onChangeSelectedMfgOverHeadByName:', value);
}

window.addProductToOrder = () => {
    let divElement = document.querySelector('div[data-selected-product-form-id]');
    if (divElement) {
        let value = divElement.getAttribute('data-selected-product-form-id');

        let formElement = document.querySelector('form[id=' + value + ']');

        const formData = new FormData(formElement);

        formData.append('order_id', window.order_id);
        formData.append('customer_id', window.customer_id);

        console.log('form.action => ', formElement.action);
        console.log('form.data => ', [...formData]);

        /* Use fetch to send the form data
        fetch(formElement.action, {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())  // assuming server responds with json
            .then(data => {
                console.log(data);
            })
            .catch((error) => {
                console.error('Error:', error);
            });
*/
        console.log(value);
    } else {
        console.log("Element not found");
    }
}

window.updateMaterialSubtotal= () => {
    let mtQtyEl = document.getElementById('materialQuantityId')
    let uom_cost = Number(mtQtyEl.getAttribute('data-uom-cost'));
    let tax_data = Number(mtQtyEl.getAttribute('data-tax-factor'));
    let profit_margin = Number(document.getElementById('materialProfitMarginId').value);
    let subtotal_previous_taxes = (uom_cost * mtQtyEl.value * (1 + (profit_margin/100))) * (1 + tax_data);
    document.getElementById('materialSubtotalId').value = subtotal_previous_taxes;
}

document.addEventListener('livewire:initialized', () => {
    Livewire.on('select-by-digital-art-body::showmodal', (event) => {
        openModal('selectProductWithDigitalArtId');
        uxmalSetCardLoading('productCard', false);
    });
    Livewire.on('add-material-to-order::showmodal', (event) => {
        openModal('selectedMaterialToAddToOrderId');
        uxmalSetCardLoading('dynamicCard', false);
    });
});


window.openModal = function (identifier) {
    const element = document.getElementById(identifier);
    if (!element) {
        console.error('No modal found with the given identifier');
        return;
    }
    const modalInstance = new Modal(element);
    modalInstance.show();
    setTimeout(function () {
        let swiperEl = element.querySelector('[data-swiper]');
        if (swiperEl) window.init_swiper_elem(swiperEl)
    }, 500);
}

window.closeModal = function (identifier) {
    const element = document.getElementById(identifier);
    if (!element) {
        console.error('No modal found with the given identifier');
        return;
    }
    const modalInstance = new Modal(element);
    modalInstance.show();
}

document.addEventListener("DOMContentLoaded", function () {
    let divElement = document.querySelector('div[data-uxmal-order-data]');
    if (divElement) {
        let order_data = JSON.parse(divElement.getAttribute('data-uxmal-order-data').toString());
        if (order_data) {
            window.order_id = order_data.order_id;
            window.customer_id = order_data.customer_id;
        }
        console.log("Order Id:", window.order_id);
        console.log("Customer Id:", window.customer_id);
    }

    // Add any other JS code you want to run on every page load
});
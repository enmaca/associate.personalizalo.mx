import {Modal} from "../../../public/enmaca/laravel-uxmal/libs/bootstrap/js/bootstrap.esm.min.js";

window.customer_id = null;
window.order_id = null;

console.log('resources/js/order/create.js Loaded')
window.onChangeSelectedProductToAdd = function (value) {
    console.log('onChangeSelectedProductToAdd:', value);
    // let liveWObj = Livewire.getByName();
    // console.log('livewire object:', liveWObj);
    uxmalSetCardLoading('productCard', true);
    Livewire.dispatch('select-by-digital-art-body::product.changed', {product: value});
    //element.dispatchEvent(new Event('input'));
    //openModal('selectProductWithDigitalArtId');
}

window.onChangeSelectedLaborCostByName = function (value) {
    console.log('onChangeSelectedLaborCostByName:', value);
}

window.onChangeSelectedMaterialByNameSkuDesc = function (value) {
    console.log('onChangeSelectedMaterialByNameSkuDesc:', value);
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
        console.log('form.data => ',[...formData]);

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

document.addEventListener('livewire:initialized', () => {
    Livewire.on('select-by-digital-art-body::showmodal', (event) => {
        openModal('selectProductWithDigitalArtId');
        uxmalSetCardLoading('productCard', false);
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

document.addEventListener("DOMContentLoaded", function() {
    let divElement = document.querySelector('div[data-uxmal-order-data]');
    if (divElement) {
        let order_data = JSON.parse(divElement.getAttribute('data-uxmal-order-data').toString());
        if(order_data){
            window.order_id = order_data.order_id;
            window.customer_id = order_data.customer_id;
        }
        console.log("Order Id:", window.order_id);
        console.log("Customer Id:", window.customer_id);
    }

    // Add any other JS code you want to run on every page load
});
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
    uxmalSetCardLoading('dynamicCard', true);
    Livewire.dispatch('add-labor-cost-to-order::laborcost.changed', {laborcost: value});
}

window.onChangeSelectedMaterialByNameSkuDesc = function (value) {
    console.log('onChangeSelectedMaterialByNameSkuDesc:', value);
    uxmalSetCardLoading('dynamicCard', true);
    Livewire.dispatch('add-material-to-order::material.changed', {material: value});
}

window.onChangeSelectedMfgOverHeadByName = function (value) {
    console.log('onChangeSelectedMfgOverHeadByName:', value);
    uxmalSetCardLoading('dynamicCard', true);
    Livewire.dispatch('add-mfg-overhead-to-order::mfgoverhead.changed', {mfgoverhead: value});
}

window.onChangeSelectedMfgAreaByName = function (value) {
    console.log('onChangeSelectedMfgAreaByName:', value);
}

window.onChangeSelectedMfgDeviceByName = function (value) {
    console.log('onChangeSelectedMfgDeviceByName:', value);
}


window.addMaterialToOrder = () => {
    window.submitModalAddToOrderForm('data-selected-material-form-id');
}
window.addProductToOrder = () => {
    window.submitModalAddToOrderForm('data-selected-product-form-id');
}

window.addMfgOverHeadToOrder = () => {
    window.submitModalAddToOrderForm('data-selected-mfgoverhead-form-id');
}

window.addLaborCostToOrder = () => {
    submitModalAddToOrderForm('data-selected-laborcost-form-id', 'onsuccessEventToDispatch', 'selectedLaborCostToAddToOrderId');
}

window.submitModalAddToOrderForm = (selector, eventOnSuccess, modalToClose) => {
    let divElement = document.querySelector('div[' + selector + ']');
    if (divElement) {
        let value = divElement.getAttribute(selector);

        let formElement = document.querySelector('form[id=' + value + ']');

        if (formElement.checkValidity() === false) {
            formElement.classList.add('was-validated');
            return;
        }
        const formData = new FormData(formElement);

        formData.append('order_id', window.order_id);
        formData.append('customer_id', window.customer_id);

        console.log('form.action => ', formElement.action);
        console.log('form.data => ', [...formData]);

        // Use fetch to send the form data
        fetch(formElement.action, {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())  // assuming server responds with json
            .then(data => {
                console.log('data', data);
                if( data.ok ) {
                    console.log('dispatchingEvent', eventOnSuccess);
                    closeModal(modalToClose);
                    return;
                }
            })
            .catch((error) => {
                console.error('Error:', error);
            });
    } else {
        console.log("Element not found");
    }
}

window.updateMaterialSubtotal = () => {
    let mtQtyEl = document.getElementById('materialQuantityId');
    let uom_cost = Number(mtQtyEl.getAttribute('data-uom-cost'));
    let tax_data = Number(mtQtyEl.getAttribute('data-tax-factor'));
    let profit_margin = Number(document.getElementById('materialProfitMarginId').value);
    let subtotal_previous_taxes = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format((uom_cost * mtQtyEl.value * (1 + (profit_margin / 100))) * (1 + tax_data));
    document.getElementById('materialSubtotalId').value = subtotal_previous_taxes;
}

window.updateMfgCostSubtotal = () => {
    let mfgQtyEl = Number(document.getElementById('mfgOverheadQuantityId'));
    let tax_data = Number(mfgQtyEl.getAttribute('data-tax-factor'));
    let uom = Number(mfgQtyEl.getAttribute('data-value'));
    let subtotal_previous_taxes = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format((mfgQtyEl.value * uom) * (1 + tax_data));
    document.getElementById('mfgOverheadSubtotalId').value = subtotal_previous_taxes;
}

window.updateLaborCostSubtotal = () => {
    let laborCostQtyEl = document.getElementById('laborCostQuantityId');
    let tax_data = Number(laborCostQtyEl.getAttribute('data-tax-factor'));
    let uom = Number(laborCostQtyEl.getAttribute('data-value'));
    let quantity = Number(laborCostQtyEl.value);
    let subtotal = (quantity * uom);
    let totaltaxes = (subtotal * tax_data);
    let subtotal_previous_taxes = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format( subtotal + totaltaxes );
    document.getElementById('laborCostSubtotalId').value = subtotal_previous_taxes;
}

document.addEventListener('livewire:initialized', () => {
    Livewire.on('select-by-digital-art-body::showmodal', (event) => {
        openModal('selectProductWithDigitalArtId');
        uxmalSetCardLoading('productCard', false);
    });
    Livewire.on('add-to-order::show-material-modal', (event) => {
        openModal('selectedMaterialToAddToOrderId');
        uxmalSetCardLoading('dynamicCard', false);
    });

    Livewire.on('add-to-order::show-mfgoverhead-modal', (event) => {
        openModal('selectedMfgOverHeadToAddToOrderId');
        uxmalSetCardLoading('dynamicCard', false);
    });

    Livewire.on('add-to-order::show-laborcost-modal', (event) => {
        openModal('selectedLaborCostToAddToOrderId');
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
        window.init_swiper(element);
    }, 500);
}

window.closeModal = function (identifier) {
    const element = document.getElementById(identifier);
    if (!element) {
        console.error('No modal found with the given identifier');
        return;
    }
    const modalInstance = Modal.getInstance(element);
    modalInstance.hide();

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
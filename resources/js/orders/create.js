import {
    UxmalSpinner,
    UxmalSelect,
    UxmalCSRF,
    UxmalCard,
    UxmalSwiper,
    UxmalModal
} from "/public/enmaca/laravel-uxmal/js/uxmal.js";


const uxmalCards = new UxmalCard();
const uxmalModals = new UxmalModal();
const uxmalSelects = new UxmalSelect();
const uxmalSwiper = new UxmalSwiper();

window.customer_id = null;
window.order_id = null;

console.log('resources/js/order/create.js Loaded')


/**
 * Products
 * @param value
 */


const onChangeSelectedMfgAreaByName = function (value) {
    console.log('onChangeSelectedMfgAreaByName:', value);
}

const onChangeSelectedMfgDeviceByName = function (value) {
    console.log('onChangeSelectedMfgDeviceByName:', value);
}

const submitModalAddToOrderForm = (selector, eventOnSuccess, modalToClose) => {
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
                if (data.ok) {
                    console.log('dispatchingEvent', eventOnSuccess);
                    workshopDispatchEvent(eventOnSuccess);
                    uxmalModals.hide(modalToClose);
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

const updateMaterialSubtotal = () => {
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

const updateMfgCostSubtotal = () => {
    let mfgQtyEl = Number(document.getElementById('mfgOverheadQuantityId'));
    let tax_data = Number(mfgQtyEl.getAttribute('data-tax-factor'));
    let uom = Number(mfgQtyEl.getAttribute('data-value'));
    let subtotal_previous_taxes = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format((mfgQtyEl.value * uom) * (1 + tax_data));
    document.getElementById('mfgOverheadSubtotalId').value = subtotal_previous_taxes;
}

const updateLaborCostSubtotal = () => {
    let laborCostQtyEl = document.getElementById('laborCostQuantityId');
    let tax_data = Number(laborCostQtyEl.getAttribute('data-tax-factor'));
    let uom = Number(laborCostQtyEl.getAttribute('data-value'));
    let quantity = Number(laborCostQtyEl.value);
    let subtotal = (quantity * uom);
    let totaltaxes = (subtotal * tax_data);
    document.getElementById('laborCostSubtotalId').value = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(subtotal + totaltaxes);
}


Livewire.on('select-by-digital-art-body::showmodal', (event) => {
    uxmalModals.show('selectProductWithDigitalArtId');
    uxmalCards.setLoading('productCard', false);
});

/**
 * Order Product Dynamic Details
 * global scope por que se manda llamar de onclick attribute
 */
window.removeOPDD = (row) => {
    uxmalCards.setLoading('dynamicCard', true);
    const id2Remove = row.getAttribute('data-row-id');
    fetch('/orders/dynamic_detail/' + id2Remove, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': UxmalCSRF()
        }
    })
        .then(response => response.json())  // assuming server responds with json
        .then(data => {
            console.log('data', data);
            if (data.ok) {
                console.log('removeOPDD [OK]');
                workshopDispatchEvent('livewire::order-product-dynamic-details.table.tbody::reload');
                return;
            } else
                if( data.error )
                    console.error(data.error);
                else if( data.warning )
                    console.warn(data.warning);
        })
        .catch((error) => {
            console.error('removeOPDD [FAIL]', error);
        });
}



/**
 * When a Modal Insert a Submit To Insert a Record
 * windows onclick attribute
 * TODO: Move to eventListener
 */

/**
 * OnClick Add Manufacturing Over Head Modal Button Save
 */
window.addMaterialToOrder = () => {
    uxmalCards.setLoading('dynamicCard', true);
    submitModalAddToOrderForm(
        'data-selected-material-form-id',
        'livewire::order-product-dynamic-details.table.tbody::reload',
        'selectedMaterialToAddToOrderId');
}

/**
 * OnClick Add Manufacturing Over Head Modal Button Save
 */
window.addMfgOverHeadToOrder = () => {
    uxmalCards.setLoading('dynamicCard', true);
    submitModalAddToOrderForm(
        'data-selected-mfgoverhead-form-id',
        'livewire::order-product-dynamic-details.table.tbody::reload',
        'selectedMfgOverHeadToAddToOrderId');
}

/**
 * OnClick Add Labor Cost Modal Button Save
 */
window.addLaborCostToOrder = () => {
    uxmalCards.setLoading('dynamicCard', true);
    submitModalAddToOrderForm(
        'data-selected-laborcost-form-id',
        'livewire::order-product-dynamic-details.table.tbody::reload',
        'selectedLaborCostToAddToOrderId');
}


/**
 * Init Events.
 */
document.addEventListener("DOMContentLoaded", function () {
    uxmalCards.init(document);
    uxmalModals.init(document);
    uxmalSelects.init(document);

    /******************************
     * OrderProductDynamicDetails *
     ******************************
     */
    // Material
    Livewire.on('add-to-order::show-material-modal', (event) => {
        uxmalModals.show('selectedMaterialToAddToOrderId');
    });
    uxmalSelects.on('materialSelectedId', 'change', (value) => {
        uxmalCards.setLoading('dynamicCard', true);
        Livewire.dispatch('add-material-to-order::material.changed', {material: value});
    });
    uxmalModals.on('selectedMaterialToAddToOrderId', 'shown.bs.modal', function () {
        uxmalCards.setLoading('dynamicCard', false);
    });

    // MfgOverHead
    Livewire.on('add-to-order::show-mfgoverhead-modal', (event) => {
        uxmalModals.show('selectedMfgOverHeadToAddToOrderId');
    });
    uxmalSelects.on('mfgOverHeadSelectedId', 'change', (value) => {
        uxmalCards.setLoading('dynamicCard', true);
        Livewire.dispatch('add-mfg-overhead-to-order::mfgoverhead.changed', {mfgoverhead: value});
    });
    uxmalModals.on('selectedMfgOverHeadToAddToOrderId', 'shown.bs.modal', function () {
        uxmalCards.setLoading('dynamicCard', false);
    });

    // MfgLaborCost
    Livewire.on('add-to-order::show-laborcost-modal', (event) => {
        uxmalModals.show('selectedLaborCostToAddToOrderId');
    });
    uxmalSelects.on('laborCostSelectedId', 'change', (value) => {
        uxmalCards.setLoading('dynamicCard', true);
        Livewire.dispatch('add-labor-cost-to-order::laborcost.changed', {laborcost: value});
    });
    uxmalModals.on('selectedLaborCostToAddToOrderId', 'shown.bs.modal', function () {
        uxmalCards.setLoading('dynamicCard', false);
    });

    // Listen To Event When Inserted Record on Table OrderProductDynamicDetails
    Livewire.on('order-product-dynamic-details.table.tbody::updated', (data) => {
        console.log('order-product-dynamic-details.table.tbody::updated', data);
        const tableEl = document.querySelector("table[id='orderProductDynamicDetailsId']");
        const oldTfoot = tableEl.querySelector('tfoot');
        if (oldTfoot) {
            oldTfoot.innerHTML = data.tfoot;
        }
        uxmalCards.setLoading('dynamicCard', false);
    });

    /***********************
     * OrderProductDetails *
     ***********************
     */
    // Product
    uxmalSelects.on('OrderProductAddId', 'change', (value) => {
        console.log(value)

        uxmalCards.setLoading('productCard', true);
        Livewire.dispatch('select-by-digital-art-body::product.changed', {product: value});
    });

    uxmalModals.on('selectProductWithDigitalArtId', 'shown.bs.modal', function () {
        uxmalSwiper.init(document.getElementById('selectProductWithDigitalArtId'));
    });

    // Listen To Event When Inserted Record on Table OrderProductDynamicDetails
    Livewire.on('order-product-dynamic-details.table.tbody::updated', (data) => {
        console.log('order-product-dynamic-details.table.tbody::updated', data);
        const tableEl = document.querySelector("table[id='orderProductDynamicDetailsId']");
        const oldTfoot = tableEl.querySelector('tfoot');
        if (oldTfoot) {
            oldTfoot.innerHTML = data.tfoot;
        }
        uxmalCards.setLoading('dynamicCard', false);
    });


    let divElement = document.querySelector('div[data-uxmal-order-data]');
    if (divElement) {
        let order_data = JSON.parse(divElement.getAttribute('data-uxmal-order-data').toString());
        if (order_data) {
            window.order_id = order_data.order_id;
            window.customer_id = order_data.customer_id;
        }
        console.log("Order Id:", order_id);
        console.log("Customer Id:", customer_id);
    }


    /**
     * Button DeliveryDate
     */
    document.getElementById('orderDeliveryDateId').addEventListener('click', (event) => {
        console.log('orderDeliveryDateId: clicked!');
    });
    document.getElementById('selectProductWithDigitalArtSaveBtn').addEventListener('click', (event) => {
        submitModalAddToOrderForm('data-selected-product-form-id');
    });
});
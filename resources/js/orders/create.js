import {
    UxmalSelect,
    UxmalCSRF,
    UxmalCard,
    UxmalSwiper,
    UxmalModal,
    UxmalForm,
    UxmalInput
} from "../../../public/enmaca/laravel-uxmal/js/uxmal.js";

import {updateOrder} from "../workshop.js";

const uxmalCards = new UxmalCard();
const uxmalModals = new UxmalModal();
const uxmalSelects = new UxmalSelect();
const uxmalSwiper = new UxmalSwiper();
const uxmalForm = new UxmalForm();
const uxmalInput = new UxmalInput();

window.customer_id = null;
window.order_id = null;

console.log('resources/js/order/create.js Loaded')

/**
 * Order Product Details
 * global scope por que se manda llamar de onclick attribute
 */
window.removeOPD = (row) => {
    uxmalCards.setLoading('productCard', true);
    const id2Remove = row.getAttribute('data-row-id');
    fetch('/orders/product_detail/' + id2Remove, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': UxmalCSRF()
        }
    })
        .then(response => response.json())  // assuming server responds with json
        .then(data => {
            if (data.ok) {
                Livewire.dispatch('order-product-details.table.tbody::reload');
            } else if (data.error)
                console.error(data.error);
            else if (data.warning)
                console.warn(data.warning);
        })
        .catch((error) => {
            console.error('removeOPD [FAIL]', error);
        });
}

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
                Livewire.dispatch('order-product-dynamic-details.table.tbody::reload');
            } else if (data.error)
                console.error(data.error);
            else if (data.warning)
                console.warn(data.warning);
        })
        .catch((error) => {
            console.error('removeOPDD [FAIL]', error);
        });
}

Livewire.hook('component.init', ({ component, cleanup }) => {
    console.log('component =>', component);
    console.log('cleanup =>', cleanup);
    switch(component.name){
        case 'order.button.delivery-date':
            component.el.querySelector('#orderDeliveryDateButtonId').onclick = () => {
                uxmalInput.get('deliveryDateId').flatpickrEl.open();
            };
            break;
    }
})

document.addEventListener("DOMContentLoaded", function () {

    uxmalCards.init(document);
    uxmalModals.init(document);
    uxmalSelects.init(document);
    uxmalForm.init(document);
    uxmalInput.init(document);

    /******************************
     * OrderProductDynamicDetails *
     ******************************
     */

    // Material
        // Material AddFormId
    let material_form_id;

    //// Attach On Change Event when selected material change
    uxmalSelects.on('materialSelectedId', 'change', (value) => {
        if (value == null || value === 0 || value === '')
            return;
        uxmalCards.setLoading('dynamicCard', true);
        Livewire.dispatch('add-material-to-order::material.changed', {material: value});
    });

    //// Material Modal Updated From Livewire => Show
    Livewire.on('add-to-order::show-material-modal', (event) => {
        uxmalModals.show('selectedMaterialToAddToOrderId');
    });

    //// Attach On shown.bs.modal Del Modal de Seleccion de Material
    uxmalModals.on('selectedMaterialToAddToOrderId', 'shown.bs.modal', function () {
        uxmalCards.setLoading('dynamicCard', false);
        material_form_id = uxmalForm.init(this);
        // Attach On Child Materials Input Change.
        uxmalForm.onChild(material_form_id, ['#materialProfitMarginId', '#materialQuantityId'], 'change', (event) => {
            const mtQtyEl = document.getElementById('materialQuantityId');
            const uom_cost = Number(mtQtyEl.getAttribute('data-uom-cost'));
            const tax_data = Number(mtQtyEl.getAttribute('data-tax-factor'));
            const profit_margin = Number(document.getElementById('materialProfitMarginId').value);
            document.getElementById('materialSubtotalId').value = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD'
            }).format((uom_cost * mtQtyEl.value * (1 + (profit_margin / 100))) * (1 + tax_data));
        });
    });
    // Attach On Child Materials SaveBtn Click.
    uxmalModals.onChild('selectedLaborCostToAddToOrderId', '.save-button', 'click', (event) => {
        console.log('selectedLaborCostToAddToOrderSaveBtn::event::click', event);
        uxmalCards.setLoading('dynamicCard', true);
        uxmalForm.submit(material_form_id, {
            order_id: window.order_id,
            customer_id: window.customer_id
        }, (elementName, data) => {
            Livewire.dispatch('order-product-dynamic-details.table.tbody::reload');
            uxmalModals.hide('selectedMaterialToAddToOrderId');
        });
    });


    // MfgOverHead
    let mfg_over_head_form_id;
    Livewire.on('add-to-order::show-mfgoverhead-modal', (event) => {
        uxmalModals.show('selectedMfgOverHeadToAddToOrderId');
    });
    uxmalSelects.on('mfgOverHeadSelectedId', 'change', (value) => {
        if (value == null || value === 0 || value === '')
            return;
        uxmalCards.setLoading('dynamicCard', true);
        Livewire.dispatch('add-mfg-overhead-to-order::mfgoverhead.changed', {mfgoverhead: value});
    });
    uxmalModals.on('selectedMfgOverHeadToAddToOrderId', 'shown.bs.modal', function () {
        uxmalCards.setLoading('dynamicCard', false);
        mfg_over_head_form_id = uxmalForm.init(this);
        uxmalForm.onChild(mfg_over_head_form_id, '#mfgOverheadQuantityId', 'change', (event) => {
            let mfgQtyEl = event.target;
            let tax_data = Number(mfgQtyEl.getAttribute('data-tax-factor'));
            let uom = Number(mfgQtyEl.getAttribute('data-value'));
            document.getElementById('mfgOverheadSubtotalId').value = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD'
            }).format((mfgQtyEl.value * uom) * (1 + tax_data));
        });
    });
    uxmalModals.onChild('selectedMfgOverHeadToAddToOrderId', '.save-button', 'click', (event) => {
        console.log('selectedMfgOverHeadToAddToOrderSaveBtn::event::click', event);
        uxmalCards.setLoading('dynamicCard', true);
        uxmalForm.submit(mfg_over_head_form_id, {
            order_id: window.order_id,
            customer_id: window.customer_id
        }, (elementName, data) => {
            Livewire.dispatch('order-product-dynamic-details.table.tbody::reload');
            uxmalModals.hide('selectedMfgOverHeadToAddToOrderId');
        });
    });

    // MfgLaborCost
    let mfg_labor_cost_form_id;
    Livewire.on('add-to-order::show-laborcost-modal', (event) => {
        uxmalModals.show('selectedLaborCostToAddToOrderId');
    });
    uxmalSelects.on('laborCostSelectedId', 'change', (value) => {
        if (value == null || value == 0 || value == '')
            return;
        uxmalCards.setLoading('dynamicCard', true);
        Livewire.dispatch('add-labor-cost-to-order::laborcost.changed', {laborcost: value});
    });
    uxmalModals.on('selectedLaborCostToAddToOrderId', 'shown.bs.modal', function () {
        uxmalCards.setLoading('dynamicCard', false);
        mfg_labor_cost_form_id = uxmalForm.init(this);
        uxmalForm.onChild(mfg_labor_cost_form_id, '#laborCostQuantityId', 'change', (event) => {
            const laborCostQtyEl = event.target;
            const tax_data = Number(laborCostQtyEl.getAttribute('data-tax-factor'));
            const uom = Number(laborCostQtyEl.getAttribute('data-value'));
            const quantity = Number(laborCostQtyEl.value);
            const subtotal = (quantity * uom);
            const totaltaxes = (subtotal * tax_data);
            document.getElementById('laborCostSubtotalId').value = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD'
            }).format(subtotal + totaltaxes);
        });
    });

    document.getElementById('selectedLaborCostToAddToOrderSaveBtn').addEventListener('click', (event) => {
        console.log('selectedMfgOverHeadToAddToOrderSaveBtn::event::click', event);
        uxmalCards.setLoading('dynamicCard', true);
        uxmalForm.submit(mfg_labor_cost_form_id, {
            order_id: window.order_id,
            customer_id: window.customer_id
        }, (elementName, data) => {
            Livewire.dispatch('order-product-dynamic-details.table.tbody::reload');
            uxmalModals.hide('selectedLaborCostToAddToOrderId');
        });
    });

    // Listen To Event When Inserted Record on Table OrderProductDynamicDetails
    Livewire.on('order-product-dynamic-details.table.tbody::updated', (data) => {
        console.log('order-product-dynamic-details.table.tbody::updated', data);
        const tableEl = document.querySelector("table[id='orderProductDynamicDetailsId']");
        const tFoot = tableEl.querySelector('tfoot');
        if (tFoot) {
            tFoot.innerHTML = data.tfoot;
        }
        uxmalCards.setLoading('dynamicCard', false);
    });


    /***********************
     * OrderProductDetails *
     ***********************
     */
    let product_with_da_form;
    // Product
    uxmalSelects.on('OrderProductAddId', 'change', (value) => {
        if (value == null || value === 0 || value === '')
            return;
        uxmalCards.setLoading('productCard', true);
        Livewire.dispatch('select-by-digital-art-body::product.changed', {product: value});
    });

    Livewire.on('select-by-digital-art-body::showmodal', (event) => {
        uxmalModals.show('selectProductWithDigitalArtId');
    });

    uxmalModals.on('selectProductWithDigitalArtId', 'shown.bs.modal', function () {
        uxmalSwiper.init(this);
        product_with_da_form = uxmalForm.init(this);
        uxmalCards.setLoading('productCard', false);
    });

    document.getElementById('selectProductWithDigitalArtSaveBtn').addEventListener('click', (event) => {
        //submitModalAddToOrderForm('data-selected-product-form-id');
        console.log('selectProductWithDigitalArtSaveBtn::event::click', event);
        uxmalCards.setLoading('productCard', true);
        uxmalForm.submit(product_with_da_form, {
            order_id: window.order_id,
            customer_id: window.customer_id
        }, (elementName, data) => {
            Livewire.dispatch('order-product-details.table.tbody::reload');
            uxmalModals.hide('selectProductWithDigitalArtId');
        });
    });

    // Listen To Event When Inserted Record on Table OrderProductDetails
    Livewire.on('order-product-details.table.tbody::updated', (data) => {
        console.log('order-product-details.table.tbody::updated', data);
        const tableEl = document.querySelector("table[id='orderProductDetailsId']");
        const tFoot = tableEl.querySelector('tfoot');
        if (tFoot) {
            tFoot.innerHTML = data.tfoot;
        }
        uxmalCards.setLoading('productCard', false);
    });


    let divElement = document.querySelector('div[data-uxmal-order-data]');
    if (divElement) {
        const order_data = JSON.parse(divElement.getAttribute('data-uxmal-order-data').toString());
        if (order_data) {
            window.order_id = order_data.order_id;
            window.customer_id = order_data.customer_id;
        }
    }


    /**
     * Button DeliveryDate
     */

    uxmalInput.on('deliveryDateId', 'change', (selectedDates, dateStr) => {
        const buttonEl = document.querySelector('#orderDeliveryDateButtonId');
        const data = {
            delivery_date: selectedDates[0].toISOString().slice(0, 19).replace('T', ' ')
        };
        updateOrder(window.order_id, data, (ok_data) => {
            Livewire.dispatch('order.button.delivery-date::reload');
        });
    });

});
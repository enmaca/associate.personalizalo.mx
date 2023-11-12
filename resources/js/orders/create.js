import {
    UxmalCSRF,
    UxmalSwiper,
    UxmalForm,
    UxmalInput,
    Uxmal
} from "../../../public/enmaca/laravel-uxmal/js/uxmal.js";



import {updateOrder} from "../workshop.js";
import button from "bootstrap/js/src/button.js";

//const uxmalCards = new UxmalCard();
//const uxmalModals = new UxmalModal();
//const uxmalSelects = new UxmalSelect();
const uxmalSwiper = new UxmalSwiper();
const uxmalForm = new UxmalForm();
const uxmalInput = new UxmalInput();
const uxmal = new Uxmal();

window.customer_id = null;
window.order_id = null;

console.log('resources/js/order/create.js Loaded')

/**
 * Order Product Details
 * global scope por que se manda llamar de onclick attribute
 */
window.removeOPD = (row) => {
    uxmal.Cards.setLoading('orderCard', true);
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
    uxmal.Cards.setLoading('orderCard', true);
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

/**
 * Init the interactive behavior of the Delivery Address Book
 */
const initDeliveryAddressBook = () => {
    uxmalForm.on('deliveryData', 'change', function (event) {
        const buttonEl = document.getElementById('addressBookSubmitId');
        if (buttonEl && buttonEl.classList.contains('d-none'))
            buttonEl.classList.remove('d-none');
    });
    const recipientDataDivEl = document.querySelector('[data-workshop-recipient-data]');
    const updRecipientDataState = () => {
        const userDataSelectors = ['recipientNameId', 'recipientLastNameId', 'recipientMobileId'];
        console.log('===============>', uxmalInput.get('recipientDataSameAsCustomerId').element.checked);
        if (uxmalInput.get('recipientDataSameAsCustomerId').element.checked) {
            recipientDataDivEl.classList.add('d-none');
            uxmalInput.for(userDataSelectors, (item) => {
                item.removeAttribute('required');
            });
        } else {
            recipientDataDivEl.classList.remove('d-none');
            uxmalInput.for(userDataSelectors, (item) => {
                item.setAttribute('required', '');
            });
        }
    };

    uxmal.Selects.get('mexMunicipalitiesId').tomselect2.lock();
    uxmal.Selects.get('mexStateId').tomselect2.lock();

    uxmalInput.on('recipientDataSameAsCustomerId', 'change', () => {
        updRecipientDataState();
    });

    uxmalInput.on('zipCodeId', 'change', (event) => {
        console.log(event.target);
        const mexDistrictIdEl = uxmal.Selects.get('mexDistrictId').tomselect2;
        mexDistrictIdEl.clear(true);
        mexDistrictIdEl.clearOptions();
        mexDistrictIdEl.load('zipcode::' + event.target.value);
        mexDistrictIdEl.on('load', function () {
            const keys = Object.keys(this.options);
            this.setValue(keys.length === 2 ? keys[1] : '');
        });

        const mexMunicipalitiesIdEl = uxmal.Selects.get('mexMunicipalitiesId').tomselect2;
        mexMunicipalitiesIdEl.clear(true);
        mexMunicipalitiesIdEl.clearOptions();
        mexMunicipalitiesIdEl.load('zipcode::' + event.target.value);
        mexMunicipalitiesIdEl.on('load', function () {
            const keys = Object.keys(this.options);
            this.setValue(keys.length === 2 ? keys[1] : '');
        });

        const mexStateIdEl = uxmal.Selects.get('mexStateId').tomselect2;
        mexStateIdEl.clear(true);
        mexStateIdEl.clearOptions();
        mexStateIdEl.load('zipcode::' + event.target.value);
        mexStateIdEl.on('load', function () {
            const keys = Object.keys(this.options);
            this.setValue(keys.length === 2 ? keys[1] : '');
        });
    });

    updRecipientDataState();
}

document.addEventListener('livewire:init', () => {
    Livewire.hook('component.init', ({component, cleanup}) => {
        console.log('init.component.name ===>', component.name);
        switch (component.name) {
            case 'order.button.delivery-date':
                component.el.querySelector('#orderDeliveryDateButtonId').onclick = () => {
                    uxmalInput.get('deliveryDateId').flatpickrEl.open();
                };
                break;
            case 'addressbook.form.default-form':
                break;
        }
    });
})

document.addEventListener("DOMContentLoaded", function () {
    uxmal.init(document);
    //uxmal.Cards.init(document);
    //uxmal.Modals.init(document);
    // uxmal.Selects.init(document);
    uxmalForm.init(document);
    uxmalInput.init(document);

    /********************************
     * Client Data && Delivery Data *
     ********************************/
    //// Update Delivery Date Interactions
    uxmalInput.on('deliveryDateId', 'change', (selectedDates) => {
        uxmal.Cards.setLoading('orderCard', true);
        const buttonEl = document.querySelector('#orderDeliveryDateButtonId');
        const data = {
            delivery_date: selectedDates[0].toISOString().slice(0, 19).replace('T', ' ')
        };
        updateOrder(window.order_id, data, () => {
            Livewire.dispatch('order.button.delivery-date::reload');
            uxmal.Cards.setLoading('orderCard', false);
        });
    });

    initDeliveryAddressBook();

    //// OnClick for Button For Save Delivery Data
    // TODO uxmalButton helpers
    document.getElementById('addressBookSubmitId').addEventListener( 'click', (event) => {
        uxmal.Cards.setLoading('orderCard', true);
        uxmalForm.submit('deliveryData', {
            order_id: window.order_id,
            customer_id: window.customer_id
        }, () => {
            Livewire.dispatch('addressbook.form.default-form::reload');
        }, (elementName, data) => {
            uxmal.sweetAlert(data.fail, 'warning');
            uxmal.Cards.setLoading('orderCard', false);
        }, (elementName, error) => {
            uxmal.sweetAlert(error, 'danger');
            uxmal.Cards.setLoading('orderCard', false);
        });
    });

    //// Listen To Event When Livewire request message Succedes
    document.addEventListener('livewire:addressbook.form.default-form:request:succeed', (event) => {
        setTimeout(() => {
            console.log('livewire:addressbook.form.default-form:request:succeed', event.detail.id);
            const scope = document.querySelector(`[wire\\:id="${event.detail.id}"]`);
            uxmalForm.init(scope);
            uxmalInput.init(scope);
            initDeliveryAddressBook();
            document.getElementById('addressBookSubmitId').classList.add('d-none');
            uxmal.Cards.setLoading('orderCard', false);
        }, 500);
    });


    /******************************
     * OrderProductDynamicDetails *
     ******************************/

        // Material
        // Material AddFormId
    let material_form_id;

    //// Attach On Change Event when selected material change
    uxmal.Selects.on('materialSelectedId', 'change', (value) => {
        if (value == null || value === 0 || value === '')
            return;
        uxmal.Cards.setLoading('orderCard', true);
        Livewire.dispatch('add-material-to-order::material.changed', {material: value});
    });

    //// Material Modal Updated From Livewire => Show
    Livewire.on('add-to-order::show-material-modal', () => {
        uxmal.Modals.show('selectedMaterialToAddToOrderId');
    });

    //// Attach On shown.bs.modal Del Modal de Seleccion de Material
    uxmal.Modals.on('selectedMaterialToAddToOrderId', 'shown.bs.modal', function () {
        uxmal.Cards.setLoading('orderCard', false);
        material_form_id = uxmalForm.init(this);
        // Attach On Child Materials Input Change.
        uxmalForm.onChild(material_form_id, ['#materialProfitMarginId', '#materialQuantityId'], 'change', () => {
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
    //// Attach On Child Materials SaveBtn Click.
    uxmal.Modals.onChild('selectedMaterialToAddToOrderId', '.save-button', 'click', (event) => {
        console.log('selectedMaterialToAddToOrderId::event::click', event);
        uxmal.Cards.setLoading('orderCard', true);
        uxmalForm.submit(material_form_id, {
            order_id: window.order_id,
            customer_id: window.customer_id
        }, () => {
            Livewire.dispatch('order-product-dynamic-details.table.tbody::reload');
            uxmal.Modals.hide('selectedMaterialToAddToOrderId');
        });
    });


    // MfgOverHead
    // MfgOverHead AddFormId
    let mfg_over_head_form_id;

    //// Attach On Change Event when selected MfgOverHead change
    uxmal.Selects.on('mfgOverHeadSelectedId', 'change', (value) => {
        if (value == null || value === 0 || value === '')
            return;
        uxmal.Cards.setLoading('orderCard', true);
        Livewire.dispatch('add-mfg-overhead-to-order::mfgoverhead.changed', {mfgoverhead: value});
    });

    //// MfgOverHead Modal Updated From Livewire => Show
    Livewire.on('add-to-order::show-mfgoverhead-modal', () => {
        uxmal.Modals.show('selectedMfgOverHeadToAddToOrderId');
    });

    //// Attach On shown.bs.modal Del Modal de Seleccion de MfgOverHead
    uxmal.Modals.on('selectedMfgOverHeadToAddToOrderId', 'shown.bs.modal', function () {
        uxmal.Cards.setLoading('orderCard', false);
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

    //// Attach On Child MfgOverHead SaveBtn Click.
    uxmal.Modals.onChild('selectedMfgOverHeadToAddToOrderId', '.save-button', 'click', (event) => {
        console.log('selectedMfgOverHeadToAddToOrderSaveBtn::event::click', event);
        uxmal.Cards.setLoading('orderCard', true);
        uxmalForm.submit(mfg_over_head_form_id, {
            order_id: window.order_id,
            customer_id: window.customer_id
        }, () => {
            Livewire.dispatch('order-product-dynamic-details.table.tbody::reload');
            uxmal.Modals.hide('selectedMfgOverHeadToAddToOrderId');
        });
    });

    // MfgLaborCost
    // MfgLaborCost AddFormId
    let mfg_labor_cost_form_id;

    //// Attach On Change Event when selected MfgLaborCost change
    uxmal.Selects.on('laborCostSelectedId', 'change', (value) => {
        if (value == null || value === 0 || value === '')
            return;
        uxmal.Cards.setLoading('orderCard', true);
        Livewire.dispatch('add-labor-cost-to-order::laborcost.changed', {laborcost: value});
    });

    //// MfgLaborCost Modal Updated From Livewire => Show
    Livewire.on('add-to-order::show-laborcost-modal', () => {
        uxmal.Modals.show('selectedLaborCostToAddToOrderId');
    });

    //// Attach On shown.bs.modal Del Modal de Seleccion de MfgLaborCost
    uxmal.Modals.on('selectedLaborCostToAddToOrderId', 'shown.bs.modal', function () {
        uxmal.Cards.setLoading('orderCard', false);
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

    //// Attach On Child MfgLaborCost SaveBtn Click.
    uxmal.Modals.onChild('selectedLaborCostToAddToOrderId', '.save-button', 'click', (event) => {
        console.log('selectedLaborCostToAddToOrderSaveBtn::event::click', event);
        uxmal.Cards.setLoading('orderCard', true);
        uxmalForm.submit(mfg_labor_cost_form_id, {
            order_id: window.order_id,
            customer_id: window.customer_id
        }, () => {
            Livewire.dispatch('order-product-dynamic-details.table.tbody::reload');
            uxmal.Modals.hide('selectedLaborCostToAddToOrderId');
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
        uxmal.Cards.setLoading('orderCard', false);
    });


    /***********************
     * OrderProductDetails *
     ***********************
     */
        // Product
        // Product AddFormId
    let product_with_da_form;

    //// Product Modal Updated From Livewire => Show
    Livewire.on('select-by-digital-art-body::showmodal', () => {
        uxmal.Modals.show('selectProductWithDigitalArtId');
    });

    //// Attach On Change Event when selected Product change
    uxmal.Selects.on('OrderProductAddId', 'change', (value) => {
        if (value == null || value === 0 || value === '')
            return;
        uxmal.Cards.setLoading('orderCard', true);
        Livewire.dispatch('select-by-digital-art-body::product.changed', {product: value});
    });

    //// Attach On shown.bs.modal Del Modal de Seleccion de Product
    uxmal.Modals.on('selectProductWithDigitalArtId', 'shown.bs.modal', function () {
        uxmalSwiper.init(this);
        product_with_da_form = uxmalForm.init(this);
        uxmal.Cards.setLoading('orderCard', false);
    });

    //// Attach On Child Product SaveBtn Click.
    uxmal.Modals.onChild('selectProductWithDigitalArtId', '.save-button', 'click', (event) => {
        console.log('selectProductWithDigitalArtSaveBtn::event::click', event);
        uxmal.Cards.setLoading('orderCard', true);
        uxmalForm.submit(product_with_da_form, {
            order_id: window.order_id,
            customer_id: window.customer_id
        }, () => {
            Livewire.dispatch('order-product-details.table.tbody::reload');
            uxmal.Modals.hide('selectProductWithDigitalArtId');
        });
    });

    //// Listen To Event When Inserted Record on Table OrderProductDetails
    Livewire.on('order-product-details.table.tbody::updated', (data) => {
        console.log('order-product-details.table.tbody::updated', data);
        const tableEl = document.querySelector("table[id='orderProductDetailsId']");
        const tFoot = tableEl.querySelector('tfoot');
        if (tFoot) {
            tFoot.innerHTML = data.tfoot;
        }
        uxmal.Cards.setLoading('orderCard', false);
    });


    //// Get From dom the order_id and customer_id
    let divElement = document.querySelector('div[data-uxmal-order-data]');
    if (divElement) {
        const order_data = JSON.parse(divElement.getAttribute('data-uxmal-order-data').toString());
        if (order_data) {
            window.order_id = order_data.order_id;
            window.customer_id = order_data.customer_id;
        }
    }
});
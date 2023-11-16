import {UxmalCSRF, UxmalSwiper, Uxmal} from "laravel-uxmal-npm";
import {updateOrder} from "../workshop.js";
import update from "../../../public/enmaca/laravel-uxmal/libs/swiper/core/update/index.js";

const uxmalSwiper = new UxmalSwiper();
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
            } else if (data.fail) {
                uxmal.sweetAlert(data.fail, 'warning');
            }
        })
        .catch((error) => {
            uxmal.sweetAlert(error.message, 'danger');
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
            if (data.ok) {
                Livewire.dispatch('order-product-dynamic-details.table.tbody::reload');
            } else if (data.fail) {
                uxmal.sweetAlert(data.fail, 'warning');
            }
        })
        .catch((error) => {
            uxmal.sweetAlert(error.message, 'danger');
        });
}

/**
 * Init the interactive behavior of the Delivery Address Book
 */

const initDeliveryAddressBook = () => {
    uxmal.Forms.on('deliveryData', 'change', function (event) {
        const buttonEl = document.getElementById('addressBookSubmitId');
        if (buttonEl && buttonEl.classList.contains('d-none'))
            buttonEl.classList.remove('d-none');
    });

    uxmal.Inputs.on('shipmentStatusId', 'change', (event) => {
        const shipmentStatusDivEl = document.querySelector('[data-workshop-shipment-data]');
        if(!event.target.checked) {
            shipmentStatusDivEl.classList.remove('d-none');
        } else {
            shipmentStatusDivEl.classList.add('d-none');
        }
    });



    const recipientDataDivEl = document.querySelector('[data-workshop-recipient-data]');
    const updRecipientDataState = () => {
        const userDataSelectors = ['recipientNameId', 'recipientLastNameId', 'recipientMobileId'];
        if (uxmal.Inputs.get('recipientDataSameAsCustomerId').element.checked) {
            recipientDataDivEl.classList.add('d-none');
            uxmal.Inputs.for(userDataSelectors, (item) => {
                item.removeAttribute('required');
            });
        } else {
            recipientDataDivEl.classList.remove('d-none');
            uxmal.Inputs.for(userDataSelectors, (item) => {
                item.setAttribute('required', '');
            });
        }
    };

    uxmal.Selects.get('mexMunicipalitiesId').tomselect2.lock();
    uxmal.Selects.get('mexStateId').tomselect2.lock();

    uxmal.Inputs.on('recipientDataSameAsCustomerId', 'change', () => {
        updRecipientDataState();
    });

    uxmal.Inputs.on('zipCodeId', 'change', (event) => {
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
        console.log('Livewire:init:component:name ===>', component.name);
        switch (component.name) {
            case 'order.button.delivery-date':
                component.el.querySelector('#orderDeliveryDateButtonId').onclick = () => {
                    uxmal.Inputs.get('deliveryDateId').flatpickrEl.open();
                };
                break;
            case 'addressbook.form.default-form':
                break;
            case 'order-payment-data.form':
                break;
        }
    });
})
document.addEventListener("DOMContentLoaded", function () {

});

document.addEventListener('livewire:initialized', () => {
    uxmal.init(document);

    /********************************
     * Client Data && Delivery Data *
     ********************************/
    //// Update Delivery Date Interactions
    uxmal.Inputs.on('deliveryDateId', 'change', (selectedDates) => {
        uxmal.Cards.setLoading('orderCard', true);
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
    // TODO: uxmalButton helpers
    document.getElementById('addressBookSubmitId').addEventListener('click', (event) => {
        uxmal.Cards.setLoading('orderCard', true);
        if( uxmal.Inputs.get('shipmentStatusId').element.checked ) {
            const data = {
                shipment_status: 'not_needed'
            };
            updateOrder(window.order_id, data, () => {
                Livewire.dispatch('addressbook.form.default-form::reload');
                uxmal.Cards.setLoading('orderCard', false);
            });
        } else {
            uxmal.Forms.submit('deliveryData', {
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
        }
    });

    //// Listen To Event When Livewire request message Succeds
    document.addEventListener('livewire:addressbook.form.default-form:request:succeed', (event) => {
        setTimeout(() => {
            const scope = document.querySelector(`[wire\\:id="${event.detail.id}"]`);
            uxmal.Forms.init(scope);
            uxmal.Inputs.init(scope);
            initDeliveryAddressBook();
            document.getElementById('addressBookSubmitId').classList.add('d-none');
            uxmal.Cards.setLoading('orderCard', false);
        }, 250);
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
    document.addEventListener('livewire:material.modal.add-material-to-order:request:succeed', (event) => {
        setTimeout(() => {
            uxmal.Modals.show('selectedMaterialToAddToOrderId');
        }, 250);
    });

    //// Attach On shown.bs.modal Del Modal de Seleccion de Material
    uxmal.Modals.on('selectedMaterialToAddToOrderId', 'shown.bs.modal', function () {
        uxmal.Cards.setLoading('orderCard', false);
        material_form_id = uxmal.Forms.init(this);
        // Attach On Child Materials Input Change.
        uxmal.Forms.onChild(material_form_id, ['#materialProfitMarginId', '#materialQuantityId'], 'change', () => {
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
    uxmal.Modals.onChild('selectedMaterialToAddToOrderId', '.uxmal-modal-save-button', 'click', (event) => {
        uxmal.Cards.setLoading('orderCard', true);
        uxmal.Forms.submit(material_form_id, {
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


    //// MfgOverHead Modal Updated From Livewire => Show  workshop.js Dispatch ===>
    document.addEventListener('livewire:mfg-over-head.modal.add-mfg-overhead-to-order:request:succeed', () => {
        uxmal.Modals.show('selectedMfgOverHeadToAddToOrderId');
    });

    //// Attach On shown.bs.modal Del Modal de Seleccion de MfgOverHead
    uxmal.Modals.on('selectedMfgOverHeadToAddToOrderId', 'shown.bs.modal', function () {
        uxmal.Cards.setLoading('orderCard', false);
        mfg_over_head_form_id = uxmal.Forms.init(this);
        uxmal.Forms.onChild(mfg_over_head_form_id, '#mfgOverheadQuantityId', 'change', (event) => {
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
    uxmal.Modals.onChild('selectedMfgOverHeadToAddToOrderId', '.uxmal-modal-save-button', 'click', (event) => {
        uxmal.Cards.setLoading('orderCard', true);
        uxmal.Forms.submit(mfg_over_head_form_id, {
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

    //// MfgLaborCost From Livewire => livewire:labor-cost.modal.add-labor-cost-to-order:request:succeed
    document.addEventListener('livewire:labor-cost.modal.add-labor-cost-to-order:request:succeed', () => {
        uxmal.Modals.show('selectedLaborCostToAddToOrderId');
    });

    //// Attach On shown.bs.modal Del Modal de Seleccion de MfgLaborCost
    uxmal.Modals.on('selectedLaborCostToAddToOrderId', 'shown.bs.modal', function () {
        uxmal.Cards.setLoading('orderCard', false);
        mfg_labor_cost_form_id = uxmal.Forms.init(this);
        uxmal.Forms.onChild(mfg_labor_cost_form_id, '#laborCostQuantityId', 'change', (event) => {
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
    uxmal.Modals.onChild('selectedLaborCostToAddToOrderId', '.uxmal-modal-save-button', 'click', (event) => {
        uxmal.Cards.setLoading('orderCard', true);
        uxmal.Forms.submit(mfg_labor_cost_form_id, {
            order_id: window.order_id,
            customer_id: window.customer_id
        }, () => {
            Livewire.dispatch('order-product-dynamic-details.table.tbody::reload');
            uxmal.Modals.hide('selectedLaborCostToAddToOrderId');
        });
    });

    let productDynamicDetailsTableFooterData;
    // Listen To Event When Inserted Record on Table OrderProductDynamicDetails
    Livewire.on('order-product-dynamic-details.table.tbody::updated', (data) => {
        productDynamicDetailsTableFooterData = data.tfoot;
        currentPrice = data.price;
        currentPriceDiv2 = data.price / 2;
        checkPayment();
    });

    // livewire:order-product-dynamic-details.table.tbody:request:succeed
    document.addEventListener('livewire:order-product-dynamic-details.table.tbody:request:succeed', (event) => {
        const tableEl = document.querySelector("table[id='orderProductDynamicDetailsId']");
        const tFoot = tableEl.querySelector('tfoot');
        if (tFoot) {
            tFoot.innerHTML = productDynamicDetailsTableFooterData;
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

    //// livewire:products.modal.select-by-digital-art-body:request:succeed
    document.addEventListener('livewire:products.modal.select-by-digital-art-body:request:succeed', () => {
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
        product_with_da_form = uxmal.Forms.init(this);
        uxmal.Cards.setLoading('orderCard', false);
    });

    //// Attach On Child Product SaveBtn Click.
    uxmal.Modals.onChild('selectProductWithDigitalArtId', '.uxmal-modal-save-button', 'click', (event) => {
        uxmal.Cards.setLoading('orderCard', true);
        uxmal.Forms.submit(product_with_da_form, {
            order_id: window.order_id,
            customer_id: window.customer_id
        }, () => {
            Livewire.dispatch('order-product-details.table.tbody::reload');
            uxmal.Modals.hide('selectProductWithDigitalArtId');
        });
    });

    let productDetailsTableFooterData;
    //// Listen To Event When Inserted Record on Table OrderProductDetails workshop.js Dispatch ===>
    Livewire.on('order-product-details.table.tbody::updated', (data) => {
        productDetailsTableFooterData = data.tfoot;
        const order_payment_amount = uxmal.Inputs.get('orderPaymentAmountId').element;

        currentPrice = data.price - order_payment_amount.value;
        currentPriceDiv2 = (data.price - order_payment_amount.value) / 2;
        checkPayment();
    });

    //// Event livewire:order-product-details.table.tbody:request:succeed
    document.addEventListener('livewire:order-product-details.table.tbody:request:succeed', (event) => {
        const tableEl = document.querySelector("table[id='orderProductDetailsId']");
        const tFoot = tableEl.querySelector('tfoot');
        if (tFoot) {
            tFoot.innerHTML = productDetailsTableFooterData;
        }
        uxmal.Cards.setLoading('orderCard', false);
    });


    //// Get From dom the order_id and customer_id
    const uxmalOrderDataEl = document.querySelector('div[data-uxmal-order-data]');
    if (uxmalOrderDataEl) {
        const order_data = JSON.parse(uxmalOrderDataEl.getAttribute('data-uxmal-order-data').toString());
        if (order_data) {
            window.order_id = order_data.order_id;
            window.customer_id = order_data.customer_id;
        }
    }

    //// On all dismiss/close buttons on modals remove indicator
    document.querySelectorAll('.uxmal-modal-close-button').forEach((item) => {
        item.addEventListener('click', () => {
            uxmal.Cards.setLoading('orderCard', false);
        });
    });

    const checkPayment = () => {
        const order_payment_status = uxmal.Inputs.get('orderPaymentStatusId').element;
        const advance_payment_50 = uxmal.Inputs.get('advance_payment_50Id').element;

        console.log(order_payment_status.value === 'completed');
        if(order_payment_status.value === 'completed'){
            updateOrderAmount('0.00');
        }


        if(advance_payment_50.checked) {
            updateOrderAmount(currentPriceDiv2);
        } else {
            updateOrderAmount(currentPrice);
        }
    }

    uxmal.Inputs.on('advance_payment_50Id', 'change', (event) => {
        checkPayment();
    });


    let currentPrice = 0;
    let currentPriceDiv2 = 0;
    const updateOrderAmount = (price) => {
        uxmal.Inputs.setValue('amountId', price);
    };

    document.getElementById("addPaymentFormButtonId").onclick = function() {
        uxmal.Cards.setLoading('orderCard', true);
        uxmal.Forms.submit('addPaymentForm', {
            order_id: window.order_id,
            customer_id: window.customer_id
        }, () => {
            Livewire.dispatch('order-payment-data.form::reload');
            uxmal.Cards.setLoading('orderCard', false);
        }, (elementName, data) => {
            uxmal.sweetAlert(data.fail, 'warning');
            uxmal.Cards.setLoading('orderCard', false);
        }, (elementName, error) => {
            uxmal.sweetAlert(error.message, 'danger');
            uxmal.Cards.setLoading('orderCard', false);
        });
    };

    document.addEventListener('livewire:order-payment-data.form:request:succeed', (event) => {
        setTimeout(() => {
            uxmal.Forms.init(document.querySelector('[data-uxmal-card-name="paymentCard"]'));
            checkPayment();
        }, 500);
    });
});
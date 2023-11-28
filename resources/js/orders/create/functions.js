import {UxmalCSRF} from "laravel-uxmal-npm/dist/esm/uxmal.js";
import {generateRandomString} from "../../workshop.js";
import {uxmal} from "../../workshop.js";
export const createFunctions = function () {

    /**
     * Obtain From the Dom, order_id, and customer_id
     */
    const uxmalOrderDataEl = document.querySelector('div[data-uxmal-order-data]');
    if (uxmalOrderDataEl) {
        const order_data = JSON.parse(uxmalOrderDataEl.getAttribute('data-uxmal-order-data').toString());
        if (order_data) {
            window.order_id = order_data.order_id;
            window.customer_id = order_data.customer_id;
        }
    }


    /**
     * Init the interactive behavior of the Delivery Address Book
     */
    const initDeliveryAddressBook = () => {
        uxmal.Forms.on('deliveryData', 'change', function () {
            const buttonEl = document.getElementById('addressBookSubmitId');
            if (buttonEl && buttonEl.classList.contains('d-none'))
                buttonEl.classList.remove('d-none');
        });

        uxmal.Inputs.on('shipmentStatusId', 'change', (event) => {
            const shipmentStatusDivEl = document.querySelector('[data-workshop-shipment-data]');
            if (!event.target.checked) {
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
                this.setValue(keys.length === 2 ? keys[1] : '', true);
            });

            const mexMunicipalitiesIdEl = uxmal.Selects.get('mexMunicipalitiesId').tomselect2;
            mexMunicipalitiesIdEl.clear(true);
            mexMunicipalitiesIdEl.clearOptions();
            mexMunicipalitiesIdEl.load('zipcode::' + event.target.value);
            mexMunicipalitiesIdEl.on('load', function () {
                const keys = Object.keys(this.options);
                this.setValue(keys.length === 2 ? keys[1] : '', true);
            });

            const mexStateIdEl = uxmal.Selects.get('mexStateId').tomselect2;
            mexStateIdEl.clear(true);
            mexStateIdEl.clearOptions();
            mexStateIdEl.load('zipcode::' + event.target.value);
            mexStateIdEl.on('load', function () {
                const keys = Object.keys(this.options);
                this.setValue(keys.length === 2 ? keys[1] : '', true);
            });
        });
        updRecipientDataState();
    }

    /*************
     * Order Dynamic Product Details
     * ***********/

    const ocardOrderDynamicProductSelectIdEl = uxmal.Selects.get('cardOrderDynamicProductSelectId').tomselect2;
    ocardOrderDynamicProductSelectIdEl.on('load', function () {
        this.setValue(window.opd_id, true);
    });

    //////// OrderPaymentData ////////

    // update the internal variables currentPrice and currentPriceDiv2, calc remaining amount to pay
    // on product add, product delete, payment add, payment delete
    const paymentUpdatePaymentData = (price) => {
        const order_payment_amount = parseFloat(uxmal.Inputs.get('orderPaymentAmountId').element.value);
        const remainingPayment = (parseFloat(price) - order_payment_amount).toFixed(2);
        return remainingPayment;
    };

    const updatePaymentData = (data) => {
        // Update Button Payment Amount
        const paymentCardPayedAmountButtonEl = document.getElementById('paymentCardPayedAmountButtonId');
        paymentCardPayedAmountButtonEl.textContent = "Pagado $" + parseFloat(data.order.payment_amount).toFixed(2);
        paymentCardPayedAmountButtonEl.classList.remove('d-none');

        // Update Button Payment Total
        const paymentCardTotalPriceButtonEl = document.getElementById('paymentCardTotalPriceButtonId');
        paymentCardTotalPriceButtonEl.textContent = "Total $" + parseFloat(data.order.price).toFixed(2);
        paymentCardTotalPriceButtonEl.classList.remove('d-none');

        const productCardPriceButtonIdEl = document.getElementById('productCardPriceButtonId');
        productCardPriceButtonIdEl.textContent = data.products.count + " Productos $" + parseFloat(data.products.payment_data.price).toFixed(2);
        productCardPriceButtonIdEl.classList.remove('d-none');

        const dynamicCardPriceButtonIdEl = document.getElementById('dynamicCardPriceButtonId');
        dynamicCardPriceButtonIdEl.textContent = data.dynamic_products.count + " Productos Dinámicos $" + parseFloat(data.dynamic_products.payment_data.price).toFixed(2);
        dynamicCardPriceButtonIdEl.classList.remove('d-none');

        const order_payment_amount = parseFloat(uxmal.Inputs.get('orderPaymentAmountId').element.value).toFixed(2);
        const order_payment_price  = parseFloat(uxmal.Inputs.get('orderPriceId').element.value).toFixed(2);
    }

    // checkPaymentData
    const paymentCheckNewPaymentData = (price) => {
        const order_payment_status = uxmal.Inputs.get('orderPaymentStatusId').element;
        const advance_payment_50 = uxmal.Inputs.get('advance_payment_50Id').element;
        if (order_payment_status.value === 'completed') {
            paymentUpdateRemainingAmountToPay(0);
        } else if (advance_payment_50.checked) {
            paymentUpdateRemainingAmountToPay((price / 2).toFixed(2));
        } else {
            paymentUpdateRemainingAmountToPay(price);
        }
    }

    // paymentUpdateRemainingAmountToPay, function to set the remaining amount to pay
    const paymentUpdateRemainingAmountToPay = (price) => {
        uxmal.Inputs.setValue('amountId', parseFloat(price).toFixed(2));
    };

    const oPDUpdateForm = (opd_id) => {
        // Dropzone Mfg Devices.
        uxmal.Dropzones.removeAllFiles('dropzone');
        const mfgDevicesSelectedEl = uxmal.Selects.get('mfgDevicesSelectedId').tomselect2;
        mfgDevicesSelectedEl.clear(true);
        mfgDevicesSelectedEl.setValue('', true);
        const mfgAreaSelectedIdEl = uxmal.Selects.get('mfgAreaSelectedId').tomselect2;
        mfgAreaSelectedIdEl.clear(true);
        mfgAreaSelectedIdEl.setValue('', true);
        const api_get_order_opd_url = uxmal.buildRoute('api_get_order_opd', window.order_id, window.opd_id);
        fetch(api_get_order_opd_url, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': UxmalCSRF()
            }
        }).then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        }).then(data => {
            if (data.ok) {
                // Update the dropzone url
                const DropzoneObj = uxmal.Dropzones.get('dropzone').dropzone
                DropzoneObj.options.url = uxmal.buildRoute('api_post_order_opd_media', window.order_id, window.opd_id);
                DropzoneObj.options.headers = {
                    'X-CSRF-TOKEN': UxmalCSRF()
                };

                if (data.result.media.length > 0) {
                    uxmal.Dropzones.addVirtualFiles('dropzone', data.result.media);
                }

                if( data.result.mfg_media_id_needed === 'yes'){
                    uxmal.Inputs.get('mfgMediaIdNeededId').element.checked = true;
                    document.querySelector('[workshop-opd-mfg-media-instructions]').classList.remove('d-none');
                    document.getElementById('customerInstructionsId').value = data.result.mfg_media_instructions;
                } else {
                    uxmal.Inputs.get('mfgMediaIdNeededId').element.checked = false;
                    document.querySelector('[workshop-opd-mfg-media-instructions]').classList.add('d-none');
                    document.getElementById('customerInstructionsId').value = '';
                }

                if( data.result.mfg_status === 'not_needed'){
                    uxmal.Inputs.get('mfgStatusId').element.checked = false;
                    document.querySelector('[workshop-opd-mfg-status]').classList.add('d-none');
                } else {
                    uxmal.Inputs.get('mfgStatusId').element.checked = true;
                    document.querySelector('[workshop-opd-mfg-status]').classList.remove('d-none');

                    if( data.result.mfg_area_id ) {
                        const mfgDevicesSelectedEl = uxmal.Selects.get('mfgDevicesSelectedId').tomselect2;
                        mfgAreaSelectedIdEl.setValue(data.result.mfg_area_id, true);
                        mfgDevicesSelectedEl.clear(true);
                        mfgDevicesSelectedEl.clearOptions();
                        mfgDevicesSelectedEl.load('mfgArea::' + data.result.mfg_area_id);
                        mfgDevicesSelectedEl.on('load', function () {
                            this.setValue(data.result.mfg_device_id, true);
                        });
                    }

                }

                const updateMfgMediaInstructionsButtonIdEl = document.getElementById('updateMfgMediaInstructionsButtonId');
                updateMfgMediaInstructionsButtonIdEl.classList.add('d-none');

            } else if (data.fail) {
                uxmal.alert(data.fail, 'danger');
            } else if (data.warning) {
                uxmal.alert(data.warning, 'warning');
            }
        }).catch(error => {
            uxmal.alert(error.message, 'danger');
        });
    }

    const oPDTableTbodyDispatchReload = () => {
        const opd_id = window.opd_id;
        Livewire.dispatch('order-product-dynamic-details.table.tbody::reload', {opd_id: opd_id});
    }

    const oPDCreateNew = ($opd_id) => {
        window.opd_id = $opd_id;
        console.log('window.opd_id CHANGED ==> ', window.opd_id);
        ocardOrderDynamicProductSelectIdEl.load(generateRandomString(6)); // RandomString to disable cache.

        oPDTableTbodyDispatchReload();
        uxmal.Modals.hide('modalOrderProductDynamicDetailsCreateNewId');

        const mfgDEvicesSelectedEl = uxmal.Selects.get('mfgDevicesSelectedId').tomselect2;
        mfgDEvicesSelectedEl.clear(true)
        mfgDEvicesSelectedEl.clearOptions();
        mfgDEvicesSelectedEl.load();
        mfgDEvicesSelectedEl.on('load', function () {
            this.setValue('', true);
        });

        const mfgAreaSelectedEl = uxmal.Selects.get('mfgAreaSelectedId').tomselect2;
        mfgAreaSelectedEl.clear(true)
        mfgAreaSelectedEl.clearOptions();
        mfgAreaSelectedEl.load();
        mfgAreaSelectedEl.on('load', function () {
            this.setValue('', true);
        });

        uxmal.Inputs.get('mfgStatusId').element.checked = false;
        document.querySelector('[workshop-opd-mfg-status]').classList.add('d-none');

        const DropzoneObj = uxmal.Dropzones.get('dropzone').dropzone
        const api_post_order_opd_media_url = uxmal.buildRoute('api_post_order_opd_media', window.opd_id);
        DropzoneObj.options.url = api_post_order_opd_media_url;
        DropzoneObj.options.headers = {
            'X-CSRF-TOKEN': UxmalCSRF()
        };
        uxmal.Dropzones.removeAllFiles('dropzone');
        uxmal.Inputs.get('mfgMediaIdNeededId').element.checked = false;
        document.querySelector('[workshop-opd-mfg-media-instructions]').classList.add('d-none');
        const updateMfgMediaInstructionsButtonIdEl = document.getElementById('updateMfgMediaInstructionsButtonId');
        if (updateMfgMediaInstructionsButtonIdEl) {
            updateMfgMediaInstructionsButtonIdEl.classList.add('d-none');
        }
    };

    const oPDModalAddMaterialUpdate = (value) => {
        if (value == null || value === 0 || value === '')
            return;
        if (window.opd_id === '' || window.opd_id === 0 || window.opd_id === null) {
            uxmal.alert('Crea un producto primero!', 'warning');
            uxmal.Selects.get('materialSelectedId').tomselect2.setValue('', true);
            return;
        }
        Livewire.dispatch('add-material-to-order::material.changed', {material: value});
        return true;
    }

    const oPDModalAddMaterialHeadOnShow = (modal) => {
        uxmal.Selects.get('materialSelectedId').tomselect2.setValue('', true);
        const _fid = uxmal.Forms.init(modal);
        // Attach On Child Materials Input Change.
        uxmal.Forms.onChild(_fid, ['#materialProfitMarginId', '#materialQuantityId'], 'change', () => {
            const mtQtyEl = document.getElementById('materialQuantityId');
            const uom_cost = Number(mtQtyEl.getAttribute('data-uom-cost'));
            const tax_data = Number(mtQtyEl.getAttribute('data-tax-factor'));
            const profit_margin = Number(document.getElementById('materialProfitMarginId').value);
            document.getElementById('materialSubtotalId').value = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD'
            }).format((uom_cost * mtQtyEl.value * (1 + (profit_margin / 100))) * (1 + tax_data));
        });
        return _fid;
    }

    const oPDModalAddMaterialSave = (material_form_id) => {
        uxmal.Forms.submit(material_form_id, {
            order_id: window.order_id,
            customer_id: window.customer_id,
            opd_id: window.opd_id
        }, (elementName, data) => {
            oPDTableTbodyDispatchReload();
            uxmal.alert(data.ok, 'success');
        });
    }

    const oPDModalMfgOverHeadUpdate = (value) => {
        if (value == null || value === 0 || value === '')
            return;
        if (window.opd_id === '' || window.opd_id === 0 || window.opd_id === null) {
            uxmal.alert('Crea un producto primero!', 'warning');
            uxmal.Selects.get('mfgOverHeadSelectedId').tomselect2.setValue('', true);
            return;
        }
        Livewire.dispatch('add-mfg-overhead-to-order::mfgoverhead.changed', {mfgoverhead: value});
        return true;
    };

    const oPDModalMfgOverHeadOnShow = (modal) => {
        uxmal.Selects.get('mfgOverHeadSelectedId').tomselect2.setValue('', true);
        const _fid = uxmal.Forms.init(modal);
        uxmal.Forms.onChild(_fid, '#mfgOverheadQuantityId', 'change', (event) => {
            const mfgQtyEl = event.target;
            const tax_data = Number(mfgQtyEl.getAttribute('data-tax-factor'));
            const uom = Number(mfgQtyEl.getAttribute('data-value'));
            document.getElementById('mfgOverheadSubtotalId').value = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD'
            }).format((mfgQtyEl.value * uom) * (1 + tax_data));
        });
        return _fid;
    }

    const oPDModalMfgOverHeadSave = (_fid) => {
        uxmal.Modals.hide('selectedMfgOverHeadToAddToOrderId');
        uxmal.Forms.submit(_fid, {
            order_id: window.order_id,
            customer_id: window.customer_id,
            opd_id: window.opd_id
        }, (elementName, data) => {
            console.log('selectedMfgOverHeadToAddToOrderId submit success');
            oPDTableTbodyDispatchReload();
            uxmal.Modals.hide('selectedMfgOverHeadToAddToOrderId');
            uxmal.alert(data.ok, 'success');
        });
    }

    const oPDModalLaborCostsUpdate = (value) => {
        if (value == null || value === 0 || value === '')
            return;
        if (window.opd_id === '' || window.opd_id === 0 || window.opd_id === null) {
            uxmal.alert('Crea un producto primero!', 'warning');
            uxmal.Selects.get('laborCostSelectedId').tomselect2.setValue('', true);
            return;
        }
        Livewire.dispatch('add-labor-cost-to-order::laborcost.changed', {laborcost: value});
        return true;
    }

    const oPDModalLaborCostsOnShow = (modal) => {
        uxmal.Selects.get('laborCostSelectedId').tomselect2.setValue('', true);
        const _fid = uxmal.Forms.init(modal);
        uxmal.Forms.onChild(_fid, '#laborCostQuantityId', 'change', (event) => {
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
        return _fid;
    }

    const oPDModalLaborCostsSave = (_fid) => {
        uxmal.Modals.hide('selectedLaborCostToAddToOrderId');
        uxmal.Forms.submit(_fid, {
            order_id: window.order_id,
            customer_id: window.customer_id,
            opd_id: window.opd_id
        }, (elementName, data) => {
            console.log('selectedLaborCostToAddToOrderId submit success');
            oPDTableTbodyDispatchReload();
            uxmal.Modals.hide('selectedLaborCostToAddToOrderId');
            uxmal.alert(data.ok, 'success');
        });
    }


    return {
        initDeliveryAddressBook,

        /* Global Elements */
        ocardOrderDynamicProductSelectIdEl,

        updatePaymentData,
        paymentCheckNewPaymentData,
        paymentUpdatePaymentData,
        paymentUpdateRemainingAmountToPay,

        oPDCreateNew,
        oPDUpdateForm,
        oPDTableTbodyDispatchReload,

        oPDModalAddMaterialUpdate,
        oPDModalAddMaterialHeadOnShow,
        oPDModalAddMaterialSave,

        oPDModalMfgOverHeadUpdate,
        oPDModalMfgOverHeadOnShow,
        oPDModalMfgOverHeadSave,

        oPDModalLaborCostsUpdate,
        oPDModalLaborCostsOnShow,
        oPDModalLaborCostsSave
    }
};
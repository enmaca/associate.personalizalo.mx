import {UxmalCSRF, UxmalSwiper} from "laravel-uxmal-npm";
import {apiPutOrder, generateRandomString, apiPutOrderProductDynamic} from "../workshop.js";
import {createFunctions} from "./create/functions.js";
import {uxmal} from "../workshop.js";

const uxmalSwiper = new UxmalSwiper();

window.customer_id = null;
window.order_id = null;
window.opd_id = null;

console.log('resources/js/order/create.js Loaded')

let productDetailsTableFooterData;
let currentPrice;


document.addEventListener('livewire:initialized', () => {
    uxmal.init(document);
    const functions = createFunctions();

    currentPrice = document.getElementById('orderPriceId').value;

    /********************************
     * Client Data && Delivery Date *
     ********************************/
    //// OnChange::DeliveryDate::Input => Livewire::Update::Order::DeliveryDate::Button
    uxmal.Inputs.on('deliveryDateId', 'change', (selectedDates) => {
        const data = {
            delivery_date: selectedDates[0].toISOString().slice(0, 19).replace('T', ' ')
        };
        uxmal.Cards.setLoading('clientCard', true);
        apiPutOrder(window.order_id, data, (data) => {
            Livewire.dispatch('order.button.delivery-date::reload');
            uxmal.alert(data.ok, 'success');
        });
    });

    //// Livewire::Update::Order::DeliveryDate::Button => RoundTrip::Succeded => Hide::Loading::Indicator
    document.addEventListener('livewire:order.button.delivery-date:request:succeed', () => {
        uxmal.Cards.setLoading('clientCard', false);
    });

    functions.initDeliveryAddressBook();

    /**
     * Events.
     */
    Echo.private(`order.${window.order_id}`).subscribed(() => {
        console.log('Subscribed to Order Channel: ' + `order.${window.order_id}`);
        fetch(uxmal.buildRoute('api_get_order_event', window.order_id, 'order_payment_data'));
    })
        .listenToAll((eventName, event) => {
            console.log("Event ::  " + eventName + ", data is ::", event.data);
        })
        .listen('OrderPaymentDataUpdated', (event) => {
            console.log('OrderPaymentDataUpdated, data is ::', event.data);
            uxmal.Cards.setLoading('paymentCard', true);
            functions.updatePaymentData(event.data);
            Livewire.dispatch('order-payment-data.form::reload');

        });

    //// Save Delivery Data
    // TODO: uxmalButton helpers
    document.getElementById('addressBookSubmitId').addEventListener('click', () => {
        uxmal.Cards.setLoading('clientCard', true);
        if (uxmal.Inputs.get('shipmentStatusId').element.checked) {
            const data = {
                shipment_status: 'not_needed'
            };
            /// apiPutOrder => Livewire::Update::AddressBookForm::DefaultForm
            apiPutOrder(window.order_id, data, (data) => {
                uxmal.Forms.get('deliveryData').element.reset();
                uxmal.Inputs.get('shipmentStatusId').element.checked = true;
                uxmal.Selects.get('mexDistrictId').tomselect2.clear(true);
                uxmal.Selects.get('mexDistrictId').tomselect2.clearOptions();
                uxmal.Selects.get('mexMunicipalitiesId').tomselect2.clear(true);
                uxmal.Selects.get('mexMunicipalitiesId').tomselect2.clearOptions();
                uxmal.Selects.get('mexStateId').tomselect2.clear(true);
                uxmal.Selects.get('mexStateId').tomselect2.clearOptions();
                Livewire.dispatch('addressbook.form.default-form::reload');
                uxmal.alert(data.ok, 'success');
            }, (data) => {
                uxmal.alert(data.fail, 'danger');
                uxmal.Cards.setLoading('clientCard', false);
            }, (error) => {
                uxmal.alert(data.warning, 'warning');
                uxmal.Cards.setLoading('clientCard', false);
            });
        } else {
            console.log('=========> ', uxmal.Inputs.get('recipientDataSameAsCustomerId').element.value);
            /// SubmitDeliveryData::Form => Livewire::Update::AddressBookForm::DefaultForm
            uxmal.Forms.submit('deliveryData', {
                order_id: window.order_id,
                customer_id: window.customer_id,
                recipientDataSameAsCustomer: uxmal.Inputs.get('recipientDataSameAsCustomerId').element.checked ? 1 : 0
            }, (elementName, data) => {
                Livewire.dispatch('addressbook.form.default-form::reload');
                uxmal.alert(data.ok, 'success');
            }, (elementName, data) => {
                uxmal.alert(data.fail, 'danger');
                uxmal.Cards.setLoading('clientCard', false);
            }, (elementName, error) => {
                uxmal.alert(error, 'warning');
                uxmal.Cards.setLoading('clientCard', false);
            });
        }
    });

    //// Save::Delivery::Data => AddressBookForm::updated => Init Behaivors
    document.addEventListener('livewire:addressbook.form.default-form:request:succeed', (event) => {
        setTimeout(() => {
            const scope = document.querySelector(`[wire\\:id="${event.detail.id}"]`);
            uxmal.Forms.init(scope);
            uxmal.Inputs.init(scope);
            functions.initDeliveryAddressBook();
            uxmal.Cards.setLoading('clientCard', false);
            document.getElementById('addressBookSubmitId').classList.add('d-none');
        }, 250);
    });


    /***********************
     * OrderProductDetails *
     ***********************/

        // Product
        // Product AddFormId
    let product_with_da_form;

    //// OP::Product::Select => On::Change => Livewire::Update::Modal
    uxmal.Selects.on('OrderProductAddId', 'change', (value) => {
        if (value == null || value === 0 || value === '')
            return;
        uxmal.Cards.setLoading('productCard', true);
        Livewire.dispatch('select-by-digital-art-body::product.changed', {product: value});
    });

    //// LiveWire::Modal::Updated => Event::Round::Trip::Succeded => ShowModal
    document.addEventListener('livewire:products.modal.select-by-digital-art-body:request:succeed', () => {
        uxmal.Modals.show('selectProductWithDigitalArtId');
    });

    //// OnShowModal::OP => Init::Swiper && Init::Form
    uxmal.Modals.on('selectProductWithDigitalArtId', 'shown.bs.modal', function () {
        uxmalSwiper.init(this);
        product_with_da_form = uxmal.Forms.init(this);
        uxmal.Selects.get('OrderProductAddId').tomselect2.setValue('', true);
        uxmal.Cards.setLoading('productCard', false);
    });

    //// OnClick::SaveBtn::OP => Submit::Form => Update::OrderProductDetailsTable
    uxmal.Modals.onChild('selectProductWithDigitalArtId', '.uxmal-modal-save-button', 'click', () => {
        uxmal.Modals.hide('selectProductWithDigitalArtId');
        uxmal.Cards.setLoading('productCard', true);
        uxmal.Forms.submit(product_with_da_form, {
            order_id: window.order_id,
            customer_id: window.customer_id
        }, () => {
            Livewire.dispatch('order-product-details.table.tbody::reload');
            uxmal.Modals.hide('selectProductWithDigitalArtId');
        });
    });

    //// Update OrderProductDetails Table Tbody::Foot InnerHTML => UpdatePaymentPrice => paymentCheckNewPaymentData
    Livewire.on('order-product-details.table.tbody::updated', (data) => {
        console.log('Catched Livewire::order-product-details.table.tbody::updated Event!!!!');
        productDetailsTableFooterData = data.tfoot;
        currentPrice = functions.paymentUpdatePaymentData(data.price);
    });

    //// Update::OrderProductDetailsTable => RoundTrip::Succeded => Update::OrderProductDetailsTable
    document.addEventListener('livewire:order-product-details.table.tbody:request:succeed', () => {
        const tableEl = document.querySelector("table[id='orderProductDetailsId']");
        const tFoot = tableEl.querySelector('tfoot');
        if (tFoot) {
            tFoot.innerHTML = productDetailsTableFooterData;
        }
        uxmal.Cards.setLoading('productCard', false);
    });

    //// On all dismiss/close buttons on modals remove indicator
    uxmal.Modals.get('selectProductWithDigitalArtId').element.querySelectorAll('.uxmal-modal-close-button').forEach((item) => {
        item.addEventListener('click', () => {
        });
    });

    /******************************
     * OrderProductDynamicDetails *
     ******************************/

    uxmal.Selects.on('cardOrderDynamicProductSelectId', 'change', (value) => {
        if (value == null || value === 0 || value === '')
            return;
        window.opd_id = value;
        functions.oPDTableTbodyDispatchReload();
        functions.oPDUpdateForm(window.opd_id);
        uxmal.Cards.setLoading('dynamicCard', true);
    });

    ///// Create New Product Dynamic Details
    uxmal.Modals.onChild('modalOrderProductDynamicDetailsCreateNewId', '.uxmal-modal-save-button', 'click', () => {
        uxmal.Cards.setLoading('dynamicCard', true);
        uxmal.Modals.hide('modalOrderProductDynamicDetailsCreateNewId');
        uxmal.Forms.submit('OrderProductDynamicDetailsCreateNewForm', {
            order_id: window.order_id,
            customer_id: window.customer_id
        }, (elementName, data) => {
            functions.oPDCreateNew(data.result.id);
            uxmal.alert(data.ok);
            uxmal.Cards.setLoading('dynamicCard', false);
        }, (elementName, data) => {
            uxmal.alert(data.fail, 'warning');
            uxmal.Cards.setLoading('dynamicCard', false);
        }, (elementName, error) => {
            console.error(elementName, error);
            uxmal.Cards.setLoading('dynamicCard', false);
        });
    });

    // Material
    // Material AddFormId
    let material_form_id;

    //// OPD::Material::Select => On::Change => Livewire::Update::Modal
    uxmal.Selects.on('materialSelectedId', 'change', (value) => {
        if (functions.oPDModalAddMaterialUpdate(value)) {
            uxmal.Cards.setLoading('dynamicCard', true);
        }
    });

    //// Livewire::Modal::Updated => Event::Round::Trip::Succeded
    document.addEventListener('livewire:material.modal.add-material-to-order:request:succeed', () => {
        uxmal.Modals.show('selectedMaterialToAddToOrderId');
    });

    //// Event::Round::Trip::Succeded => Modal::Add::Material => Show
    uxmal.Modals.on('selectedMaterialToAddToOrderId', 'shown.bs.modal', function () {
        material_form_id = functions.oPDModalAddMaterialHeadOnShow(this);
        uxmal.Cards.setLoading('dynamicCard', false);
    });

    //// Modal::Add::Material::SaveBtn => Form::Submit => Update::OrderDynamicDetailsTable
    uxmal.Modals.onChild('selectedMaterialToAddToOrderId', '.uxmal-modal-save-button', 'click', () => {
        uxmal.Cards.setLoading('dynamicCard', true);
        uxmal.Modals.hide('selectedMaterialToAddToOrderId');
        functions.oPDModalAddMaterialSave(material_form_id);
    });

    // MfgOverHead
    // MfgOverHead AddFormId
    let mfg_over_head_form_id;
    //// Attach On Change Event when selected MfgOverHead change
    uxmal.Selects.on('mfgOverHeadSelectedId', 'change', (value) => {
        if (functions.oPDModalMfgOverHeadUpdate(value)) {
            uxmal.Cards.setLoading('dynamicCard', true);
        }
    });
    //// Livewire => Modal::Add::MfgOverHead => Save => Event Roundtrip Succeded
    document.addEventListener('livewire:mfg-over-head.modal.add-mfg-overhead-to-order:request:succeed', () => {
        uxmal.Modals.show('selectedMfgOverHeadToAddToOrderId');
    });

    //// Attach On shown.bs.modal Del Modal de Seleccion de MfgOverHead
    uxmal.Modals.on('selectedMfgOverHeadToAddToOrderId', 'shown.bs.modal', function () {
        mfg_over_head_form_id = functions.oPDModalMfgOverHeadOnShow(this);
        uxmal.Cards.setLoading('dynamicCard', false);
    });

    //// Attach On Child MfgOverHead SaveBtn => Form::Submit => Update OrderDynamicDetailsTable
    uxmal.Modals.onChild('selectedMfgOverHeadToAddToOrderId', '.uxmal-modal-save-button', 'click', () => {
        uxmal.Cards.setLoading('dynamicCard', true);
        uxmal.Modals.hide('selectedMfgOverHeadToAddToOrderId');
        functions.oPDModalMfgOverHeadSave(mfg_over_head_form_id);
    });

    // MfgLaborCost
    // MfgLaborCost AddFormId
    let mfg_labor_cost_form_id;

    //// Attach On Change Event when selected MfgLaborCost change
    uxmal.Selects.on('laborCostSelectedId', 'change', (value) => {
        if (functions.oPDModalLaborCostsUpdate(value)) {
            uxmal.Cards.setLoading('dynamicCard', true);
        }
    });

    //// MfgLaborCost From Livewire => livewire:labor-cost.modal.add-labor-cost-to-order:request:succeed
    document.addEventListener('livewire:labor-cost.modal.add-labor-cost-to-order:request:succeed', () => {
        uxmal.Modals.show('selectedLaborCostToAddToOrderId');
    });

    //// Attach On shown.bs.modal Del Modal de Seleccion de MfgLaborCost
    uxmal.Modals.on('selectedLaborCostToAddToOrderId', 'shown.bs.modal', function () {
        mfg_labor_cost_form_id = functions.oPDModalLaborCostsOnShow(this);
        uxmal.Cards.setLoading('dynamicCard', false);
    });

    //// Attach On Child MfgLaborCost SaveBtn Click.
    uxmal.Modals.onChild('selectedLaborCostToAddToOrderId', '.uxmal-modal-save-button', 'click', () => {
        uxmal.Cards.setLoading('dynamicCard', true);
        uxmal.Modals.hide('selectedLaborCostToAddToOrderId');
        functions.oPDModalLaborCostsSave(mfg_labor_cost_form_id);
    });

    let productDynamicDetailsTableFooterData;
    // Listen To Event When Inserted Record on Table OrderProductDynamicDetails
    Livewire.on('order-product-dynamic-details.table.tbody::updated', (data) => {
        console.log('Catched Livewire::order-product-dynamic-details.table.tbody::updated Event!!!!');
        document.getElementById('orderDynamicDetailsDescriptionId').innerHTML = data.opp_description;
        productDynamicDetailsTableFooterData = data.tfoot;
    });

    // livewire:order-product-dynamic-details.table.tbody:request:succeed
    document.addEventListener('livewire:order-product-dynamic-details.table.tbody:request:succeed', () => {
        const tableEl = document.querySelector("table[id='orderProductDynamicDetailsId']");
        const tFoot = tableEl.querySelector('tfoot');
        if (tFoot) {
            tFoot.innerHTML = productDynamicDetailsTableFooterData;
        }
        uxmal.Cards.setLoading('dynamicCard', false);
    });


//// Need MFG Media (Necesita diseño)
    uxmal.Inputs.on('mfgMediaIdNeededId', 'change', (event) => {
        if (!window.opd_id) {
            event.target.checked = !event.target.checked
            uxmal.alert('Crea un producto primero!', 'warning');
            return;
        }
        uxmal.Cards.setLoading('dynamicCard', true);
        if (event.target.checked) {
            apiPutOrderProductDynamic(window.order_id, window.opd_id, {mfg_media_id_needed: 'yes'}, (data) => {
                uxmal.alert(data.ok, 'success');
                uxmal.Cards.setLoading('dynamicCard', false);
            }, (data) => {
                uxmal.alert(data.fail, 'warning');
                uxmal.Cards.setLoading('dynamicCard', false);
            }, (error) => {
                uxmal.alert(error, 'danger');
                uxmal.Cards.setLoading('dynamicCard', false);
            });
            document.querySelector('[workshop-opd-mfg-media-instructions]').classList.remove('d-none');
        } else {
            apiPutOrderProductDynamic(window.order_id, window.opd_id, {mfg_media_id_needed: 'no'}, (data) => {
                uxmal.alert(data.ok, 'success');
                uxmal.Cards.setLoading('dynamicCard', false);
            }, (data) => {
                uxmal.alert(data.fail, 'warning');
                uxmal.Cards.setLoading('dynamicCard', false);
            }, (error) => {
                uxmal.alert(error, 'danger');
                uxmal.Cards.setLoading('dynamicCard', false);
            });
            //TODO Clear instrucciones y DropZone
            document.querySelector('[workshop-opd-mfg-media-instructions]').classList.add('d-none');
        }
    });

    const cumtomerMfgInstructionsEl = document.getElementById('customerInstructionsId');
    const updateMfgMediaInstructionsButtonIdEl = document.getElementById('updateMfgMediaInstructionsButtonId');

    /** OnChange Manufacturing Media Instruccions Show (Save Button) **/
    cumtomerMfgInstructionsEl.addEventListener('input', (event) => {
        updateMfgMediaInstructionsButtonIdEl.classList.remove('d-none');
    });

    /** Manufacturing Media Instruccion Save Button Click **/
    updateMfgMediaInstructionsButtonIdEl.onclick = function () {
        console.log('updateMfgMediaInstructionsButtonId clicked!');
        apiPutOrderProductDynamic(window.order_id, window.opd_id, {mfg_media_instructions: cumtomerMfgInstructionsEl.value}, (data) => {
            updateMfgMediaInstructionsButtonIdEl.classList.add('d-none');
            uxmal.alert(data.ok, 'success');
        });
    }


//// Clear MfgDevice Select
    const mfgDevicesSelectedEl = uxmal.Selects.get('mfgDevicesSelectedId').tomselect2;

    mfgDevicesSelectedEl.on('load', (event) => {
        mfgDevicesSelectedEl.setValue('', true);
    });
//// MfgStatus, MfgArea, MfgDevice
    uxmal.Inputs.on('mfgStatusId', 'change', (event) => {
        if (!window.opd_id) {
            event.target.checked = !event.target.checked
            uxmal.alert('Crea un producto primero!', 'warning');
            return;
        }
        uxmal.Cards.setLoading('dynamicCard', true);
        if (event.target.checked) {
            apiPutOrderProductDynamic(window.order_id, window.opd_id, {mfg_status: 'pending'}, (data) => {
                uxmal.alert(data.ok, 'success');
                uxmal.Cards.setLoading('dynamicCard', false);
            });
            document.querySelector('[workshop-opd-mfg-status]').classList.remove('d-none');
        } else {
            apiPutOrderProductDynamic(window.order_id, window.opd_id, {mfg_status: 'not_needed'}, (data) => {
                mfgDevicesSelectedEl.clear(true);
                mfgDevicesSelectedEl.clearOptions();
                uxmal.alert(data.ok, 'success');
                uxmal.Cards.setLoading('dynamicCard', false);
            });
            document.querySelector('[workshop-opd-mfg-status]').classList.add('d-none');
        }
    });

    uxmal.Selects.on('mfgAreaSelectedId', 'change', (value) => {
        if (window.opd_id === '' || window.opd_id === 0 || window.opd_id === null) {
            uxmal.alert('Crea un producto primero!', 'warning');
            uxmal.Selects.get('mfgAreaSelectedId').tomselect2.setValue('', true);
            return;
        }
        mfgDevicesSelectedEl.clear(true);
        mfgDevicesSelectedEl.clearOptions();
        mfgDevicesSelectedEl.load('mfgArea::' + value);
    });

//// Select MfgDevice On Change
    uxmal.Selects.on('mfgDevicesSelectedId', 'change', (value) => {
        if (window.opd_id === '' || window.opd_id === 0 || window.opd_id === null) {
            uxmal.alert('Crea un producto primero!', 'warning');
            return;
        }
        uxmal.Cards.setLoading('dynamicCard', true);
        apiPutOrderProductDynamic(window.order_id, window.opd_id, {mfg_device_id: value}, (data) => {
            uxmal.alert(data.ok, 'success');
            uxmal.Cards.setLoading('dynamicCard', false);
        });
    });


    document.getElementById('createNewDynamicProductButtonId').onclick = function () {
        console.log('createNewDynamicProductButtonId clicked!');
        uxmal.Modals.show('modalOrderProductDynamicDetailsCreateNewId');
    }

    window.removeOPDD = (row) => {

    }


// On check Checkbox (Anticipo 50%)
    uxmal.Inputs.on('advance_payment_50Id', 'change', () => {
        functions.paymentCheckNewPaymentData(currentPrice);
    });

//// Variables to work with the payment card
// currentPrice 100% price, currentPriceDiv2 50% price
//

//// Register a payment action.
//// Process the onClick addPaymentFormButtonId button
    document.getElementById("addPaymentFormButtonId").onclick = function () {
        if (parseFloat(uxmal.Inputs.get('amountId').element.value) === 0)
            return;

        uxmal.Forms.submit('addPaymentForm', {
            order_id: window.order_id,
            customer_id: window.customer_id
        });
    };

//// Listen To Event When Livewire Request for Update the Payment Data Form succesds
    document.addEventListener('livewire:order-payment-data.form:request:succeed', () => {
        setTimeout(() => {
            uxmal.Forms.init(document.querySelector('[data-uxmal-card-name="paymentCard"]'));
            functions.paymentCheckNewPaymentData(currentPrice);
            uxmal.Cards.setLoading('paymentCard', false);
        }, 500);
    });


    /**
     * Remove OPDD de un OPD Logica.
     */
    uxmal.Cards.onChild('dynamicCard', '.card-footer', 'click', (event) => {
        let targetElement = event.target;
        while (targetElement && targetElement !== this) {
            if (targetElement.hasAttribute('data-workshop-opd-delete')) {
                // Element with the desired attribute was clicked
                // Perform your logic here
                break;
            }
            targetElement = targetElement.parentNode;
        }
        const opdd_id = targetElement.getAttribute('data-row-id');
        if (opdd_id) {
            uxmal.Cards.setLoading('dynamicCard', true);
            const apiDeleteOrderProductDynamicDetailUrl = uxmal.buildRoute('api_delete_order_opdd', window.order_id, window.opd_id, opdd_id);
            fetch(apiDeleteOrderProductDynamicDetailUrl, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': UxmalCSRF()
                }
            })
                .then(response => response.json())  // assuming server responds with json
                .then(data => {
                    if (data.ok) {
                        // El indicador de carga se oculta en el evento de livewire de reload de la tabla
                        functions.oPDTableTbodyDispatchReload();
                        uxmal.alert(data.ok, 'success');
                    } else if (data.fail) {
                        uxmal.Cards.setLoading('dynamicCard', false);
                        uxmal.alert(data.fail, 'danger');
                    } else if (data.warning) {
                        uxmal.Cards.setLoading('dynamicCard', false);
                        uxmal.alert(data.warning, 'warning');
                    }
                })
                .catch((error) => {
                    uxmal.Cards.setLoading('dynamicCard', false);
                    uxmal.alert(error.message, 'danger');
                });
        }
    });


    /**
     * Remove OPD de un OP Logica.
     */
    uxmal.Cards.onChild('productCard', '.card-footer', 'click', (event) => {
        let targetElement = event.target;
        while (targetElement && targetElement !== this) {
            if (targetElement.hasAttribute('data-workshop-oprd-delete')) {
                // Element with the desired attribute was clicked
                // Perform your logic here
                break;
            }
            targetElement = targetElement.parentNode;
        }
        uxmal.Cards.setLoading('productCard', true);
        const oprd_hashedId = targetElement.getAttribute('data-row-id');
        if (oprd_hashedId) {
            const apiDeleteOrderProductDetail = uxmal.buildRoute('api_delete_order_product_detail', window.order_id, oprd_hashedId);
            fetch(apiDeleteOrderProductDetail, {
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
                        uxmal.alert(data.ok, 'success');
                    } else if (data.fail) {
                        uxmal.alert(data.fail, 'danger');
                        uxmal.Cards.setLoading('productCard', false);
                    } else if (data.warning) {
                        uxmal.alert(data.warning, 'warning');
                        uxmal.Cards.setLoading('productCard', false);
                    }
                })
                .catch((error) => {
                    uxmal.alert(error.message, 'danger');
                    uxmal.Cards.setLoading('productCard', false);
                });
        }
    });

    /**
     * Enable Buton to select DeliveryDate to open FlatPickr
     */
    uxmal.Buttons.get('orderDeliveryDateButtonId').element.onclick = () => {
        uxmal.Inputs.get('deliveryDateId').flatpickrEl.open();
    };

    /**
     * Validate Order Button
     */
    uxmal.Buttons.get('validateOrderButtonId').element.onclick = () => {
        console.log('validateOrderButtonId clicked!');
    }
});
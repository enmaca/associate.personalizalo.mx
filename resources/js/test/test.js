import {
    UxmalSelect,
    UxmalInput,
    UxmalForm,
} from "../../../public/enmaca/laravel-uxmal/js/uxmal.js";

const uxmalInput = new UxmalInput();
const uxmalSelect = new UxmalSelect();
const uxmalForm = new UxmalForm();

document.addEventListener("DOMContentLoaded", function () {
    uxmalInput.init();
    uxmalSelect.init();
    uxmalForm.init();

    uxmalSelect.get('mexDistrictId').tomselect2.controlInput = null;

    const recipientDataDivEl = document.querySelector('[data-workshop-recipient-data]');

    //uxmalSelect.get('mexMunicipalitiesId').tomselect2.lock();
    //uxmalSelect.get('mexStateId').tomselect2.lock();

    uxmalInput.on('zipCodeId', 'change', (event) => {
        const mexDistrictIdEl = uxmalSelect.get('mexDistrictId').tomselect2;
        mexDistrictIdEl.clear(true);
        mexDistrictIdEl.clearOptions();
        mexDistrictIdEl.load('zipcode::' + event.target.value);
        mexDistrictIdEl.on('load', function () {
            const keys = Object.keys(this.options);
            this.setValue(keys.length === 2 ? keys[1] : '');
        });

        const mexMunicipalitiesIdEl = uxmalSelect.get('mexMunicipalitiesId').tomselect2;
        mexMunicipalitiesIdEl.clear(true);
        mexMunicipalitiesIdEl.clearOptions();
        mexMunicipalitiesIdEl.load('zipcode::' + event.target.value);
        mexMunicipalitiesIdEl.on('load', function () {
            const keys = Object.keys(this.options);
            this.setValue(keys.length === 2 ? keys[1] : '');
        });

        const mexStateIdEl = uxmalSelect.get('mexStateId').tomselect2;
        mexStateIdEl.clear(true);
        mexStateIdEl.clearOptions();
        mexStateIdEl.load('zipcode::' + event.target.value);
        mexStateIdEl.on('load', function () {
            const keys = Object.keys(this.options);
            this.setValue(keys.length === 2 ? keys[1] : '');
        });
    });


    /**
     * Initial State Dom
     */
    uxmalForm.on('deliveryData', 'change', function(event){
       console.log(event.target);
    });
});


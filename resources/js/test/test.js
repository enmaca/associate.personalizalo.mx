import {
    UxmalSelect,
    UxmalInput,
} from "../../../public/enmaca/laravel-uxmal/js/uxmal.js";

const uxmalInput = new UxmalInput();
const uxmalSelect = new UxmalSelect();
document.addEventListener("DOMContentLoaded", function () {
    uxmalInput.init();
    uxmalSelect.init();
    uxmalSelect.get('mexDistrictId').tomselect2.controlInput = null;
    //uxmalSelect.get('mexMunicipalitiesId').tomselect2.lock();
    //uxmalSelect.get('mexStateId').tomselect2.lock();

    uxmalInput.on('recipientDataSameAsCustomerId', 'change', (event) => {
        console.log(event.target.checked);
    });

    uxmalInput.on('zipCodeId', 'change', (event) => {
        console.log(event.target);
        const mexDistrictIdEl = uxmalSelect.get('mexDistrictId').tomselect2;
        mexDistrictIdEl.clear(true);
        mexDistrictIdEl.clearOptions();
        mexDistrictIdEl.load('zipcode::' + event.target.value);

        const mexMunicipalitiesIdEl = uxmalSelect.get('mexMunicipalitiesId').tomselect2;
        mexMunicipalitiesIdEl.clear(true);
        mexMunicipalitiesIdEl.clearOptions();
        mexMunicipalitiesIdEl.load('zipcode::' + event.target.value);

        const mexStateIdEl = uxmalSelect.get('mexStateId').tomselect2;
        mexStateIdEl.clear(true);
        mexStateIdEl.clearOptions();
        mexStateIdEl.load('zipcode::' + event.target.value);

    });
});


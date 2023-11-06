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

    const recipientDataDivEl = document.querySelector('[data-workshop-recipient-data]');

    const updRecipientDataState = () => {
        const userDataSelectors = ['recipientNameId', 'recipientLastNameId', 'recipientMobileId' ];
        if( uxmalInput.get('recipientDataSameAsCustomerId').element.checked ){
            recipientDataDivEl.classList.remove('d-none');
            uxmalInput.for(userDataSelectors, (item) => {
                item.setAttribute('required', '');
            });
        } else {
            recipientDataDivEl.classList.add('d-none');
            uxmalInput.for(userDataSelectors, (item) => {
                item.removeAttribute('required');
            });
        }
    };
    //uxmalSelect.get('mexMunicipalitiesId').tomselect2.lock();
    //uxmalSelect.get('mexStateId').tomselect2.lock();

    uxmalInput.on('recipientDataSameAsCustomerId', 'change', (event) => {
        updRecipientDataState();
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


    /**
     * Initial State Dom
     */
    updRecipientDataState();

});


import List from "list.js"
import {toInteger} from "lodash";

window.inited_listjs = [];
window.listjsCheckAllElement = [];
window.listjsCheckChildElements = []

window.init_listjs = function () {
    /**
     * Choices Select plugin
     */
    console.log('executing window.init_listjs()');
    let listJSsElements = document.querySelectorAll("[data-listjs]");
    Array.from(listJSsElements).forEach(function (item) {
        window.init_listjs_elem(item);
    });
}

window.init_listjs_elem = function ( element ) {
    init_listjs_checks();
    let listjsData = {};
    let isListJStVal = element.attributes;

    if (isListJStVal["data-listjs-pagination"]) {
        listjsData.page = toInteger(isListJStVal["data-listjs-pagination"].value);
        listjsData.pagination = true;
    }

    if (isListJStVal["data-listjs-value-names"]) {
        listjsData.valueNames = JSON.parse(isListJStVal["data-listjs-value-names"].value.toString());
    }

    console.log('Init ListJS Element with Options: ', listjsData);
    window.inited_listjs[element.id] = new List(element, listjsData);
}

window.init_listjs_checks = function () {
    listjsCheckAllElement = document.getElementById("checkAll");
    if (listjsCheckAllElement) {
        console.log('listjsCheckAllElement', listjsCheckAllElement);
        listjsCheckAllElement.onclick = function () {
            if (listjsCheckAllElement.checked == true) {
                Array.from(listjsCheckChildElements).forEach(function (checkbox) {
                    checkbox.checked = true;
                    checkbox.closest("tr").classList.add("table-active");
                });
            } else {
                Array.from(listjsCheckChildElements).forEach(function (checkbox) {
                    checkbox.checked = false;
                    checkbox.closest("tr").classList.remove("table-active");
                });
            }
        };
    }
    listjsCheckChildElements = document.querySelectorAll('input[type="checkbox"][name^="chk_child"]');
    if( listjsCheckChildElements ){
        console.log('listjsCheckChildElements', listjsCheckChildElements);
        listjsCheckChildElements.forEach(checkbox => {
            checkbox.addEventListener('change', (e) => {
                console.log(`Checkbox ${e.target.name} changed to ${e.target.checked}`);
                if (e.target.checked) {
                    e.target.closest("tr").classList.add("table-active");
                } else {
                    e.target.closest("tr").classList.remove("table-active");
                }
            });
        });
    }
}
import List from "list.js"
import {toInteger} from "lodash";

window.inited_listjs = [];
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

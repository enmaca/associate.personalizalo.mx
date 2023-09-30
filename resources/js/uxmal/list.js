import List from "list.js"

window.inited_listjs = [];
window.init_listjs = function () {
    /**
     * Choices Select plugin
     */
    console.log('executing window.init_listjs()');
    let tomsElements = document.querySelectorAll("[data-listjs]");
    Array.from(tomsElements).forEach(function (item) {
        window.init_listjs_elem(item);
    });
}

window.init_listjs_elem = function ( element ) {
    let listjsData = {};
    let isListJStVal = element.attributes;

    if (isListJStVal["data-listjs-pagination"]) {
        listjsData.page = isListJStVal["data-listjs-pagination"].value.toString();
        listjsData.pagination = true;
    }

    if (isListJStVal["data-listjs-value_names"]) {
        listjsData.valueNames = JSON.parse(isListJStVal["data-listjs-value_names"].value.toString());
        console.log(listjsData.valueNames);
    }


    console.log('Init ListJS Element with Options: ', listjsData);
    window.inited_listjs[element.id] = new List(element, listjsData);
}

import Choices from "choices.js";
window.inited_choices = [];
window.init_choices = function () {
    /**
     * Choices Select plugin
     */
    console.log('executing window.init_choices()');
    let choicesElements = document.querySelectorAll("[data-choices]");
    Array.from(choicesElements).forEach(function (item) {
        window.init_choice_elem(item);
    });
}

window.init_choice_elem = function ( element ) {
    let choiceData = {};
    let isChoicesVal = element.attributes;
    if (isChoicesVal["data-choices-groups"]) {
        choiceData.placeholderValue = "This is a placeholder set in the config";
    }
    if (isChoicesVal["data-choices-search-false"]) {
        choiceData.searchEnabled = false;
    }
    if (isChoicesVal["data-choices-search-true"]) {
        choiceData.searchEnabled = true;
    }
    if (isChoicesVal["data-choices-removeelement"]) {
        choiceData.removeItemButton = true;
    }
    if (isChoicesVal["data-choices-sorting-false"]) {
        choiceData.shouldSort = false;
    }
    if (isChoicesVal["data-choices-sorting-true"]) {
        choiceData.shouldSort = true;
    }
    if (isChoicesVal["data-choices-multiple-remove"]) {
        choiceData.removeItemButton = true;
    }
    if (isChoicesVal["data-choices-limit"]) {
        choiceData.maxItemCount = isChoicesVal["data-choices-limit"].value.toString();
    }
    if (isChoicesVal["data-choices-limit"]) {
        choiceData.maxItemCount = isChoicesVal["data-choices-limit"].value.toString();
    }
    if (isChoicesVal["data-choices-editItem-true"]) {
        choiceData.maxItemCount = true;
    }
    if (isChoicesVal["data-choices-editItem-false"]) {
        choiceData.maxItemCount = false;
    }
    if (isChoicesVal["data-choices-text-unique-true"]) {
        choiceData.duplicateItemsAllowed = false;
    }
    if (isChoicesVal["data-choices-text-disabled-true"]) {
        choiceData.addItems = false;
    }

    choiceData.allowHTML = true;


    console.log('Init Choices Element ' + element.id);
    window.inited_choices[element.id] = isChoicesVal["data-choices-text-disabled-true"] ?  new Choices(element, choiceData).disable() : new Choices(element, choiceData);
}

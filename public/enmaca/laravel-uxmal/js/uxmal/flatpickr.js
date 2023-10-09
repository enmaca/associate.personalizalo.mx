/**
 * flatpickr
 */
let flatpickr_items = document.querySelectorAll("[data-provider=flatpickr]");
Array.from(flatpickr_items).forEach(function (item) {
        let dateData = {};
        let isFlatpickerVal = item.attributes;
        if (isFlatpickerVal["data-date-format"])
            dateData.dateFormat = isFlatpickerVal["data-date-format"].value.toString();
        if (isFlatpickerVal["data-enable-time"]) {
            dateData.enableTime = true;
            dateData.dateFormat = isFlatpickerVal["data-date-format"].value.toString() + " H:i";
        }
        if (isFlatpickerVal["data-altFormat"]) {
            dateData.altInput = true;
            dateData.altFormat = isFlatpickerVal["data-altFormat"].value.toString();
        }
        if (isFlatpickerVal["data-minDate"]) {
            dateData.minDate = isFlatpickerVal["data-minDate"].value.toString();
            dateData.dateFormat = isFlatpickerVal["data-date-format"].value.toString();
        }
        if (isFlatpickerVal["data-maxDate"]) {
            dateData.maxDate = isFlatpickerVal["data-maxDate"].value.toString();
            dateData.dateFormat = isFlatpickerVal["data-date-format"].value.toString();
        }
        if (isFlatpickerVal["data-deafult-date"]) {
            dateData.defaultDate = isFlatpickerVal["data-deafult-date"].value.toString();
            dateData.dateFormat = isFlatpickerVal["data-date-format"].value.toString();
        }
        if (isFlatpickerVal["data-multiple-date"]) {
            dateData.mode = "multiple";
            dateData.dateFormat = isFlatpickerVal["data-date-format"].value.toString();
        }
        if (isFlatpickerVal["data-range-date"]) {
            dateData.mode = "range";
            dateData.dateFormat = isFlatpickerVal["data-date-format"].value.toString();
        }
        if (isFlatpickerVal["data-inline-date"]) {
            dateData.inline = true;
            dateData.defaultDate = isFlatpickerVal["data-deafult-date"].value.toString();
            dateData.dateFormat = isFlatpickerVal["data-date-format"].value.toString();
        }
        if (isFlatpickerVal["data-disable-date"]) {
            let dates = [];
            dates.push(isFlatpickerVal["data-disable-date"].value);
            dateData.disable = dates.toString().split(",");
        }
        if (isFlatpickerVal["data-week-number"]) {
            let dates = [];
            dates.push(isFlatpickerVal["data-week-number"].value);
            dateData.weekNumbers = true
        }
        flatpickr(item, dateData);
});
var timeData = {};
var isTimepickerVal = item.attributes;
if (isTimepickerVal["data-time-basic"]) {
    (timeData.enableTime = true),
        (timeData.noCalendar = true),
        (timeData.dateFormat = "H:i");
}
if (isTimepickerVal["data-time-hrs"]) {
    (timeData.enableTime = true),
        (timeData.noCalendar = true),
        (timeData.dateFormat = "H:i"),
        (timeData.time_24hr = true);
}
if (isTimepickerVal["data-min-time"]) {
    (timeData.enableTime = true),
        (timeData.noCalendar = true),
        (timeData.dateFormat = "H:i"),
        (timeData.minTime = isTimepickerVal["data-min-time"].value.toString());
}
if (isTimepickerVal["data-max-time"]) {
    (timeData.enableTime = true),
        (timeData.noCalendar = true),
        (timeData.dateFormat = "H:i"),
        (timeData.minTime = isTimepickerVal["data-max-time"].value.toString());
}
if (isTimepickerVal["data-default-time"]) {
    (timeData.enableTime = true),
        (timeData.noCalendar = true),
        (timeData.dateFormat = "H:i"),
        (timeData.defaultDate = isTimepickerVal["data-default-time"].value.toString());
}
if (isTimepickerVal["data-time-inline"]) {
    (timeData.enableTime = true),
        (timeData.noCalendar = true),
        (timeData.defaultDate = isTimepickerVal["data-time-inline"].value.toString());
    timeData.inline = true;
}
flatpickr(item, timeData);

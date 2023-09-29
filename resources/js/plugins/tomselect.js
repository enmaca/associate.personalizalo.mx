import TomSelect from "tom-select";
window.inited_tomselect = [];
window.init_tomselect = function () {
    /**
     * Choices Select plugin
     */
    console.log('executing window.init_tomselect()');
    let tomsElements = document.querySelectorAll("[data-tomselect]");
    Array.from(tomsElements).forEach(function (item) {
        window.init_tomselect_elem(item);
    });
}

window.init_tomselect_elem = function ( element ) {
    let tomselectData = {};
    let isTomSelectVal = element.attributes;
    if (isTomSelectVal["data-tomselect-create"]) {
        tomselectData.create = true;
    }
    if (isTomSelectVal["data-tomselect-create-url"]) {
        tomselectData.create = function(new_input){
            const url = isTomSelectVal["data-tomselect-create-url"].value.toString();; // Replace with your API endpoint

            // Send a POST request
            fetch(url, {
                method: 'POST', // or 'PUT'
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(new_input) // Converts JavaScript object to JSON string
            }).then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.json(); // Parse the JSON from the response
            }).then(data => {
                console.log('Success:', data);
                return {
                    value:data.id,
                    text:data.name
                }
            }).catch((error) => {
                console.error('There was a problem with the fetch operation:', error);
                return false;
            });
        }
    }

    console.log('Init TomSelect Element with Options: ', tomselectData);
    window.inited_tomselect[element.id] = new TomSelect(element, tomselectData);
}

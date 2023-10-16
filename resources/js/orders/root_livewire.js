Livewire.on('customer-id-find', (event) => {
    /**
     * event.data
     * id : 3
     * email : "enmaca@hotmail.com"
     * name : "Enrique"
     * last_name : "Martinez"
     * mobile : "+528183662523"
     * notify_email : null
     * notify_sms : null
     * notify_whatsapp : null
     * created_at : "2023-09-30T05:28:03.000000Z"
     * updated_at : "2023-09-30T05:28:03.000000Z"
     */
    console.log('[customer-id-find]', event.data);

    enableFields = true;
    if (event.data.id != 'new')
        enableFields = false;
    setValueDE('input[name=customerMobile]', event.data.mobile, enableFields);
    setValueDE('input[name=customerName]', event.data.name, enableFields);
    setValueDE('input[name=customerLastName]', event.data.last_name, enableFields);
    setValueDE('input[name=customerEmail]', event.data.email, enableFields);
});
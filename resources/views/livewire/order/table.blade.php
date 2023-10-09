<div>
</div>
@pushonce('scripts')
    <script>
        function setValueDE(selector, value, enable){
            let inputE = document.querySelector(selector);
            inputE.value = value;
            inputE.disabled = !enable;
        }
        function goToOrder( order_id ){
            window.location.href = '/orders/' + order_id;
        }
        function submitNewOrderFrom(){
            document.getElementById('NewOrderFrom').submit();
        }
    </script>
@endpushonce
@section("javascript")
@pushonce('livewire:initialized')
    @this.on('change-customer-id', (event) => {
        console.log(event.data);
        enableFields = true;
        if (event.data.id != 'new')
            enableFields = false;
            setValueDE('input[name=customerMobile]', event.data.mobile, enableFields);
            setValueDE('input[name=customerName]', event.data.name, enableFields);
            setValueDE('input[name=customerLastName]', event.data.last_name, enableFields);
            setValueDE('input[name=customerEmail]', event.data.email, enableFields);
    });
    if (window.init_listjs) { window.init_listjs(); }
@endpushonce
@stop
@pushonce('scripts')
    @vite('resources/js/uxmal/list.js')
@endpushonce



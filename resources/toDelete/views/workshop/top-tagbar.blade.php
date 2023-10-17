<div class="top-tagbar">
    <div class="w-100">
        <div class="row justify-content-between align-items-center">
            <div class="col-md-auto col-9">
                <div class="text-white-50 fs-13">
                    <i class="bi bi-clock align-middle me-2"></i> <span id="current-time"></span>
                </div>
            </div>
            <div class="col-md-auto col-6 d-none d-lg-block">
                <div class="d-flex align-items-center justify-content-center gap-3 fs-13 text-white-50">
                    <div>
                        <i class="bi bi-envelope align-middle me-2"></i> soporte@personalizalo.mx
                    </div>
                    <div>
                        <i class="bi bi-globe align-middle me-2"></i> personalizalo.mx
                    </div>
                </div>
            </div>
            <div class="col-md-auto col-3"></div>
        </div>
    </div>
</div>
@section('javascript')
    @pushonce('DOMContentLoaded')
        if (document.getElementById("current-time") !== null) {
            setInterval(() => {
                // date
                let d = new Date();
                let dateOptions = {weekday: 'short', month: 'short', day: 'numeric'};
                let date = d.toLocaleDateString(undefined, dateOptions);
                // time
                let hours = d.getHours();
                let ampm = hours >= 12 ? ' PM' : ' AM';
                hours = hours % 12;
                let time = ("0" + hours).slice(-2) + ':' + ("0" + d.getMinutes()).slice(-2) + ampm;
                document.getElementById("current-time").innerHTML = date + " | " + time;
            }, 1000);
        }
    @endpushonce
@stop
<!--start back-to-top-->
<button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
    <i class="ri-arrow-up-line"></i>
</button>
<!--end back-to-top-->
@section('javascript')
@pushonce('DOMContentLoaded')
        let mybutton = document.getElementById("back-to-top");

        if (mybutton !== null) {
            // When the user scrolls down 20px from the top of the document, show the button
            window.onscroll = function () {
                scrollFunction();
            };

            function scrollFunction() {
                if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
                    mybutton.style.display = "block";
                } else {
                    mybutton.style.display = "none";
                }
            }
            window.topFunction = function() {
                document.body.scrollTop = 0;
                document.documentElement.scrollTop = 0;
            }
        }
@endpushonce
@stop
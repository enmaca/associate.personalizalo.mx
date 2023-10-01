Array.from(document.querySelectorAll('.dropdown-menu a[data-bs-toggle="tab"]')).forEach(function (element) {
    element.addEventListener("click", function (e) {
        e.stopPropagation();
        bootstrap.Tab.getInstance(e.target).show();
    });
});
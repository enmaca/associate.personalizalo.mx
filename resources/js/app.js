
import * as bootstrap from "bootstrap";
import SimpleBar from 'simplebar';
import 'simplebar/dist/simplebar.css';

(function () {
    ("use strict");

    /**
     *  global variables
     */
    let horizontalMenuSplit = 6; // after this number all horizontal menus will be moved in More menu options

    // on click collapse menu
    function isCollapseMenu() {
        /**
         * Sidebar menu collapse
         */
        if (document.querySelectorAll(".navbar-nav .collapse")) {
            var collapses = document.querySelectorAll(".navbar-nav .collapse");
            Array.from(collapses).forEach(function (collapse) {
                // Init collapses
                var collapseInstance = new bootstrap.Collapse(collapse, {
                    toggle: false,
                });
                // Hide sibling collapses on `show.bs.collapse`
                collapse.addEventListener("show.bs.collapse", function (e) {
                    e.stopPropagation();
                    var closestCollapse = collapse.parentElement.closest(".collapse");
                    if (closestCollapse) {
                        var siblingCollapses = closestCollapse.querySelectorAll(".collapse");
                        Array.from(siblingCollapses).forEach(function (siblingCollapse) {
                            var siblingCollapseInstance = bootstrap.Collapse.getInstance(siblingCollapse);
                            if (siblingCollapseInstance === collapseInstance) {
                                return;
                            }
                            siblingCollapseInstance.hide();
                        });
                    } else {
                        var getSiblings = function (elem) {
                            // Setup siblings array and get the first sibling
                            var siblings = [];
                            var sibling = elem.parentNode.firstChild;
                            // Loop through each sibling and push to the array
                            while (sibling) {
                                if (sibling.nodeType === 1 && sibling !== elem) {
                                    siblings.push(sibling);
                                }
                                sibling = sibling.nextSibling;
                            }
                            return siblings;
                        };
                        var siblings = getSiblings(collapse.parentElement);
                        Array.from(siblings).forEach(function (item) {
                            if (item.childNodes.length > 2)
                                item.firstElementChild.setAttribute("aria-expanded", "false");
                            var ids = item.querySelectorAll("*[id]");
                            Array.from(ids).forEach(function (item1) {
                                item1.classList.remove("show");
                                if (item1.childNodes.length > 2) {
                                    var val = item1.querySelectorAll("ul li a");
                                    Array.from(val).forEach(function (subitem) {
                                        if (subitem.hasAttribute("aria-expanded"))
                                            subitem.setAttribute("aria-expanded", "false");
                                    });
                                }
                            });
                        });
                    }
                });

                // Hide nested collapses on `hide.bs.collapse`
                collapse.addEventListener("hide.bs.collapse", function (e) {
                    e.stopPropagation();
                    let childCollapses = collapse.querySelectorAll(".collapse");
                    Array.from(childCollapses).forEach(function (childCollapse) {
                        let childCollapseInstance = bootstrap.Collapse.getInstance(childCollapse);
                        childCollapseInstance.hide();
                    });
                });
            });
        }
    }

    /**
     * Generate two column menu
     */
    function twoColumnMenuGenerate() {
        let isTwoColumn = document.documentElement.getAttribute("data-layout");
        let isValues = sessionStorage.getItem("defaultAttribute");
        let defaultValues = JSON.parse(isValues);

        if (defaultValues && (isTwoColumn == "twocolumn" || defaultValues["data-layout"] == "twocolumn")) {
            if (document.querySelector(".navbar-menu")) {
                document.querySelector(".navbar-menu").innerHTML = navbarMenuHTML;
            }
            let ul = document.createElement("ul");
            ul.innerHTML = '<a href="index.html" class="logo"><img src="build/images/logo-sm.png" alt="" height="22"></a>';
            Array.from(document.getElementById("navbar-nav").querySelectorAll(".menu-link")).forEach(function (item) {
                ul.className = "twocolumn-iconview";
                let li = document.createElement("li");
                let a = item;
                a.querySelectorAll("span").forEach(function (element) {
                    element.classList.add("d-none");
                });

                if (item.parentElement.classList.contains("twocolumn-item-show")) {
                    item.classList.add("active");
                }
                li.appendChild(a);
                ul.appendChild(li);

                a.classList.contains("nav-link") ? a.classList.replace("nav-link", "nav-icon") : "";
                a.classList.remove("collapsed", "menu-link");
            });
            let currentPath = location.pathname == "/" ? "index.html" : location.pathname.substring(1);
            currentPath = currentPath.substring(currentPath.lastIndexOf("/") + 1);
            if (currentPath) {
                // navbar-nav
                let a = document.getElementById("navbar-nav").querySelector('[href="' + currentPath + '"]');

                if (a) {
                    let parentCollapseDiv = a.closest(".collapse.menu-dropdown");
                    if (parentCollapseDiv) {
                        parentCollapseDiv.classList.add("show");
                        parentCollapseDiv.parentElement.children[0].classList.add("active");
                        parentCollapseDiv.parentElement.children[0].setAttribute("aria-expanded", "true");
                        if (parentCollapseDiv.parentElement.closest(".collapse.menu-dropdown")) {
                            parentCollapseDiv.parentElement.closest(".collapse").classList.add("show");
                            if (parentCollapseDiv.parentElement.closest(".collapse").previousElementSibling)
                                parentCollapseDiv.parentElement.closest(".collapse").previousElementSibling.classList.add("active");
                            if (parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.closest(".collapse.menu-dropdown")) {
                                parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.closest(".collapse").classList.add("show");
                                if (parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.closest(".collapse").previousElementSibling) {
                                    parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.closest(".collapse").previousElementSibling.classList.add("active");
                                }
                            }
                        }
                    }
                }
            }
            // add all sidebar menu icons
            document.getElementById("two-column-menu").innerHTML = ul.outerHTML;

            // show submenu on sidebar menu click
            Array.from(document.querySelector("#two-column-menu ul").querySelectorAll("li a")).forEach(function (element) {
                let currentPath = location.pathname == "/" ? "index.html" : location.pathname.substring(1);
                currentPath = currentPath.substring(currentPath.lastIndexOf("/") + 1);
                element.addEventListener("click", function (e) {
                    if (!(currentPath == "/" + element.getAttribute("href") && !element.getAttribute("data-bs-toggle")))
                        document.body.classList.contains("twocolumn-panel") ? document.body.classList.remove("twocolumn-panel") : "";
                    document.getElementById("navbar-nav").classList.remove("twocolumn-nav-hide");
                    document.querySelector(".hamburger-icon").classList.remove("open");
                    if ((e.target && e.target.matches("a.nav-icon")) || (e.target && e.target.matches("i"))) {
                        if (document.querySelector("#two-column-menu ul .nav-icon.active") !== null)
                            document.querySelector("#two-column-menu ul .nav-icon.active").classList.remove("active");
                        e.target.matches("i") ? e.target.closest("a").classList.add("active") : e.target.classList.add("active");

                        let twoColumnItem = document.getElementsByClassName("twocolumn-item-show");

                        twoColumnItem.length > 0 ? twoColumnItem[0].classList.remove("twocolumn-item-show") : "";

                        let currentMenu = e.target.matches("i") ? e.target.closest("a") : e.target;
                        let childMenusId = currentMenu.getAttribute("href").slice(1);
                        if (document.getElementById(childMenusId))
                            document.getElementById(childMenusId).parentElement.classList.add("twocolumn-item-show");
                    }
                });

                // add active class to the sidebar menu icon who has direct link
                if (currentPath == "/" + element.getAttribute("href") && !element.getAttribute("data-bs-toggle")) {
                    element.classList.add("active");
                    document.getElementById("navbar-nav").classList.add("twocolumn-nav-hide");
                    if (document.querySelector(".hamburger-icon")) {
                        document.querySelector(".hamburger-icon").classList.add("open");
                    }
                }
            });

            let currentLayout = document.documentElement.getAttribute("data-layout");
            if (currentLayout !== "horizontal") {
                let simpleBar = new SimpleBar(document.getElementById("navbar-nav"));
                if (simpleBar) simpleBar.getContentElement();

                let simpleBar1 = new SimpleBar(
                    document.getElementsByClassName("twocolumn-iconview")[0]
                );
                if (simpleBar1) simpleBar1.getContentElement();
            }
        }
    }

    //  Search menu dropdown on Topbar
    function isCustomDropdown() {
        //Search bar
        let searchOptions = document.getElementById("search-close-options");
        let dropdown = document.getElementById("search-dropdown");
        let searchInput = document.getElementById("search-options");
        if (searchInput) {
            searchInput.addEventListener("focus", function () {
                let inputLength = searchInput.value.length;
                if (inputLength > 0) {
                    dropdown.classList.add("show");
                    searchOptions.classList.remove("d-none");
                } else {
                    dropdown.classList.remove("show");
                    searchOptions.classList.add("d-none");
                }
            });

            searchInput.addEventListener("keyup", function (event) {
                let inputLength = searchInput.value.length;
                if (inputLength > 0) {
                    dropdown.classList.add("show");
                    searchOptions.classList.remove("d-none");

                    let inputVal = searchInput.value.toLowerCase();
                    let notifyItem = document.getElementsByClassName("notify-item");

                    Array.from(notifyItem).forEach(function (element) {
                        let notifiTxt = ''
                        if (element.querySelector("h6")) {
                            let spantext = element.getElementsByTagName("span")[0].innerText.toLowerCase()
                            let name = element.querySelector("h6").innerText.toLowerCase()
                            if (name.includes(inputVal)) {
                                notifiTxt = name
                            } else {
                                notifiTxt = spantext
                            }
                        } else if (element.getElementsByTagName("span")) {
                            notifiTxt = element.getElementsByTagName("span")[0].innerText.toLowerCase()
                        }

                        if (notifiTxt) {
                            if (notifiTxt.includes(inputVal)) {
                                element.classList.add("d-block");
                                element.classList.remove("d-none");
                            } else {
                                element.classList.remove("d-block");
                                element.classList.add("d-none");
                            }
                        }

                        Array.from(document.getElementsByClassName("notification-group-list")).forEach(function (element) {
                            if (element.querySelectorAll(".notify-item.d-block").length == 0) {
                                element.querySelector(".notification-title").style.display = 'none'
                            } else {
                                element.querySelector(".notification-title").style.display = 'block'
                            }
                        });
                    });
                } else {
                    dropdown.classList.remove("show");
                    searchOptions.classList.add("d-none");
                }
            });

            searchOptions.addEventListener("click", function () {
                searchInput.value = "";
                dropdown.classList.remove("show");
                searchOptions.classList.add("d-none");
            });

            document.body.addEventListener("click", function (e) {
                if (e.target.getAttribute("id") !== "search-options") {
                    dropdown.classList.remove("show");
                    searchOptions.classList.add("d-none");
                }
            });
        }
    }

    //  search menu dropdown on topbar
    function isCustomDropdownResponsive() {
        //Search bar
        let searchOptions = document.getElementById("search-close-options");
        let dropdownReponsive = document.getElementById("search-dropdown-reponsive");
        let searchInputReponsive = document.getElementById("search-options-reponsive");

        if (searchOptions && dropdownReponsive && searchInputReponsive) {
            searchInputReponsive.addEventListener("focus", function () {
                let inputLength = searchInputReponsive.value.length;
                if (inputLength > 0) {
                    dropdownReponsive.classList.add("show");
                    searchOptions.classList.remove("d-none");
                } else {
                    dropdownReponsive.classList.remove("show");
                    searchOptions.classList.add("d-none");
                }
            });

            searchInputReponsive.addEventListener("keyup", function () {
                let inputLength = searchInputReponsive.value.length;
                if (inputLength > 0) {
                    dropdownReponsive.classList.add("show");
                    searchOptions.classList.remove("d-none");
                } else {
                    dropdownReponsive.classList.remove("show");
                    searchOptions.classList.add("d-none");
                }
            });

            searchOptions.addEventListener("click", function () {
                searchInputReponsive.value = "";
                dropdownReponsive.classList.remove("show");
                searchOptions.classList.add("d-none");
            });

            document.body.addEventListener("click", function (e) {
                if (e.target.getAttribute("id") !== "search-options") {
                    dropdownReponsive.classList.remove("show");
                    searchOptions.classList.add("d-none");
                }
            });
        }
    }

    function elementInViewport(el) {
        if (el) {
            let top = el.offsetTop;
            let left = el.offsetLeft;
            let width = el.offsetWidth;
            let height = el.offsetHeight;

            if (el.offsetParent) {
                while (el.offsetParent) {
                    el = el.offsetParent;
                    top += el.offsetTop;
                    left += el.offsetLeft;
                }
            }
            return (
                top >= window.pageYOffset &&
                left >= window.pageXOffset &&
                top + height <= window.pageYOffset + window.innerHeight &&
                left + width <= window.pageXOffset + window.innerWidth
            );
        }
    }

    function initLeftMenuCollapse() {
        /**
         * Vertical layout menu scroll add
         */
        if (document.documentElement.getAttribute("data-layout") == "vertical") {
            document.getElementById("two-column-menu").innerHTML = "";
            if (document.querySelector(".navbar-menu")) {
                document.querySelector(".navbar-menu").innerHTML = navbarMenuHTML;
            }
            document.getElementById("scrollbar").setAttribute("data-simplebar", "");
            document.getElementById("navbar-nav").setAttribute("data-simplebar", "");
            document.getElementById("scrollbar").classList.add("h-100");
        }

        /**
         * Two-column layout menu scroll add
         */
        if (document.documentElement.getAttribute("data-layout") == "twocolumn") {
            document.getElementById("scrollbar").removeAttribute("data-simplebar");
            document.getElementById("scrollbar").classList.remove("h-100");
        }

        /**
         * Horizontal layout menu
         */
        if (document.documentElement.getAttribute("data-layout") == "horizontal") {
            updateHorizontalMenus();
        }
    }

    function isLoadBodyElement() {
        let verticalOverlay = document.getElementsByClassName("vertical-overlay");
        if (verticalOverlay) {
            Array.from(verticalOverlay).forEach(function (element) {
                element.addEventListener("click", function () {
                    document.body.classList.remove("vertical-sidebar-enable");
                    if (sessionStorage.getItem("data-layout") == "twocolumn")
                        document.body.classList.add("twocolumn-panel");
                    else
                        document.documentElement.setAttribute("data-sidebar-size", sessionStorage.getItem("data-sidebar-size"));
                });
            });
        }
    }

    function windowResizeHover() {
        let windowSize = document.documentElement.clientWidth;
        if (windowSize < 1025 && windowSize > 767) {
            document.body.classList.remove("twocolumn-panel");
            if (sessionStorage.getItem("data-layout") == "twocolumn") {
                document.documentElement.setAttribute("data-layout", "twocolumn");
                if (document.getElementById("customizer-layout03")) {
                    document.getElementById("customizer-layout03").click();
                }
                twoColumnMenuGenerate();
                initTwoColumnActiveMenu();
                isCollapseMenu();
            }
            if (sessionStorage.getItem("data-layout") == "vertical") {
                document.documentElement.setAttribute("data-sidebar-size", "sm");
            }
            if (document.querySelector(".hamburger-icon")) {
                document.querySelector(".hamburger-icon").classList.add("open");
            }
        } else if (windowSize >= 1025) {
            document.body.classList.remove("twocolumn-panel");
            if (sessionStorage.getItem("data-layout") == "twocolumn") {
                document.documentElement.setAttribute("data-layout", "twocolumn");
                if (document.getElementById("customizer-layout03")) {
                    document.getElementById("customizer-layout03").click();
                }
                twoColumnMenuGenerate();
                initTwoColumnActiveMenu();
                isCollapseMenu();
            }
            if (sessionStorage.getItem("data-layout") == "vertical") {
                document.documentElement.setAttribute(
                    "data-sidebar-size",
                    sessionStorage.getItem("data-sidebar-size")
                );
            }
            if (document.querySelector(".hamburger-icon")) {
                document.querySelector(".hamburger-icon").classList.remove("open");
            }
        } else if (windowSize <= 767) {
            document.body.classList.remove("vertical-sidebar-enable");
            document.body.classList.add("twocolumn-panel");
            if (sessionStorage.getItem("data-layout") == "twocolumn") {
                document.documentElement.setAttribute("data-layout", "vertical");
                hideShowLayoutOptions("vertical");
                isCollapseMenu();
            }
            if (sessionStorage.getItem("data-layout") != "horizontal") {
                document.documentElement.setAttribute("data-sidebar-size", "lg");
            }
            if (document.querySelector(".hamburger-icon")) {
                document.querySelector(".hamburger-icon").classList.add("open");
            }
        }

        let isElement = document.querySelectorAll("#navbar-nav > li.nav-item");
        Array.from(isElement).forEach(function (item) {
            item.addEventListener("click", menuItem.bind(this), false);
            item.addEventListener("mouseover", menuItem.bind(this), false);
        });
    }

    function menuItem(e) {
        if (e.target && e.target.matches("a.nav-link span")) {
            if (elementInViewport(e.target.parentElement.nextElementSibling) == false) {
                e.target.parentElement.nextElementSibling.classList.add("dropdown-custom-right");
                e.target.parentElement.parentElement.parentElement.parentElement.classList.add("dropdown-custom-right");
                let eleChild = e.target.parentElement.nextElementSibling;
                Array.from(eleChild.querySelectorAll(".menu-dropdown")).forEach(function (item) {
                    item.classList.add("dropdown-custom-right");
                });
            } else if (elementInViewport(e.target.parentElement.nextElementSibling) == true) {
                if (window.innerWidth >= 1848) {
                    let elements = document.getElementsByClassName("dropdown-custom-right");
                    while (elements.length > 0) {
                        elements[0].classList.remove("dropdown-custom-right");
                    }
                }
            }
        }

        if (e.target && e.target.matches("a.nav-link")) {
            if (elementInViewport(e.target.nextElementSibling) == false) {
                e.target.nextElementSibling.classList.add("dropdown-custom-right");
                e.target.parentElement.parentElement.parentElement.classList.add("dropdown-custom-right");
                let eleChild = e.target.nextElementSibling;
                Array.from(eleChild.querySelectorAll(".menu-dropdown")).forEach(function (item) {
                    item.classList.add("dropdown-custom-right");
                });
            } else if (elementInViewport(e.target.nextElementSibling) == true) {
                if (window.innerWidth >= 1848) {
                    let elements = document.getElementsByClassName("dropdown-custom-right");
                    while (elements.length > 0) {
                        elements[0].classList.remove("dropdown-custom-right");
                    }
                }
            }
        }
    }

    function toggleHamburgerMenu() {
        let windowSize = document.documentElement.clientWidth;

        if (windowSize > 767)
            document.querySelector(".hamburger-icon").classList.toggle("open");

        //For collapse horizontal menu
        if (document.documentElement.getAttribute("data-layout") === "horizontal") {
            document.body.classList.contains("menu") ? document.body.classList.remove("menu") : document.body.classList.add("menu");
        }

        //For collapse vertical menu
        if (document.documentElement.getAttribute("data-layout") === "vertical") {
            if (windowSize < 1025 && windowSize > 767) {
                document.body.classList.remove("vertical-sidebar-enable");
                document.documentElement.getAttribute("data-sidebar-size") == "sm" ?
                    document.documentElement.setAttribute("data-sidebar-size", "") :
                    document.documentElement.setAttribute("data-sidebar-size", "sm");
            } else if (windowSize > 1025) {
                document.body.classList.remove("vertical-sidebar-enable");
                document.documentElement.getAttribute("data-sidebar-size") == "lg" ?
                    document.documentElement.setAttribute("data-sidebar-size", "sm") :
                    document.documentElement.setAttribute("data-sidebar-size", "lg");
            } else if (windowSize <= 767) {
                document.body.classList.add("vertical-sidebar-enable");
                document.documentElement.setAttribute("data-sidebar-size", "lg");
            }
        }

        //Two column menu
        if (document.documentElement.getAttribute("data-layout") == "twocolumn") {
            document.body.classList.contains("twocolumn-panel") ?
                document.body.classList.remove("twocolumn-panel") :
                document.body.classList.add("twocolumn-panel");
        }
    }

    function windowLoadContent() {
        window.addEventListener("resize", windowResizeHover);
        windowResizeHover();

        document.addEventListener("scroll", function () {
            windowScroll();
        });

        window.addEventListener("load", function () {
            let isTwoColumn = document.documentElement.getAttribute("data-layout");
            if (isTwoColumn == "twocolumn") {
                initTwoColumnActiveMenu();
            } else {
                initActiveMenu();
            }
            isLoadBodyElement();
            addEventListenerOnSmHoverMenu();
        });
        if (document.getElementById("topnav-hamburger-icon")) {
            document.getElementById("topnav-hamburger-icon").addEventListener("click", toggleHamburgerMenu);
        }
        let isValues = sessionStorage.getItem("defaultAttribute");
        let defaultValues = JSON.parse(isValues);
        let windowSize = document.documentElement.clientWidth;

        if (defaultValues["data-layout"] == "twocolumn" && windowSize < 767) {
            Array.from(document.getElementById("two-column-menu").querySelectorAll("li")).forEach(function (item) {
                item.addEventListener("click", function (e) {
                    document.body.classList.remove("twocolumn-panel");
                });
            });
        }
    }

    // page topbar class added
    function windowScroll() {
        let pageTopbar = document.getElementById("page-topbar");
        if (pageTopbar) {
            document.body.scrollTop >= 50 || document.documentElement.scrollTop >= 50 ? pageTopbar.classList.add("topbar-shadow") : pageTopbar.classList.remove("topbar-shadow");
        }
    }

    // Two-column menu activation
    function initTwoColumnActiveMenu() {
        // two column sidebar active js
        let currentPath = location.pathname == "/" ? "index.html" : location.pathname.substring(1);
        currentPath = currentPath.substring(currentPath.lastIndexOf("/") + 1);
        if (currentPath) {
            if (document.body.className == "twocolumn-panel") {
                document.getElementById("two-column-menu").querySelector('.nav-icon[href="' + currentPath + '"]').classList.add("active");
            }
            // navbar-nav
            let a = document.getElementById("navbar-nav").querySelector('[href="' + currentPath + '"]');
            if (a) {
                a.classList.add("active");
                let parentCollapseDiv = a.closest(".collapse.menu-dropdown");
                if (parentCollapseDiv && parentCollapseDiv.parentElement.closest(".collapse.menu-dropdown")) {
                    parentCollapseDiv.classList.add("show");
                    parentCollapseDiv.parentElement.children[0].classList.add("active");
                    parentCollapseDiv.parentElement.closest(".collapse.menu-dropdown").parentElement.classList.add("twocolumn-item-show");
                    if (parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.closest(".collapse.menu-dropdown")) {
                        let menuIdSub = parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.closest(".collapse.menu-dropdown").getAttribute("id");
                        parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.closest(".collapse.menu-dropdown").parentElement.classList.add("twocolumn-item-show");
                        parentCollapseDiv.parentElement.closest(".collapse.menu-dropdown").parentElement.classList.remove("twocolumn-item-show");
                        if (document.getElementById("two-column-menu").querySelector('[href="#' + menuIdSub + '"]'))
                            document.getElementById("two-column-menu").querySelector('[href="#' + menuIdSub + '"]').classList.add("active");
                    }
                    let menuId = parentCollapseDiv.parentElement.closest(".collapse.menu-dropdown").getAttribute("id");
                    if (document.getElementById("two-column-menu").querySelector('[href="#' + menuId + '"]'))
                        document.getElementById("two-column-menu").querySelector('[href="#' + menuId + '"]').classList.add("active");
                } else {
                    a.closest(".collapse.menu-dropdown").parentElement.classList.add("twocolumn-item-show");
                    let menuId = parentCollapseDiv.getAttribute("id");
                    if (document.getElementById("two-column-menu").querySelector('[href="#' + menuId + '"]'))
                        document.getElementById("two-column-menu").querySelector('[href="#' + menuId + '"]').classList.add("active");
                }
            } else {
                document.body.classList.add("twocolumn-panel");
            }
        }
    }

    // two-column sidebar active js
    function initActiveMenu() {
        let currentPath = location.pathname == "/" ? "index.html" : location.pathname.substring(1);
        currentPath = currentPath.substring(currentPath.lastIndexOf("/") + 1);
        if (currentPath) {
            // navbar-nav
            let a = document.getElementById("navbar-nav").querySelector('[href="' + currentPath + '"]');
            if (a) {
                a.classList.add("active");
                let parentCollapseDiv = a.closest(".collapse.menu-dropdown");
                if (parentCollapseDiv) {
                    parentCollapseDiv.classList.add("show");
                    parentCollapseDiv.parentElement.children[0].classList.add("active");
                    parentCollapseDiv.parentElement.children[0].setAttribute("aria-expanded", "true");
                    if (parentCollapseDiv.parentElement.closest(".collapse.menu-dropdown")) {
                        parentCollapseDiv.parentElement.closest(".collapse").classList.add("show");
                        if (parentCollapseDiv.parentElement.closest(".collapse").previousElementSibling)
                            parentCollapseDiv.parentElement.closest(".collapse").previousElementSibling.classList.add("active");

                        if (parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.closest(".collapse.menu-dropdown")) {
                            parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.closest(".collapse").classList.add("show");
                            if (parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.closest(".collapse").previousElementSibling) {

                                parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.closest(".collapse").previousElementSibling.classList.add("active");
                                if ((document.documentElement.getAttribute("data-layout") == "horizontal") && parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.closest(".collapse")) {
                                    parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.closest(".collapse").previousElementSibling.classList.add("active")
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    function elementInViewport(el) {
        if (el) {
            let top = el.offsetTop;
            let left = el.offsetLeft;
            let width = el.offsetWidth;
            let height = el.offsetHeight;

            if (el.offsetParent) {
                while (el.offsetParent) {
                    el = el.offsetParent;
                    top += el.offsetTop;
                    left += el.offsetLeft;
                }
            }
            return (
                top >= window.pageYOffset &&
                left >= window.pageXOffset &&
                top + height <= window.pageYOffset + window.innerHeight &&
                left + width <= window.pageXOffset + window.innerWidth
            );
        }
    }

    // notification cart dropdown
    function initTopbarComponents() {
        if (document.getElementsByClassName("dropdown-item-cart")) {
            let dropdownItemCart = document.querySelectorAll(".dropdown-item-cart").length;
            Array.from(document.querySelectorAll("#page-topbar .dropdown-menu-cart .remove-item-btn")).forEach(function (item) {
                item.addEventListener("click", function (e) {
                    dropdownItemCart--;
                    this.closest(".dropdown-item-cart").remove();
                    Array.from(document.getElementsByClassName("cartitem-badge")).forEach(function (e) {
                        e.innerHTML = dropdownItemCart;
                    });
                    updateCartPrice();
                    if (document.getElementById("empty-cart")) {
                        document.getElementById("empty-cart").style.display = dropdownItemCart == 0 ? "block" : "none";
                    }
                    if (document.getElementById("checkout-elem")) {
                        document.getElementById("checkout-elem").style.display = dropdownItemCart == 0 ? "none" : "block";
                    }
                });
            });
            Array.from(document.getElementsByClassName("cartitem-badge")).forEach(function (e) {
                e.innerHTML = dropdownItemCart;
            });
            if (document.getElementById("empty-cart")) {
                document.getElementById("empty-cart").style.display = "none";
            }
            if (document.getElementById("checkout-elem")) {
                document.getElementById("checkout-elem").style.display = "block";
            }

            function updateCartPrice() {
                let currencySign = "$";
                let subtotal = 0;
                Array.from(document.getElementsByClassName("cart-item-price")).forEach(function (e) {
                    subtotal += parseFloat(e.innerHTML);
                });
                if (document.getElementById("cart-item-total")) {
                    document.getElementById("cart-item-total").innerHTML = currencySign + subtotal.toFixed(2);
                }
            }

            updateCartPrice();
        }

        // notification messages
        if (document.getElementsByClassName("notification-check")) {
            function emptyNotification() {
                if (document.querySelectorAll(".notification-item").length > 0) {
                    document.querySelectorAll(".notification-title").forEach(function (item) {
                        item.style.display = "block";
                    });
                } else {
                    document.querySelectorAll(".notification-title").forEach(function (item) {
                        item.style.display = "none";
                    });

                    let emptyNotificationElem = document.querySelector("#notificationItemsTabContent .empty-notification-elem")
                    if (!emptyNotificationElem) {
                        document.getElementById("notificationItemsTabContent").innerHTML += '<div class="empty-notification-elem text-center px-4">\
						<div class="mt-3 avatar-md mx-auto">\
							<div class="avatar-title bg-info-subtle text-info fs-24 rounded-circle">\
							<i class="bi bi-bell "></i>\
							</div>\
						</div>\
						<div class="pb-3 mt-2">\
							<h6 class="fs-16 fw-semibold lh-base">Hey! You have no any notifications </h6>\
						</div>\
					</div>'
                    }
                }
            }

            emptyNotification();
            Array.from(document.querySelectorAll(".notification-check input")).forEach(function (element) {
                element.addEventListener("change", function (el) {
                    el.target.closest(".notification-item").classList.toggle("active");

                    let checkedCount = document.querySelectorAll('.notification-check input:checked').length;

                    if (el.target.closest(".notification-item").classList.contains("active")) {
                        (checkedCount > 0) ? document.getElementById("notification-actions").style.display = 'block' : document.getElementById("notification-actions").style.display = 'none';
                    } else {
                        (checkedCount > 0) ? document.getElementById("notification-actions").style.display = 'block' : document.getElementById("notification-actions").style.display = 'none';
                    }
                    document.getElementById("select-content").innerHTML = checkedCount
                });

                let notificationDropdown = document.getElementById('notificationDropdown')
                if (notificationDropdown) {
                    notificationDropdown.addEventListener('hide.bs.dropdown', function (event) {
                        element.checked = false;
                        document.querySelectorAll('.notification-item').forEach(function (item) {
                            item.classList.remove("active");
                        })
                        emptyNotification();
                        document.getElementById('notification-actions').style.display = '';
                    });
                }

            });


            let removeItem = document.getElementById('removeNotificationModal');
            if (removeItem) {
                removeItem.addEventListener('show.bs.modal', function (event) {
                    document.getElementById("delete-notification").addEventListener("click", function () {
                        Array.from(document.querySelectorAll(".notification-item")).forEach(function (element) {
                            if (element.classList.contains("active")) {
                                element.remove();
                            }
                            Array.from(document.querySelectorAll(".notification-badge")).forEach(function (item) {
                                item.innerHTML = document.querySelectorAll('.notification-check input').length;
                            })
                            Array.from(document.querySelectorAll(".notification-unread")).forEach(function (item) {
                                item.innerHTML = document.querySelectorAll('.notification-item.unread-message').length;
                            })
                        });
                        emptyNotification();
                        document.getElementById("NotificationModalbtn-close").click();
                    })
                })
            }
        }
    }

    function initComponents() {
        // tooltip
        let tooltipTriggerList = [].slice.call(
            document.querySelectorAll('[data-bs-toggle="tooltip"]')
        );
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // popover
        let popoverTriggerList = [].slice.call(
            document.querySelectorAll('[data-bs-toggle="popover"]')
        );
        popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl);
        });
    }

    // Counter Number
    function counter() {
        let counter = document.querySelectorAll(".counter-value");
        let speed = 250; // The lower the slower
        counter &&
        Array.from(counter).forEach(function (counter_value) {
            function updateCount() {
                let target = +counter_value.getAttribute("data-target");
                let count = +counter_value.innerText;
                let inc = target / speed;
                if (inc < 1) {
                    inc = 1;
                }
                // Check if target is reached
                if (count < target) {
                    // Add inc to count and output in counter_value
                    counter_value.innerText = (count + inc).toFixed(0);
                    // Call function every ms
                    setTimeout(updateCount, 1);
                } else {
                    counter_value.innerText = numberWithCommas(target);
                }
                numberWithCommas(counter_value.innerText);
            }

            updateCount();
        });

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    }

    function updateHorizontalMenus() {
        document.getElementById("two-column-menu").innerHTML = "";
        if (document.querySelector(".navbar-menu")) {
            document.querySelector(".navbar-menu").innerHTML = navbarMenuHTML;
        }
        document.getElementById("scrollbar").removeAttribute("data-simplebar");
        document.getElementById("navbar-nav").removeAttribute("data-simplebar");
        document.getElementById("scrollbar").classList.remove("h-100");

        let splitMenu = horizontalMenuSplit;
        let extraMenuName = "More";
        let menuData = document.querySelectorAll("ul.navbar-nav > li.nav-item");
        let newMenus = "";
        let splitItem = "";

        Array.from(menuData).forEach(function (item, index) {
            if (index + 1 === splitMenu) {
                splitItem = item;
            }
            if (index + 1 > splitMenu) {
                newMenus += item.outerHTML;
                item.remove();
            }

            if (index + 1 === menuData.length) {
                if (splitItem.insertAdjacentHTML) {
                    splitItem.insertAdjacentHTML(
                        "afterend",
                        '<li class="nav-item">\
                            <a class="nav-link" href="#sidebarMore" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarMore">\
                                <i class="ri-briefcase-2-line"></i> ' + extraMenuName + '\
						</a>\
						<div class="collapse menu-dropdown" id="sidebarMore"><ul class="nav nav-sm flex-column">' + newMenus + "</ul></div>\
					</li>");
                }
            }
        });
    }

    function hideShowLayoutOptions(dataLayout) {
        return;
        if (dataLayout == "vertical") {
            document.getElementById("two-column-menu").innerHTML = "";
            if (document.querySelector(".navbar-menu")) {
                document.querySelector(".navbar-menu").innerHTML = navbarMenuHTML;
            }
            if (document.getElementById("theme-settings-offcanvas")) {
                document.getElementById("sidebar-size").style.display = "block";
                document.getElementById("sidebar-view").style.display = "block";
                document.getElementById("sidebar-color").style.display = "block";
                if (document.getElementById("sidebar-img")) {
                    document.getElementById("sidebar-img").style.display = "block";
                }
                document.getElementById("layout-position").style.display = "block";
                document.getElementById("layout-width").style.display = "block";
            }
            initLeftMenuCollapse();
            initActiveMenu();
            addEventListenerOnSmHoverMenu();
            initMenuItemScroll();
        } else if (dataLayout == "horizontal") {
            updateHorizontalMenus();
            if (document.getElementById("theme-settings-offcanvas")) {
                document.getElementById("sidebar-size").style.display = "none";
                document.getElementById("sidebar-view").style.display = "none";
                document.getElementById("sidebar-color").style.display = "none";
                if (document.getElementById("sidebar-img")) {
                    document.getElementById("sidebar-img").style.display = "none";
                }
                document.getElementById("layout-position").style.display = "block";
                document.getElementById("layout-width").style.display = "block";
            }
            initActiveMenu();
        } else if (dataLayout == "twocolumn") {
            document.getElementById("scrollbar").removeAttribute("data-simplebar");
            document.getElementById("scrollbar").classList.remove("h-100");
            if (document.getElementById("theme-settings-offcanvas")) {
                document.getElementById("sidebar-size").style.display = "none";
                document.getElementById("sidebar-view").style.display = "none";
                document.getElementById("sidebar-color").style.display = "block";
                if (document.getElementById("sidebar-img")) {
                    document.getElementById("sidebar-img").style.display = "block";
                }
                document.getElementById("layout-position").style.display = "none";
                document.getElementById("layout-width").style.display = "none";
            }
        }
    }

    // add listener Sidebar Hover icon on change layout from setting
    function addEventListenerOnSmHoverMenu() {
        document.getElementById("vertical-hover").addEventListener("click", function () {
            if (document.documentElement.getAttribute("data-sidebar-size") === "sm-hover") {
                document.documentElement.setAttribute("data-sidebar-size", "sm-hover-active");
            } else if (document.documentElement.getAttribute("data-sidebar-size") === "sm-hover-active") {
                document.documentElement.setAttribute("data-sidebar-size", "sm-hover");
            } else {
                document.documentElement.setAttribute("data-sidebar-size", "sm-hover");
            }
        });
    }

    // set full layout
    function layoutSwitch(isLayoutAttributes) {
        switch (isLayoutAttributes) {
            case isLayoutAttributes:
                switch (isLayoutAttributes["data-layout"]) {
                    case "vertical":
                        getElementUsingTagname("data-layout", "vertical");
                        sessionStorage.setItem("data-layout", "vertical");
                        document.documentElement.setAttribute("data-layout", "vertical");
                        hideShowLayoutOptions("vertical");
                        isCollapseMenu();
                        break;
                    case "horizontal":
                        getElementUsingTagname("data-layout", "horizontal");
                        sessionStorage.setItem("data-layout", "horizontal");
                        document.documentElement.setAttribute("data-layout", "horizontal");
                        hideShowLayoutOptions("horizontal");
                        break;
                    case "twocolumn":
                        getElementUsingTagname("data-layout", "twocolumn");
                        sessionStorage.setItem("data-layout", "twocolumn");
                        document.documentElement.setAttribute("data-layout", "twocolumn");
                        hideShowLayoutOptions("twocolumn");
                        break;
                    default:
                        if (sessionStorage.getItem("data-layout") == "vertical" && sessionStorage.getItem("data-layout")) {
                            getElementUsingTagname("data-layout", "vertical");
                            sessionStorage.setItem("data-layout", "vertical");
                            document.documentElement.setAttribute("data-layout", "vertical");
                            hideShowLayoutOptions("vertical");
                            isCollapseMenu();
                        } else if (sessionStorage.getItem("data-layout") == "horizontal") {
                            getElementUsingTagname("data-layout", "horizontal");
                            sessionStorage.setItem("data-layout", "horizontal");
                            document.documentElement.setAttribute("data-layout", "horizontal");
                            hideShowLayoutOptions("horizontal");
                        } else if (sessionStorage.getItem("data-layout") == "twocolumn") {
                            getElementUsingTagname("data-layout", "twocolumn");
                            sessionStorage.setItem("data-layout", "twocolumn");
                            document.documentElement.setAttribute("data-layout", "twocolumn");
                            hideShowLayoutOptions("twocolumn");
                        }
                        break;
                }
                switch (isLayoutAttributes["data-topbar"]) {
                    case "light":
                        getElementUsingTagname("data-topbar", "light");
                        sessionStorage.setItem("data-topbar", "light");
                        document.documentElement.setAttribute("data-topbar", "light");
                        break;
                    case "dark":
                        getElementUsingTagname("data-topbar", "dark");
                        sessionStorage.setItem("data-topbar", "dark");
                        document.documentElement.setAttribute("data-topbar", "dark");
                        break;
                    default:
                        if (sessionStorage.getItem("data-topbar") == "dark") {
                            getElementUsingTagname("data-topbar", "dark");
                            sessionStorage.setItem("data-topbar", "dark");
                            document.documentElement.setAttribute("data-topbar", "dark");
                        } else {
                            getElementUsingTagname("data-topbar", "light");
                            sessionStorage.setItem("data-topbar", "light");
                            document.documentElement.setAttribute("data-topbar", "light");
                        }
                        break;
                }

                switch (isLayoutAttributes["data-layout-style"]) {
                    case "default":
                        getElementUsingTagname("data-layout-style", "default");
                        sessionStorage.setItem("data-layout-style", "default");
                        document.documentElement.setAttribute("data-layout-style", "default");
                        break;
                    case "detached":
                        getElementUsingTagname("data-layout-style", "detached");
                        sessionStorage.setItem("data-layout-style", "detached");
                        document.documentElement.setAttribute("data-layout-style", "detached");
                        break;
                    default:
                        if (sessionStorage.getItem("data-layout-style") == "detached") {
                            getElementUsingTagname("data-layout-style", "detached");
                            sessionStorage.setItem("data-layout-style", "detached");
                            document.documentElement.setAttribute("data-layout-style", "detached");
                        } else {
                            getElementUsingTagname("data-layout-style", "default");
                            sessionStorage.setItem("data-layout-style", "default");
                            document.documentElement.setAttribute("data-layout-style", "default");
                        }
                        break;
                }

                switch (isLayoutAttributes["data-sidebar-size"]) {
                    case "lg":
                        getElementUsingTagname("data-sidebar-size", "lg");
                        document.documentElement.setAttribute("data-sidebar-size", "lg");
                        sessionStorage.setItem("data-sidebar-size", "lg");
                        break;

                    case "sm":
                        getElementUsingTagname("data-sidebar-size", "sm");
                        document.documentElement.setAttribute("data-sidebar-size", "sm");
                        sessionStorage.setItem("data-sidebar-size", "sm");
                        break;

                    case "md":
                        getElementUsingTagname("data-sidebar-size", "md");
                        document.documentElement.setAttribute("data-sidebar-size", "md");
                        sessionStorage.setItem("data-sidebar-size", "md");
                        break;

                    case "sm-hover":
                        getElementUsingTagname("data-sidebar-size", "sm-hover");
                        document.documentElement.setAttribute("data-sidebar-size", "sm-hover");
                        sessionStorage.setItem("data-sidebar-size", "sm-hover");
                        break;

                    default:
                        if (sessionStorage.getItem("data-sidebar-size") == "sm") {
                            document.documentElement.setAttribute("data-sidebar-size", "sm");
                            getElementUsingTagname("data-sidebar-size", "sm");
                            sessionStorage.setItem("data-sidebar-size", "sm");
                        } else if (sessionStorage.getItem("data-sidebar-size") == "md") {
                            document.documentElement.setAttribute("data-sidebar-size", "md");
                            getElementUsingTagname("data-sidebar-size", "md");
                            sessionStorage.setItem("data-sidebar-size", "md");
                        } else if (sessionStorage.getItem("data-sidebar-size") == "sm-hover") {
                            document.documentElement.setAttribute("data-sidebar-size", "sm-hover");
                            getElementUsingTagname("data-sidebar-size", "sm-hover");
                            sessionStorage.setItem("data-sidebar-size", "sm-hover");
                        } else {
                            document.documentElement.setAttribute("data-sidebar-size", "lg");
                            getElementUsingTagname("data-sidebar-size", "lg");
                            sessionStorage.setItem("data-sidebar-size", "lg");
                        }
                        break;
                }

                switch (isLayoutAttributes["data-bs-theme"]) {
                    case "light":
                        getElementUsingTagname("data-bs-theme", "light");
                        document.documentElement.setAttribute("data-bs-theme", "light");
                        sessionStorage.setItem("data-bs-theme", "light");
                        break;
                    case "dark":
                        getElementUsingTagname("data-bs-theme", "dark");
                        document.documentElement.setAttribute("data-bs-theme", "dark");
                        sessionStorage.setItem("data-bs-theme", "dark");
                        break;
                    default:
                        if (sessionStorage.getItem("data-bs-theme") && sessionStorage.getItem("data-bs-theme") == "dark") {
                            sessionStorage.setItem("data-bs-theme", "dark");
                            document.documentElement.setAttribute("data-bs-theme", "dark");
                            getElementUsingTagname("data-bs-theme", "dark");
                        } else {
                            sessionStorage.setItem("data-bs-theme", "light");
                            document.documentElement.setAttribute("data-bs-theme", "light");
                            getElementUsingTagname("data-bs-theme", "light");
                        }
                        break;
                }

                switch (isLayoutAttributes["data-layout-width"]) {
                    case "fluid":
                        getElementUsingTagname("data-layout-width", "fluid");
                        document.documentElement.setAttribute("data-layout-width", "fluid");
                        sessionStorage.setItem("data-layout-width", "fluid");
                        break;
                    case "boxed":
                        getElementUsingTagname("data-layout-width", "boxed");
                        document.documentElement.setAttribute("data-layout-width", "boxed");
                        sessionStorage.setItem("data-layout-width", "boxed");
                        break;
                    default:
                        if (sessionStorage.getItem("data-layout-width") == "boxed") {
                            sessionStorage.setItem("data-layout-width", "boxed");
                            document.documentElement.setAttribute("data-layout-width", "boxed");
                            getElementUsingTagname("data-layout-width", "boxed");
                        } else {
                            sessionStorage.setItem("data-layout-width", "fluid");
                            document.documentElement.setAttribute("data-layout-width", "fluid");
                            getElementUsingTagname("data-layout-width", "fluid");
                        }
                        break;
                }

                switch (isLayoutAttributes["data-sidebar"]) {
                    case "light":
                        getElementUsingTagname("data-sidebar", "light");
                        sessionStorage.setItem("data-sidebar", "light");
                        document.documentElement.setAttribute("data-sidebar", "light");
                        break;
                    case "dark":
                        getElementUsingTagname("data-sidebar", "dark");
                        sessionStorage.setItem("data-sidebar", "dark");
                        document.documentElement.setAttribute("data-sidebar", "dark");
                        break;
                    case "gradient":
                        getElementUsingTagname("data-sidebar", "gradient");
                        sessionStorage.setItem("data-sidebar", "gradient");
                        document.documentElement.setAttribute("data-sidebar", "gradient");
                        break;
                    case "gradient-2":
                        getElementUsingTagname("data-sidebar", "gradient-2");
                        sessionStorage.setItem("data-sidebar", "gradient-2");
                        document.documentElement.setAttribute("data-sidebar", "gradient-2");
                        break;
                    case "gradient-3":
                        getElementUsingTagname("data-sidebar", "gradient-3");
                        sessionStorage.setItem("data-sidebar", "gradient-3");
                        document.documentElement.setAttribute("data-sidebar", "gradient-3");
                        break;
                    case "gradient-4":
                        getElementUsingTagname("data-sidebar", "gradient-4");
                        sessionStorage.setItem("data-sidebar", "gradient-4");
                        document.documentElement.setAttribute("data-sidebar", "gradient-4");
                        break;
                    default:
                        if (sessionStorage.getItem("data-sidebar") && sessionStorage.getItem("data-sidebar") == "light") {
                            sessionStorage.setItem("data-sidebar", "light");
                            getElementUsingTagname("data-sidebar", "light");
                            document.documentElement.setAttribute("data-sidebar", "light");
                        } else if (sessionStorage.getItem("data-sidebar") == "dark") {
                            sessionStorage.setItem("data-sidebar", "dark");
                            getElementUsingTagname("data-sidebar", "dark");
                            document.documentElement.setAttribute("data-sidebar", "dark");
                        } else if (sessionStorage.getItem("data-sidebar") == "gradient") {
                            sessionStorage.setItem("data-sidebar", "gradient");
                            getElementUsingTagname("data-sidebar", "gradient");
                            document.documentElement.setAttribute("data-sidebar", "gradient");
                        } else if (sessionStorage.getItem("data-sidebar") == "gradient-2") {
                            sessionStorage.setItem("data-sidebar", "gradient-2");
                            getElementUsingTagname("data-sidebar", "gradient-2");
                            document.documentElement.setAttribute("data-sidebar", "gradient-2");
                        } else if (sessionStorage.getItem("data-sidebar") == "gradient-3") {
                            sessionStorage.setItem("data-sidebar", "gradient-3");
                            getElementUsingTagname("data-sidebar", "gradient-3");
                            document.documentElement.setAttribute("data-sidebar", "gradient-3");
                        } else if (sessionStorage.getItem("data-sidebar") == "gradient-4") {
                            sessionStorage.setItem("data-sidebar", "gradient-4");
                            getElementUsingTagname("data-sidebar", "gradient-4");
                            document.documentElement.setAttribute("data-sidebar", "gradient-4");
                        }
                        break;
                }

                switch (isLayoutAttributes["data-sidebar-image"]) {
                    case "none":
                        getElementUsingTagname("data-sidebar-image", "none");
                        sessionStorage.setItem("data-sidebar-image", "none");
                        document.documentElement.setAttribute("data-sidebar-image", "none");
                        break;
                    case "img-1":
                        getElementUsingTagname("data-sidebar-image", "img-1");
                        sessionStorage.setItem("data-sidebar-image", "img-1");
                        document.documentElement.setAttribute("data-sidebar-image", "img-1");
                        break;
                    case "img-2":
                        getElementUsingTagname("data-sidebar-image", "img-2");
                        sessionStorage.setItem("data-sidebar-image", "img-2");
                        document.documentElement.setAttribute("data-sidebar-image", "img-2");
                        break;
                    case "img-3":
                        getElementUsingTagname("data-sidebar-image", "img-3");
                        sessionStorage.setItem("data-sidebar-image", "img-3");
                        document.documentElement.setAttribute("data-sidebar-image", "img-3");
                        break;
                    case "img-4":
                        getElementUsingTagname("data-sidebar-image", "img-4");
                        sessionStorage.setItem("data-sidebar-image", "img-4");
                        document.documentElement.setAttribute("data-sidebar-image", "img-4");
                        break;
                    default:
                        if (sessionStorage.getItem("data-sidebar-image") && sessionStorage.getItem("data-sidebar-image") == "none") {
                            sessionStorage.setItem("data-sidebar-image", "none");
                            getElementUsingTagname("data-sidebar-image", "none");
                            document.documentElement.setAttribute("data-sidebar-image", "none");
                        } else if (sessionStorage.getItem("data-sidebar-image") == "img-1") {
                            sessionStorage.setItem("data-sidebar-image", "img-1");
                            getElementUsingTagname("data-sidebar-image", "img-1");
                            document.documentElement.setAttribute("data-sidebar-image", "img-2");
                        } else if (sessionStorage.getItem("data-sidebar-image") == "img-2") {
                            sessionStorage.setItem("data-sidebar-image", "img-2");
                            getElementUsingTagname("data-sidebar-image", "img-2");
                            document.documentElement.setAttribute("data-sidebar-image", "img-2");
                        } else if (sessionStorage.getItem("data-sidebar-image") == "img-3") {
                            sessionStorage.setItem("data-sidebar-image", "img-3");
                            getElementUsingTagname("data-sidebar-image", "img-3");
                            document.documentElement.setAttribute("data-sidebar-image", "img-3");
                        } else if (sessionStorage.getItem("data-sidebar-image") == "img-4") {
                            sessionStorage.setItem("data-sidebar-image", "img-4");
                            getElementUsingTagname("data-sidebar-image", "img-4");
                            document.documentElement.setAttribute("data-sidebar-image", "img-4");
                        }
                        break;
                }

                switch (isLayoutAttributes["data-layout-position"]) {
                    case "fixed":
                        getElementUsingTagname("data-layout-position", "fixed");
                        sessionStorage.setItem("data-layout-position", "fixed");
                        document.documentElement.setAttribute("data-layout-position", "fixed");
                        break;
                    case "scrollable":
                        getElementUsingTagname("data-layout-position", "scrollable");
                        sessionStorage.setItem("data-layout-position", "scrollable");
                        document.documentElement.setAttribute("data-layout-position", "scrollable");
                        break;
                    default:
                        if (sessionStorage.getItem("data-layout-position") && sessionStorage.getItem("data-layout-position") == "scrollable") {
                            getElementUsingTagname("data-layout-position", "scrollable");
                            sessionStorage.setItem("data-layout-position", "scrollable");
                            document.documentElement.setAttribute("data-layout-position", "scrollable");
                        } else {
                            getElementUsingTagname("data-layout-position", "fixed");
                            sessionStorage.setItem("data-layout-position", "fixed");
                            document.documentElement.setAttribute("data-layout-position", "fixed");
                        }
                        break;
                }

                switch (isLayoutAttributes["data-preloader"]) {
                    case "disable":
                        getElementUsingTagname("data-preloader", "disable");
                        sessionStorage.setItem("data-preloader", "disable");
                        document.documentElement.setAttribute("data-preloader", "disable");

                        break;
                    case "enable":
                        getElementUsingTagname("data-preloader", "enable");
                        sessionStorage.setItem("data-preloader", "enable");
                        document.documentElement.setAttribute("data-preloader", "enable");
                        let preloader = document.getElementById("preloader");
                        if (preloader) {
                            window.addEventListener("load", function () {
                                preloader.style.opacity = "0";
                                preloader.style.visibility = "hidden";
                            });
                        }
                        break;
                    default:
                        if (sessionStorage.getItem("data-preloader") && sessionStorage.getItem("data-preloader") == "disable") {
                            getElementUsingTagname("data-preloader", "disable");
                            sessionStorage.setItem("data-preloader", "disable");
                            document.documentElement.setAttribute("data-preloader", "disable");

                        } else if (sessionStorage.getItem("data-preloader") == "enable") {
                            getElementUsingTagname("data-preloader", "enable");
                            sessionStorage.setItem("data-preloader", "enable");
                            document.documentElement.setAttribute("data-preloader", "enable");
                            let preloader = document.getElementById("preloader");
                            if (preloader) {
                                window.addEventListener("load", function () {
                                    preloader.style.opacity = "0";
                                    preloader.style.visibility = "hidden";
                                });
                            }
                        } else {
                            document.documentElement.setAttribute("data-preloader", "disable");
                        }
                        break;
                }

                switch (isLayoutAttributes["data-body-image"]) {
                    case "img-1":
                        getElementUsingTagname("data-body-image", "img-1");
                        sessionStorage.setItem("data-sidebabodyr-image", "img-1");
                        document.documentElement.setAttribute("data-body-image", "img-1");
                        if (document.getElementById("theme-settings-offcanvas")) {
                            document.documentElement.removeAttribute("data-sidebar-image");
                        }
                        break;
                    case "img-2":
                        getElementUsingTagname("data-body-image", "img-2");
                        sessionStorage.setItem("data-body-image", "img-2");
                        document.documentElement.setAttribute("data-body-image", "img-2");
                        break;
                    case "img-3":
                        getElementUsingTagname("data-body-image", "img-3");
                        sessionStorage.setItem("data-body-image", "img-3");
                        document.documentElement.setAttribute("data-body-image", "img-3");
                        break;
                    case "none":
                        getElementUsingTagname("data-body-image", "none");
                        sessionStorage.setItem("data-body-image", "none");
                        document.documentElement.setAttribute("data-body-image", "none");
                        break;

                    default:
                        if (sessionStorage.getItem("data-body-image") && sessionStorage.getItem("data-body-image") == "img-1") {
                            sessionStorage.setItem("data-body-image", "img-1");
                            getElementUsingTagname("data-body-image", "img-1");
                            document.documentElement.setAttribute("data-body-image", "img-1");

                            if (document.getElementById("theme-settings-offcanvas")) {
                                document.getElementById("sidebar-img").style.display = "none";
                                document.documentElement.removeAttribute("data-sidebar-image");
                            }
                        } else if (sessionStorage.getItem("data-body-image") == "img-2") {
                            sessionStorage.setItem("data-body-image", "img-2");
                            getElementUsingTagname("data-body-image", "img-2");
                            document.documentElement.setAttribute("data-body-image", "img-2");
                        } else if (sessionStorage.getItem("data-body-image") == "img-3") {
                            sessionStorage.setItem("data-body-image", "img-3");
                            getElementUsingTagname("data-body-image", "img-3");
                            document.documentElement.setAttribute("data-body-image", "img-3");
                        } else if (sessionStorage.getItem("data-body-image") == "none") {
                            sessionStorage.setItem("data-body-image", "none");
                            getElementUsingTagname("data-body-image", "none");
                            document.documentElement.setAttribute("data-body-image", "none");
                        }
                        break;
                }
            default:
                break;
        }
    }

    function initMenuItemScroll() {
        setTimeout(function () {
            let sidebarMenu = document.getElementById("navbar-nav");
            if (sidebarMenu) {
                let activeMenu = sidebarMenu.querySelector(".nav-item .active");
                let offset = activeMenu ? activeMenu.offsetTop : 0;
                if (offset > 300) {
                    let verticalMenu = document.getElementsByClassName("app-menu") ? document.getElementsByClassName("app-menu")[0] : "";
                    if (verticalMenu && verticalMenu.querySelector(".simplebar-content-wrapper")) {
                        setTimeout(function () {
                            offset == 330 ?
                                (verticalMenu.querySelector(".simplebar-content-wrapper").scrollTop = offset + 85) :
                                (verticalMenu.querySelector(".simplebar-content-wrapper").scrollTop = offset);
                        }, 0);
                    }
                }
            }
        }, 250);
    }

    // add change event listener on right layout setting
    function getElementUsingTagname(ele, val) {
        Array.from(document.querySelectorAll("input[name=" + ele + "]")).forEach(function (x) {
            val == x.value ? (x.checked = true) : (x.checked = false);

            x.addEventListener("change", function () {
                document.documentElement.setAttribute(ele, x.value);
                sessionStorage.setItem(ele, x.value);
                initLanguage();

                if (ele == "data-layout-width" && x.value == "boxed") {
                    document.documentElement.setAttribute("data-sidebar-size", "sm-hover");
                    sessionStorage.setItem("data-sidebar-size", "sm-hover");
                    document.getElementById("sidebar-size-small-hover").checked = true;
                } else if (ele == "data-layout-width" && x.value == "fluid") {
                    document.documentElement.setAttribute("data-sidebar-size", "lg");
                    sessionStorage.setItem("data-sidebar-size", "lg");
                    document.getElementById("sidebar-size-default").checked = true;
                }

                if (ele == "data-layout") {
                    if (x.value == "vertical") {
                        hideShowLayoutOptions("vertical");
                        isCollapseMenu();
                    } else if (x.value == "horizontal") {
                        if (document.getElementById("sidebarimg-none")) {
                            document.getElementById("sidebarimg-none").click();
                        }
                        hideShowLayoutOptions("horizontal");
                    } else if (x.value == "twocolumn") {
                        hideShowLayoutOptions("twocolumn");
                        document.documentElement.setAttribute("data-layout-width", "fluid");
                        document.getElementById("layout-width-fluid").click();
                        twoColumnMenuGenerate();
                        initTwoColumnActiveMenu();
                        isCollapseMenu();
                    }
                }

                if (ele == "data-bs-theme" && x.value == "light") {
                    document.getElementById("topbar-color-light").click();
                    document.getElementById("sidebar-color-light").click();
                } else if (ele == "data-bs-theme" && x.value == "dark") {
                    document.getElementById("topbar-color-dark").click();
                    document.getElementById("sidebar-color-dark").click();
                }

                if (ele == "data-preloader" && x.value == "enable") {
                    document.documentElement.setAttribute("data-preloader", "enable");
                    let preloader = document.getElementById("preloader");
                    if (preloader) {
                        setTimeout(function () {
                            preloader.style.opacity = "0";
                            preloader.style.visibility = "hidden";
                        }, 1000);
                    }
                    document.getElementById("customizerclose-btn").click();
                } else if (ele == "data-preloader" && x.value == "disable") {
                    document.documentElement.setAttribute("data-preloader", "disable");
                    document.getElementById("customizerclose-btn").click();
                }
            });
        });

        if (document.getElementById('collapseBgGradient')) {
            Array.from(document.querySelectorAll("#collapseBgGradient .form-check input")).forEach(function (subElem) {
                let myCollapse = document.getElementById('collapseBgGradient')
                if ((subElem.checked == true)) {
                    let bsCollapse = new bootstrap.Collapse(myCollapse, {
                        toggle: false,
                    })
                    bsCollapse.show()
                }

                if (document.querySelector("[data-bs-target='#collapseBgGradient']")) {
                    document.querySelector("[data-bs-target='#collapseBgGradient']").addEventListener('click', function (elem) {
                        document.getElementById("sidebar-color-gradient").click();
                    });
                }
            });
        }

        Array.from(document.querySelectorAll("[name='data-sidebar']")).forEach(function (elem) {
            if (document.querySelector("[data-bs-target='#collapseBgGradient']")) {
                if (document.querySelector("#collapseBgGradient .form-check input:checked")) {
                    document.querySelector("[data-bs-target='#collapseBgGradient']").classList.add("active");
                } else {
                    document.querySelector("[data-bs-target='#collapseBgGradient']").classList.remove("active");
                }

                elem.addEventListener("change", function () {
                    if (document.querySelector("#collapseBgGradient .form-check input:checked")) {
                        document.querySelector("[data-bs-target='#collapseBgGradient']").classList.add("active");
                    } else {
                        document.querySelector("[data-bs-target='#collapseBgGradient']").classList.remove("active");
                    }
                })
            }
        })

    }

    function setDefaultAttribute() {
        if (!sessionStorage.getItem("defaultAttribute")) {
            let attributesValue = document.documentElement.attributes;
            let isLayoutAttributes = {};
            Array.from(attributesValue).forEach(function (x) {
                if (x && x.nodeName && x.nodeName != "undefined") {
                    let nodeKey = x.nodeName;
                    isLayoutAttributes[nodeKey] = x.nodeValue;
                    sessionStorage.setItem(nodeKey, x.nodeValue);
                }
            });
            sessionStorage.setItem("defaultAttribute", JSON.stringify(isLayoutAttributes));
            layoutSwitch(isLayoutAttributes);

            // open right sidebar on first time load
            let offCanvas = document.querySelector('.btn[data-bs-target="#theme-settings-offcanvas"]');
            offCanvas ? offCanvas.click() : "";
        } else {
            let isLayoutAttributes = {};
            isLayoutAttributes["data-layout"] = sessionStorage.getItem("data-layout");
            isLayoutAttributes["data-sidebar-size"] = sessionStorage.getItem("data-sidebar-size");
            isLayoutAttributes["data-bs-theme"] = sessionStorage.getItem("data-bs-theme");
            isLayoutAttributes["data-layout-width"] = sessionStorage.getItem("data-layout-width");
            isLayoutAttributes["data-sidebar"] = sessionStorage.getItem("data-sidebar");
            isLayoutAttributes['data-sidebar-image'] = sessionStorage.getItem('data-sidebar-image');
            isLayoutAttributes["data-layout-position"] = sessionStorage.getItem("data-layout-position");
            isLayoutAttributes["data-layout-style"] = sessionStorage.getItem("data-layout-style");
            isLayoutAttributes["data-topbar"] = sessionStorage.getItem("data-topbar");
            isLayoutAttributes["data-preloader"] = sessionStorage.getItem("data-preloader");
            isLayoutAttributes["data-body-image"] = sessionStorage.getItem("data-body-image");
            layoutSwitch(isLayoutAttributes);
        }
    }

    function initFullScreen() {
        let fullscreenBtn = document.querySelector('[data-toggle="fullscreen"]');
        fullscreenBtn &&
        fullscreenBtn.addEventListener("click", function (e) {
            e.preventDefault();
            document.body.classList.toggle("fullscreen-enable");
            if (!document.fullscreenElement &&
                /* alternative standard method */
                !document.mozFullScreenElement &&
                !document.webkitFullscreenElement
            ) {
                // current working methods
                if (document.documentElement.requestFullscreen) {
                    document.documentElement.requestFullscreen();
                } else if (document.documentElement.mozRequestFullScreen) {
                    document.documentElement.mozRequestFullScreen();
                } else if (document.documentElement.webkitRequestFullscreen) {
                    document.documentElement.webkitRequestFullscreen(
                        Element.ALLOW_KEYBOARD_INPUT
                    );
                }
            } else {
                if (document.cancelFullScreen) {
                    document.cancelFullScreen();
                } else if (document.mozCancelFullScreen) {
                    document.mozCancelFullScreen();
                } else if (document.webkitCancelFullScreen) {
                    document.webkitCancelFullScreen();
                }
            }
        });

        document.addEventListener("fullscreenchange", exitHandler);
        document.addEventListener("webkitfullscreenchange", exitHandler);
        document.addEventListener("mozfullscreenchange", exitHandler);

        function exitHandler() {
            if (!document.webkitIsFullScreen && !document.mozFullScreen && !document.msFullscreenElement) {
                document.body.classList.remove("fullscreen-enable");
            }
        }
    }

    function setLayoutMode(mode, modeType, modeTypeId, html) {
        let isModeTypeId = document.getElementById(modeTypeId);
        html.setAttribute(mode, modeType);
        if (isModeTypeId) {
            document.getElementById(modeTypeId).click();
            document.getElementById("sidebar-color-" + modeType).click();
            document.getElementById("topbar-color-" + modeType).click();
        }
    }

    function initModeSetting() {
        let html = document.getElementsByTagName("HTML")[0];

        document.querySelectorAll("#light-dark-mode .dropdown-item").forEach(function (item) {
            item.addEventListener("click", function (event) {
                if (html.hasAttribute("data-bs-theme") && item.getAttribute("data-mode") == "light") {
                    setLayoutMode("data-bs-theme", "light", "layout-mode-light", html);
                    sessionStorage.setItem("data-layout-auto", "false");

                } else if (html.hasAttribute("data-bs-theme") && item.getAttribute("data-mode") == "dark") {
                    setLayoutMode("data-bs-theme", "dark", "layout-mode-dark", html);
                    sessionStorage.setItem("data-layout-auto", "false");

                } else if (html.hasAttribute("data-bs-theme") && item.getAttribute("data-mode") == "auto") {
                    let prefersDarkScheme = window.matchMedia("(prefers-color-scheme: dark)");

                    if (prefersDarkScheme.matches) {
                        setLayoutMode("data-bs-theme", "dark", "layout-mode-dark", html);
                    } else {
                        setLayoutMode("data-bs-theme", "light", "layout-mode-light", html)
                    }

                    sessionStorage.setItem("data-layout-auto", "true");

                }

                if (sessionStorage.getItem("data-layout-auto") && sessionStorage.getItem("data-layout-auto") == "true") {
                    document.documentElement.classList.add("mode-auto");
                } else {
                    document.documentElement.classList.remove("mode-auto");
                }
            })
        })

        if (sessionStorage.getItem("data-layout-auto") && sessionStorage.getItem("data-layout-auto") == "true") {
            document.documentElement.classList.add("mode-auto");
        } else {
            document.documentElement.classList.remove("mode-auto");
        }
    }

    function resetLayout() {
        if (document.getElementById("reset-layout")) {
            document.getElementById("reset-layout").addEventListener("click", function () {
                sessionStorage.clear();
                window.location.reload();
            });
        }
    }

    function init() {
        setDefaultAttribute();
        twoColumnMenuGenerate();
        isCustomDropdown();
        isCustomDropdownResponsive();
        initFullScreen();
        initModeSetting();
        windowLoadContent();
        counter();
        initTopbarComponents();
        initComponents();
        resetLayout();
        isCollapseMenu();
        initMenuItemScroll();
    }

    init();

    let timeOutFunctionId;

    function setResize() {
        let currentLayout = document.documentElement.getAttribute("data-layout");
        if (currentLayout !== "horizontal") {
            if (document.getElementById("navbar-nav")) {
                let simpleBar = new SimpleBar(document.getElementById("navbar-nav"));
                if (simpleBar) simpleBar.getContentElement();
            }

            if (document.getElementsByClassName("twocolumn-iconview")[0]) {
                let simpleBar1 = new SimpleBar(
                    document.getElementsByClassName("twocolumn-iconview")[0]
                );
                if (simpleBar1) simpleBar1.getContentElement();
            }
            clearTimeout(timeOutFunctionId);
        }
    }

    window.addEventListener("resize", function () {
        if (timeOutFunctionId) clearTimeout(timeOutFunctionId);
        timeOutFunctionId = setTimeout(setResize, 2000);
    });
})();

new SimpleBar(document.getElementById("navbar-nav"));
//Couter Js
let num = document.querySelectorAll(".counterup");
let num2 = document.querySelectorAll(".counterin");
let numArray = Array.from(num)
let numArray2 = Array.from(num2)

numArray.map((item) => {
    let count = 0

    function counterup() {
        count++
        item.innerHTML = count + "+";

        if (count == item.dataset.number) {
            clearInterval(stop)
        }
    }

    let stop = setInterval(function () {
        counterup()
    }, 1)
});
numArray2.map((item) => {
    let count = 24800;

    function counterin() {
        count++
        item.innerHTML = count + "+";

        if (count == 25000) {
            clearInterval(stop)

        }
    }

    let stop = setInterval(function () {
        counterin()
    }, 0.1)
});
//Portfolio Js
$(document).ready(function () {

    $(".filter-button").click(function () {
        var value = $(this).attr('data-filter');

        if (value == "all") {
            //$('.filter').removeClass('hidden');
            $('.filter').show('1000');
        } else {
            $(".filter").not('.' + value).hide('3000');
            $('.filter').filter('.' + value).show('3000');

        }
    });

});


//Partner Crousel Js
const nextIcon = '<img src="Web/assets/img/crousel-arrow/next.png" alt="right">';
const prevIcon = '<img src="Web/assets/img/crousel-arrow/left-arrow.png" alt="left" >';
//Reviws Crousel Js
$('#owl-one').owlCarousel({
    loop: true,
    autoplay: true,
    margin: 10,
    nav: true,
    navText: [
        prevIcon,
        nextIcon
    ],
    responsive: {
        0: {
            items: 1
        },
        768: {
            items: 2
        },
        2000: {
            items: 3
        },
        2500: {
            items: 4
        }
    }
});


$('#owl-two').owlCarousel({
    loop: true,
    autoplay: true,
    margin: 10,
    smartSpeed: 1000,
    nav: false,
    navText: [
        prevIcon,
        nextIcon
    ],
    responsive: {
        0: {
            items: 1
        },
        576: {
            items: 1
        }, 375: {
            items: 1
        },
        768: {
            items: 2
        },
        1200: {
            items: 3
        }
    }
});

$('#owl-three').owlCarousel({
    loop: true,
    autoplay: true,
    margin: 10,
    smartSpeed: 1000,
    nav: true,
    navText: [
        prevIcon,
        nextIcon
    ],
    responsive: {
        0: {
            items: 1
        },
        768: {
            items: 2
        },
        1000: {
            items: 3
        },
        1200: {
            items: 4
        },
        2000: {
            items: 5
        },
        2500: {
            items: 6
        }
    }
});

$('#owl-four').owlCarousel({
    loop: true,
    autoplay: true,
    margin: 10,
    smartSpeed: 1000,
    nav: false,
    navText: [
        prevIcon,
        nextIcon
    ],
    responsive: {
        0: {
            items: 2
        },
        768: {
            items: 2
        },
        1200: {
            items: 3
        }
    }
});

$('#owl-four-one').owlCarousel({
    loop: true,
    autoplay: true,
    margin: 10,
    smartSpeed: 1000,
    nav: false,
    navText: [
        prevIcon,
        nextIcon
    ],
    responsive: {
        0: {
            items: 1
        },
        768: {
            items: 2
        },
        1200: {
            items: 3
        }
    }
});

$('#owl-feature-two').owlCarousel({
    loop: true,
    autoplay: true,
    margin: 10,
    smartSpeed: 1000,
    nav: true,
    navText: [
        prevIcon,
        nextIcon
    ],
    responsive: {
        0: {
            items: 1
        },
        768: {
            items: 2
        },
        1000: {
            items: 3
        },
        1200: {
            items: 4
        },
        2000: {
            items: 5
        },
        2500: {
            items: 6
        }
    }
});

$('#owl-partner-section').owlCarousel({
    loop: true,
    autoplay: true,
    margin: 10,
    smartSpeed: 1000,
    nav: true,
    navText: [
        prevIcon,
        nextIcon
    ],
    responsive: {
        0: {
            items: 2
        },
        768: {
            items: 2
        },
        1000: {
            items: 3
        },
        1200: {
            items: 5
        },
        2000: {
            items: 5
        },
        2500: {
            items: 6
        }
    }
});
/**
 WorkSpace Hero Carousel
 */
// banner-carousel
if ($('.banner-carousel').length) {
    $('.banner-carousel').owlCarousel({
        loop: true,
        margin: 0,
        nav: true,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        active: true,
        smartSpeed: 1000,
        autoplay: 6000,
        navText: ['<img class="workplace-hero-left" src="./assets/img/crousel-arrow/left-arrow.png" alt="left" >', '<img class="workplace-hero-right" src="./assets/img/crousel-arrow/next.png" alt="right">'],
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            800: {
                items: 1
            },
            1024: {
                items: 1
            }
        }
    });
}
//Workspace Book A tour Cards
if ($('.three-item-carousel').length) {
    $('.three-item-carousel').owlCarousel({
        loop: true,
        margin: 10,
        nav: false,
        smartSpeed: 500,
        autoplay: 1000,
        navText: ['<span class="fas fa-angle-left"></span><span class="fas fa-angle-left"></span>', '<span class="fas fa-angle-right"></span><span class="fas fa-angle-right"></span>'],
        responsive: {
            0: {
                items: 1
            },
            480: {
                items: 1
            },
            768: {
                items: 2
            },
            800: {
                items: 2
            },
            992: {
                items: 3
            }
        }
    });
}
//Product Tabs isl lhr fsd
if ($('.project-tab').length) {
    $('.project-tab .product-tab-btns .p-tab-btn').on('click', function (e) {
        e.preventDefault();
        var target = $($(this).attr('data-tab'));

        if ($(target).hasClass('actve-tab')) {
            return false;
        } else {
            $('.project-tab .product-tab-btns .p-tab-btn').removeClass('active-btn');
            $(this).addClass('active-btn');
            $('.project-tab .p-tabs-content .p-tab').removeClass('active-tab');
            $(target).addClass('active-tab');
        }
    });
}

// International Phone number
const phoneInputField = document.querySelector("#phone");
// const phoneInput = window.intlTelInput(phoneInputField, {
//   utilsScript:
//     "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
// });

const info = document.querySelector(".alert-info");
const field = document.querySelector(".text-value")
const error = document.querySelector(".alert-error");

function process(event) {
    event.preventDefault();

    const phoneNumber = phoneInput.getNumber();

    info.style.display = "";
    info.innerHTML = `Phone number in E.164 format: <strong>${phoneNumber}</strong>`;
    field.style.display = "";
    field.value = phoneNumber;
    document.querySelector(".reset-btn").style.display = "inline-block";
    document.querySelector(".reset-btn").addEventListener("click", function () {
        location.reload()
    })
}

// Changing Facilities Section Download Image

// Dropdown Start
function myFunction() {
    document.getElementById("myDropdown-useful").classList.toggle("show-useful");
}

// Close the dropdown menu if the user clicks outside of it
window.onclick = function (event) {
    if (!event.target.matches('.dropbtn-useful')) {
        var dropdowns = document.getElementsByClassName("dropdown-content-useful");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show-useful')) {
                openDropdown.classList.remove('show-useful');
            }
        }
    }
}
// Dropdown End

//FAQ SECTION JS
let rotate = document.getElementById('faq-arrow-ai');
let rotate2 = document.getElementById('faq-arrow-ai-2');
let rotate3 = document.getElementById('faq-arrow-ai-3');
let rotate4 = document.getElementById('faq-arrow-ai-4');
let color1 = document.getElementById('changeColor1');
let color2 = document.getElementById('changeColor2');
let color3 = document.getElementById('changeColor3');
let color4 = document.getElementById('changeColor4');


if (rotate) {
    rotate.addEventListener('click', function () {
        rotate.classList.toggle('rotate-ai');
        let num1 = document.getElementById('nm1');
        num1.classList.toggle('drop-down-number-ai');
    })
}

if (rotate2) {
    rotate2.addEventListener('click', function () {
        rotate2.classList.toggle('rotate-ai');
        let num2 = document.getElementById('num2');
        num2.classList.toggle('drop-down-number-ai');
    })
}

if (rotate3) {
    rotate3.addEventListener('click', function () {
        rotate3.classList.toggle('rotate-ai');
        let num3 = document.getElementById('num3');
        num3.classList.toggle('drop-down-number-ai');
    })
}

if (rotate4) {
    rotate4.addEventListener('click', function () {
        rotate4.classList.toggle('rotate-ai');
        let num4 = document.getElementById('num4');
        num4.classList.toggle('drop-down-number-ai');
    })
}
if (color1) {
    color1.addEventListener('click', function () {
        rotate.classList.toggle('rotate-ai');
        let num1 = document.getElementById('nm1');
        num1.classList.toggle('drop-down-number-ai');
    })
}

if (color2) {
    color2.addEventListener('click', function () {
        rotate2.classList.toggle('rotate-ai');
        let num2 = document.getElementById('num2');
        num2.classList.toggle('drop-down-number-ai');
    })
}

if (color3) {
    color3.addEventListener('click', function () {
        rotate3.classList.toggle('rotate-ai');
        let num3 = document.getElementById('num3');
        num3.classList.toggle('drop-down-number-ai');
    })
}

if (color4) {
    color4.addEventListener('click', function () {
        rotate4.classList.toggle('rotate-ai');
        let num4 = document.getElementById('num4');
        num4.classList.toggle('drop-down-number-ai');
    })
}

//Grid To List View Js
let gridShow = document.getElementById('grid');
let listShow = document.getElementById('list');

if (gridShow) {
    gridShow.addEventListener('click', () => {
        let show = document.getElementById('show-grid');
        let hide = document.getElementById('show-list');
        show.classList.remove('abt-to-hide');
        hide.classList.add('abt-to-hide');
    })
}
if (listShow) {
    listShow.addEventListener('click', () => {
        let show = document.getElementById('show-grid');
        let hide = document.getElementById('show-list');
        show.classList.add('abt-to-hide');
        hide.classList.remove('abt-to-hide');
    })
}

// Marquee JS
$('#demo').marquee({

    // enable the plugin
    enable: true,  //plug-in is enabled

    // scroll direction
    // 'vertical' or 'horizontal'
    direction: 'vertical',

    // children items
    itemSelecter: 'li',

    // animation delay
    delay: 1000,

    // animation speed
    speed: 1,

    // animation timing
    timing: 1,

    // mouse hover to stop the scroller
    mouse: true

});

/**
 * Animation on scroll
 */


// inititate Glightbox
if (GLightbox) {
    const glightbox = GLightbox({
        selector: '.glightbox'
    });
    // glightbox
    const portfolioLightbox = GLightbox({
        selector: '.portfolio-lightbox'
    });
}

// search

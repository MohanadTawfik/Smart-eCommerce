/*==================================
  change the theme 
  ==================================*/

const themeToggler = document.querySelector(".theme-toggler");
// start with dark theme
// document.body.classList.toggle("dark-them-variables");

if (themeToggler) {
  // change the theme
  themeToggler.addEventListener("click", () => {
    document.body.classList.toggle("dark-them-variables");

    themeToggler.querySelector("i:nth-child(1)").classList.toggle("active");
    themeToggler.querySelector("i:nth-child(2)").classList.toggle("active");
  });
}

/*==================================
  Sidebar in mobile and small tablet 
  ==================================*/

const sideMenu = document.querySelectorAll("aside .navigation ul.sidebar li");
sideMenu.forEach((item) => item.addEventListener("click", activeLink));

function activeLink() {
  sideMenu.forEach((item) => item.classList.remove("active"));
  this.classList.add("active");
}

/*==================================
    show and hide Sidebar
    ==================================*/

const toggleSidebar = document.querySelector(".toggle-sidebar");
const logo = document.querySelector(".logo-box");
const sidebar = document.querySelector(".sidebar");

if (toggleSidebar && logo) {
  toggleSidebar.addEventListener("click", () => {
    sidebar.classList.toggle("close");
  });

  logo.addEventListener("click", () => {
    sidebar.classList.toggle("close");
  });
}

/*==================================
    Sidebar in other pages
    ==================================*/

const listItems = document.querySelectorAll(".sidebar-list li");

listItems.forEach((item) => {
  item.addEventListener("click", () => {
    let isActive = item.classList.contains("active");

    listItems.forEach((el) => {
      el.classList.remove("active");
    });

    if (isActive) item.classList.remove("active");
    else item.classList.add("active");
  });
});

/*==================================
  slider card
    ==================================*/
var swiper = new Swiper(".slide-content", {
  slidesPerView: 3,
  spaceBetween: 25,
  loop: false,
  centerSlide: "true",
  fade: "true",
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
    dynamicBullets: true,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  breakpoints: {
    0: {
      slidesPerView: 1,
    },
    520: {
      slidesPerView: 2,
    },
    950: {
      slidesPerView: 3,
    },
  },
});

/*==================================
  notification alert
    ==================================*/

function notify(flag_success, massage = "تبيه بإجراء عملية ") {
  $(".toast").addClass("active");
  $(".text-massage").text(massage);

  if (flag_success === "success") {
    $(".toast").addClass("success");
    $(".check").addClass("fa-check");
    //
    // alert text
    $(".text-title").text("تم");
  } else if (flag_success === "danger") {
    $(".toast").addClass("danger");
    $(".check").addClass("fa-close");
    //
    // alert text
    $(".text-title").text("خطأ");
  } else if (flag_success === "warning") {
    $(".toast").addClass("warning");
    $(".check").addClass("fa-warning");
    //
    // alert text
    $(".text-title").text("تحذير");
  }

  setTimeout(() => {
    $(".toast").removeClass("active success danger warning");
  }, 3300);

  $(".close").click(function () {
    setTimeout(() => {
      $(this).parent(".toast").removeClass("active success danger warning");
    }, 10);
  });
}

// Add to cart
let arr = [];
function addToCart(id, ele) {
  alert("click");
  // arr.push(id);

  // let time = new Date();
  // var dayesDelay = 5;
  // var newdate = new Date(time);
  // newdate.setDate(time.getDate() + dayesDelay);

  // let va = "userCart=" + arr + ";expires=" + newdate + ";path=/";
  // document.cookie = va;

  // console.log(va);
  // $(ele).attr("disabled", "disabled");
}

/*==================================
  Get Rating Products
  ==================================*/
function getRating() {
  const starsTotal = 5;
  let products = document.querySelectorAll(".product-card");

  products.forEach((e) => {
    // get percentage
    const starPercentage = (e.getAttribute("rating") / starsTotal) * 100;

    // Round to nearest 10
    const starPercentageRounded = `${Math.round((starPercentage / 10) * 10)}%`;

    // set width of stars-inner to percentage
    let $star = e.children[2].children[1].children[0].children[0];
    if ($star) {
      $star.style.width = starPercentageRounded;
    }
  });
}

getRating();

/*==================================
  JQuery Functions
  ==================================*/

$(document).ready(function () {
  ("use strict");

  /*================================
    Search Animation
    ==================================*/
  $(".search i").click(function () {
    $(this).parent(".search").toggleClass("active");

    if ($(this).hasClass("fa-search")) {
      $(this).removeClass("fa-search search").addClass("fa-close close");
    } else {
      $(this).removeClass("fa-close close").addClass("fa-search search");
    }
  });

  //live preview form
  $(".live").keyup(function () {
    if ($(this).data("class") == ".live-image") {
      $($(this).data("class")).attr(
        "src",
        "data\\uploads\\itemsPhoto\\" + $(this).val()
      );
    } else {
      $($(this).data("class")).text($(this).val());
    }
  });

  //live preview price in user cart
  let previous = $(".price input#number").val();

  $(".price input#number").change(function () {
    let current = $(this).val();
    let totalPrice = $(".title-date .date .price");
    let price = parseInt($(this).attr("price").replace("$", ""));

    if (current > previous) {
      totalPrice.text(+totalPrice.text() + price);
    } else {
      // current = previous - current;
      // totalPrice.text(+totalPrice.text() - price);
      console.log(previous - current);
    }
  });

  // switch between login and signup
  $(".button-login #form_button").click(function () {
    $(this).addClass("selected").siblings().removeClass("selected");
    $(".login-page form").hide();
    $("#" + $(this).data("class")).css("display", "flex");
  });

  // apply animation on label letters on focus on input
  let MyText;
  let afterLabel;

  $("form .input-group input")
    .focus(function () {
      if ($(this).attr("type") !== "radio") {
        let label = $(this).siblings("label");
        let labelText = label.text().split("");
        label.empty();
        let timeDelay = 0;
        for (let i = 0; i < labelText.length; i++) {
          let letter = labelText[i];
          $("<span></span>", {
            text: letter,
            style: `transition-delay: ${(timeDelay += 50)}ms`,
          }).appendTo(label);
        }
        $(this)
          .delay(0)
          .queue(function () {
            label.addClass("focused");
            $(this)
              .delay(800)
              .queue(function () {
                afterLabel = label.children("span").text();
                MyText = label.html();
                label.empty().css("top", "-17px").text(afterLabel);
                $(this).dequeue();
              })
              .dequeue();
          });
      }
    })
    .blur(function () {
      if ($(this).attr("type") !== "radio") {
        if ($(this).val().length === 0) {
          let label = $(this).siblings("label");
          label.css("top", "10px").empty().html(MyText);
          $(this)
            .delay(0)
            .queue(function () {
              label.removeClass("focused");
              $(this)
                .delay(800)
                .queue(function () {
                  label.empty().text(afterLabel);
                  $(this).dequeue();
                });
              $(this).dequeue();
            });
        }
      }
    });

  //
  //
  //
  /*==================================
    Preloader
    ==================================*/
  $(".preloader ").fadeOut();
});

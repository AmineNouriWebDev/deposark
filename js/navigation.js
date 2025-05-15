// ---------Responsive-navbar-active-animation-----------
function test() {
  var tabsNewAnim = jQuery("#navbarSupportedContent");
  var selectorNewAnim = jQuery("#navbarSupportedContent").find("li").length;
  var activeItemNewAnim = tabsNewAnim.find(".active");
  if (activeItemNewAnim.length) {
    var activeWidthNewAnimHeight = activeItemNewAnim.innerHeight();
    var activeWidthNewAnimWidth = activeItemNewAnim.innerWidth();
    var itemPosNewAnimTop = activeItemNewAnim.position();
    var itemPosNewAnimLeft = activeItemNewAnim.position();
    jQuery(".hori-selector").css({
      top: itemPosNewAnimTop.top + "px",
      left: itemPosNewAnimLeft.left + "px",
      height: activeWidthNewAnimHeight + "px",
      width: activeWidthNewAnimWidth + "px",
    });
  }
  jQuery("#navbarSupportedContent").on("click", "li", function (e) {
    jQuery("#navbarSupportedContent ul li").removeClass("active");
    jQuery(this).addClass("active");
    var activeWidthNewAnimHeight = jQuery(this).innerHeight();
    var activeWidthNewAnimWidth = jQuery(this).innerWidth();
    var itemPosNewAnimTop = jQuery(this).position();
    var itemPosNewAnimLeft = jQuery(this).position();
    jQuery(".hori-selector").css({
      top: itemPosNewAnimTop.top + "px",
      left: itemPosNewAnimLeft.left + "px",
      height: activeWidthNewAnimHeight + "px",
      width: activeWidthNewAnimWidth + "px",
    });
  });
}
jQuery(document).ready(function () {
  setTimeout(function () {
    test();
  });
});
jQuery(window).on("resize", function () {
  setTimeout(function () {
    test();
  }, 500);
});
jQuery(".navbar-toggler").click(function () {
  jQuery(".navbar-collapse").slideToggle(300);
  setTimeout(function () {
    test();
  });
});

// --------------add active class-on another-page move----------
jQuery(document).ready(function () {
  // Get current path and find target link
  var path = window.location.pathname.split("/").pop();

  // Account for home page with empty path
  if (path == "") {
    path = "index.html";
  }

  var target = jQuery('#navbarSupportedContent ul li a[href="' + path + '"]');
  // Add active class to target link
  target.parent().addClass("active");
});

document.addEventListener("DOMContentLoaded", function () {
  // Fonction pour animer lettre par lettre - CORRIGÉ
  function animateLetters(element, totalDuration = 4) {
    if (!element) {
      console.warn("Element d'animation non trouvé");
      return;
    }

    const text = element.textContent;
    element.innerHTML = text
      .split("")
      .map((c) => `<span>${c === " " ? "&nbsp;" : c}</span>`)
      .join("");

    const letters = element.querySelectorAll("span");
    const durationPerLetter = (totalDuration * 1000) / letters.length;

    letters.forEach((letter, index) => {
      letter.style.animationDelay = `${index * durationPerLetter}ms`;
    });
  }

  // Ajout de vérifications null
  const animatedTitle = document.querySelector(".animated-title");
  const animatedParagraph = document.querySelector(".animated-paragraph");

  if (animatedTitle) animateLetters(animatedTitle, 4);
  if (animatedParagraph) animateLetters(animatedParagraph, 4);
});

// Scroll to Top
document.addEventListener("DOMContentLoaded", function () {
  const scrollButton = document.querySelector(".deposark-scroll-top");

  // Afficher/cacher le bouton
  window.addEventListener("scroll", function () {
    if (window.pageYOffset > 200) {
      scrollButton.classList.add("visible");
    } else {
      scrollButton.classList.remove("visible");
    }
  });

  // Animation de défilement
  scrollButton.addEventListener("click", function (e) {
    e.preventDefault();
    window.scrollTo({
      top: 0,
      behavior: "smooth",
    });
  });
});

function aosInit() {
  AOS.init({
    duration: 600,
    easing: "ease-in-out",
    once: true,
    mirror: false,
  });
}
window.addEventListener("load", aosInit);
/**
 * Init swiper sliders
 */
function initSwiper() {
  document.querySelectorAll(".init-swiper").forEach(function (swiperElement) {
    let config = JSON.parse(
      swiperElement.querySelector(".swiper-config").innerHTML.trim()
    );

    if (swiperElement.classList.contains("swiper-tab")) {
      initSwiperWithCustomPagination(swiperElement, config);
    } else {
      new Swiper(swiperElement, config);
    }
  });
}

window.addEventListener("load", initSwiper);

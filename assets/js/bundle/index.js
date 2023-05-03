import clickOutside from "./modules/clickOutside";
import svg from "./modules/svg";
import nav from "./modules/nav";
import mobileMenu from "./modules/mobileMenu";
import toggleClass from "./modules/toggleClass";
import carousel from "./modules/carousel";
import payment from "./modules/payment";
import modals from "./modules/modals";
import slider from "./modules/slider";
import inputNumber from "./modules/inputNumber";
import filtersLocation from "./modules/filtersLocation";
import tab from "./modules/tab";
import spaSlider from "./modules/spaSlider";
import inputFile from "./modules/inputFile";
import contactCv from "./modules/contactCV";
import filterSlider from "./modules/filterSlider";


clickOutside('is-active')
contactCv()
nav()
svg()
mobileMenu()
toggleClass()
carousel()
carousel('.swiper-carousel-services', 3,1,16,24,'','','.swiper-services-pagination','bullets',false,false, 2)
carousel('.swiper-carousel-blog', 3,1,24,24,'','','.swiper-blog-pagination','fraction',false,false, 3)
payment()
modals()
slider()
inputNumber()
filtersLocation()
tab()
spaSlider()
inputFile()
filterSlider()

$(window).on( "load", function() {
    $('.hide-loading').removeClass('hide-loading')
    const height = window.innerHeight - 175;
    const heightBooking = $('.c-booking').outerHeight();
    const heightHead = $('.c-header').outerHeight();
    if(heightBooking > height) {
        $('.c-booking__block--reviews').removeClass('is-active')
    }
})

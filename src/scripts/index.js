import { message } from './message';
import '../styles/main.scss';

// alert(message('MyApp'));

// When the user scrolls the page, execute myFunction
window.onscroll = function() {scrollheader()};

// Get the header
var header = document.getElementById("myHeader");

// Get the offset position of the navbar
var sticky = header.offsetTop;

// Add the sticky class to the header when you reach its scroll position. Remove "sticky" when you leave the scroll position
function scrollheader() {
    if (window.pageYOffset > sticky) {
        header.classList.add("scroll");
} else {
    header.classList.remove("scroll");
    }
}
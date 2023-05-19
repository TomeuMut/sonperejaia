import Swiper from 'swiper/bundle'
import "swiper/css/bundle"

export default function (sliderContainer = '.swiper-slider') {

    function init($this) {

        var  $el = $this.find('.swiper-container'),
            pagination = $this.find('.swiper-pagination'),
            navNext = $this.find('.swiper-slider-next'),
            navPrev = $this.find('.swiper-slider-prev');
        const slider = new Swiper($el[0], {
            effect: 'fade',
            pagination: {
                el: pagination[0]
            },
            // Navigation arrows
            navigation: {
                nextEl: navNext[0],
                prevEl: navPrev[0],
            }
        })
    }
    window.setTimeout(function () {
        var $swiperContainer = $(sliderContainer);
        if ($swiperContainer.length) {
            $swiperContainer.each(function(i, Slider) {
                init($(Slider));
            })
        }
    });

}

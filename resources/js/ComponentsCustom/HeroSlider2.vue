<template>
     <swiper
    :grabCursor="true"
    :effect="'creative'"
    :autoplay="{
      delay: 3000,
      disableOnInteraction: false,
    }"
    :creativeEffect="{
      prev: {
        shadow: true,
        translate: ['-20%', 0, -1],
      },
      next: {
        translate: ['100%', 0, 0],
      },
    }"
    :pagination="{
      clickable: true,
    }"
    :navigation="true"
    :speed="600"
    :modules="modules"
    class="mySwiper3"
    @slideChangeTransitionStart="onSlideChangeTransitionStart"
    @slideChangeTransitionEnd="onSlideChangeTransitionEnd"

  >
    <swiper-slide v-for="(slide_item, slide_item__index)  in slides" :key="slide_item__index"  :class="{ 'previous-slide': slide_item__index === previousSlide, 'active-slide': activeSlide === slide_item__index }">
        <img :src="slide_item">
        <div class="slide-text" :class="{ 'active': activeSlide === slide_item__index, 'next': nextSlide === slide_item__index }"><img class="img-logo" :src="imgLogo"></div>
        <div class="slide-text-discount" :class="{ 'active': activeSlide === slide_item__index, 'next': nextSlide === slide_item__index }"><img class="img-logo" :src="imgDiscount"></div>
        <!-- <div class="slide-text-info" :class="{ 'active': activeSlide === slide_item__index, 'next': nextSlide === slide_item__index }">
            <p class="text-1"><span class="red-text">1/2 KG</span> <span class="green-text">RAVIOLES</span></p>
            <p class="black-text">DE QUESO Y ESPINACA</p>
        </div> -->
        <!-- <div class="slide-text-info-2" :class="{ 'active': activeSlide === slide_item__index, 'next': nextSlide === slide_item__index }"><p class="text-variety">Contamos con una variedad de sabores</p></div>
        <div class="slide-text-info-3" :class="{ 'active': activeSlide === slide_item__index, 'next': nextSlide === slide_item__index }"><p class="text-now">Contamos con una variedad de sabores</p></div> -->
    </swiper-slide>

  </swiper>
  </template>

<script>
  // Import Swiper Vue.js components
  import { Swiper, SwiperSlide } from 'swiper/vue';
  import { Navigation, Pagination} from 'swiper/modules';
  import { EffectCreative } from 'swiper/modules';
  import img7Slider from '../../img/slider/banner_food_d.png'
  import img8Slider from '../../img/slider/banner_food_d.png'
  import imgLogo from '../../img/logo/logo_food.png'
  import imgDiscount from '../../img/slider/discount.png'


  // Import Swiper styles
  import 'swiper/css';
  import 'swiper/css/effect-creative';
//   import './style.css';

  import 'swiper/css/navigation';
  import 'swiper/css/pagination';
  import 'swiper/css/scrollbar';

  export default {

    components: {
      Swiper,
      SwiperSlide,
    },
    data(){
        return{
            slides: [
                img7Slider,
                img8Slider
            ],
            imgLogo,
            imgDiscount,
            activeSlide: 0,
            previousSlide: null,
            nextSlide: 1
        }
    },
    methods: {
      onSlideChangeTransitionStart(swiper) {
        this.previousSlide = this.activeSlide;
        this.activeSlide = swiper.activeIndex;
        this.nextSlide = (swiper.activeIndex + 1) % this.slides.length;

      },
      onSlideChangeTransitionEnd() {
        this.previousSlide = null;
        this.nextSlide = (this.activeSlide + 1) % this.slides.length;

      }
    },
    mounted() {
      this.nextSlide = (this.activeSlide + 1) % this.slides.length;
    },
    setup() {
      return {
        modules: [Navigation, Pagination, EffectCreative],
      };
    //   const onSlideChange = () => {
    //     console.log('slide change');
    //   };
    //   return {
    //     onSwiper,
    //     onSlideChange,
    //     modules: [Navigation, Pagination, EffectCreative],

    //   };
    },
  };
</script>

<style lang="scss" scoped>
*{
  font-family: "Open Sans", sans-serif;

}
    .swiper-creative{
        .swiper-wrapper{
            height: 360px;
            .swiper-slide{
                position: relative;
                img{
                    height: 360px;
                    object-fit: cover;
                    width: 100%;
                    transition: transform 1s ease-in-out, opacity 1s ease-in-out; 
                }
                &.previous-slide img {
                    opacity: 0.5; 
                }
                &.active-slide img {
                    opacity: 1; 
                }
                .slide-text-discount{
                    position: absolute;
                    top: 20%;
                    right: 41%;
                    color: #fff;
                    font-weight: 700;
                    font-size: 24px;
                    opacity: 0;

                    transform: translateY(20px);
                    transition: opacity 1s ease-in-out, transform 1s ease-in-out; /* Ajusta la transición del texto */
                    &.active {
                        opacity: 1;
                        transform: translateY(0);
                    }
                    &.next {
                        opacity: 0;
                        transform: translateY(40px);
                        transition: none;
                    }
                    .img-logo{
                        height: auto;
                    }
                }
                .slide-text-info{
                    position: absolute;
                    top: 35%;
                    right: 3%;
                    opacity: 0;

                    transform: translateY(20px);
                    transition: opacity 1s ease-in-out, transform 1s ease-in-out; /* Ajusta la transición del texto */
                    &.active {
                        opacity: 1;
                        transform: translateY(0);
                    }
                    &.next {
                        opacity: 0;
                        transform: translateY(40px);
                        transition: none;
                    }
                    .img-logo{
                        height: auto;
                    }
                    .text-1{
                        font-weight: 600;
                        font-size: 3.5rem;
                        text-align: center;
                        .red-text{
                            color:#961921;
                        }
                        .green-text{
                            color:#144220;
                        }
                    }
                    .black-text{
                        font-weight: 500;
                        font-size: 2.5rem;
                        color: #000000;
                        text-align: center;
                        margin-top: 1.5rem;
                    }
                    
                }
                .slide-text {
                    position: absolute;
                    top: 10%;
                    right: 6%;
                    color: #fff;
                    font-weight: 700;
                    font-size: 24px;
                    opacity: 0;

                    transform: translateY(20px);
                    transition: opacity 1s ease-in-out, transform 1s ease-in-out; /* Ajusta la transición del texto */
                    &.active {
                        opacity: 1;
                        transform: translateY(0);
                    }
                    &.next {
                        opacity: 0;
                        transform: translateY(40px);
                        transition: none;
                    }
                    .img-logo{
                        height: auto;
                    }
                }
            }
        }
    }
</style>
<template>
    <div class="slide-show-main">
        <Carousel :itemsToShow="1" :wrapAround="true" :transition="500">
            <Slide v-for="slide_item in slides" :key="slide_item">
            <div class="carousel__item">
                <img :src="slide_item">
            </div>
            </Slide>
            <template #addons>
                <Navigation />

                <Pagination v-model="currentPage"/>
            </template>

        </Carousel>
        
    </div>
</template>

<script>
import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'
// import img1Slider from '../../img/slider/banner_1.png'
// import img2Slider from '../../img/slider/1.jpg'
// import img3Slider from '../../img/slider/2.jpg'
// import img4Slider from '../../img/slider/3.jpg'
// import img5Slider from '../../img/slider/4.jpg'
import img6Slider from '../../img/slider/banner_food.png'
import img7Slider from '../../img/slider/banner_food_d.png'

export default {
    data(){
        return{
            currentPage: 0,
            valorInput:"",
            settings: {
                itemsToShow: 3,
                snapAlign: 'center',
                loop: true,
            },

            slides: [
                img7Slider
            ],
        }
    },
    methods:{
        mensaje(){
            alert("esto es una alerta")
        }
    },
    components:{
        Carousel,
        Slide,
        Pagination,
        Navigation
    },
    setup () {
    
        return {}
    }
}
</script>

<!-- <style lang="scss" scoped>
.carousel{
    padding-top: 4rem;
}
.carousel__viewport{
    .carousel__track{
        .carousel__slide{
            width: 100%;
            .carousel__item{
                // min-height: 200px;
                width: 100%;
                height: 100%;
                color: #fff;
                font-size: 20px;
                border-radius: 8px;
                display: flex;
                justify-content: center;
                align-items: center; 
                img{
                    width: 100%;
                }
            }
        }
    }
}
</style> -->
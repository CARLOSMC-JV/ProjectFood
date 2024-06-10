
<script>
import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'
import img01 from '../../img/categories/01.jpg' 
import img02 from '../../img/categories/02.jpg' 
import img03 from '../../img/categories/03.jpg' 
import img04 from '../../img/categories/04.jpg' 
import img05 from '../../img/categories/05.jpg' 
import img06 from '../../img/categories/06.jpg' 

export default {
    props: {
        categories_list: {
            type: Array,
            required: true,
        },
    },
    data(){
        return{
            currentPage: 0,
            img01,
            img02,
            img03,
            img04,
            img05,
            img06,
            settings: {
                itemsToShow: 1,
                snapAlign: 'center',
                loop: true,
            },
            breakpoints: {
                // 700px and up
                700: {
                    itemsToShow: 1,
                    snapAlign: 'center',
                },
                // 1024 and up
                1024: {
                    itemsToShow: 6,
                    snapAlign: 'start',
                },

            },
            slides: [
                img01,
                img02,
                img03,
                img04,
                img05,
                img06,
            ],
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
<template>
    <div>
        <Carousel v-bind="settings" :wrapAround="true" :transition="500" :breakpoints="breakpoints">
            <!-- <Slide v-for="slide_item in slides" :key="slide_item">
                <div class="carousel__item"><img class="img-product" :src="slide_item"></div>
            </Slide> -->
            <Slide v-for="category in categories_list" :key="category.id">
                <a class="carousel__item__category" :href="route('categoria.index', { categoria: category.id })">
                    <!-- <img class="img-product" :src="category.name"> -->
                    <h3 class="title-category">{{ category.name }}</h3>
                </a>
            </Slide>
            <template #addons>
                <Navigation />

                <Pagination v-model="currentPage"/>
            </template>

        </Carousel>
    </div>
</template>

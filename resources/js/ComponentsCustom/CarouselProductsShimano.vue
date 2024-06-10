
<script>
import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'
import img01 from '../../img/shop/01.jpg' 
import img02 from '../../img/shop/02.jpg' 
import img03 from '../../img/shop/03.jpg' 
import img04 from '../../img/shop/04.jpg' 
import img05 from '../../img/shop/05.jpg' 
import img06 from '../../img/shop/06.jpg' 

export default {
    props: {
        products: {
            type: Array,
            required: true,
        }
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
                    itemsToShow: 4,
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
    methods:{
        redirectToProductDetails(category, product) {
                this.$inertia.visit(route('product.details', { category: category, id: product.id }));
        },
    },
    components:{
        Carousel,
        Slide,
        Pagination,
        Navigation
    },
    created(){
        console.log(this.products)
    },
    setup () {
    
        return {}
    }
}
</script>
<template>
    <div>
        <Carousel v-bind="settings" :wrapAround="true" :transition="500" :breakpoints="breakpoints">
            <Slide v-for="product in products" :key="product.id" @click="redirectToProductDetails(product.subcategory.category.name, product)">
                <div class="carousel__item">
                    <img class="img-product" :src="product.image">
                    <!-- Puedes mostrar otros detalles del producto aquí -->
                    <h3 class="name-product">{{ product.name }}</h3>
                    <p>S/. {{ product.price }}.00</p>
                </div>
            </Slide>
            <template #addons>
                <Navigation />

                <Pagination v-model="currentPage"/>
            </template>

        </Carousel>
    </div>
</template>

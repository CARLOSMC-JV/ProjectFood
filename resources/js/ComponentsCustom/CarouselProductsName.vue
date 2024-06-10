
<script>
import { ref } from 'vue';

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
                // loop: true,
                // perPage: 1
            },
            breakpoints: {
                // 700px and up
                700: {
                    itemsToShow: 1,
                    snapAlign: 'center',
                },
                // 1024 and up
                1024: {
                    itemsToShow: 5,
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
    computed: {
        groupedProducts() {
            // Agrupar productos por nombre
            const groupedByName = this.groupProductsByName(this.products);

            // Ajustar la lógica para agrupar los productos según la cantidad de elementos que se muestran en cada diapositiva
            const itemsPerSlide = this.settings.itemsToShow;
            return this.chunkArray(groupedByName, itemsPerSlide);
        },
    },
    methods: {
        groupProductsByName(products) {
            const groupedProducts = {};

            products.forEach((product) => {
                const name = product.name;

                if (!groupedProducts[name]) {
                groupedProducts[name] = [];
                }

                groupedProducts[name].push(product);
            });

            return Object.values(groupedProducts);
        },
        chunkArray(array, size) {
            const chunkedArray = [];
            for (let i = 0; i < array.length; i += size) {
                chunkedArray.push(array.slice(i, i + size));
            }
            return chunkedArray;
        },
        // removeDuplicates() {
        //     this.products = [...new Set(this.products)];
        // },
    },
    created(){
        console.log(this.products);
        // this.products = [...new Set(this.products)];

    },
    setup() {
        // const products = ref([]);

        // const removeDuplicates = () => {
        //     products.value = [...new Set(products.value)];
        // };

        // return {
        //     products,
        //     removeDuplicates,
        // };
    },
}
</script>
<template>
    <div>
        <Carousel v-bind="settings" :breakpoints="breakpoints" :wrapAround="true">
            <Slide v-for="(slide, index) in products" :key="slide">
                <div class="carousel__item">
                    <!-- <div v-for="(product, index) in slide" :key="index"> -->
                        <img class="img-product" :src="slide.image">
                            <p>{{ index+1 }}</p>
                            <p class="product-name">{{ slide.name }}</p>
                            <p class="product-price">S/. {{ slide.price }}</p>

                    <!-- </div> -->

                </div>
            </Slide>

            <template #addons>
                <Navigation />

                <!-- <Pagination v-model="currentPage" :numberOfPages="groupedProducts.length"/> -->
            </template>

        </Carousel>
    </div>
</template>

<script>
import carousel from 'vue-owl-carousel'
import img01 from '../../img/shop/01.jpg'
import img02 from '../../img/shop/02.jpg'
import img03 from '../../img/shop/03.jpg'
import img04 from '../../img/shop/04.jpg'
import img05 from '../../img/shop/05.jpg'
import img06 from '../../img/shop/06.jpg'
import { Splide, SplideSlide } from '@splidejs/vue-splide';
import '@splidejs/vue-splide/css';
import '@splidejs/vue-splide/css/sea-green';

export default {
    props: {
        products: {
            type: Array,
            required: true,
        },

    },
    data(){
        return{
            img01,
            img02,
            img03,
            img04,
            img05,
            img06,
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
    created(){
        console.log("estos ",this.products)
    },
    components: {
        carousel,
        Splide,
        SplideSlide,
    },
    methods:{
        openGetInfoByWhatsapp(product, event){
                let urlOfProduct="https://bikeperushop.pe/product/bottom-bracket-sram-dub-bsa-68-73mm-a-granel/"
                let customMessage=`Hola+Bicizona+estoy+interesado+en+este+producto *+${product.name}+*%0AURL: %20${urlOfProduct}`
                event.stopPropagation();
                event.preventDefault();

                console.log(product)
                console.log(customMessage)
                let whatsappurl = `https://api.whatsapp.com/send?phone=51997315973&text=${customMessage}`
                window.open(
                    whatsappurl,
                    '_blank' 
                );
        },  
    }
}
</script>

<template>
    <div>

        <!-- <carousel v-for="slide in slides" :key="slide">
            <template v-slot:prev><span class="prev">prev</span></template>

            <img :src="slide" alt="">

            <template v-slot:next><span class="next">next</span></template>

        </carousel> -->

        <Splide :options="{ perPage: 5, rewind: true }" aria-label="My Favorite Images">
            <SplideSlide v-for="slide in products" :key="slide">
                <!-- <div class="carousel__item">
                    <img class="img-product" :src="slide.image">
                    <div class="section-data">
                        <p class="product-name">{{ slide.name }}</p>
                        <p class="product-price">S/. {{ slide.price }}</p>
                    </div>
                </div> -->
                <a :whatsapp-link="'https://api.whatsapp.com/send?phone=TUNUMERO&text=Hola,%20estoy%20interesado%20en%20el%20producto:%20'+ encodeURIComponent(slide.name) + '%20-%20Precio:%20' + slide.price">

                    <div class="carousel__item">
                        <img class="img-product" :src="slide.images.length>0 ? slide.images[0].image_path : slide.image" alt="">
                        <div class="section-data">
                            <p class="product-name">{{ slide.name }}</p>
                            <p class="product-price">S/. {{ slide.price }}</p>
                            <a class="button-show" @click.stop="openGetInfoByWhatsapp(slide, $event)">Consultar por Whatsapp</a>

                        </div>
                    </div>
                </a>
            </SplideSlide>
        </Splide>
    </div>
</template>



<style>
/* Add your custom styles here */
.thumbnails {
  display: flex;
  margin: 1rem auto 0;
  padding: 0;
  justify-content: center;
}

.thumbnail {
  width: 70px;
  height: 70px;
  overflow: hidden;
  list-style: none;
  margin: 0 0.2rem;
  cursor: pointer;
}

.thumbnail img {
  width: 100%;
  height: auto;
}

</style>
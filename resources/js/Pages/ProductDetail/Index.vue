<script>
    import MainNavCustom from "@/ComponentsCustom/MainNavCustom.vue";
    import { Head, useForm } from '@inertiajs/vue3';
    import Footer from "@/ComponentsCustom/Footer.vue";
    import CarouselSplideGallery from "@/ComponentsCustom/CarouselSplideGallery.vue";

    export default {
        data() {
            return {
                descriptionProduct:'',
            }
        },
        components:{
            MainNavCustom,
            Head,
            Footer,
            CarouselSplideGallery
        },
        props:{
            product: {type: Object},
        },
        created(){
        }
    }
</script>

<template>
    <div>
        <Head :title="product.name" />
        <MainNavCustom/>
        <div id="product_detail">
            <div class="box-detail-product">
                <p>
                    <!-- <a :href="route('home')">Inicio</a> / <a :href="route('categoria.index', { categoria: product.category })">{{ product.category }}</a> / {{ product.subcategory ? product.subcategory.name : '' }} / {{ product.name }} -->
                </p>

                <div class="container-image">
                    <div class="img-left">
                        <!-- <img :src="product.image" alt=""> -->
                        <CarouselSplideGallery :product="product"></CarouselSplideGallery>
                    </div>
                    <div class="data-right">
                        <p class="text-product-small">{{ product.category }} - {{ product.subcategory ? product.subcategory.name : '' }}</p>
                        <p class="text-product">{{ product.name }}</p>
                        <p class="text-price">S/. {{ product.price }}</p>
                        <p class="text-product-small">{{ product.name }}</p>

                        <!-- <p class="text-product-small">{{ product.description }}</p> -->

                        <a class="button-show">Consultar por whatsapp</a>

                        <section class="container-questions">
                            <section class="form-container-body first-section">
                                <div class="border-box">
                                    <div class="chevron-down" @click="descriptionProduct=!descriptionProduct">
                                        <h4 class="title-questions">INFORMACIÓN DEL PRODUCTO</h4>
                                        <div class="background-circle"> <i class="fa fa-angle-down chevron-icon" v-bind:class="[ descriptionProduct ? 'rotatechev' : '']"></i> </div>
                                    </div>
                                    <div class="questions-general" v-show="descriptionProduct">
                                        <p class="detail-answer">{{ product.description }}</p>                       
                                    </div>
                                </div>
                            </section>
                        </section>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <Footer />
</template>



<style lang="scss" scoped>

</style>

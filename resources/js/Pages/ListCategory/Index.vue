<script>
    import MainNav3 from "@/ComponentsCustom/MainNav3.vue";
    import imgBackground from "../../../img/list_category/img-back.png";
    import angleRight from "../../../img/list_category/angle-right.svg";
    import angleRightWhite from "../../../img/list_category/angle-right-white.svg";
    import imgBackgroundAccessories from "../../../img/list_category/accesories-back.png";
    import imgBackgroundIndumentaria from "../../../img/list_category/back-indumentaria.png";
    import Footer from "@/ComponentsCustom/Footer.vue";
    import CarouselProductsShimano from '@/ComponentsCustom/CarouselProductsShimano.vue';

    import { Head, useForm } from '@inertiajs/vue3';

    export default {
        data() {
            return {
                is_bike: false,
                is_accesories: false,
                is_clothes: false,
                is_brands: false,
                imgBackground,
                angleRight,
                angleRightWhite,
                imgBackgroundAccessories,
                imgBackgroundIndumentaria,
                hoveredIndex: null,
                productsShimano:[
                    {
                        id: 1,
                        name: "CAMBIO SHIMANO 7-8V. RD-M360-L, ACERA, SGS 7-8 SPEED",
                        description: null, 
                        image: "https://res.cloudinary.com/drza9lfnl/image/upload/v1705794330/marcas/cambio-shimano_gtof6n.webp",
                        price: 190.00
                    },
                    {
                        id: 2,
                        name: "MAZA TRASERA 11V SHIMANO DEORE XT FH-M8010-B",
                        description: null, 
                        image: "https://res.cloudinary.com/drza9lfnl/image/upload/v1705794328/marcas/maza-trasera-shimano_vaggpj.webp",
                        price: 450.00
                    },
                    {
                        id: 3,
                        name: "CABLE DE CAMBIO 1.2X2100 MM SHIMANO",
                        description: null, 
                        image: "https://res.cloudinary.com/drza9lfnl/image/upload/v1705794328/marcas/cable-cambio_huqkrh.webp",
                        price: 10.00
                    },
                    {
                        id: 4,
                        name: "CAMBIO DELANTERO 3X8-7V SHIMANO TOUR-NEY TX FD-TX800-TS6",
                        description: null, 
                        image: "https://res.cloudinary.com/drza9lfnl/image/upload/v1705794329/marcas/cambio-delantero_b3i4is.webp",
                        price: 45.00
                    },
                    {
                        id: 5,
                        name: "CALIPER DELANTERO MECANICO SHIMANO TOURNEY TX BR-TX805",
                        description: null, 
                        image: "https://res.cloudinary.com/drza9lfnl/image/upload/v1705794329/marcas/clipper-delantero_dukx3c.webp",
                        price: 110.00
                    },
                    {
                        id: 6,
                        name: "CABLE DE FRENO 1.6X2050 MM SHIMANO",
                        description: null, 
                        image: "https://res.cloudinary.com/drza9lfnl/image/upload/v1705794328/marcas/cambio-freno_t51van.webp",
                        price: 10.00
                    }
                ]
            }
        },
        components:{
            MainNav3,
            Head,
            Footer,
            CarouselProductsShimano
        },
        props:{
            categories:{type: Array},
            classCategoryName: { type: String }
        },
        created(){
            console.log(this.categories)
            console.log(this.classCategoryName)
            const lowerCaseCategoryName = this.classCategoryName.toLowerCase();

            switch (lowerCaseCategoryName) {
                case 'bicicletas':
                    this.is_bike=true
                break;

                case 'accesorios':
                    this.is_accesories=true
                break;

                case 'indumentaria':
                    this.is_clothes=true
                break;

                case 'marcas':
                    this.is_brands=true
                break;
            
                default:
                    break;
            }
        },
        methods:{
            setHoveredIndex(index) {
                this.hoveredIndex = index;
            },
            redirectToCategorySelect(category) {
                this.$inertia.visit(route('categoria.index', { categoria: category.name }));
            },
        },
        computed:{
            computedBackground() {
                if (this.is_accesories) {
                    return { 'background-image': `url('${imgBackgroundAccessories}')` };
                } else if (this.is_bike) {
                    return { 'background-image': `url('${imgBackground}')` };
                } else if (this.is_clothes) {
                    return { 'background-image': `url('${imgBackgroundIndumentaria}')` };
                } else if (this.is_brands) {
                    return { 'background-color': 'rgb(39, 33, 30)' };
                }
            },
        }
    }
</script>

<template>
        <Head :title="`${classCategoryName} | Bicizona`" />
        <MainNav3/>

        <div class="container-list-category">
            <div class="container-title">
                <h2 class="title-category">{{classCategoryName}}</h2>
                <h2 class="title-category" v-if="is_brands">SHIMANO</h2>

                <p class="subtitle" v-if="is_bike">Una experiencia de compra como ninguna otra</p>
                <p class="subtitle" v-else-if="is_accesories">Mejora tu experiencia en bicicleta con nuestros accesorios de alta calidad. Desde la seguridad hasta la comodidad, tenemos lo que necesitas.</p>
                <p class="subtitle" v-else-if="is_clothes">La seguridad es clave, así que equípate con cascos de MTB, ruta o urbanos, protecciones, guantes y una amplia gama de ropa para todas las estaciones.</p>
                <p class="subtitle" v-else-if="is_brands">Como sinónimo de excelencia en el mundo del ciclismo, Shimano es la marca que nos acompaña en cada aventura. Su tecnología de vanguardia y su compromiso con la innovación son el motor que impulsa nuestras bicicletas hacia el futuro.</p>
            </div>

            <div class="contain-select-list" :style="computedBackground">
                <h2 class="title-bike-select" v-if="is_bike">¿Qué tipo de bicicleta estas buscando?</h2>
                <h2 class="title-bike-select" v-else-if="is_accesories">¿Qué accesorios estas buscando?</h2>
                <h2 class="title-bike-select" v-else-if="is_clothes">¿Qué indumentaria estas buscando?</h2>
                <div class="section-carousel-shimano" v-else-if="is_brands">
                    <!-- <h2 class="title-bike-select">Productos</h2>
                    <CarouselProductsShimano :products="productsShimano"></CarouselProductsShimano> -->

                </div>
                <div class="box-categories">
                    <div v-for="(cat, cat__index) in categories" :key="cat__index" class="item-category">
                        <a class="button-show" @mouseover="setHoveredIndex(cat__index)"
                    @mouseleave="setHoveredIndex(null)" @click="redirectToCategorySelect(cat)">Selecciona<img :src="hoveredIndex === cat__index ? angleRight : angleRightWhite"></a>

                        <h2 class="number-categorie">0{{ cat__index + 1 }}</h2>
                        <h2 class="title-categorie">{{ cat.name }}</h2>
                    </div>
                </div>
            </div>

            
        </div>


        <Footer />
    
</template>


<style lang="scss" scoped>

</style>
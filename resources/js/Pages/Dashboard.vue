<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import HeroSlider from "@/ComponentsCustom/HeroSlider.vue";
import HeroSlider2 from "@/ComponentsCustom/HeroSlider2.vue";
import MainNav3 from "@/ComponentsCustom/MainNav3.vue";
import MainNavCustom from "@/ComponentsCustom/MainNavCustom.vue";
import ListProductsMain from "@/ComponentsCustom/ListProductsMain.vue";
import FooterVue from "@/ComponentsCustom/Footer.vue";
import PopularCategories from "@/ComponentsCustom/PopularCategories.vue";
import { useStore } from '@/store';

export default {
    props: {
        latestProducts: {
            type: Array,
            required: false,
        },
        categories: {
            type: Array,
            required: true,
        },
        cart: {
            type: Array,
            required: false,
            default: () => [],   
        },
    },
    head() {
        return {
            title: 'Título de tu página',
            link: [
                {
                rel: 'icon',
                type: 'image/x-icon',
                href: 'https://res.cloudinary.com/drza9lfnl/image/upload/v1717364627/logo/logo_food_yefp0z.png' 
                }
            ]
        };
    },
    data(){
        return{
            // latestProducts: [],

        }
    },
    methods:{

    },

    components:{
        Head,
        AuthenticatedLayout,
        HeroSlider,
        HeroSlider2,
        MainNav3,
        MainNavCustom,
        ListProductsMain,
        FooterVue,
        PopularCategories,
    },
    setup(props) {
        const store = useStore();
        
        store.initializeCart(props.cart);
        console.log(store.cart);

        store.setLatestProducts(props.latestProducts);
        store.setCategories(props.categories);
        return {
            latestProducts: store.latestProducts,
            categories: store.categories,
            cart: store.cart,
        };
    },
}
</script>

<template>
    <Head title="LA CASA DE LOS RAVIOLES" />
    <div class="box-general">

        <MainNavCustom :latestProducts="latestProducts" :cart="cart"/>

        <HeroSlider2/>
        <ListProductsMain :latest-products="latestProducts" :cart="cart"/>
        <!-- <PopularCategories :categories="categories"/> -->
        <FooterVue />
        <AsistanChef />
    </div>

</template>



<script>
    import MainNav3 from "@/ComponentsCustom/MainNav3.vue";
    import { Head, useForm } from '@inertiajs/vue3';

    export default {
        components:{
            MainNav3,
            Head
        },
        props:{
            products: {type: Object},
            subcategory: {type: String},
            category: {type: String},

        },
        created(){
            console.log(this.subcategory);
            console.log(this.products);
        }
    }
</script>

<template>
    <Head :title="'Bicicletas ' + subcategory" />

    <MainNav3/>
    <div class="section-product">

        <h2 class="text-product">Bicicletas {{subcategory}}: {{ category }}</h2>
    </div>
</template>

<style lang="scss" scoped>
    .text-product{
        margin-top: 8rem;
        margin-left: 5rem;
    }
</style>
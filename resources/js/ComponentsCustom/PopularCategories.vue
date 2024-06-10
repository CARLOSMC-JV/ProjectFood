
<script>
    import CarouselCategories from '@/ComponentsCustom/CarouselCategories.vue';
    import { useStore } from '@/store';

    export default {
        components:{
            CarouselCategories
        },
        props:{
            categories: {
                type: Array,
                required: true,
            },
        },
        setup(props) {
            const productStore = useStore();
            // Actualizar los productos en el store cuando cambian las props
            productStore.setCategories(props.categories);
            return {
                productStore,
            };
    },
    }
</script>

<template>
    <div class="categories">
        <section class="list-products-new">
            <div class="box-title-products">
                <h2 class="title">Categorias</h2>
                <span class="sub-title">Echa un vistazo a nuestras categorias</span>
            </div>
        
            <CarouselCategories :categories_list="categories"></CarouselCategories>
        </section>
    </div>
</template>

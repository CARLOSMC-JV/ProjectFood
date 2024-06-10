

<script>
    import MainNavCustom from "@/ComponentsCustom/MainNavCustom.vue";
    import BaseSelectGeneric from "@/ComponentsCustom/BaseSelectGeneric";
    import { Head, useForm } from '@inertiajs/vue3';
    import SelectInput from '@/Components/SelectInput.vue'
    import Footer from "@/ComponentsCustom/Footer.vue";
    import CarouselProductsName from '@/ComponentsCustom/CarouselProductsName.vue';
    import CarouselSplide from '@/ComponentsCustom/CarouselSplide.vue';
    import PrimaryButton from "@/Components/PrimaryButton.vue";
    import iconMore from '../../../img/more-icon.png';
    import  {useToast}  from 'vue-toastification';
    import { useStore } from '@/store';

    export default {
        data() {
            return {
                currentPage: 1,
                totalProductsForCategory: 0,
                perPage: 12,
                filter_category:{
                    search_category:0
                },
                filter: {
                    search_name_product: "",
                },
                currentPage: 1,
                number_pages:undefined,
                subcategoryOptions:undefined,
                subCategoryId: undefined,
                iconMore
            }
        },
        components:{
            MainNavCustom,
            BaseSelectGeneric,
            Head,
            SelectInput,
            Footer,
            CarouselProductsName,
            CarouselSplide,
            PrimaryButton
        },
        props:{
            products: {type: Object},
            category: {type: String},
            class_category: {type: String},
            cart: {
                type: Object,
                required: true,
                default: () => [],      
            },
        },
        created(){
            console.log(this.products);
            console.log(this.category_list);
            console.log(this.class_category);

            this.number_pages = Math.ceil(this.products.length / this.perPage);

        },
        computed:{
            formatPrice: function(value) {
                console.log(typeof value)
                // const number = parseFloat(value);
                return value.toFixed(2);

            },
            totalPages() {
                return Math.ceil(this.totalProductsForCategory / this.perPage);
            },
            filteredProducByCategory: function(){
                if (this.products) {
                    const startIndex = this.perPage * (this.currentPage - 1);
                    const endIndex = startIndex + this.perPage;
                    let filtered = this.products;

                    const selectedCategoryId = Number(this.filter_category.search_category);

                    if (selectedCategoryId !== 0) {
                        filtered = filtered.filter(document => document.subcategory_id === selectedCategoryId);
                    }else{
                        this.totalProductsForCategory = 0;
                    }

                    if (this.filter.search_name_product) {
                        if (selectedCategoryId !== 0) {
                            filtered = filtered.filter(document => document.name.toLowerCase().includes(this.filter.search_name_product.toLowerCase()));
                        } else {
                            filtered = this.products.filter(document => document.name.toLowerCase().includes(this.filter.search_name_product.toLowerCase()));
                        }
                    }
                    this.totalProductsForCategory = filtered.length;

                    const arrayReduced = filtered.slice(startIndex, endIndex);

                    return arrayReduced;
                }else{
                    return []
                }
            },
        },
        methods: {
            async addToCart(productId) {
                try {
                    const response = await this.$inertia.post('/cart/add', {
                    product_id: productId,
                    quantity: 1,
                    });
                    this.toast.success("Producto agregado correctamente");
                    

                } catch (error) {
                    console.error(error);
                    this.toast.error('Hubo un problema al agregar el producto');

                }
            },
            redirectToProductDetails(category, product) {
                console.log(category)
                this.$inertia.visit(route('product.details', { categoria2: category, id: product.id }));
            },
            getProductsBySubcategory(subcategoryId) {
                this.subCategoryId=subcategoryId
                if (subcategoryId === null || subcategoryId === undefined) {
                    return this.products.filter(product => product.subcategory_id === null || product.subcategory_id === undefined);
                }else{
                    console.log("filtro ",this.products.filter(product => product.subcategory_id == subcategoryId))
                    return this.products.filter(product => product.subcategory_id == subcategoryId);
                }
            },
            prevPage(){
                if(this.currentPage>1){
                    this.currentPage--;
                }
            },
            nextPage(){
                if(this.currentPage<this.number_pages){
                    this.currentPage++;
                }
            },
            goToPageNumber(pageNumber){
                if (pageNumber >= 1 && pageNumber <= this.number_pages) {
                    setTimeout(() => {
                        this.scrollToTop();
                    }, 100);
                    this.currentPage = pageNumber;
                }
            },
            scrollToTop() {
                window.scrollTo(0,0);
            },
        },
        setup(props) {
            const toast = useToast();
            const store = useStore();

            store.initializeCart(props.cart);

            return { toast,      
                cart: store.cart, 
            };
        },
    }
</script>

<template>
    <Head :title="class_category" />

    <MainNavCustom :category-active="class_category" :cart="cart"/>

    <div id="category_product">
        <div class="section-product">
            <div class="list-documents">

                <h2 class="title-category"> {{ class_category }}</h2>
                <template v-if="filteredProducByCategory.length">
                    <div class="box-documents">

                        <div class="document-item" v-for="(productByCategoryItem) in filteredProducByCategory" :key="productByCategoryItem.id" >
                            <div class="box-data-document">
                                <div class="box-img-data" @click="redirectToProductDetails(productByCategoryItem.class_categories_id, productByCategoryItem)">
                                    <img :src="productByCategoryItem.images.length>0 ? productByCategoryItem.images[0].image_path : productByCategoryItem.image" alt="" class="img-preview">
                                </div>
                                    
                                    
                                <div class="data-product">   
                                    <div class="box-data-general">
                                        <h2 class="title-item" @click="redirectToProductDetails(productByCategoryItem.class_categories_id, productByCategoryItem)">{{productByCategoryItem.name}}</h2>
                                        <h2 class="title-desription">{{productByCategoryItem.description}}</h2> 
                                        <h2 class="title-price">S/. {{(productByCategoryItem.price).toFixed(2)}}</h2>
                                    </div>
                                    <div class="box-button-general">
                                        <div class="box-button-more">
                                            <button class="button-show" @click.stop="addToCart(productByCategoryItem.id)"><img :src="iconMore"></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-price">
                                    <h2 class="title-price">S/. {{(productByCategoryItem.price).toFixed(2)}}</h2>
                                    <button class="button-buy" @click.stop="openGetInfoByWhatsapp(productByCategoryItem)">Comprar</button>
                                </div>
                            </div>

                        </div>
                    </div>
                    <nav class="pt-1 ml-auto" aria-label="Pagination">
                        <ul class="pagination mb-0">
                            <li class="page-item d-sm-none">
                                <span class="page-link page-link-static">1 / 5</span>
                            </li>

                            <div class="contain-number">
                                <button class="button-left"  @click="prevPage" :disabled="currentPage===1" :class="[currentPage===1 ? 'disabled-button': '']">
                                    <i class="fa-solid fa-angle-left" style="color: #17696a;"></i>
                                </button>

                                <li class="page-item d-none d-sm-block number-page" style="cursor: pointer;" aria-current="page"  @click="goToPageNumber(page)" v-for="page in totalPages" :key="page" :class="{ 'active-div': page === currentPage }">
                                    <span class="page-link">{{page}}
                                    </span>
                                </li>

                                <button class="button-rigth" @click="nextPage" :disabled="number_pages===currentPage" :class="[number_pages===currentPage ? 'disabled-button': '']">
                                    <i class="fa-solid fa-angle-right" style="color: #17696a;"></i>
                                </button>
                            </div>


                        </ul>
                    </nav>
                </template>

                <template v-else>
                    <template v-if="products">
                    <div class="document-list-searched">
                        <div class="box-document-empty">
                            No se encontraron productos con relación a su busqueda
                        </div>
                    </div>
                    </template>
                    <template v-else>
                        <div class="document-list-searched">
                            <div class="box-document-empty">
                                Aun no se ha subido ningún producto
                            </div>
                        </div>
                    </template>
                </template>
            </div>

        </div>
    </div>
    <AsistanChef />

    <Footer />
</template>

<style>
*{
    font-family: "Montserrat", sans-serif;
  font-optical-sizing: auto;

  font-style: normal;


}
</style>



<script>
    import MainNav3 from "@/ComponentsCustom/MainNav3.vue";
    import BaseSelectGeneric from "@/ComponentsCustom/BaseSelectGeneric";
    import { Head, useForm } from '@inertiajs/vue3';
    import SelectInput from '@/Components/SelectInput.vue'
    import Footer from "@/ComponentsCustom/Footer.vue";
    import axios from 'axios'; 

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
                filteredProducts: undefined,
                id_sub: undefined
            }
        },
        components:{
            MainNav3,
            BaseSelectGeneric,
            Head,
            SelectInput,
            Footer
        },
        props:{
            products: {type: Object},
            category: {type: String},
            category_list: {type: Array },
            subcategory: {type: String},
            subcategory_id: {type: Number}
        },
        created(){
            console.log("este es el producto by category ",this.products)
            console.log(this.category)
            console.log(this.category_list)
            console.log(this.subcategory)
            console.log(this.subcategory_id)
            this.number_pages = Math.ceil(this.products.length / this.perPage);
            this.category_list.unshift({ id: 0, name: "Todas las subcategorías" });
            this.filterProductsBySubcategory()
        },
        computed:{
            totalPages() {
                return Math.ceil(this.totalProductsForCategory / this.perPage);
            },
            filteredProducByCategory: function(){
                if (this.filteredProducts) {
                    console.log(this.filteredProducts)
                    const startIndex = this.perPage * (this.currentPage - 1);
                    const endIndex = startIndex + this.perPage;
                    let filtered="";
                    if(this.id_sub==undefined){
                        filtered = this.filteredProducts;
                    }else{
                        filtered = this.products;
                    }

                    // Convertir this.filter_category.search_category a un número
                    const selectedCategoryId = Number(this.filter_category.search_category);

                    if (selectedCategoryId !== 0) {
                        // Filtrar por subcategoría si no se elige "Todas las subcategorías"
                        filtered = filtered.filter(document => document.subcategory_id === selectedCategoryId);
                    }else{
                        this.totalProductsForCategory = 0;
                    }

                    if (this.filter.search_name_product) {
                        if (selectedCategoryId !== 0) {
                            // Si se eligió una subcategoría, filtrar también por nombre
                            filtered = filtered.filter(document => document.name.toLowerCase().includes(this.filter.search_name_product.toLowerCase()));
                        } else {
                            // Si se eligió "Todas las subcategorías," solo filtrar por nombre
                            filtered = this.products.filter(document => document.name.toLowerCase().includes(this.filter.search_name_product.toLowerCase()));
                        }
                    }
                    this.totalProductsForCategory = filtered.length;

                    // Aplicar paginación a los resultados filtrados
                    const arrayReduced = filtered.slice(startIndex, endIndex);

                    return arrayReduced;
                }else{
                    return []
                }
            },
        },
        methods: {
            openGetInfoByWhatsapp(product){
                let urlOfProduct="https://bikeperushop.pe/product/bottom-bracket-sram-dub-bsa-68-73mm-a-granel/"
                let customMessage=`Hola+Bicizona+estoy+interesado+en+este+producto *+${product.name}+*%0AURL: %20${urlOfProduct}`

                console.log(product)
                console.log(customMessage)
                let whatsappurl = `https://api.whatsapp.com/send?phone=51997315973&text=${customMessage}`
                window.open(
                    whatsappurl,
                    '_blank' 
                );
            },  
            redirectToProductDetails(category, product) {
                this.$inertia.visit(route('product.details', { category: category, id: product.id }));
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

            filterProductsBySubcategory(id_sub) {
                console.log(id_sub)
                this.id_sub=id_sub
                if(this.id_sub==undefined){
                    if(this.subcategory_id > 0){

                        this.filteredProducts=this.products.filter(product =>
                            product.subcategory_id === this.subcategory_id
                        );
                    }else{
                        this.filteredProducts=this.products
                    }

                }
            },
        },
    }
</script>

<template>
    <Head :title="category" />

    <MainNav3/>
    <div id="category_product">
        <div class="section-product">
            <div class="section-box-title">
                <h2 class="title-category">{{ category }}</h2>
                <p v-if="category=='CASCOS'">"Protege tu cabeza con estilo. Encuentra el casco que se adapte a tu tipo de ciclismo y personalidad."</p>
                <p v-if="category=='HIDRATACIÓN'">"Mantente en movimiento con nuestras botellas, porta botellas y mochilas diseñadas para hidratarte en cualquier aventura."</p>
                <p v-if="category=='INFANTIL'">"El viaje comienza temprano. Desde los primeros paseos hasta las primeras carreras, nuestras bicicletas infantiles crecen contigo."</p>
            </div>
            <div class="list-documents">
                <div class="section-title">
                    <div class="title-subtitle">
                        <span> {{ category }}</span>
                    </div>
                    <div class="box-filter">
                        <div class="search-ads">
                            <div class="control has-icons-left">
                                <input autocomplete="off" class="input" type="text" placeholder="Busca tu producto aqui" style="height: 40px" v-model.trim="filter.search_name_product">
                                <span class="icon is-small is-left"> <i class="fa fa-search"></i> </span>
                            </div>
                        </div>
                        <div class="box-select-filter">
                            <SelectInput class="select-category" :options="category_list" id="department_id" v-model="filter_category.search_category"  @change="filterProductsBySubcategory(filter_category.search_category)"
                            >
                                <option :value="null">Seleccionar una categoría</option>

                                <template v-for="cat in category_list" :key="cat.id">
                                    <option :value="cat.id">{{ cat.name }}</option>
                                </template>
                            </SelectInput>
                        </div>

                    </div>

                </div>
                <template v-if="filteredProducByCategory.length">
                    <div class="box-documents">
                        <div class="document-item" v-for="(productByCategoryItem) in filteredProducByCategory" :key="productByCategoryItem.id" @click="redirectToProductDetails(category, productByCategoryItem)">
                            <div class="box-data-document">
                                <img  :src="productByCategoryItem.images.length>0 ? productByCategoryItem.images[0].image_path : productByCategoryItem.image" alt="" class="img-preview">
                                <div class="data-product">
                                    <h2 class="title-item">{{productByCategoryItem.name}}</h2>
                                    <h2 class="title-price">S/. {{productByCategoryItem.price}}</h2>
                                    <a class="button-show" @click.stop="openGetInfoByWhatsapp(productByCategoryItem)">Consultar por Whatsapp</a>
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
                                    <i class="fa-solid fa-angle-left"></i>
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

    <Footer />
</template>

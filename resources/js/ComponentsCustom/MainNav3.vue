<template>
    <div id="main-nav-principal" v-click-outside="closeNavbar">
        <nav class="navbar">
            <NavLink :href="route('home')">
                    <img :src="iconlogoPage" alt="" class="logo-main">
                </NavLink>
        <div class="menu-container">
            <ul class="mega-menu">

                <li class="dropdown" v-for="classCategory in categorias" :key="classCategory.id" :class="[classCategory.name === 'Marcas' ? 'marcas' : '' ]">
                    <div :class="[classCategory.showMenu ? 'active' : '']" class="contain-categoria-superior" @click="mobileDeviceCamera ? toggleSubMenu(classCategory) : redirectToListCategory(classCategory.id)">
                        <span class="title-categoria-superior">{{ classCategory.name }}</span>
                        <span class="material-symbols-outlined">
                            chevron_right
                        </span>
                    </div>
                    <ul class="menu" :class="classCategory.showMenu ? 'active' : ''">

                        <li v-for="category in classCategory.categories"
                                        :key="category.id"
                                        :href="route('categoria.index', { categoria: category.id })"
                                        class="sub-dropdown">
                            <div  @click="mobileDeviceCamera ? toggleCategorySubmenu(classCategory, category) : ''" :href="route('categoria.index', { categoria: category.id })" v-show="classCategory.showMenu">
                                <span>{{category.name}}</span>
                                <span class="material-symbols-outlined">
                                    chevron_right
                                </span>
                            </div>
                            <ul class="sub-menu">
                                <a class="title-category-desktop" :href="route('categoria.index', { categoria: category.id })">{{category.name}}</a>
                                <div class="menu-item-box">
                                    <li v-for="subcategory in category.subcategories" :key="subcategory.id">
                                        <template v-if="!mobileDeviceCamera">
                                            <!-- :href="route('show_more_products.index', { categoria: category })" -->
                                            <a :href="route('subcategorias.index', { categoria: category.name, subcategoria: subcategory.name })">
                                            {{ subcategory.name }}
                                            </a>
                                        </template>

                                        <template v-else>

                                            <a :href="route('subcategorias.index', { categoria: category.name, subcategoria: subcategory.name })" v-show="category.showMenuCategory">
                                                {{ subcategory.name }}
                                            </a>
                                        </template>

                                    </li>
                                </div>

                            </ul>

                        </li>

                    </ul>
                </li>

            </ul>
        </div>
        <div class="buttons">
            <button class="menu-btn" v-toggle-navbar>
                <span class="material-symbols-outlined">
                    menu
                </span>
            </button>
        </div>
    </nav>
    </div>
</template>

<script>
    import iconlogoPage from '../../img/logo/logo_main.png';
    import chevronDown from '../../img/chevron-down.svg';
    import NavLink from '@/Components/NavLink.vue';
    import Dropdown from '@/Components/Dropdown.vue';
    import DropdownLink from '@/Components/DropdownLink.vue';
    import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';

    import { ref } from 'vue';
    import axios from 'axios';
    export default {
        data(){
            return{
                iconlogoPage,
                show_options_shop_bike:false,
                show_options_shop_accessories:false,
                show_options_mega:false,
                chevronDown,
                mobileDeviceCamera:undefined,
                navOption:"",
                showMenu: false,
                showMenuCategory:false,
                categorias: [],
                showMenuBike:false,
                categoriaAbierta: null,
                showNabvar: false
            }

        },
        components:{
            // Link
            NavLink,
            Dropdown,
            DropdownLink,
            ResponsiveNavLink
        },
        created(){
            this.mobileDeviceCamera = window.innerWidth <= 768;
            this.navOption=route().current()
            this.fetchCategorias();
        },
        methods:{
            redirectToListCategory(class_category) {
                this.$inertia.visit(route('class_category.index', { class_category: class_category }));
            },
            closeOptionsDocumentOnClickOutside() {
                if(this.showNabvar){
                    this.showNabvar=false
                }
            },
            fetchCategorias() {
                axios.get('/listcategories') // La ruta debe coincidir con la que creaste en tu archivo de rutas
                    .then((response) => {
                        response.data.classCategories.forEach((categoria) => {
                            categoria.showMenu = false; // Inicialmente, ningún menú está visible
                            categoria.categories.forEach(c=>c.showMenuCategory = false)

                        });
                        this.categorias = response.data.classCategories; // Asigna las categorías obtenidas a la propiedad categorias
                    })
                    .catch((error) => {
                    console.error('Error al obtener categorías:', error);
                    });
            },

            toggleCategorySubmenu(classCategory, category) {
                console.log(classCategory);

                if (this.mobileDeviceCamera) {
                    // Cierra las subcategorías previamente abiertas de otras categorías
                    this.categorias.forEach((c) => {
                        console.log(c);
                        if (c !== classCategory) {
                            c.categories.forEach((subcat) => {
                                subcat.showMenuCategory = false;
                            });
                        }
                    });

                    // Abre o cierra las subcategorías de la categoría actual
                    category.showMenuCategory = !category.showMenuCategory;
                }
            },

            toggleSubMenu(classCategory){
                if (this.mobileDeviceCamera) {

                    // Si es un dispositivo móvil, verifica si la categoría ya está abierta
                    if (classCategory === this.categoriaAbierta) {
                        classCategory.showMenu = !classCategory.showMenu;

                        classCategory.categories.forEach((subcategory) => {
                            subcategory.showMenuCategory = false;
                        });
                    } else {
                        // Cierra la categoría previamente abierta
                        if (this.categoriaAbierta) {
                            this.categoriaAbierta.showMenu = false;
                            console.log(this.categoriaAbierta);
                            // this.categoriaAbierta.categories.forEach((subcategory) => {
                            //     subcategory.showMenuCategory = false;
                            // });
                        }
                        // Abre la nueva categoría
                        classCategory.showMenu = true;
                        this.categoriaAbierta = classCategory;
                    }
                }
            },
        },
        setup(){
            const isNavbarOpen = ref(false);

            const closeNavbar = () => {
                isNavbarOpen.value = false;
                document.body.classList.remove('show-navbar');
            };
            return{
                closeNavbar
            }


        }
    }
</script>


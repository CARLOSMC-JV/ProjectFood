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
                categorias: [],
                showMenuBike:false,
                categoriaAbierta: null,
                showNabvar: false,
                showMobileOverlay: false,

            }
            
        },
        components:{
            // Link
            NavLink,
            Dropdown,
            DropdownLink,
            ResponsiveNavLink
        },
        mounted() {
            window.addEventListener("resize", this.handleResize);
        },
        created(){
            this.handleResize();
            this.mobileDeviceCamera = window.innerWidth <= 768; 
            console.log(this.mobileDeviceCamera);
            this.navOption=route().current()
            this.fetchCategorias();

        },
        destroyed() {
            // * Destroy listener when leaving page or reload
            window.removeEventListener("resize", this.handleResize);
        },
        methods:{
            handleResize() {
            // * If th window width is more than 1200px, change whats is showed
                if (process.browser) {
                    this.windowWidth = parseInt(window.innerWidth, 10);
                    if (this.windowWidth >= 991) {
                        this.showMobileOverlay = false;
                    }
                }
            },
            closeOptionsDocumentOnClickOutside() {
                console.log("Hola");
                if(this.showNabvar){
                    this.showNabvar=false
                }
            },
            fetchCategorias() {
                axios.get('/listcategories') // La ruta debe coincidir con la que creaste en tu archivo de rutas
                    .then((response) => {
                        console.log(response);
                        response.data.classCategories.forEach((categoria) => {
                            categoria.showMenu = false; // Inicialmente, ningún menú está visible
                        });
                        this.categorias = response.data.classCategories; // Asigna las categorías obtenidas a la propiedad categorias
                    })
                    .catch((error) => {
                    console.error('Error al obtener categorías:', error);
                    });
            },

            toggleSubMenu(classCategory){
                if (this.mobileDeviceCamera) {
                    // Si es un dispositivo móvil, verifica si la categoría ya está abierta
                    if (classCategory === this.categoriaAbierta) {
                        classCategory.showMenu = !classCategory.showMenu;
                    } else {
                        // Cierra la categoría previamente abierta
                        if (this.categoriaAbierta) {
                        this.categoriaAbierta.showMenu = false;
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

<template>
    <header id="header" v-click-outside="closeNavbar">
        <div class="general-box-header">

            <div class="menu-icon" v-toggle-navbar>
                <font-awesome-icon class="menu-fa" :icon="['fas', 'bars']" />
            </div>
            <div class="header-img">
                <NavLink :href="route('home')">
                    <img :src="iconlogoPage" alt="" class="logo-main">
                </NavLink>
            </div>
            <!-- <div class="menu-icon-2" v-toggle-navbar @click="toggleMenu">
                <font-awesome-icon class="menu-fa" :icon="['fas', 'bars']" /> Menu
            </div>
            <transition name="slide-fade">
                <div class="menu" v-if="showMenu">
                    Holis
                </div>
            </transition> -->
            <div class="header-menu">
                <div class="close-icon" v-toggle-navbar> <font-awesome-icon :icon="['fas', 'times']" /></div>
                <ul class="nav-menu">
                    <!-- <li class="menu-item-main">
                        <div class="link-main">
                            <NavLink :href="route('dashboard')" 
                            class="link-main" @click="closeNavbar"  >
                                Inicio
                            </NavLink>
                        </div>
                    </li> -->
                    

                    <!-- <li class="menu-item-main" v-for="classCategory in categorias" :key="classCategory.id" @mouseover="!mobileDeviceCamera ? classCategory.showMenu = true : '' " @mouseleave="!mobileDeviceCamera ? classCategory.showMenu = false : ''">
                        <div class="link-main" @click="mobileDeviceCamera ? toggleSubMenu(classCategory) : ''" :class="[classCategory.showMenu ? 'active' : '']">
                            {{ classCategory.name }}
                            <img :src="chevronDown" alt="">
                        </div>
                        <transition name="menu-animation">
                            <div class="box-general-options" v-show="classCategory.showMenu">
                                <div class="box-transparent" @mouseenter="classCategory.showMenu = true">

                                </div>
                                <div class="box-show-options" >
                        

                                    <NavLink
                                        v-for="category in classCategory.categories"
                                        :key="category.id"
                                        :href="route('categoria.index', { categoria: category.name })"
                                        class="link-main-drop"
                                        @mouseenter="classCategory.showMenu = true"
                                        @click="closeNavbar"
                                    >
                                        {{ category.name }}
                                    </NavLink>
                                </div>
                            </div>
                        </transition>
                    </li> -->

                    <!-- <li class="menu-item-main" @mouseover="!mobileDeviceCamera ? show_options_shop_accessories = true : '' " @mouseleave="!mobileDeviceCamera ? show_options_shop_accessories = false : ''">
                        <div class="link-main" @click="mobileDeviceCamera ? toggleShowOptionsAccesories() : ''">
                            Accesorio
                            <img :src="chevronDown" alt="">
                        </div>
                        <transition name="menu-animation">
                            <div class="box-general-options" v-show="show_options_shop_accessories">
                                <div class="box-transparent" @mouseenter="show_options_shop_accessories = true">

                                </div>
                                <div class="box-show-options" >
                            
                                    <NavLink :href="route('admin.dashboard')" class="link-main-drop" @mouseenter="show_options_shop_accessories = true">
                                        Seguridad y Luces
                                    </NavLink>

                                        <NavLink :href="route('subcategorias.index', { categoria: 'INFANTIL', subcategoria: 'ARO 12' })"
                                            class="link-main-drop" @click="closeNavbar" @mouseenter="show_options_shop_bike = true">
                                        ARO 12
                                    </NavLink>

                                    <NavLink :href="route('departments.index')"
                                    class="link-main-drop" @click="closeNavbar" @mouseenter="show_options_shop_accessories = true">
                                        Accesorios Varios

                                    </NavLink>

                                    <NavLink :href="route('departments.index')"
                                    class="link-main-drop" @click="closeNavbar" @mouseenter="show_options_shop_accessories = true">
                                        Infantil

                                    </NavLink>
                                </div>
                            </div>
                        </transition>
                    </li> -->

                    <li class="menu-item-main" v-for="classCategory in categorias" :key="classCategory.id" @mouseover="!mobileDeviceCamera ? classCategory.showMenu = true : '' " @mouseleave="!mobileDeviceCamera ? classCategory.showMenu = false : ''">
                        <a class="link-main" @click="mobileDeviceCamera ? toggleSubMenu(classCategory) : ''" :class="[classCategory.showMenu ? 'active' : '']">
                            {{ classCategory.name }}
                            <img :src="chevronDown" alt="">
                        </a>
                        <transition name="menu-animation">
                            <div class="box-general-options" v-show="classCategory.showMenu">
                                <div class="box-transparent"  @mouseenter="classCategory.showMenu = true">

                                </div>
                                <div class="box-show-options-mega">
                                
                                    <div class="section-options">
                                        <NavLink
                                        v-for="category in classCategory.categories"
                                        :key="category.id"
                                        :href="route('categoria.index', { categoria: category.name })"
                                        class="link-main-drop"
                                        @mouseenter="classCategory.showMenu = true"
                                        @click="closeNavbar"
                                        >
                                            {{ category.name }}
                                        
                                            <div class="section-options-sub">
                                                <NavLink v-for="subcategory in category.subcategories" :key="subcategory.id" :href="route('subcategorias.index', { categoria: category.name, subcategoria: subcategory.name })"
                                                class="link-main-drop-sub" @click="closeNavbar" @mouseenter="classCategory.showMenu = true">
                                                    {{ subcategory.name }}
                                                </NavLink>
                                            </div>
                                        </NavLink>
                                    </div>

                                </div>
                            </div>
                        </transition>
                    </li>
                </ul>
                
            </div>

            <!-- <div class="hidden sm:flex sm:items-center sm:ml-6"  v-if="$page.props.auth.user && $page.props.auth.user.name">
                Settings Dropdown
                <div class="ml-3 relative">
                    <Dropdown align="right" width="48">
                        <template #trigger>
                            <span class="inline-flex rounded-md">
                                <button
                                    type="button"
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                    v-if="$page.props.auth.user && $page.props.auth.user.name"

                                >
                                    {{ $page.props.auth.user.name }}

                                    <svg
                                        class="ml-2 -mr-0.5 h-4 w-4"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </button>
                            </span>
                        </template>

                        <template #content>
                            <DropdownLink :href="route('profile.edit')"> Profile </DropdownLink>
                            <DropdownLink :href="route('logout')" method="post" as="button">
                                Log Out
                            </DropdownLink>
                        </template>
                    </Dropdown>
                </div>
            </div> -->



            <div class="header-img-right">
                <NavLink :href="route('departments.index')">
                    <img :src="iconlogoPage" alt="" class="logo-main">
                </NavLink>
            </div>
        </div>

    </header>
    
</template>


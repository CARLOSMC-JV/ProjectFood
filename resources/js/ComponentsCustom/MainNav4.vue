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
            console.log(this.mobileDeviceCamera);
            this.navOption=route().current()
            this.fetchCategorias();
        },
        methods:{

            fetchCategorias() {
                axios.get('/listcategories') // La ruta debe coincidir con la que creaste en tu archivo de rutas
                    .then((response) => {
                        console.log(response);
                        response.data.classCategories.forEach((categoria) => {
                            categoria.showMenu = false; // Inicialmente, ningún menú está visible
                            // categoria.categories.forEach(c=>c.showMenuCategory = false)

                        });
                        this.categorias = response.data.classCategories; // Asigna las categorías obtenidas a la propiedad categorias
                        // console.log(this.categorias);

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
        },
    }
</script>

<template>
    <div id="main-nav-principal">
        <nav class="navbar">
        <a href="#" class="brand">Brand</a>
        <div class="menu-container">
            <ul class="mega-menu">
                <li class="dropdown" v-for="classCategory in categorias" :key="classCategory.id">
                    <div>
                        <span>{{ classCategory.name }}</span>
                        <span class="material-symbols-outlined">
                            chevron_right
                        </span>
                    </div>
                    <ul class="menu">
                        <!-- <li>
                            <a href="#">New Releases</a>
                        </li> -->
                        <li class="sub-dropdown" >
                            <div v-for="category in classCategory.categories"
                                        :key="category.id"
                                        :href="route('categoria.index', { categoria: category.name })">
                                <span>{{category.name}}</span>
                                <span class="material-symbols-outlined">
                                    chevron_right
                                </span>
                            </div>
                            <ul class="sub-menu" v-for="category in classCategory.categories"
                                        :key="category.id"
                                        :href="route('categoria.index', { categoria: category.name })">
                                <span>{{category.name}}</span>

                                <!-- <li>
                                    <a href="#">Featured</a>
                                </li>
                                <li>
                                    <a href="#">Shop All New Arrivals</a>
                                </li>
                                <li>
                                    <a href="#">SKNRS Launch Calendar</a>
                                </li> -->
                            </ul>
                        </li>
                    </ul>
                </li>
                <!-- Mens -->
                <!-- <li class="dropdown">
                    <div>
                        <span>Men</span>
                        <span class="material-symbols-outlined">
                            chevron_right
                        </span>
                    </div>
                    <ul class="menu">
                        <li>
                            <a href="#">Men</a>
                        </li>
                        <li class="sub-dropdown">
                            <div>
                                <span>Featured</span>
                                <span class="material-symbols-outlined">
                                    chevron_right
                                </span>
                            </div>
                            <ul class="sub-menu">
                                <li>
                                    <a href="#">Featured</a>
                                </li>
                                <li>
                                    <a href="#">New Releases</a>
                                </li>
                                <li>
                                    <a href="# ">SKNRS Launch Calendar</a>
                                </li>
                                <li>
                                    <a href="#">Bestsellers</a>
                                </li>
                            </ul>
                        </li>
                        <li class="sub-dropdown">
                            <div>
                                <span>Shoes</span>
                                <span class="material-symbols-outlined">
                                    chevron_right
                                </span>
                            </div>
                            <ul class="sub-menu">
                                <li>
                                    <a href="#">All Shoes</a>
                                </li>
                                <li>
                                    <a href="#">Lifestyle</a>
                                </li>
                                <li>
                                    <a href="#">Jordan</a>
                                </li>
                                <li>
                                    <a href="#">Running</a>
                                </li>
                                <li>
                                    <a href="#">Football</a>
                                </li>
                                <li>
                                    <a href="#">Basketball</a>
                                </li>
                                <li>
                                    <a href="#">Training and Gym</a>
                                </li>
                                <li>
                                    <a href="#">Skateboarding</a>
                                </li>
                            </ul>
                        </li>
                        <li class="sub-dropdown">
                            <div>
                                <span>Clothing</span>
                                <span class="material-symbols-outlined">
                                    chevron_right
                                </span>
                            </div>
                            <ul class="sub-menu">
                                <li>
                                    <a href="#">All Clothing</a>
                                </li>
                                <li>
                                    <a href="#">Lyfestyle</a>
                                </li>
                                <li>
                                    <a href="#">Tops and T-Shirts</a>
                                </li>
                                <li>
                                    <a href="#">Hoodies and Sweatshirts</a>
                                </li>
                                <li>
                                    <a href="#">Shorts</a>
                                </li>
                                <li>
                                    <a href="#">Tracksuits</a>
                                </li>
                                <li>
                                    <a href="#">Trousers and Tights</a>
                                </li>
                                <li>
                                    <a href="#">Jackets</a>
                                </li>
                                <li>
                                    <a href="#">Kits and Jerseys</a>
                                </li>
                            </ul>
                        </li>
                        <li class="sub-dropdown">
                            <div>
                                <span>Shop By Sport</span>
                                <span class="material-symbols-outlined">
                                    chevron_right
                                </span>
                            </div>
                            <ul class="sub-menu">
                                <li>
                                    <a href="#">All Sports</a>
                                </li>
                                <li>
                                    <a href="#">Running</a>
                                </li>
                                <li>
                                    <a href="#">Football</a>
                                </li>
                                <li>
                                    <a href="#">Basketball</a>
                                </li>
                                <li>
                                    <a href="#">Training and Gym</a>
                                </li>
                                <li>
                                    <a href="#">Tennis</a>
                                </li>
                                <li>
                                    <a href="#">Golf</a>
                                </li>
                            </ul>
                        </li>
                        <li class="sub-dropdown">
                            <div>
                                <span>Accessories</span>
                                <span class="material-symbols-outlined">
                                    chevron_right
                                </span>
                            </div>
                            <ul class="sub-menu">
                                <li>
                                    <a href="#">All Accessories</a>
                                </li>
                                <li>
                                    <a href="#">Bags and Backpacks</a>
                                </li>
                                <li>
                                    <a href="#">Socks</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li> -->
                <!-- Women section -->
                <!-- <li class="dropdown">
                    <div>
                        <span>Women</span>
                        <span class="material-symbols-outlined">
                            chevron_right
                        </span>
                    </div>
                    <ul class="menu">
                        <li>
                            <a href="#">Women</a>
                        </li>
                        <li class="sub-dropdown">
                            <div>
                                <span>Featured</span>
                                <span class="material-symbols-outlined">
                                    chevron_right
                                </span>
                            </div>
                            <ul class="sub-menu">
                                <li>
                                    <a href="#">Featured</a>
                                </li>
                                <li>
                                    <a href="#">New Releases</a>
                                </li>
                                <li>
                                    <a href="# ">SKNRS Launch Calendar</a>
                                </li>
                                <li>
                                    <a href="#">Bestsellers</a>
                                </li>
                            </ul>
                        </li>
                        <li class="sub-dropdown">
                            <div>
                                <span>Shoes</span>
                                <span class="material-symbols-outlined">
                                    chevron_right
                                </span>
                            </div>
                            <ul class="sub-menu">
                                <li>
                                    <a href="#">All Shoes</a>
                                </li>
                                <li>
                                    <a href="#">Lifestyle</a>
                                </li>
                                <li>
                                    <a href="#">Jordan</a>
                                </li>
                                <li>
                                    <a href="#">Running</a>
                                </li>
                                <li>
                                    <a href="#">Training and Gym</a>
                                </li>
                            </ul>
                        </li>
                        <li class="sub-dropdown">
                            <div>
                                <span>Clothing</span>
                                <span class="material-symbols-outlined">
                                    chevron_right
                                </span>
                            </div>
                            <ul class="sub-menu">
                                <li>
                                    <a href="#">All Clothing</a>
                                </li>
                                <li>
                                    <a href="#">Lyfestyle</a>
                                </li>
                                <li>
                                    <a href="#">Tops and T-Shirts</a>
                                </li>
                                <li>
                                    <a href="#">Hoodies and Sweatshirts</a>
                                </li>
                                <li>
                                    <a href="#">Leggings</a>
                                </li>
                                <li>
                                    <a href="#">Trousers</a>
                                </li>
                                <li>
                                    <a href="#">Shorts</a>
                                </li>
                                <li>
                                    <a href="#">Tracksuits</a>
                                </li>
                                <li>
                                    <a href="#">Sports Bra</a>
                                </li>
                                <li>
                                    <a href="#">Matching Sets</a>
                                </li>
                                <li>
                                    <a href="#">Jackets</a>
                                </li>
                                <li>
                                    <a href="#">Skirts and Dresses</a>
                                </li>
                            </ul>
                        </li>
                        <li class="sub-dropdown">
                            <div>
                                <span>Shop By Sport</span>
                                <span class="material-symbols-outlined">
                                    chevron_right
                                </span>
                            </div>
                            <ul class="sub-menu">
                                <li>
                                    <a href="#">All Sports</a>
                                </li>
                                <li>
                                    <a href="#">Running</a>
                                </li>
                                <li>
                                    <a href="#">Yoga</a>
                                </li>
                                <li>
                                    <a href="#">HandBall</a>
                                </li>
                                <li>
                                    <a href="#">Training and Gym</a>
                                </li>
                                <li>
                                    <a href="#">Tennis</a>
                                </li>
                                <li>
                                    <a href="#">Golf</a>
                                </li>
                            </ul>
                        </li>
                        <li class="sub-dropdown">
                            <div>
                                <span>Accessories</span>
                                <span class="material-symbols-outlined">
                                    chevron_right
                                </span>
                            </div>
                            <ul class="sub-menu">
                                <li>
                                    <a href="#">All Accessories</a>
                                </li>
                                <li>
                                    <a href="#">Bags and Backpacks</a>
                                </li>
                                <li>
                                    <a href="#">Socks</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li> -->
                <!-- Kids section -->
                <!-- <li class="dropdown">
                    <div>
                        <span>Kids</span>
                        <span class="material-symbols-outlined">
                            chevron_right
                        </span>
                    </div>
                    <ul class="menu">
                        <li>
                            <a href="#">Kids</a>
                        </li>
                        <li class="sub-dropdown">
                            <div>
                                <span>Featured</span>
                                <span class="material-symbols-outlined">
                                    chevron_right
                                </span>
                            </div>
                            <ul class="sub-menu">
                                <li>
                                    <a href="#">Featured</a>
                                </li>
                                <li>
                                    <a href="#">New Releases</a>
                                </li>
                                <li>
                                    <a href="#">Bestsellers</a>
                                </li>
                            </ul>
                        </li>
                        <li class="sub-dropdown">
                            <div>
                                <span>Shoes</span>
                                <span class="material-symbols-outlined">
                                    chevron_right
                                </span>
                            </div>
                            <ul class="sub-menu">
                                <li>
                                    <a href="#">All Shoes</a>
                                </li>
                                <li>
                                    <a href="#">Lifestyle</a>
                                </li>
                                <li>
                                    <a href="#">Jordan</a>
                                </li>
                                <li>
                                    <a href="#">Running</a>
                                </li>
                                <li>
                                    <a href="#">Football</a>
                                </li>
                                <li>
                                    <a href="#">Basketball</a>
                                </li>
                            </ul>
                        </li>
                        <li class="sub-dropdown">
                            <div>
                                <span>Clothing</span>
                                <span class="material-symbols-outlined">
                                    chevron_right
                                </span>
                            </div>
                            <ul class="sub-menu">
                                <li>
                                    <a href="#">All Clothing</a>
                                </li>
                                <li>
                                    <a href="#">Tops and T-Shirts</a>
                                </li>
                                <li>
                                    <a href="#">Hoodies and Sweatshirts</a>
                                </li>
                                <li>
                                    <a href="#">Shorts</a>
                                </li>
                                <li>
                                    <a href="#">Tracksuits</a>
                                </li>
                                <li>
                                    <a href="#">Trousers and Leggings</a>
                                </li>
                                <li>
                                    <a href="#">Jackets</a>
                                </li>
                                <li>
                                    <a href="#">Kits and Jerseys</a>
                                </li>
                                <li>
                                    <a href="#">Sport Clothing</a>
                                </li>
                            </ul>
                        </li>
                        <li class="sub-dropdown">
                            <div>
                                <span>Kids by age</span>
                                <span class="material-symbols-outlined">
                                    chevron_right
                                </span>
                            </div>
                            <ul class="sub-menu">
                                <li>
                                    <a href="#">Baby & Toddler(0-3 years)</a>
                                </li>
                                <li>
                                    <a href="#">Younger Kids(3-7 years)</a>
                                </li>
                                <li>
                                    <a href="#">Older Kids(7-15 years)</a>
                                </li>
                            </ul>
                        </li>
                        <li class="sub-dropdown">
                            <div>
                                <span>Accessories</span>
                                <span class="material-symbols-outlined">
                                    chevron_right
                                </span>
                            </div>
                            <ul class="sub-menu">
                                <li>
                                    <a href="#">All Accessories</a>
                                </li>
                                <li>
                                    <a href="#">Bags and Backpacks</a>
                                </li>
                                <li>
                                    <a href="#">Socks</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li> -->
                <!-- Sales section -->
                <!-- <li class="dropdown">
                    <div>
                        <span>Sale</span>
                        <span class="material-symbols-outlined">
                            chevron_right
                        </span>
                    </div>
                    <ul class="menu">
                        <li>
                            <a href="#">Sale</a>
                        </li>
                        <li class="sub-dropdown">
                            <div>
                                <span>Featured</span>
                                <span class="material-symbols-outlined">
                                    chevron_right
                                </span>
                            </div>
                            <ul class="sub-menu">
                                <li>
                                    <a href="#">Featured</a>
                                </li>
                                <li>
                                    <a href="#">Shop All Sale</a>
                                </li>
                                <li>
                                    <a href="#">Bestsellers</a>
                                </li>
                            </ul>
                        </li>
                        <li class="sub-dropdown">
                            <div>
                                <span>Sale For Men</span>
                                <span class="material-symbols-outlined">
                                    chevron_right
                                </span>
                            </div>
                            <ul class="sub-menu">
                                <li>
                                    <a href="#">Shop All Sale Men's</a>
                                </li>
                                <li>
                                    <a href="#">Shoes</a>
                                </li>
                                <li>
                                    <a href="#">Clothing</a>
                                </li>
                                <li>
                                    <a href="#">Accessories</a>
                                </li>
                            </ul>
                        </li>
                        <li class="sub-dropdown">
                            <div>
                                <span>Sale For Women</span>
                                <span class="material-symbols-outlined">
                                    chevron_right
                                </span>
                            </div>
                            <ul class="sub-menu">
                                <li>
                                    <a href="#">Shop All Sale Women's</a>
                                </li>
                                <li>
                                    <a href="#">Shoes</a>
                                </li>
                                <li>
                                    <a href="#">Clothing</a>
                                </li>
                                <li>
                                    <a href="#">Accessories</a>
                                </li>
                            </ul>
                        </li>
                        <li class="sub-dropdown">
                            <div>
                                <span>Sale For Kids</span>
                                <span class="material-symbols-outlined">
                                    chevron_right
                                </span>
                            </div>
                            <ul class="sub-menu">
                                <li>
                                    <a href="#">Shop All Sale Kid's</a>
                                </li>
                                <li>
                                    <a href="#">Shoes</a>
                                </li>
                                <li>
                                    <a href="#">Clothing</a>
                                </li>
                                <li>
                                    <a href="#">Accessories</a>
                                </li>
                            </ul>
                        </li>
                        <li class="sub-dropdown">
                            <div>
                                <span>Sale By Sport</span>
                                <span class="material-symbols-outlined">
                                    chevron_right
                                </span>
                            </div>
                            <ul class="sub-menu">
                                <li>
                                    <a href="#">Sale by Sport's</a>
                                </li>
                                <li>
                                    <a href="#">Running</a>
                                </li>
                                <li>
                                    <a href="#">Football</a>
                                </li>
                                <li>
                                    <a href="#">Basketball</a>
                                </li>
                                <li>
                                    <a href="#">Gym and Training</a>
                                </li>
                                <li>
                                    <a href="#">Tennis</a>
                                </li>
                                <li>
                                    <a href="#">Golf</a>
                                </li>
                                <li>
                                    <a href="#">Yoga</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li> -->
                <!-- Collections section -->
                <!-- <li class="dropdown">
                    <div>
                        <span>Collections</span>
                        <span class="material-symbols-outlined">
                            chevron_right
                        </span>
                    </div>
                    <ul class="menu">
                        <li>
                            <a href="#">All Collections</a>
                        </li>
                        <li class="sub-dropdown">
                            <div>
                                <span>Trending</span>
                                <span class="material-symbols-outlined">
                                    chevron_right
                                </span>
                            </div>
                            <ul class="sub-menu">
                                <li>
                                    <a href="#">All Trending</a>
                                </li>
                                <li>
                                    <a href="#">Dunk</a>
                                </li>
                                <li>
                                    <a href="# ">Louis Vuitton</a>
                                </li>
                                <li>
                                    <a href="#">SuperRep Shoes</a>
                                </li>
                                <li>
                                    <a href="#">Women's Air Force I</a>
                                </li>
                                <li>
                                    <a href="#">White Air Force I</a>
                                </li>
                                <li>
                                    <a href="#">Nike Essentials</a>
                                </li>
                                <li>
                                    <a href="#">FlyEase</a>
                                </li>
                            </ul>
                        </li>
                        <li class="sub-dropdown">
                            <div>
                                <span>Lifestyle</span>
                                <span class="material-symbols-outlined">
                                    chevron_right
                                </span>
                            </div>
                            <ul class="sub-menu">
                                <li>
                                    <a href="#">Lifestyle</a>
                                </li>
                                <li>
                                    <a href="#">Air Force I</a>
                                </li>
                                <li>
                                    <a href="#">Blazer</a>
                                </li>
                                <li>
                                    <a href="#">Air Max</a>
                                </li>
                                <li>
                                    <a href="#">Air Max 90</a>
                                </li>
                                <li>
                                    <a href="#">Air Max Plus</a>
                                </li>
                                <li>
                                    <a href="#">Air Jordan</a>
                                </li>
                            </ul>
                        </li>
                        <li class="sub-dropdown">
                            <div>
                                <span>Running</span>
                                <span class="material-symbols-outlined">
                                    chevron_right
                                </span>
                            </div>
                            <ul class="sub-menu">
                                <li>
                                    <a href="#">Running</a>
                                </li>
                                <li>
                                    <a href="#">React</a>
                                </li>
                                <li>
                                    <a href="#">Pegasus</a>
                                </li>
                            </ul>
                        </li>
                        <li class="sub-dropdown">
                            <div>
                                <span>Football</span>
                                <span class="material-symbols-outlined">
                                    chevron_right
                                </span>
                            </div>
                            <ul class="sub-menu">
                                <li>
                                    <a href="#">Football</a>
                                </li>
                                <li>
                                    <a href="#">Phantom</a>
                                </li>
                                <li>
                                    <a href="#">Mercurial</a>
                                </li>
                                <li>
                                    <a href="#">National Teams Collections</a>
                                </li>
                                <li>
                                    <a href="#">Football Clubs</a>
                                </li>
                                <li>
                                    <a href="#">F.C. Barcelona</a>
                                </li>
                                <li>
                                    <a href="#">Liverpool F.C.</a>
                                </li>
                                <li>
                                    <a href="#">Manchester United</a>
                                </li>
                                <li>
                                    <a href="#">Paris Saint-Germain</a>
                                </li>
                                <li>
                                    <a href="#">Chelsea</a>
                                </li>
                                <li>
                                    <a href="#">Inter Milan</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li> -->
            </ul>
        </div>
        <div class="buttons">
            <button class="btn">Contact</button>
            <button class="menu-btn">
                <span class="material-symbols-outlined">
                    menu
                </span>
            </button>
        </div>
    </nav>
    </div>
</template>


<style scoped>
    body{
    background: #ccc;
    font-family: 'Poppins', sans-serif;
}

*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

ul{
    list-style: none;
}

a{
    text-decoration: none;
    color: #000;
}

.navbar{
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    background: #fff;
    z-index: 2;
}

.navbar, .buttons{
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1em;
}

.brand{
    font-weight: bolder;
    font-size: 1.5em;
}

.brand:hover{
    font-weight: bolder;
    color: #428aff;
}

button{
    border: none;
    transition: 0.3s;
    cursor: pointer;
}

.btn{
    font-family: 'Poppins', sans-serif;
    font-size: 1.1em;
    background: #428aff;
    padding: 0.5em 1.3em;
    border-radius: 16px;
    color: #fff;
}

.btn:hover{
    background: #3877db;
}

.menu-btn{
    margin-left: 1em;
    background: none;
    display: inline-block;
}

.menu-btn span{
    font-size: 2.3em;
}

.dropdown > div, .sub-dropdown > div {
    cursor: pointer;
}

.dropdown .menu a:hover{
    color: #9b9b9b;
}

@media screen and (min-width: 800px) {
    .navbar{
        padding: 0 1.5em;
    }
    .dropdown > div{
        padding: 1.5em 1em;
    }
    .mega-menu{
        display: flex;
        justify-content: center;
    }
    .menu-btn{
        display: none;
    }
    .menu{
        background: #fff;
        position: fixed;
        top: 4.65em;
        left: 0;
        width: 100%;
        padding: 0 2em;
        overflow-y: scroll;
        transition: 0.3s ease-in-out;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        gap: 2em;
    }

    .menu > li:first-child{
        font-size: 1.1em;
        font-weight: bold;
        margin: 0;
    }

    .sub-dropdown > div span:first-child{
        font-weight: bold;
    }
    
    .dropdown > div{
        border-bottom: 3px #fff solid;
        transition: 0.3s;
    }

    .dropdown:hover > div{
        border-color: #000;
    }

    .dropdown li{
        margin-bottom: 1em;
    }

    .dropdown > div span:last-child, 
    .sub-dropdown > div{
        display: none;
    }

    /* Width */
    .menu::-webkit-scrollbar{
        width: 8px;
    }
    /* Track */
    .menu::-webkit-scrollbar-track{
        background: #f1f1f1;
    }
    /* Handle */
    .menu::-webkit-scrollbar-thumb{
        background: #888;
    }

    /* Handle on hover */
    .menu::-webkit-scrollbar-thumb:hover{
        background: #555;
    }

    /* Hide menu */
    .menu{
        height: 0;
    }
    .dropdown:hover .menu{
        height: 50vh;
        padding: 2em;
    }
}

/* Responsive Design */
@media screen and (max-width: 800px) {
    .navbar{
        padding: 1em 1.5em;
    }
    .menu-container{
        background: #fff;
        position: absolute;
        top: 4.4em;
        left: 0;
        width: 100%;
        overflow-y: hidden;
        transition: 0.3s ease-in-out;
    }

    /* Width */
    .mega-menu::-webkit-scrollbar{
        width: 8px;
    }
    /* Track */
    .mega-menu::-webkit-scrollbar-track{
        background: #f1f1f1;
    }
    /* Handle */
    .mega-menu::-webkit-scrollbar-thumb{
        background: #888;
    }
    /* Handle on hover */
    .mega-menu::-webkit-scrollbar-thumb:hover{
        background: #555;
    }
    .mega-menu{
        padding: 0 1em 1em 1em;
        height: 100%;
        overflow-y: scroll;
    }
    .mega-menu li{
        font-weight: bold;
        font-size: 1.1em;
    }
    .mega-menu li > div{
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 0.5em;
    }
    .menu li{
        padding: 0 1em;
        font-size: 1em;
        font-weight: 400;
    }
    .menu a{
        display: block;
        margin: 0.8em 0;
    }
    .menu{
        display: none;
    }
    /* Toggle class for Javascript */
    .menu-show{
        display: block;
    }
    .material-symbols-outlined{
        transition: 0.3s;
    }
    /* Toggle class for javascript */
    .icon-rotated{
        transform: rotate(90deg);
    }
    .dropdown>div, .sub-dropdown > div{
        cursor: pointer;
        padding: 0.5em;
    }
    .sub-menu{
        font-size: 0.9em;
        display: none;
    }
    /* Toggle class for Javascript */
    .sub-menu-show{
        display: block;
    }
    .dropdown:hover>div, .sub-dropdown:hover>div{
        background: #dbdbdb;
    }
    /* Hide menu */
    .menu-container{
        height: 0;
    }
    /* Toggle class for javascript */
    .mega-menu-show{
        height: 50vh;
    }
}
</style>
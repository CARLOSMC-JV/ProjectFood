<script>
    import Link from '@/components/Link.vue';
    import iconlogoPage from '@/assets/img/logo.svg';
    import chevronDown from '@/assets/img/chevron-down.svg';

    import { ref } from 'vue';

    export default {
        data(){
            return{
                iconlogoPage,
                show_options_shop:false,
                show_options_mega:false,
                chevronDown,
                mobileDeviceCamera:undefined
            }
            
        },
        components:{
            Link
        },
        created(){
            this.mobileDeviceCamera = window.innerWidth <= 768; 
            console.log(this.mobileDeviceCamera);
        },
        methods:{
            hideOptionsShop() {
                setTimeout(() => {
                this.show_options_shop = false;
                }, 2000); // 200 milisegundos (ajusta el valor según tus necesidades)
            },
            toggleShowOptions(){
                this.show_options_shop = !this.show_options_shop
                if(this.show_options_mega){
                    this.show_options_mega=false
                }
            },
            toggleShowOptionsMega(){
                this.show_options_mega = !this.show_options_mega
                if(this.show_options_shop){
                    this.show_options_shop=false
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
    }
</script>

<template>
    <header id="header">
        <div class="general-box-header">

            <div class="menu-icon" v-toggle-navbar>
                <i class="fa fa-bars"></i>
            </div>
            <div class="header-img">
                <RouterLink :to="{name: 'shop'}">
                    <img :src="iconlogoPage" alt="">
                </RouterLink>
            </div>
            <div class="header-menu">
                <div class="close-icon" v-toggle-navbar> <i class="fa fa-times"></i> </div>
                <ul class="nav-menu">
                    <li class="menu-item-main">
                        <RouterLink :to="{name: 'shop'}"
                        class="link-main" @click="closeNavbar">
                            Inicio
                        </RouterLink>
                    </li>
                    <li class="menu-item-main" @mouseover="!mobileDeviceCamera ? show_options_shop = true : '' " @mouseleave="!mobileDeviceCamera ? show_options_shop = false : ''">
                        <div class="link-main" @click="mobileDeviceCamera ? toggleShowOptions() : ''">
                            Tienda
                            <img :src="chevronDown" alt="">
                        </div>
                        <div class="box-general-options" v-show="show_options_shop">
                            <div class="box-transparent" @mouseenter="show_options_shop = true">

                            </div>
                            <div class="box-show-options" >
                           
                                <RouterLink :to="{name: 'shop'}"
                                class="link-main-drop" @click="closeNavbar" @mouseenter="show_options_shop = true">
                                    Catalog with Filters
                                </RouterLink>

                                <RouterLink :to="{name: 'shop'}"
                                class="link-main-drop" @click="closeNavbar" @mouseenter="show_options_shop = true">
                                    Single Products
                                </RouterLink>

                                <RouterLink :to="{name: 'shop'}"
                                class="link-main-drop" @click="closeNavbar" @mouseenter="show_options_shop = true">
                                    Checkout
                                </RouterLink>
                            </div>
                        </div>
                        
                    </li>

                    <li class="menu-item-main" @mouseover="!mobileDeviceCamera ? show_options_mega = true : '' " @mouseleave="!mobileDeviceCamera ? show_options_mega = false : ''">
                        <a class="link-main" @click="mobileDeviceCamera ? toggleShowOptionsMega() : ''">
                            Megamenu
                            <img :src="chevronDown" alt="">
                        </a>
                        <div class="box-show-options-mega" v-show="show_options_mega">
                            <div class="section-options">
                                <RouterLink :to="{name: 'shop'}"
                                class="link-main-drop" @click="closeNavbar" @mouseenter="show_options_mega = true">
                                    New collection
                                </RouterLink>

                                <RouterLink :to="{name: 'shop'}"
                                class="link-main-drop" @click="closeNavbar" @mouseenter="show_options_mega = true">
                                    Best sellers
                                </RouterLink>
                            </div>
                            <div class="section-options">
                                <h2>CLOTHES</h2>
                                <RouterLink :to="{name: 'shop'}"
                                class="link-main-drop" @click="closeNavbar" @mouseenter="show_options_mega = true">
                                    Coats
                                </RouterLink>
                                <RouterLink :to="{name: 'shop'}"
                                class="link-main-drop" @click="closeNavbar" @mouseenter="show_options_mega = true">
                                    Jackets
                                </RouterLink>
                                <RouterLink :to="{name: 'shop'}"
                                class="link-main-drop" @click="closeNavbar" @mouseenter="show_options_mega = true">
                                    Suits
                                </RouterLink>
                            </div>
                            <div class="section-options">
                                <h2>SHOES</h2>
                                <RouterLink :to="{name: 'shop'}"
                                class="link-main-drop" @click="closeNavbar" @mouseenter="show_options_mega = true">
                                    Boots
                                </RouterLink>
                                <RouterLink :to="{name: 'shop'}"
                                class="link-main-drop" @click="closeNavbar" @mouseenter="show_options_mega = true">
                                    Flat shoes
                                </RouterLink>
                                <RouterLink :to="{name: 'shop'}"
                                class="link-main-drop" @click="closeNavbar" @mouseenter="show_options_mega = true">
                                    Heels
                                </RouterLink>
                            </div>
                            <div></div>
                        </div>
                    </li>

                    <div class="button-demo-whatsapp">  
                        <Link to="admin">
                            Administrar
                        </Link>
                        <div class="fab whatsapp" style="width: 40px; height: 40px; margin-top: 0; font-size: .6rem;"> <a target="_blank" href="https://wa.me/51952107003?text=Hola,%20por%20favor%20deseo%20más%20información%20de%20la%20plataforma%20AbrilATS,%20gracias."> <i class="fa fa-whatsapp"></i></a> </div>
                    </div>
                </ul>

            </div>

            <div class="header-img-right">
                <RouterLink :to="{name: 'shop'}">
                    <img :src="iconlogoPage" alt="">
                </RouterLink>
            </div>
        </div>
    </header>
</template>


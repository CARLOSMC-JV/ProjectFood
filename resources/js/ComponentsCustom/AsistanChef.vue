<script>  
    import iconChef from '../../img/chef_icon.png';
    export default {
        name: "helpAsistant",
        data() {
            return{
   
                iconChef,
            }
        },
        methods: {
         
        },

    };
</script>
<template>
    <div class="chef">
        <!-- <h2>Hola mundo</h2> -->
        <div class="box-help" @click="openVideoTutorialModal()">
            <div class="text"><p>¡Hola! Somos la casa de los ravioles. Si necesitas ayuda con tu pedido, ¡estamos listos para ayudarte!</p></div>

            <div class="image-chef"><img :src="iconChef"></div>
        </div>

    </div>
</template>

<style lang="scss">
    .chef{
        .box-help{
            position: fixed;
            display: flex;
            bottom: 10%;
            right: 5%;
        }

    }
</style>

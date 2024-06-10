<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { Head, useForm } from '@inertiajs/vue3';
import Swal  from "sweetalert2";
import MainNav from "@/ComponentsCustom/MainNav.vue";

    export default {
        data() {
            return {
                form: useForm({
                    id: '',
                }),
            }
        },
        props:{
            class_categories: {type: Object}
        },
        created(){
            console.log(this.class_categories);
        },
        methods:{
            deleteDepartment(id) {
                Swal.fire({
                    title: "¿Seguro que desea eliminar " + this.class_categories.name + "?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: '<i class="fa-solid fa-check"></i>Si, eliminar',
                    cancelButtonText: '<i class="fa-solid fa-ban"></i>Cancelar',
                }).then((result) => {
                    if (result.isConfirmed) {
                    this.form.delete(route("class_categories.destroy", id))
                        
                    }
                });
            },
            confirmDelete(id, name) {
                console.log(id);
                this.class_categories.id = id;
                this.class_categories.name = name;
                this.deleteDepartment(id);
            },
        },
        components:{
            Head,
            MainNav,
            DangerButton,
            AuthenticatedLayout
        }
    }

</script>

<template>
    <Head title="Categorias Superiores" />
    <!-- <MainNav/> -->
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>
        <div class="py-12">
            <div class="bg-white grid v-screen place-items-center ml-24 mr-24 rounded-md">
                <div class="mt-8 mb-3 flex">
                    <a :href="route('class_categories.create')" 
                        :class="'px-4 py-2 bg-gray-800 text-white border rounded-md font-semibold text-xs'">
                        <i class="fa fa-solid fa-plus-circle"></i>Agregar
                    </a>
                </div>
            </div>

            <div class="bg-white grid place-items-center ml-24 mr-24 pb-8">
                <table class="table-auto border border-gray-400">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-4">#</th>
                            <th class="px-4 py-4">CATEGORIA</th>
                            <th class="px-4 py-4" colspan="2">Opciones</th>
                            <th class="px-4 py-4"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="dep, i in class_categories" :key="dep.id">
                            <td class="border border-gray-400 px-4 py-4">{{ i+1 }}</td>
                            <td class="border border-gray-400 px-4 py-4">{{ dep.name }}</td>
                            <td class="border border-gray-400 px-4 py-4">
                                <a :href="route('class_categories.edit', dep.id)" 
                                    :class="'px-4 py-2 bg-yellow-400 text-white border rounded-md font-semibold text-xs hover:bg-yellow-600'">
                                    <i class="fa-solid fa-edit text-white"></i>Editar
                                </a>
                            </td>
                            <td class="border border-gray-400 px-4 py-4">
                                <DangerButton @click="confirmDelete(dep.id, dep.name)">
                                    <i class="fa-solid fa-trash text-white"></i>
                                </DangerButton>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
    
    
</template>

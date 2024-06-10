<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { Head, useForm } from '@inertiajs/vue3';
import Swal  from "sweetalert2";
import MainNav from "@/ComponentsCustom/MainNav.vue";

import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue'

import SelectInput from '@/Components/SelectInput.vue'

import WarningButton from '@/Components/WarningButton.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import Modal from '@/Components/Modal.vue'

import { nextTick, ref } from 'vue';

    export default {
        data() {
            return {
                form: useForm({
                    class_category_id:'',
                    name:''
                }),
                formPage:useForm({}),
                nameInput:null,
                modal: false,
                title: '',
                operation: 1,
                id_value:'',
                category_data:undefined,

                perPage: 8,
                currentPage: 1,
                number_pages:undefined,

            }
        },
        props:{
            categories: {type: Object},
            class_categories: {type: Object}
        },
        created(){
            this.number_pages = Math.ceil(this.categories.length / this.perPage);

        },
        methods:{
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
            pageClick(){
                this.form.get(route("categories.destroy", id))
            },
            openModal(op, name, class_category, employee_id){
                this.modal=true;
                this.operation=op;
                this.employee_id=employee_id;
                if(op == 1){
                    this.title="Crear"
                }else{
                    this.title="Editar";
                    this.form.name=name,
                    this.form.class_category_id=class_category
                }
            },
            closeModal(){
                this.modal=false
                this.form.reset()
                this.form.name=""
                this.form.class_category_id=""
            },  
            save(){
                try {
                    if(this.operation == 1){
                        this.form.post(route('categories.store'), {
                            onSuccess: () => {
                                this.ok("Categoria guardada"); 

                            }
                        });
                    }else{
                        this.form.put(route('categories.update', this.employee_id), {
                            onSuccess: () => {
                                this.ok("Categoria actualizada")
                            }
                        });
                    }
                } catch (error) {
                    console.log(error);
                }
                
            },
            ok(msj){
                this.form.reset();
                this.closeModal();
                Swal.fire(
                    {title: msj,
                    icon: "success"
                    }
                );
            },  
            deleteEmployees(id) {
                Swal.fire({
                    title: "¿Seguro que desea eliminar " + this.categories.name + "?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: '<i class="fa-solid fa-check"></i>Si, eliminar',
                    cancelButtonText: '<i class="fa-solid fa-ban"></i>Cancelar',
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.form.delete(route("categories.destroy", id));
                        this.ok("Categoria eliminada")
                        
                    }
                });
            },
            confirmDelete(id, name) {
                this.categories.id = id;
                this.categories.name = name;
                this.deleteEmployees(id);
            },
        },
        computed:{
            totalPages() {
                return Math.ceil(this.categories.length / this.perPage);
            },
            filteredCategory: function(){
                if (this.categories) {
                    const startIndex = this.perPage * (this.currentPage - 1);
                    const endIndex = startIndex + this.perPage;
                    let filtered = this.categories;

                    
                    const arrayReduced = filtered.slice(startIndex, endIndex);

                    return arrayReduced;
                }else{
                    return []
                }
            },
        },
        components:{
            Head,
            MainNav,
            DangerButton,
            InputError,
            InputLabel,
            PrimaryButton,
            TextInput,
            SelectInput,
            WarningButton,
            SecondaryButton,
            Modal,
            nextTick,
            ref,
            AuthenticatedLayout
        }
    }

</script>

<template>
    <Head title="Categorias" />
    <!-- <MainNav/> -->
    <AuthenticatedLayout>
    <div class="py-12">
            <div class="bg-white grid v-screen place-items-center ml-24 mr-24 rounded-md">
                <div class="mt-8 mb-3 flex">
                    <PrimaryButton @click="openModal(1)">
                        <i class="fa-solid fa-plus-circle"></i> Agregar
                    </PrimaryButton>
                </div>
            </div>

            <div class="bg-white grid place-items-center ml-24 mr-24 pb-8">
                <table class="table-auto border border-gray-400">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-2 py-2">#</th>
                            <th class="px-2 py-2">Categoria</th>
                            <th class="px-2 py-2">Categoria Sup.</th>
                            <th class="px-2 py-2" colspan="2">Opciones</th>
                            <th class="px-2 py-2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="subcat, i in filteredCategory" :key="subcat.id">
                            <td class="border border-gray-400 px-2 py-2">{{ i+1 }}</td>
                            <td class="border border-gray-400 px-2 py-2">{{ subcat.name }}</td>
                            <td class="border border-gray-400 px-2 py-2">{{ subcat.category }}</td>
                            <td class="border border-gray-400 px-2 py-2">
                                <WarningButton @click="openModal(2, subcat.name,subcat.class_category_id, subcat.id)">
                                    <i class="fa-solid fa-edit text-white"></i>
                                </WarningButton>
                            </td>
                            <td class="border border-gray-400 px-2 py-2">
                                <DangerButton @click="confirmDelete(subcat.id, subcat.name)">
                                    <i class="fa-solid fa-trash text-white"></i>
                                </DangerButton>
                            </td>
                        </tr>
                    </tbody>
                </table>

                    <nav class="pt-1 ml-auto" aria-label="Pagination">
                        <ul class="pagination mb-0">
                            <li class="page-item d-sm-none">
                                <span class="page-link page-link-static">1 / 5</span>
                            </li>
     
                            <div class="contain-number">
                                <button class="button-left"  @click="prevPage" :disabled="currentPage===1" :class="[currentPage===1 ? 'disabled-button': '']">
                                    <i class="fa-solid fa-angle-left" style="color: #17696a;"></i>
                                </button>
        
                                <li class="page-item d-none d-sm-block number-page" style="cursor: pointer;" aria-current="page" @click="goToPageNumber(page)" v-for="page in totalPages" :key="page" :class="{ 'active-div': page === currentPage }">
                                    <span class="page-link">{{page}}
                                    </span>
                                </li>

                                <button class="button-rigth" @click="nextPage" :disabled="number_pages===currentPage" :class="[number_pages===currentPage ? 'disabled-button': '']">
                                    <i class="fa-solid fa-angle-right" style="color: #17696a;"></i>
                                </button>
                            </div>
            
                        
                        </ul>
                    </nav>
            </div>

            <Modal :show="modal" @close="closeModal">
                <h2 class="p-3 text-lg font-medium text-gray-900">{{ title }}</h2>

                <div class="p-3">
                    <InputLabel for="name" value="Nombre de Categoria: "></InputLabel>

                    <TextInput id="name" ref="nameInput" v-model="form.name" type="text" class="mt-1 block w-3/4"
                    placeholder="Nombre de Categoria"></TextInput>

                    <!-- <InputLabel for="slug" value="Slug: " class="mt-4"></InputLabel>

                    <TextInput id="slug" ref="slugInput" v-model="form.slug" type="text" class="mt-1 block w-3/4"
                    placeholder=""></TextInput> -->

                    <InputError :message="form.errors.name" class="mt-2"></InputError>
                </div>


                <div class="p-3">
                    <InputLabel for="class_category_id" value="Categoria Superior: "></InputLabel>

                    <SelectInput :options="class_categories" id="class_category_id" v-model="form.class_category_id" class="mt-1 block w-3/4"
                    placeholder="Categoria Superior"></SelectInput>

                    <InputError :message="form.errors.class_category_id" class="mt-2"></InputError>
                </div>

                <div class="p-3">
                    <PrimaryButton :disable="form.processing" @click="save">
                            <i class="fa-solid fa-save text-white">Guardar</i>
                    </PrimaryButton>
                </div>

                <div class="p-3 mt-6 flex justify-end">

                    <SecondaryButton class="ml-3" :disabled="form.processing" @click="closeModal">
                        Cancel
                    </SecondaryButton>
                </div>
            </Modal>
        </div>
    </AuthenticatedLayout>
</template>

<style lang="scss" scoped>
    .py-12{
        .pt-1{
            display: flex;
            justify-content: center;
            width: 100%;
            .pagination{
            justify-content: center;
            margin-top: 2rem;
            .contain-number{
                display: flex;
                align-items: center;
                gap: 1rem;
                .number-page{
                    margin-bottom: 0rem;
                    .page-link{
                        padding: 0 0.5rem;
                    }
                    &.active-div{
                        background-color: #17696a;
                        border-radius: 0.2rem;
                        .page-link{
                            color: #ffffff;
                            padding: 0 0.5rem;
                        }
                    }

                    &:hover{
                        background-color: #17696a;
                        border-radius: 0.2rem;
                        .page-link{
                            color: #ffffff;
                            padding: 0 0.5rem;
                        }
                    }
                    
                }
                .button-left{
                    margin-right: 0.2rem;
                    &.disabled-button{
                        opacity: 0.7;
                        cursor: not-allowed;
                    }
                }
                .button-rigth{
                    margin-left: 0.2rem;
                    &.disabled-button{
                        opacity: 0.7;
                        cursor: not-allowed;
                    }
                }
            }
        }
        }
    }
</style>


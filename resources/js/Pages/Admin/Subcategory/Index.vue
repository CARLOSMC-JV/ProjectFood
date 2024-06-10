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

// import VueTaiwlindPagination from '@/ocrv/vue-tailwind-pagination';

    export default {
        data() {
            return {
                form: useForm({
                    category_id:'',
                    name:'',
                    slug:''
                }),
                formPage:useForm({}),
                nameInput:null,
                modal: false,
                title: '',
                operation: 1,
                id_value:'',

                perPage: 8,
                currentPage: 1,
                number_pages:undefined,
            }
        },
        props:{
            subcategories: {type: Object},
            categories: {type: Object}
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
                this.form.get(route("subcategories.destroy", id))
            },
            openModal(op, name, category, employee_id){
                this.modal=true;
                // this.nextTick(()=> this.nameInput.value.focus());
                this.operation=op;
                this.employee_id=employee_id;
                if(op == 1){
                    this.title="Crear"
                }else{
                    this.title="Editar";
                    this.form.name=name,
                    this.form.category_id=category
                }
            },
            closeModal(){
                this.modal=false
                this.form.reset()
                this.form.name=""
                this.form.slug=""
                this.form.category_id=""
            },
            save(){
                try {
                    console.log(this.operation);
                    if(this.operation == 1){
                        this.form.post(route('subcategories.store'), {
                            onSuccess: () => {
                                this.ok("Subcategoria guardada");

                            }
                        });
                    }else{
                        this.form.put(route('subcategories.update', this.employee_id), {
                            onSuccess: () => {
                                this.ok("Subcategoria actualizada")
                            }
                        });
                    }
                } catch (error) {
                    console.log(error);
                }

            },
            ok(msj){
                console.log(msj);
                this.form.reset();
                this.closeModal();
                Swal.fire(
                    {title: msj,
                    icon: "success"
                    }
                );
            },
            deleteEmployees(id) {
                console.log(id);
                Swal.fire({
                    title: "¿Seguro que desea eliminar " + this.subcategories.name + "?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: '<i class="fa-solid fa-check"></i>Si, eliminar',
                    cancelButtonText: '<i class="fa-solid fa-ban"></i>Cancelar',
                }).then((result) => {
                    console.log(result);
                    if (result.isConfirmed) {
                    this.form.delete(route("subcategories.destroy", id));
                    this.ok("Subcategoria eliminada")
                    // this.form.delete(route("subcategories.destroy", id, {
                    //     onSuccess: ()=> {
                    //         this.ok("Subcategoria eliminada")
                    //     }
                    // }))

                    }
                });
            },
            confirmDelete(id, name) {
                console.log(id);
                this.subcategories.id = id;
                this.subcategories.name = name;
                this.deleteEmployees(id);
            },
        },
        computed:{
            totalPages() {
                return Math.ceil(this.subcategories.length / this.perPage);
            },
            filteredSubCategory: function(){
                if (this.subcategories) {
                    const startIndex = this.perPage * (this.currentPage - 1);
                    const endIndex = startIndex + this.perPage;
                    let filtered = this.subcategories;


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
    <Head title="Subcategorias" />
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
                            <th class="px-2 py-2">Subcategoria</th>
                            <th class="px-2 py-2">Categoria</th>
                            <th class="px-2 py-2" colspan="2">Opciones</th>
                            <th class="px-2 py-2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="subcat, i in filteredSubCategory" :key="subcat.id">
                            <td class="border border-gray-400 px-2 py-2">{{ i+1 }}</td>
                            <td class="border border-gray-400 px-2 py-2">{{ subcat.name }}</td>
                            <td class="border border-gray-400 px-2 py-2">{{ subcat.category }}</td>
                            <td class="border border-gray-400 px-2 py-2">
                                <WarningButton @click="openModal(2, subcat.name,subcat.category_id, subcat.id)">
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
                    <InputLabel for="name" value="Nombre de Subcategoria: "></InputLabel>

                    <TextInput id="name" ref="nameInput" v-model="form.name" type="text" class="mt-1 block w-3/4"
                    placeholder="Nombre de Subcategoria"></TextInput>

                    <!-- <InputLabel for="slug" value="Slug: " class="mt-4"></InputLabel>

                    <TextInput id="slug" ref="slugInput" v-model="form.slug" type="text" class="mt-1 block w-3/4"
                    placeholder=""></TextInput> -->

                    <InputError :message="form.errors.name" class="mt-2"></InputError>
                </div>


                <div class="p-3">
                    <InputLabel for="category_id" value="Categoria: "></InputLabel>

                    <SelectInput :options="categories" id="category_id" v-model="form.category_id" class="mt-1 block w-3/4"
                    placeholder="Categoria"></SelectInput>

                    <InputError :message="form.errors.category_id" class="mt-2"></InputError>
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

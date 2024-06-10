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
                    class_category_id:'',
                    name:'',
                    price:'',
                    quantity:'',
                    images: [],
                    description:''
                }),
                formPage:useForm({}),
                nameInput:null,
                descriptonInput:null,
                cantidadInput:null,
                modal: false,
                title: '',
                operation: 1,
                id_value:'',
                filteredSubCat: [],
                filteredCat:[],
                product_id:undefined,

                perPage: 8,
                currentPage: 1,
                number_pages:undefined,
                saving: false,
            }
        },
        props:{
            products: {type: Object},
            subcategories: {type: Object},
            categories: {type: Object},
            class_categories: {type: Object},
        },
        created(){
            this.number_pages = Math.ceil(this.products.length / this.perPage);
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
            filterCategories() {
                const selectedClassCategory = this.form.class_category_id;
                if(this.form.subcategory_id){
                    this.form.subcategory_id=""
                }
                this.filteredCat = this.categories.filter((category) => {
                    return category.class_category_id == selectedClassCategory;
                });

            },

            filterSubcategories() {
                // Filtra las subcategorías en función de la categoría seleccionada
                const selectedCategory = this.form.category_id;
                this.filteredSubCat = this.subcategories.filter((subcategory) => {
                    return subcategory.category_id == selectedCategory;
                });
                // Restablece la subcategoría seleccionada
                this.form.subcategory_id = null;
            },
            handleImageUpload(event) {
                const files = event.target.files;
                this.form.images = files;
            },
            pageClick(){
                this.form.get(route("products.destroy", id))
            },

            openModal(op, name, description, quantity, class_category, price, product_id){
                console.log(class_category)
                this.modal=true;
                // this.nextTick(()=> this.nameInput.value.focus());
                this.operation=op;
                this.product_id=product_id;
                if(op == 1){
                    this.title="Crear"
                }else{
                    this.title="Editar";
                    this.form.name=name
                    this.form.description=description
                    this.form.class_category_id=class_category
                    this.form.price=price
                    this.form.quantity=quantity
                }
            },
            closeModal(){
                this.modal=false
                this.form.reset()
                this.form.name=""
                this.form.description=""
                this.form.class_category_id=""
            },
            save(){
                try {
                    this.saving = true;
                    console.log(this.operation);
                    console.log(this.form.class_category_id);
                    const formData = new FormData();
                    formData.append('name', this.form.name);
                    formData.append('price', this.form.price);
                    formData.append('quantity', this.form.quantity);
                    formData.append('description', this.form.description);
                    formData.append('class_category_id', this.form.class_category_id);

                    for (let i = 0; i < this.form.images.length; i++) {
                        formData.append('images[]', this.form.images[i]);
                    }
                    
                    if(this.operation == 1){
                        this.form.post(route('products.store'), {
                            method: 'post',
                            body: formData,
                            onSuccess: () => {
                                this.ok("Producto guardado");
                                this.saving = false;
                            }
                        });
                    }else{
                        try {
                            this.form.put(route('products.update', this.product_id), {
                                onSuccess: (request) => {
                                    console.log(request);
                                    this.ok("Producto actualizado")
                                }
                            });
                        }catch (error) {
                            console.log(error);
                        }
                    }
                } catch (error) {
                    console.log(error);
                } finally {
                        this.saving = false; // Restablece el estado de carga a falso en caso de error
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
                    title: "¿Seguro que desea eliminar " + this.products.name + "?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: '<i class="fa-solid fa-check"></i>Si, eliminar',
                    cancelButtonText: '<i class="fa-solid fa-ban"></i>Cancelar',
                }).then((result) => {
                    console.log(result);
                    if (result.isConfirmed) {
                    this.form.delete(route("products.destroy", id, {
                        onSuccess: ()=> {
                            this.ok("Producto eliminado")
                        }
                    }))

                    }
                });
            },
            confirmDelete(id, name) {
                console.log(id);
                this.products.id = id;
                this.products.name = name;
                this.deleteEmployees(id);
            },
        },
        computed:{
            totalPages() {
                return Math.ceil(this.products.length / this.perPage);
            },
            filteredProduct: function(){
                if (this.products) {
                    const startIndex = this.perPage * (this.currentPage - 1);
                    const endIndex = startIndex + this.perPage;
                    let filtered = this.products;


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
    <Head title="Productos" />
    <!-- <MainNav/> -->
    <AuthenticatedLayout>
    <div class="py-12 contain-product">
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
                            <th class="px-2 py-2">Producto</th>
                            <!-- <th class="px-2 py-2">Imagen</th> -->
                            <th class="px-2 py-2">Precio</th>
                            <th class="px-2 py-2">Cantidad</th>
                            <th class="px-2 py-2">Categoria</th>
                            <!-- <th class="px-2 py-2">Categoria</th> -->
                            <!-- <th class="px-2 py-2">SubCategoria</th> -->
                            <th class="px-2 py-2" colspan="2">Opciones</th>
                            <th class="px-2 py-2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="prod, i in filteredProduct" :key="prod.id">
                            <td class="border border-gray-400 px-2 py-2" v-if="currentPage===1">{{ i+1 }}</td>
                            <td class="border border-gray-400 px-2 py-2" v-else-if="currentPage===2">{{ 8 + i + 1 }}</td>
                            <td class="border border-gray-400 px-2 py-2" v-else-if="currentPage===3">{{ 16+ i + 1 }}</td>

                            <td class="border border-gray-400 px-2 py-2" style="font-size: 0.875rem;">{{ prod.name }}</td>
                            <!-- <td class="border img-box border-gray-400 px-2 py-2"><img :src="prod.image" /></td> -->
                            <td class="border border-gray-400 px-2 py-2">{{ prod.price.toFixed(2) }}</td>
                            <td class="border border-gray-400 px-2 py-2">{{ prod.quantity }}</td>
                            <td class="border border-gray-400 px-2 py-2" style="font-size: 0.875rem;">{{ prod.class_category }}</td>
                            <!-- <td class="border border-gray-400 px-2 py-2" style="font-size: 0.875rem;">{{ prod.category }}</td> -->
                            <!-- <td class="border border-gray-400 px-2 py-2" style="font-size: 0.875rem;">{{ prod.subcategory }}</td> -->
                            <td class="border border-gray-400 px-2 py-2">
                                <WarningButton @click="openModal(2, prod.name, prod.description, prod.quantity, prod.class_categories_id, prod.price, prod.id)">
                                    <i class="fa-solid fa-edit text-white"></i>
                                </WarningButton>
                            </td>
                            <td class="border border-gray-400 px-2 py-2">
                                <DangerButton @click="confirmDelete(prod.id, prod.name)">
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
                    <InputLabel for="name" value="Nombre del Producto: "></InputLabel>

                    <TextInput id="name" ref="nameInput" v-model="form.name" type="text" class="mt-1 block w-3/4"
                    placeholder="Nombre del Producto" autocomplete="off"></TextInput>

                    <InputError :message="form.errors.name" class="mt-2"></InputError>
                </div>

                <div class="p-3">
                    <InputLabel for="description" value="Descripción del Producto: "></InputLabel>
                    <textarea id="description" ref="descriptonInput" v-model="form.description" placeholder="Descripción del Producto" class="mt-1 block w-3/4 rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 placeholder:text-gray-300">

                    </textarea>

                    <InputError :message="form.errors.description" class="mt-2"></InputError>
                </div>

                <div class="p-3">
                    <InputLabel for="price" value="Precio: "></InputLabel>

                    <TextInput id="price" ref="priceInput" v-model="form.price" type="number" class="mt-1 block w-3/4"
                    placeholder="Precio"></TextInput>

                    <InputError :message="form.errors.price" class="mt-2"></InputError>
                </div>

                <div class="p-3">
                    <InputLabel for="quantity" value="Cantidad: "></InputLabel>

                    <TextInput id="quantity" ref="quantityInput" v-model="form.quantity" type="number" class="mt-1 block w-3/4"
                    placeholder="Cantidad"></TextInput>

                    <InputError :message="form.errors.quantity" class="mt-2"></InputError>
                </div>

                <div class="p-3" v-if="operation===1">
                    <InputLabel for="image" value="Imagen:"></InputLabel>

                    <input type="file" id="image" accept="image/*" ref="imageInput" @change="handleImageUpload" class="mt-1 block w-3/4" multiple>
                </div>

                <div class="p-3">
                    <InputLabel for="class_category_id" value="Categoria: "></InputLabel>

                    <SelectInput :options="class_categories" id="class_category_id" v-model="form.class_category_id" @change="filterCategories" class="mt-1 block w-3/4"
                    placeholder="Categoria" ></SelectInput>

                    <InputError :message="form.errors.class_category_id" class="mt-2"></InputError>
                </div>

                <!-- <div class="p-3">
                    <InputLabel for="category_id" value="Categoria: "></InputLabel>

                    <SelectInput :options="operation==1 ? filteredCat : categories" id="category_id" v-model="form.category_id" @change="filterSubcategories" class="mt-1 block w-3/4"
                    placeholder="Categoria" ></SelectInput>

                    <InputError :message="form.errors.category_id" class="mt-2"></InputError>
                </div>

                <div class="p-3">
                    <InputLabel for="subcategory_id" value="Subcategoria: "></InputLabel>

                    <SelectInput :options="operation==1 ? filteredSubCat : subcategories" id="subcategory_id" v-model="form.subcategory_id" class="mt-1 block w-3/4"
                    placeholder="Subcategoria"></SelectInput>

                    <InputError :message="form.errors.subcategory_id" class="mt-2"></InputError>
                </div> -->

                <div class="p-3">
                    <PrimaryButton :disabled="saving" @click="save" class="btn-add">
                        <span v-if="!form.processing">Guardar</span>
                        <span v-else><i class="fas fa-spinner fa-spin"></i> Guardando...</span>
                    </PrimaryButton>
                </div>

                <div class="p-3 mt-2 flex justify-end">

                    <SecondaryButton class="ml-3" :disabled="form.processing" @click="closeModal">
                        Cancel
                    </SecondaryButton>
                </div>
            </Modal>
        </div>
    </AuthenticatedLayout>
</template>

<style lang="scss" scoped>
    .p-3{
        .btn-add{
            background: #222F54;
            span{
                color: #ffffff;
            }
        }
        .btn-add:hover{
            background: #324885;
        }
    }
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

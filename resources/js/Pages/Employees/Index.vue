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
                    department_id:'',
                    name:'',
                    email:'',
                    phone:''
                }),
                formPage:useForm({}),
                nameInput:null,
                modal: false,
                title: '',
                operation: 1,
                id_value:''
            }
        },
        props:{
            employees: {type: Object},
            departments: {type: Object}
        },
        created(){
            this.employees_data=this.employees.data
        },
        methods:{
            pageClick(){
                this.form.get(route("employees.destroy", id))
            },
            openModal(op, name, email, phone, department, employee_id){
                this.modal=true;
                // this.nextTick(()=> this.nameInput.value.focus());
                this.operation=op;
                this.employee_id=employee_id;
                if(op == 1){
                    this.title="Crear"
                }else{
                    this.title="Editar";
                    this.form.name=name
                    this.form.email=email
                    this.form.phone=phone
                    this.form.department_id=department
                }
            },
            closeModal(){
                this.modal=false
                this.form.reset()
                this.form.name=""
                this.form.email=""
                this.form.phone=""
                this.form.department_id=""
            },  
            save(){
                if(this.operation == 1){
                    this.form.post(route('employees.store'), {
                        onSuccess: () => {this.ok("Empleado guardado")}
                    });
                }else{
                    this.form.put(route('employees.update', this.employee_id), {
                        onSuccess: () => {this.ok("Empleado actualizado")}
                    });
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
                    title: "¿Seguro que desea eliminar " + this.employees.name + "?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: '<i class="fa-solid fa-check"></i>Si, eliminar',
                    cancelButtonText: '<i class="fa-solid fa-ban"></i>Cancelar',
                }).then((result) => {
                    if (result.isConfirmed) {
                    this.form.delete(route("employees.destroy", id, {onSuccess: ()=> {this.ok("Empleado eliminado")}}))
                        
                    }
                });
            },
            confirmDelete(id, name) {
                console.log(id);
                this.employees.id = id;
                this.employees.name = name;
                this.deleteEmployees(id);
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
    <Head title="Employees" />
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
                            <th class="px-2 py-2">NAME</th>
                            <th class="px-2 py-2">EMAIL</th>
                            <th class="px-2 py-2">PHONE</th>
                            <th class="px-2 py-2">DEPARTMENT</th>
                            <th class="px-2 py-2" colspan="2">Opciones</th>
                            <th class="px-2 py-2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="emp, i in employees_data" :key="emp.id">
                            <td class="border border-gray-400 px-2 py-2">{{ i+1 }}</td>
                            <td class="border border-gray-400 px-2 py-2">{{ emp.name }}</td>
                            <td class="border border-gray-400 px-2 py-2">{{ emp.email }}</td>
                            <td class="border border-gray-400 px-2 py-2">{{ emp.phone }}</td>
                            <td class="border border-gray-400 px-2 py-2">{{ emp.department }}</td>
                            <td class="border border-gray-400 px-2 py-2">
                                <WarningButton @click="openModal(2, emp.name, emp.email, emp.phone, emp.department_id, emp.id)">
                                    <i class="fa-solid fa-edit text-white"></i>
                                </WarningButton>
                            </td>
                            <td class="border border-gray-400 px-2 py-2">
                                <DangerButton @click="confirmDelete(dep.id, dep.name)">
                                    <i class="fa-solid fa-trash text-white"></i>
                                </DangerButton>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <Modal :show="modal" @close="closeModal">
                <h2 class="p-3 text-lg font-medium text-gray-900">{{ title }}</h2>

                <div class="p-3">
                    <InputLabel for="name" value="Name: "></InputLabel>

                    <TextInput id="name" ref="nameInput" v-model="form.name" type="text" class="mt-1 block w-3/4"
                    placeholder="Name"></TextInput>

                    <InputError :message="form.errors.name" class="mt-2"></InputError>
                </div>


                <div class="p-3">
                    <InputLabel for="email" value="Email: "></InputLabel>

                    <TextInput id="email" v-model="form.email" type="email" class="mt-1 block w-3/4"
                    placeholder="Email"></TextInput>

                    <InputError :message="form.errors.email" class="mt-2"></InputError>
                </div>

                <div class="p-3">
                    <InputLabel for="phone" value="Phone: "></InputLabel>

                    <TextInput id="phone" v-model="form.phone" type="text" class="mt-1 block w-3/4"
                    placeholder="Phone"></TextInput>

                    <InputError :message="form.errors.phone" class="mt-2"></InputError>
                </div>

                <div class="p-3">
                    <InputLabel for="department_id" value="Department: "></InputLabel>

                    <SelectInput :options="departments" id="department_id" v-model="form.department_id" class="mt-1 block w-3/4"
                    placeholder="Department"></SelectInput>

                    <InputError :message="form.errors.department_id" class="mt-2"></InputError>
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

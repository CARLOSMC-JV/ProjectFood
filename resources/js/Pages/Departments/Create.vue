<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import HeroSlider from "@/ComponentsCustom/HeroSlider.vue";
import MainNav from "@/ComponentsCustom/MainNav.vue";
import ListProductsMain from "@/ComponentsCustom/ListProductsMain.vue";
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
export default {
    data(){
        return{
            form: useForm({
                    name: '',
                }),
        }
    },
    components:{
        Head,
        AuthenticatedLayout,
        HeroSlider,
        MainNav,
        ListProductsMain,
        InputError,
        PrimaryButton,
        InputLabel,
        TextInput
    },
}
</script>

<template>
    <Head title="Create Departments" />
<!-- 
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">You're logged in!</div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout> -->

    <MainNav/>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-4 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <form @submit.prevent="$event=>form.post(route('departments.store'))" class="mt-6 space-y-6 max-w-xl">
                        <InputLabel for="name" value="Department"></InputLabel>
                        <TextInput id="name" type="text" v-model="form.name" autofocus required class="mt-1 block w-full"></TextInput>
                        <InputError :message="form.errors.name" class="mt-2"></InputError>
                        <PrimaryButton :disbled="form.processing">
                            <i class="fa fa-solid fa-save"></i>Save
                        </PrimaryButton>
                    </form>
                </div>
            </div>
    </div>
</template>

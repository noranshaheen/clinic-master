<template>
    <div class="px-3 py-6 w-screen h-screen flex justify-center items-center">
        <jet-dialog-modal :show="showDialog" @close="showDialog=false" max-width="2xl" max-height="h-1/2"
        >
            <template #title>
                الفيديو للتعرف على طريقة الربط و الحصول على كود الربط
            </template>
            <template #content>
                <iframe
                    width="100%"
                    height="480px"
                    src="https://www.youtube.com/watch?v=L3dX9TpcHsU"
                    title="Accounting Master"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen />				
            </template>
        </jet-dialog-modal>
		<div
            class="grid grid-cols-2 gap-4 w-full lg:w-2/5 xl:w-2/5 2xl:w-2/6 border border-gray-200 rounded-lg shadow-lg p-6"
        >
            <div class="col-span-2 items-center justify-center h-full p-12">
                <div class="w-full">
                    <h1 class="text-center text-2xl font-semibold text-gray-700">مرحباً فى برنامج كلينيك ماستر</h1>
                    <p class="text-center mt-2 text-sm text-gray-500">
                        اختر البيئة المناسبة
                    </p>
                </div>
            </div>
            <div class="col-span-2 bg-cover lg:block">
                <div class="mt-8 flex justify justify-around">
                    <button
                        class="w-1/3 px-4 py-2 tracking-wide text-white transition-colors duration-200 transform bg-gray-700 rounded hover:bg-gray-600 focus:outline-none focus:bg-gray-600"
                        @click="actualEnv()"
                    >
                        البيئة الفعلية
                    </button>
                    <button
                        class="w-1/3 px-4 py-2 tracking-wide text-white transition-colors duration-200 transform bg-gray-700 rounded hover:bg-gray-600 focus:outline-none focus:bg-gray-600"
                        @click="demoEnv()"
                    >
                        البيئة التجريبية
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import InputError from "@/Jetstream/InputError.vue";
import JetDialogModal from '@/Jetstream/DialogModal.vue'
import swal from "sweetalert";
import axios from "axios";

export default {
    components: {
        InputError,
        JetDialogModal
    },
    props: {},
    data() {
        return {
            showDialog: false,
           
        };
    },
    methods: {
        actualEnv(){
            this.$inertia.visit(route("setup.actual.step1"));
        },
        demoEnv() {
            this.$inertia.visit(route("setup.demo.step1"));
        },
    },

    created() {
       
    },
};
</script>
<style scoped>
button:disabled {
    cursor: not-allowed;
}
input:focus {
    box-shadow: none;
}
</style>

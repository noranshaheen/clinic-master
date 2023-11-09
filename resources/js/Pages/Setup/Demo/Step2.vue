<template>
    <div class=" my-2 px-3 py-6 flex justify-center items-center" dir="rtl">
        <div
            class="grid grid-cols-1 gap-4 w-full lg:w-2/5 xl:w-2/5 2xl:w-1/3 border border-gray-200 rounded-lg shadow-lg p-6">
            <div class="col-span-1 items-center justify-center h-full p-12">
                <div class="w-full">
                    <h1 class="text-center text-2xl font-semibold text-gray-700">مرحباً فى برنامج كلينيك ماستر</h1>
                    <p class="text-center mt-2 text-sm text-gray-500">
                        خطوتين لإعداد بيانات تجريبية للبرنامج
                    </p>
                </div>
            </div>
            <div class="col-span-1 bg-cover lg:block">
                <div class="text-right">
                    <h1 class="text-2xl font-semibold text-gray-700">الخطوة الثانية</h1>
                    فتح مجموعة مواعيد
                </div>
            </div>
            <form @submit.prevent="submit">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <div class="">
                            <jet-label for="date" :value="__('التاريخ')" />
                            <jet-input id="date" type="text" readonly class="mt-1 block w-full" v-model="form.date"
                                required />
                        </div>
                        <div class="mt-4">
                            <jet-label for="Room" :value="__('الغرفة')" />
                            <select id="Room"
                                class="mt-1 block w-full rounded border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow-sm"
                                v-model="form.room">
                                <option v-for="room in all_rooms" :key="room.id" :value="room.id">
                                    {{ room.name }}
                                </option>
                            </select>
                        </div>

                        <div class="mt-4">
                            <jet-label for="from" :value="__('من')" />
                            <jet-input id="from" type="time" class="mt-1 block w-full" v-model="form.from" required />
                        </div>
                        <div class="mt-4">
                            <jet-label for="cases" :value="__('عدد الحالات')" />
                            <jet-input id="cases" type="number" class="mt-1 block w-full" v-model="form.numberOfCases"
                                required />
                        </div>
                    </div>
                    <div>
                        <div class="">
                            <jet-label for="name" :value="__('اسم العيادة')" />
                            <jet-input id="name" type="text" v-model="form.name" vlaue="{{all_clinics[0].name}}" readonly
                                class="mt-1 block w-full" required />
                        </div>
                        <div class="mt-4">
                            <jet-label for="Doctors" :value="__('الطبيب')" />
                            <select id="Doctors"
                                class="mt-1 block w-full rounded border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow-sm"
                                v-model="form.doctor">
                                <option v-for="doctor in all_doctors" :key="doctor.id" :value="doctor.id">
                                    {{ doctor.name }}
                                </option>
                            </select>
                        </div>
                        <div class="mt-4">
                            <jet-label for="To" :value="__('إلى')" />
                            <jet-input id="To" type="time" class="mt-1 block w-full" v-model="form.to" required />
                        </div>

                    </div>
                </div>
            </form>
            <div class="mt-8 flex justify justify-between">
                <button
                    class="w-1/3 px-4 py-2 my-4 tracking-wide text-white transition-colors duration-200 transform bg-gray-700 rounded hover:bg-gray-600 focus:outline-none focus:bg-gray-600"
                    :disabled="formIsProcessing" @click="goBack">
                    {{ "السابق" }}
                </button>

                <button
                    class="w-1/3 px-4 py-2 my-4 tracking-wide text-white transition-colors duration-200 transform bg-gray-700 rounded hover:bg-gray-600 focus:outline-none focus:bg-gray-600"
                    :disabled="formIsProcessing" @click="submit">
                    {{ formIsProcessing ? "جاري التحميل" : "انهاء" }}
                </button>
            </div>
        </div>
    </div>
</template>

<script>

import InputError from "@/Jetstream/InputError.vue";
import JetActionMessage from "@/Jetstream/ActionMessage.vue";
import JetActionSection from "@/Jetstream/ActionSection.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetConfirmationModal from "@/Jetstream/ConfirmationModal.vue";
import JetDangerButton from "@/Jetstream/DangerButton.vue";
import JetDialogModal from "@/Jetstream/DialogModal.vue";
import JetFormSection from "@/Jetstream/FormSection.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetCheckbox from "@/Jetstream/Checkbox.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import JetSectionBorder from "@/Jetstream/SectionBorder.vue";
import JetValidationErrors from "@/Jetstream/ValidationErrors.vue";
import swal from "sweetalert";

export default {
    components: {
        JetActionMessage,
        JetActionSection,
        JetButton,
        JetConfirmationModal,
        JetDangerButton,
        JetDialogModal,
        JetFormSection,
        JetInput,
        JetCheckbox,
        JetInputError,
        InputError,
        JetLabel,
        JetSecondaryButton,
        JetSectionBorder,
        JetValidationErrors,
    },
    props: {},
    data() {
        return {
            errors: [],

            all_clinics: [],
            all_rooms: [],
            all_doctors: [],

            form: this.$inertia.form({
                name: "",
                date: new Date().toLocaleDateString(),
                room: "",
                doctor: "",
                from: "",
                to: "",
            }),
        };
    },
    methods: {
        submit() {
            axios
                .post(route("setup.demo.step2.store"), this.form)
                .then((response) => {
                    this.form.processing = false;
                    swal({
                        title: "تم الحفظ بنجاح",
                        text: "سيتم تحويلك الى البرنامج الأن",
                        icon: "success",
                        button: "موافق",
                    }).then(() => {
                        this.form.processing = false;
                        this.$inertia.visit(route("dashboard"));
                    });
                })
                .catch((error) => {
                    this.form.processing = false;
                    this.$page.props.errors = error.response.data.errors;
                    this.errors = error.response.data.errors; //.password[0];
                    //this.$refs.password.focus()
                });

        },
        goBack() {
            window.location.href = route("setup.demo.step1");
        },
    },
    computed: {
        formIsProcessing() {
            return this.form.processing;
        },
    },
    created() {
        axios.get(route('doctor.all'))
            .then(response => {
                this.all_doctors = response.data;
            }).catch(error => {
            });
        axios.get(route('clinic.all'))
            .then(response => {
                this.all_clinics = response.data;
                this.form.name = response.data[0].name;
            }).catch(error => {
            });
        axios.get(route('room.all'))
            .then(response => {
                this.all_rooms = response.data;
            }).catch(error => {
            });

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

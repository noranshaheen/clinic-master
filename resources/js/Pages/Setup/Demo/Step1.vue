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
                    <h1 class="text-2xl font-semibold text-gray-700">الخطوة الاولى</h1>
                    أدخال بيانات الفرع الرئيسي
                </div>
            </div>
            <form @submit.prevent="submit">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <div class="">
                            <jet-label for="phone" :value="__('Clinic Phone')" />
                            <jet-input id="phone" type="text" class="mt-1 block w-full" v-model="form.phone" required />
                        </div>
                        <div class="mt-4">
                            <jet-label for="Rooms" :value="__('Number of Rooms')" />
                            <jet-input id="Rooms" type="number" class="mt-1 block w-full" v-model="form.numberOfRooms"
                                required />
                        </div>
                        <div class="mt-4">
                            <jet-label for="doctors" :value="__('Number of Doctors')" />
                            <jet-input id="doctors" type="number" class="mt-1 block w-full" v-model="form.numberOfDoctors"
                                required />
                        </div>

                    </div>
                    <div>
                        <div class="">
                            <jet-label for="name" :value="__('Clinic Name')" />
                            <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" required />
                        </div>
                        <div class="mt-4">
                            <jet-label for="location" :value="__('Clinic Address')" />
                            <jet-input id="location" type="text" class="mt-1 block w-full" v-model="form.address" />
                        </div>
                        <div class="mt-4">
                            <jet-label for="Patients" :value="__('Number of Patients')" />
                            <jet-input id="Patients" type="number" class="mt-1 block w-full" v-model="form.numberOfPatients"
                                required />
                        </div>
                        <!-- <div class="mt-4">
                            <jet-label
                                for="branchLogo"
                                :value="__('Branch Logo')"
                            ></jet-label>
                            <input
                                type="file"
                                class="mt-1 block w-full py-2"
                                required
                                accept=".jpg,.png,.jpeg"
                                @change="branchLogo($event)"
                            />
                        </div> -->
                    </div>
                </div>
            </form>
            <div class="mt-8 flex justify justify-end">
                <!-- <button
                    class="w-1/3 px-4 py-2 my-4 tracking-wide text-white transition-colors duration-200 transform bg-gray-700 rounded hover:bg-gray-600 focus:outline-none focus:bg-gray-600"
                    :disabled="formIsProcessing"
                    @click="goBack"
                >
                    {{ "السابق" }}
                </button> -->

                <button
                    class="w-1/3 px-4 py-2 my-4 tracking-wide text-white transition-colors duration-200 transform bg-gray-700 rounded hover:bg-gray-600 focus:outline-none focus:bg-gray-600"
                    :disabled="formIsProcessing" @click="submit">
                    {{ formIsProcessing ? "جاري التحميل" : "التالي" }}
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
            form: this.$inertia.form({
                name: "",
                phone: "",
                address: "",
                numberOfRooms: "",
                numberOfDoctors: "",
                numberOfPatients: "",
            }),
        };
    },
    methods: {
        submit() {
            axios
                .post(route("setup.demo.step1.store"), this.form)
                .then((response) => {
                    this.form.processing = false;
                    swal({
                        title: "تم الحفظ بنجاح",
                        text: "سيتم تحويلك الى الخطوة الثانيةالأن",
                        icon: "success",
                        button: "موافق",
                    }).then(() => {
                        this.form.processing = false;
                        this.$inertia.visit(route("setup.demo.step2"));
                    });
                })
                .catch((error) => {
                    this.form.processing = false;
                    this.$page.props.errors = error.response.data.errors;
                    this.errors = error.response.data.errors; //.password[0];
                    //this.$refs.password.focus()
                });

        },
        // goBack() {
        //     window.location.href = route("setup.step2");
        // },
        // branchLogo(e) {
        //     this.form.branchLogo = e.target.files[0];
        // },
    },
    computed: {
        formIsProcessing() {
            return this.form.processing;
        },
    },
    created() {
        // axios.get(route('settings.json'), { params: { type: "Company Settings"} })
        //     .then(response => {
        //         this.form.name = response.data.company_name;
        //         this.form.issuer_id = response.data.tax_number;                
        //     }).catch(error => {
        //     });
        // axios.get(route('json.branches'))
        //     .then(response => {
        //         this.old_id = response.data[0].Id;
        //         this.form.name = response.data[0].name;
        //         this.form.issuer_id = response.data[0].issuer_id;
        //         this.form.address.branchID = response.data[0].address.branchID;
        //         this.form.address.country = response.data[0].address.country;
        //         this.form.address.governate = response.data[0].address.governate;
        //         this.form.address.regionCity = response.data[0].address.regionCity;
        //         this.form.address.street = response.data[0].address.street;
        //         this.form.address.buildingNumber =
        //             response.data[0].address.buildingNumber;
        //         this.form.address.postalCode = response.data[0].address.postalCode;
        //         this.form.address.additionalInformation =
        //             response.data[0].address.additionalInformation;
        //     }).catch(error => {
        //     });
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

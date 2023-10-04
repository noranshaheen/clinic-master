<template>
    <div class=" my-2 px-3 py-6 flex justify-center items-center" dir="rtl">
        <div
            class="grid grid-cols-1 gap-4 w-full lg:w-2/5 xl:w-2/5 2xl:w-1/3 border border-gray-200 rounded-lg shadow-lg p-6">
            <div class="col-span-1 items-center justify-center h-full p-12">
                <div class="w-full">
                    <h1 class="text-center text-2xl font-semibold text-gray-700">مرحباً فى برنامج كلينيك ماستر</h1>
                    <p class="text-center mt-2 text-sm text-gray-500">
                        خطوات بسيطة لإعداد بيانات البرنامج
                    </p>
                </div>
            </div>
            <div class="col-span-1 bg-cover lg:block">
                <div class="text-right">
                    <h1 class="text-2xl font-semibold text-gray-700">الخطوة التانية</h1>
                    ادخال بيانات طبيب الفرع الرئيسي
                </div>
            </div>
            <jet-validation-errors class="mb-4" />

            <form @submit.prevent="submit">
                <div class="grid grid-cols-1 gap-4">

                    <div class="grid grid-cols-2 gap-4">
                        <div class="">
                            <jet-label :value='__("اسم الدكتور")' />
                            <jet-input type="text" class="mt-1 block w-full" v-model="store_doctor_form.name" required
                                autofocus />
                        </div>
                        <div class="">
                            <jet-label :value='__("رقم التلفون")' />
                            <jet-input type="text" class="mt-1 block w-full" v-model="store_doctor_form.phone" required
                                autofocus />
                        </div>
                        <div class="">
                            <jet-label :value='__("رقم آخر")' />
                            <span class="m-2 text-gray-500 text-sm">{{"(اختياري)"}}</span>
                            <jet-input type="text" class="mt-1 block w-full" v-model="store_doctor_form.another_phone"
                                autofocus placeholder="optional" />
                        </div>
                        <div class="">
                            <jet-label :value='__("التخصص")' />
                            <select
                                class="mt-1 block w-full rounded border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow-sm"
                                v-model="store_doctor_form.specialty_id" required autofocus>
                                <option v-for="specialty in specialties" :key="specialty.id" :value="specialty.id">
                                    {{ specialty.name }}
                                </option>
                            </select>
                        </div>

                        <div class="">
                            <jet-label :value='__("الدرجة العلمية")' />
                            <select v-model="store_doctor_form.title"
                                class="mt-1 block w-full rounded border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow-sm"
                                required>
                                <option value="طبيب الامتياز">{{ __("طبيب الامتياز") }}</option>
                                <option value="طبيب مقيم">{{ __("طبيب مقيم") }}</option>
                                <option value="أخصائي">{{ __("أخصائي") }}</option>
                                <option value="أخصائي أول">{{ __("أخصائي أول") }}</option>
                                <option value="إستشاري">{{ __("إستشاري") }}</option>
                                <option value="استشاري أول">{{ __("استشاري أول") }}</option>
                                <option value="دكتوراه">{{ __("دكتوراه") }}</option>
                            </select>
                        </div>

                        <div class="">
                            <jet-label :value='__("تاريخ الميلاد")' />
                            <jet-input type="date" class="mt-1 block w-full" v-model="store_doctor_form.date_of_birth"
                                required autofocus />
                        </div>
                        <div>
                            <jet-label for="Email" :value="__('الايميل')" />
                            <jet-input id="Email" type="Email" class="mt-1 block w-full" v-model="store_user_form.email"
                                required />
                        </div>
                        <div>
                            <jet-label for="password" :value="__('كلمة السر')" />
                            <jet-input id="password" type="password" class="mt-1 block w-full"
                                v-model="store_user_form.password" required />
                        </div>
                    </div>
                </div>
            </form>

            <!-- :disabled="formIsProcessing" ????  -->
            <div class="mt-8 flex justify justify-end">
                <button class="w-1/3 px-4 py-2 my-4 tracking-wide text-white transition-colors 
                    duration-200 transform bg-gray-700 rounded hover:bg-gray-600 
                    focus:outline-none focus:bg-gray-600"
                    @click="submit()">
                    {{ "التالي" }}
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
            specialties: [],
            store_doctor_form: this.$inertia.form({
                name: "",
                phone: "",
                another_phone: "",
                specialty_id: "",
                title: "",
                date_of_birth: ""
            }),
            store_user_form: this.$inertia.form({
                email: "",
                password: "",
            }),
        };
    },
    methods: {
        submit() {
            axios
                .post(route("doctors.store", this.store_doctor_form))
                .then((response) => {
                    axios
                        .post(route("setup.actual.step2.store"), this.store_user_form)
                        .then((response) => {
                            // this.form.processing = false;
                            swal({
                                title: "تم الحفظ بنجاح",
                                text: "سيتم تحويلك الى الخطوة الثالثة الأن",
                                icon: "success",
                                button: "موافق",
                            }).then(() => {
                                // this.form.processing = false;
                                this.$inertia.visit(route("setup.actual.step3"));
                            })
                        })
                        .catch((error) => {
                            // this.form.processing = false;
                            this.$page.props.errors = error.response.data.errors;
                            this.errors = error.response.data.errors; //.password[0];
                            //this.$refs.password.focus()
                        });
                })
                .catch((error) => {
                //   this.form.processing = false;
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
        // formIsProcessing() {
        //     return this.form.processing;
        // },
    },
    created() {
        axios
            .get(route("specialties.index"))
            .then((res) => {
                this.specialties = res.data;
            })
            .catch((err) => {
                console.log(err);
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

<template>
    <div class=" my-2 px-3 py-6 flex justify-center items-center" dir="rtl">
        <div
            class="grid grid-cols-1 gap-4 w-full lg:w-2/5 xl:w-2/5 2xl:w-1/3 border border-gray-200 rounded-lg shadow-lg p-6">
            <div class="col-span-1 items-center justify-center h-full p-8">
                <div class="w-full">
                    <h1 class="text-center text-2xl font-semibold text-gray-700">مرحباً فى برنامج كلينيك ماستر</h1>
                    <p class="text-center text-sm text-gray-500">
                        خطوات بسيطة لإعداد بيانات البرنامج
                    </p>
                </div>
            </div>
            <div class="col-span-1 bg-cover lg:block">
                <div class="text-right">
                    <h1 class="text-2xl font-semibold text-gray-700">الخطوة الثالثة</h1>
                    ادخال بيانات عامة
                </div>
            </div>
            <form @submit.prevent="submit">
                <div class="grid grid-cols-1 gap-4 px-5">

                    <!-- patients_file -->
                    <div class="grid grid-cols-1 shadow p-2 border border-gray-100 rounded-lg">
                        <div class="text-md">
                            <JetLabel :value="__('رفع ملف المرضى')" />
                            <span class="m-2 text-gray-500 text-sm">{{ "(اختياري)" }}</span>
                            <p v-if="patients_uploaded" class="text-sm text-green-500">
                                {{ __("تم تحميل الملف بنجاح") }}
                            </p>
                            <input type="file" class="block mt-1" @change="handleUploadPatients($event)"
                                ref="patientsFile" />
                        </div>
                        <div class="flex justify-start underline decoration-1 text-md">
                            <a href="/ExcelTemplates/PatientUpload.xlsx">{{ __('تحميل نموذج الاكسل') }}</a>
                        </div>
                    </div>

                    <!-- drugs_file -->
                    <div class="grid grid-cols-1 shadow p-2 border border-gray-100 rounded-lg">
                        <div class="text-md">
                            <JetLabel :value="__('رفع ملف الأدوية')" />
                            <span class="m-2 text-gray-500 text-sm">{{ "(اختياري)" }}</span>
                            <p v-if="drugs_uploaded" class="text-sm text-green-500">
                                {{ __("تم تحميل الملف بنجاح") }}
                            </p>
                            <input type="file" class="block mt-1" @change="handleUploadDrugs($event)" ref="drugsFile" />
                        </div>
                        <div class="flex justify-start underline decoration-1 text-md">
                            <a href="/ExcelTemplates/DrugUpload.xlsx">{{ __('تحميل نموذج الاكسل') }}</a>
                        </div>
                    </div>

                    <!-- rays_file -->
                    <div class="grid grid-cols-1 shadow p-2 border border-gray-100 rounded-lg">
                        <div class="text-md">
                            <JetLabel :value="__('رفع ملف الأشعة')" />
                            <span class="m-2 text-gray-500 text-sm">{{ "(اختياري)" }}</span>
                            <p v-if="rays_uploaded" class="text-sm text-green-500">
                                {{ __("تم تحميل الملف بنجاح") }}
                            </p>
                            <input type="file" class="block mt-1" @change="handleUploadRyas($event)" ref="raysFile" />
                        </div>
                        <div class="flex justify-start underline decoration-1 text-md">
                            <a href="/ExcelTemplates/RaysUpload.xlsx">{{ __('تحميل نموذج الاكسل') }}</a>
                        </div>
                    </div>

                    <!-- analysis_file -->
                    <div class="grid grid-cols-1 shadow p-2 border border-gray-100 rounded-lg">
                        <div class="text-md">
                            <JetLabel :value="__('رفع ملف التحاليل')" />
                            <span class="m-2 text-gray-500 text-sm">{{ "(اختياري)" }}</span>
                            <p v-if="analysis_uploaded" class="text-sm text-green-500">
                                {{ __("تم تحميل الملف بنجاح") }}
                            </p>
                            <input type="file" class="block mt-1" @change="handleUploadAnalysis($event)"
                                ref="analysisFile" />
                        </div>
                        <div class="flex justify-start underline decoration-1 text-md">
                            <a href="/ExcelTemplates/AnalysisUpload.xlsx">{{ __('تحميل نموذج الاكسل') }}</a>
                        </div>
                    </div>

                    <!-- :disabled="uploadIsProcessing" -->
                    <div class="flex justify justify-start">
                        <button class="w-1/4 p-1 tracking-wide text-white transition-colors 
                    duration-200 transform bg-gray-700 rounded hover:bg-gray-600 
                    focus:outline-none focus:bg-gray-600" @click="uploadAll()">
                            {{ "رفع الكل" }}
                        </button>
                    </div>

                </div>
            </form>

            <!-- :disabled="formIsProcessing" ????  -->
            <div class="mt-8 flex justify justify-end">
                <button class="w-1/3 px-4 py-2 my-4 tracking-wide text-white transition-colors 
                    duration-200 transform bg-gray-700 rounded hover:bg-gray-600 
                    focus:outline-none focus:bg-gray-600" @click="goDashboard()">
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
import axios from "axios";

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
            patients_file: '',
            patients_uploaded: false,
            drugs_file: '',
            drugs_uploaded: false,
            rays_file: '',
            rays_uploaded: false,
            analysis_file: '',
            analysis_uploaded: false,
        };
    },
    methods: {
        handleUploadPatients(event) {
            console.log(event)
            this.patients_file = event.target.files[0];
        },
        handleUploadDrugs(event) {
            this.drugs_file = event.target.files[0];
        },
        handleUploadRyas(event) {
            this.rays_file = event.target.files[0];
        },
        handleUploadAnalysis(event) {
            this.analysis_file = event.target.files[0];
        },
        uploadAll() {

            //send patients file
            if (this.patients_file) {
                let PatientformData = new FormData();
                PatientformData.append('file', this.patients_file);
                axios
                    .post(route("patient.upload"),
                        PatientformData,
                        {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        })
                    .then((res) => {
                        this.patients_uploaded = true;
                        this.$refs.patientsFile.value = null;
                    })
                    .catch((err) => { })
            }

            //send drug file
            if (this.drugs_file) {
                let DrugsformData = new FormData();
                DrugsformData.append('file', this.drugs_file);
                axios
                    .post(route("drug.upload"),
                        DrugsformData,
                        {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        })
                    .then((res) => {
                        this.drugs_uploaded = true;
                        this.$refs.drugsFile.value = null;
                    })
                    .catch((err) => { })
            }

            //send rays file
            if (this.rays_file) {
                let RaysformData = new FormData();
                RaysformData.append('file', this.rays_file);
                axios
                    .post(route("rays.upload"),
                        RaysformData,
                        {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        })
                    .then((res) => {
                        this.rays_uploaded = true;
                        this.$refs.raysFile.value = null;
                    })
                    .catch((err) => {
                    })
            }
            //send analysis file
            if (this.analysis_file) {
                let AnalysisformData = new FormData();
                AnalysisformData.append('file', this.analysis_file);
                axios
                    .post(route("analysis.upload"),
                        AnalysisformData,
                        {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        })
                    .then((res) => {
                        this.analysis_uploaded = true;
                        this.$refs.analysisFile.value = null;
                    })
                    .catch((err) => { })
            }


        },
        goDashboard() {
            swal({
                title: "تم الحفظ بنجاح",
                text: "سيتم تحويلك الى صفحة البرنامج الرئيسية",
                icon: "success",
                button: "موافق",
            }).then(() => {
                // this.form.processing = false;
                window.location.href = route("dashboard");
            });
           
        },
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

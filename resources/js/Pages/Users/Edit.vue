<template>
    <jet-dialog-modal :show="showDialog" max-width="lg" @close="showDialog = false">
        <template #title>
            {{ __("User Information") }}
        </template>

        <template #content>
            <jet-validation-errors class="mb-4" />

            <form @submit.prevent="submit">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <jet-label :value="__('Role')" />
                        <select id="type" v-model="form.current_team_id" class="mt-1 block w-full"
                            @change="getAll(form.current_team_id)">
                            <option value="1">{{ __("Reseptionist") }}</option>
                            <option value="2">{{ __("Doctor") }}</option>
                        </select>
                    </div>
                    <div>
                        <jet-label for="name" :value="__('Name')" />
                        <select required v-model="form.doctor_id"
                            class="mt-1 block w-full border-slate-300 rounded-md text-sm" v-if="all_doctors.length != 0">
                            <option v-for="doctor in all_doctors" :value="doctor.id" :key="doctor.id">
                                {{ doctor.name }}
                            </option>
                        </select>
                        <select required v-model="form.reseptionist_id"
                            class="mt-1 block w-full border-slate-300 rounded-md text-sm" v-if="all_reseptionists.length != 0">
                            <option v-for="reseptionist in all_reseptionists" 
                            :value="reseptionist.id" :key="reseptionist.id">
                                {{ reseptionist.name }}
                            </option>
                        </select>
                    </div>
                    <div>
                        <jet-label for="Email" :value="__('Email')" />
                        <jet-input id="Email" type="Email" class="mt-1 block w-full" v-model="form.email" required />
                    </div>
                    <div>
                        <jet-label for="password" :value="__('Password')" />
                        <jet-input id="password" type="password" class="mt-1 block w-full" v-model="form.password"
                            required />
                    </div>
                </div>
            </form>
            <!-- <div v-else>
                {{__("You are not authorized to add/edit users")}}
            </div> -->
        </template>
        <template #footer>
            <div class="flex items-center justify-end mt-4">
                <jet-secondary-button @click="CancelAddUser()">
                    {{ __("Cancel") }}
                </jet-secondary-button>

                <jet-button class="ms-2" @click="submit" :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing">
                    {{ __("Save") }}
                </jet-button>
            </div>
        </template>
    </jet-dialog-modal>
</template>

<style src="@suadelabs/vue3-multiselect/dist/vue3-multiselect.css"></style>

<script>
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
import Multiselect from "@suadelabs/vue3-multiselect";
import axios from 'axios';

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
        JetLabel,
        JetSecondaryButton,
        JetSectionBorder,
        JetValidationErrors,
        Multiselect,
    },

    props: {
        pUser: {
            Type: Object,
            default: null,
        },
    },

    data() {
        return {
            all_doctors: [],
            all_reseptionists: [],
            errors: [],
            form: this.$inertia.form({
                reseptionist_id: "",
                doctor_id:"",
                email: "",
                password: "",
                current_team_id: ""
            }),
            showDialog: false,
        };
    },

    methods: {
        ShowDialog() {
            if (this.pUser !== null) {
                this.form.name = this.pUser.name;
                this.form.email = this.pUser.email;
                this.form.current_team_id = this.pUser.current_team_id;
            }
            this.showDialog = true;
        },
        CancelAddUser() {
            this.showDialog = false;
        },
        SaveUser() {
            axios
                .put(route("users.update", { user: this.pUser.id }), this.form)
                .then((response) => {
                    location.reload();
                })
                .catch((error) => {
                    this.form.processing = false;
                    this.$page.props.errors = error.response.data.errors;
                    this.errors = error.response.data.errors; //.password[0];
                    //this.$refs.password.focus()
                });
        },
        SaveNewUser() {
            axios
                .post(route("users.store"), this.form)
                .then((response) => {
                    this.processing = false;
                    this.$nextTick(() => this.$emit("dataUpdated"));
                    this.form.reset();
                    this.form.processing = false;
                    this.showDialog = false;
                    location.reload();
                })
                .catch((error) => {
                    this.form.processing = false;
                    this.$page.props.errors = error.response.data.errors;
                    this.errors = error.response.data.errors; //.password[0];
                    //this.$refs.password.focus()
                });
        },
        getAll(team_id) {
            // console.log(team_id);
            if (team_id == 1) {
                axios
                    .get(route("reseptionist.all"))
                    .then((response) => {
                        this.all_doctors = [];
                        this.form.doctor_id = "";
                        this.all_reseptionists = response.data;
                        console.log(response.data);
                    })
            } else if (team_id == 2) {
                axios
                    .get(route("doctor.all"))
                    .then((response) => {
                        this.all_reseptionists = [];
                        this.form.reseptionist_id = "";
                        this.all_doctors = response.data;
                        console.log(response.data);
                    })
            }
        },
        submit() {
            if (this.pUser == null) this.SaveNewUser();
            else this.SaveUser();
        },
    },
    // created: function created() {
    //     axios
    //         .get(route("json.branches"))
    //         .then((response) => {
    //             this.branches = response.data;
    //             if (this.pUser)
    //                 for (var i = 0; i < this.pUser.issuers.length; i++)
    //                     this.issuers.push(
    //                         this.branches.find(
    //                             (option) =>
    //                                 option.Id === this.pUser.issuers[i].Id
    //                         )
    //                     );
    //         })
    //         .catch((error) => {});
    // },
};
</script>

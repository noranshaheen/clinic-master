<template>
  <jet-dialog-modal :show="showDialog" @close="showDialog = false">
    <template #title>
      {{ __("Patient Information") }}
    </template>

    <template #content>
      <jet-validation-errors class="mb-4" />

      <form @submit.prevent="submit">
        <div class="grid grid-cols-2 gap-4">

          <div>
            <div class="mt-4">
              <jet-label :value='__("Patient Name")' />
              <jet-input type="text" class="mt-1 block w-full" v-model="form.name" required id="name" />
            </div>

            <div class="mt-4">
              <jet-label :value='__("Phone Number")' />
              <jet-input type="text" class="mt-1 block w-full" v-model="form.phone" required id="phone" />
            </div>

            <div class="mt-4">
              <jet-label :value='__("Date Of Birth")' />
              <jet-input type="date" class="mt-1 block w-full" v-model="form.date_of_birth" autofocus id="Birthdate" />
            </div>

            <div class="mt-4">
              <TextField v-model="form.additionalInformation" itemType="text"
                :itemLabel="__('Additional Information (optional)')" />
            </div>

            <div class="mt-4" v-if="appointment_id != null">
              <jet-label :value='__("Detection Type")' />
              <div class="mt-2">
                <div class="mb-2">
                  <input id="1" type="radio" name="type" value="Normal" v-model="form.appointment_type" />
                  <label for="1" class="ml-2">Normal</label>
                </div>
                <div class="mb-2">
                  <input id="2" type="radio" name="type" value="Emergency" v-model="form.appointment_type" />
                  <label for="2" class="ml-2">Emergency</label>
                </div>
                <div class="mb-2">
                  <input id="3" type="radio" name="type" value="Consultation" v-model="form.appointment_type" />
                  <label for="3" class="ml-2">Consultation</label>
                </div>
              </div>
            </div>
          </div>

          <div>
            <div class="mt-4">
              <jet-label for="gender" :value='__("Gender")' />
              <select id="gender" v-model="form.gender" required
                class="mt-1 block w-full rounded border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow-sm">
                <option value="M">{{ __("Male") }}</option>
                <option value="F">{{ __("Female") }}</option>
              </select>
            </div>

            <div class="mt-4">
              <jet-label for="type" :value='__("Type")' />
              <select id="type" v-model="form.type" required
                class="mt-1 block w-full rounded border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow-sm">
                <option value="P">{{ __("Personal") }}</option>
                <option value="I">{{ __("Insurance") }}</option>
              </select>
            </div>

            <div v-if="form.type == 'I'">

              <div class="mt-4">
                <jet-label for="insurance_number" :value='__("Insurance Number")' />
                <jet-input id="insurance_number" type="text" class="mt-1 block w-full" v-model="form.insurance_number"
                  required />
              </div>

              <div class="mt-4">
                <jet-label for="insurance_company" :value='__("Insurance Company")' />
                <jet-input id="insurance_company" type="text" class="mt-1 block w-full" v-model="form.insurance_company"
                  required />
              </div>

            </div>
          </div>
        </div>
      </form>
    </template>
    <template #footer>
      <div class="flex items-center justify-end">
        <jet-secondary-button @click="CancelAddcustomer()">
          {{ __("Cancel") }}
        </jet-secondary-button>

        <jet-button class="ms-2" @click="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
          {{ __("Save") }}
        </jet-button>
      </div>
    </template>
  </jet-dialog-modal>
</template>

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
import TextField from "@/UI/TextField.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import JetSectionBorder from "@/Jetstream/SectionBorder.vue";
import JetValidationErrors from "@/Jetstream/ValidationErrors.vue";
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
    JetLabel,
    JetSecondaryButton,
    JetSectionBorder,
    JetValidationErrors,
    TextField
  },

  props: {
    patient: {
      Type: Object,
      default: null,
    },
    appointment_id: {
      default: null
    }
  },

  data() {
    return {
      errors: [],
      form: this.$inertia.form({
        name: "",
        phone: "",
        date_of_birth: "",
        type: "",
        gender: "",
        insurance_number: "",
        insurance_company: "",
        appointment_type: "",
        additionalInformation:""
      }),
      showDialog: false,
    };
  },

  methods: {
    ShowDialog() {
      if (this.patient !== null) {
        this.form.name = this.patient.name;
        this.form.phone = this.patient.phone;
        this.form.type = this.patient.type;
        this.form.date_of_birth = this.patient.date_of_birth;
        this.form.gender = this.patient.gender;
        this.form.insurance_number = this.patient.insurance_number;
        this.form.insurance_company = this.patient.insurance_company;
        this.form.additionalInformation = this.patient.additionalInformation;
      }
      this.showDialog = true;
    },
    CancelAddcustomer() {
      this.showDialog = false;
    },
    SaveCustomer() {
      axios
        .put(route("patients.update", { patient: this.patient.id }), this.form)
        .then((response) => {
          this.$store.dispatch("setSuccessFlashMessage", true);
          this.showDialog = false;
          setTimeout(() => {
            window.location.reload();
          }, 500);


        })
        .catch((error) => {
          console.log(error);
          this.form.processing = false;
          this.$page.props.errors = error.response.data.errors;
          this.errors = error.response.data.errors; //.password[0];
          //this.$refs.password.focus()
        });
    },
    SaveNewCustomer() {
      if (this.appointment_id == null) {
        axios
          .post(route("patients.store"), this.form)
          .then((response) => {
            this.$store.dispatch("setSuccessFlashMessage", true);
            this.processing = false;
            this.$nextTick(() => this.$emit("dataUpdated"));
            this.form.reset();
            this.form.processing = false;
            this.showDialog = false;
            setTimeout(() => {
              window.location.reload();
            }, 500);
          })
          .catch((error) => {
            this.form.processing = false;
            this.$page.props.errors = error.response.data.errors;
            this.errors = error.response.data.errors; //.password[0];
            //this.$refs.password.focus()
          });
      } else {
        axios
          .post(route('appointment.reserveNewPatient', { appointment_id: this.appointment_id }), this.form)
          .then((response) => {
            this.$store.dispatch("setSuccessFlashMessage", true);
            this.showDialog = false;
            this.$emit('Save');
          }).catch((error) => {
            this.form.processing = false;
            this.$page.props.errors = error.response.data.errors;
            this.errors = error.response.data.errors;
          })
      }
    },
    submit() {
      if (this.patient == null) this.SaveNewCustomer();
      else this.SaveCustomer();
    },
    // onCountryChange(event){
    //     alert(event.target.value);
    //     this.allStates.find((state) => {
    //         if (state.countryShortCode == event.target.value) {
    //             this.states = state.regions;
    //         }
    //     });
    //     console.log(this.states);
    // }
  },
  // created: function created() {
  //     axios
  //         .get("/json/Countries.json")
  //         .then((response) => {
  //             this.countries = response.data.map((country) => {
  //                 return {
  //                     name: country.countryName,
  //                     code: country.countryShortCode,
  //                 };
  //             });
  //             this.allStates = response.data;
  //             this.allStates.find((state) => {
  //                 if (state.countryShortCode == this.form.address.country) {
  //                     this.states = state.regions;
  //                 }
  //             });
  //         })
  //         .catch((error) => {});
  // },
};
</script>

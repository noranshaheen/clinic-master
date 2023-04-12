<template>
  <jet-dialog-modal :show="showDialog" @close="showDialog = false">
    <template #title>
      {{ __("Clinic Information") }}
    </template>

    <template #content>
      <jet-validation-errors class="mb-4" />

      <form @submit.prevent="submit">
        <div class="grid grid-cols-1">
          <div>

            <div class="mt-4">
              <jet-label  value="Clinic Name" />
              <jet-input
                type="text"
                class="mt-1 block w-full"
                v-model="form.name"
                required
              />
            </div>

            <div class="mt-4">
              <jet-label value="Clinic Phone" />
              <jet-input
                type="text"
                class="mt-1 block w-full"
                v-model="form.phone"
                required
              />
            </div>

            <div class="mt-4">
              <jet-label value="Address" />
              <jet-input
                type="text"
                class="mt-1 block w-full"
                v-model="form.address"
                required
                autofocus
              />
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

        <jet-button
          class="ms-2"
          @click="submit"
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
        >
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
  },

  props: {
    clinic: {
      Type: Object,
      default: null,
    },
  },

  data() {
    return {
      errors: [],
      form: this.$inertia.form({
        name: "",
        phone: "",
        address:""
      }),
      showDialog: false,
    };
  },

  methods: {
    ShowDialog() {
      if (this.clinic !== null) {
        this.form.name = this.clinic.name;
        this.form.phone = this.clinic.phone;
        this.form.address = this.clinic.address;
      }
      this.showDialog = true;
    },
    CancelAddcustomer() {
      this.showDialog = false;
    },
    SaveCustomer() {
      axios
        .put(
          route("clinics.update", { clinic: this.clinic.id }),
          this.form
        )
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
      axios
        .post(route("clinics.store"), this.form)
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
    },
    submit() {
      if (this.clinic == null) this.SaveNewCustomer();
      else this.SaveCustomer();
    },
    // onCountryChange(event) {
    //   alert(event.target.value);
    //   this.allStates.find((state) => {
    //     if (state.countryShortCode == event.target.value) {
    //       this.states = state.regions;
    //     }
    //   });
    //   console.log(this.states);
    // },
  },
  // created: function created() {
  //   axios
  //     .get("/json/Countries.json")
  //     .then((response) => {
  //       this.countries = response.data.map((country) => {
  //         return {
  //           name: country.countryName,
  //           code: country.countryShortCode,
  //         };
  //       });
  //       this.allStates = response.data;
  //       this.allStates.find((state) => {
  //         if (state.countryShortCode == this.form.country) {
  //           this.states = state.regions;
  //         }
  //       });
  //     })
  //     .catch((error) => {});
  // },
};
</script>

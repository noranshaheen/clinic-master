<template>
  <jet-dialog-modal :show="showDialog" @close="showDialog = false">
    <template #title>
      {{ __("Reseptionist Information") }}
    </template>

    <template #content>
      <jet-validation-errors class="mb-4" />

      <form @submit.prevent="submit">
        <div class="flex flex-col sm:grid sm:grid-cols-2 sm:gap-4">

          <div>
            <div class="mt-4">
              <jet-label :value='__("Name")' />
              <jet-input type="text" class="mt-1 block w-full" v-model="form.name" required />
            </div>

            <div class="mt-4">
              <jet-label :value='__("Phone Number")' />
              <jet-input type="text" class="mt-1 block w-full" v-model="form.phone" required />
            </div>
          </div>

          <div>
            <div class="mt-4">
              <jet-label :value='__("Date Of Birth")' />
              <jet-input type="date" class="mt-1 block w-full" v-model="form.date_of_birth" required autofocus />
            </div>
            <div class="mt-4">
              <jet-label for="gender" :value='__("Gender")' />
              <select id="gender" v-model="form.gender" required
                class="mt-1 block w-full rounded border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow-sm">
                <option value="M">{{ __("Male") }}</option>
                <option value="F">{{ __("Female") }}</option>
              </select>
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
    reseptionist: {
      Type: Object,
      default: null,
    }
  },

  data() {
    return {
      errors: [],
      form: this.$inertia.form({
        name: "",
        phone: "",
        date_of_birth: "",
        gender: "",
      }),
      showDialog: false,
    };
  },

  methods: {
    ShowDialog() {
      if (this.reseptionist !== null) {
        this.form.name = this.reseptionist.name;
        this.form.phone = this.reseptionist.phone;
        this.form.date_of_birth = this.reseptionist.date_of_birth;
        this.form.gender = this.reseptionist.gender;
      }
      this.showDialog = true;
    },
    CancelAddcustomer() {
      this.showDialog = false;
    },
    SaveCustomer() {
      axios
        .put(route("reseptionists.update", { reseptionist: this.reseptionist.id }), this.form)
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
          .post(route("reseptionists.store"), this.form)
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
      if (this.reseptionist == null) this.SaveNewCustomer();
      else this.SaveCustomer();
    },
  },
};
</script>

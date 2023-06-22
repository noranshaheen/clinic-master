<template>
  <jet-dialog-modal :show="showDialog" @close="showDialog = false">
    <template #title>
      {{ __("Doctor Information") }}
    </template>

    <template #content>
      <jet-validation-errors class="mb-4" />

      <form @submit.prevent="submit">
        <div class="grid grid-cols-2 gap-4">
          <div>
            <div class="mt-4">
              <jet-label :value='__("Doctor Name")' />
              <jet-input
                type="text"
                class="mt-1 block w-full"
                v-model="form.name"
                required
                autofocus
              />
            </div>
            <div class="mt-4">
              <jet-label :value='__("Phone Number")' />
              <jet-input
                type="text"
                class="mt-1 block w-full"
                v-model="form.phone"
                required
                autofocus
              />
            </div>
            <div class="mt-4">
              <jet-label :value='__("Another Phone (optional)")' />
              <jet-input
                type="text"
                class="mt-1 block w-full"
                v-model="form.another_phone"
                autofocus
              />
            </div>
          </div>
          <div>
            <div class="mt-4">
              <jet-label :value='__("Speciatly")' />
              <select
                class="mt-1 block w-full rounded border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow-sm"
                v-model="form.specialty_id"
                required
                autofocus
              >
                <option
                  v-for="specialty in specialties"
                  :key="specialty.id"
                  :value="specialty.id"
                >
                  {{ specialty.name }}
                </option>
              </select>
            </div>

            <div class="mt-4">
              <jet-label :value='__("Title")' />
              <select
                v-model="form.title"
                class="mt-1 block w-full rounded border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow-sm"
                required
                >
                <option value="أخصائي">{{ __("أخصائي") }}</option>
                <option value="استشاري">{{ __("استشاري") }}</option>
                <option value="أستاذ">{{ __("أستاذ") }}</option>
              </select>
            </div>
            <div class="mt-4">
              <jet-label :value='__("Date Of Birth")' />
              <jet-input
                type="date"
                class="mt-1 block w-full"
                v-model="form.date_of_birth"
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
    doctor: {
      Type: Object,
      default: null,
    },
  },

  data() {
    return {
      specialties: [],
      errors: [],
      form: this.$inertia.form({
        name: "",
        phone: "",
        another_phone: "",
        specialty_id: "",
        title: "",
        date_of_birth: "",
      }),
      showDialog: false,
    };
  },

  methods: {
    ShowDialog() {
      if (this.doctor !== null) {
        this.form.name = this.doctor.name;
        this.form.phone = this.doctor.phone;
        this.form.another_phone = this.doctor.another_phone;
        this.form.specialty_id = this.doctor.specialty_id;
        this.form.title = this.doctor.title;
        this.form.date_of_birth = this.doctor.date_of_birth;
      }
      this.showDialog = true;
    },
    CancelAddcustomer() {
      this.showDialog = false;
    },
    SaveCustomer() {
      axios
        .put(route("doctors.update", { doctor: this.doctor.id }), this.form)
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
          // this.showDialog = false;
          // setTimeout(() => {
          //   window.location.reload();
          // }, 500);
        });
    },
    SaveNewCustomer() {
      axios
        .post(route("doctors.store"), this.form)
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
      if (this.doctor == null) this.SaveNewCustomer();
      else this.SaveCustomer();
    },
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

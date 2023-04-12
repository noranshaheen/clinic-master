<template>
  <jet-dialog-modal :show="showDialog" @close="showDialog = false">
    <template #title>
      {{ __("Make A Reservation Dialog") }}
    </template>

    <template #content>
      <jet-validation-errors class="mb-4" />

      <div class="grid grid-cols-1">
        <div class="grid grid-cols-2 gap-3">
          <!-- all doctors -->
          <div class="col-span-1">
            <jet-label :value="__('Doctor')" />
            <select
              v-model="form.doctor_id"
              class="mt-1 block w-full border-slate-300 rounded-md"
            >
              <option
                v-for="doctor in doctors"
                :value="doctor.id"
                :key="doctor.id"
              >
                {{ doctor.name }}
              </option>
            </select>
          </div>

          <!-- select date -->
          <div class="col-span-1">
            <jet-label :value="__('Date')" class="mt-4" />
            <jet-input
              type="date"
              class="mt-1 block w-full text-sm"
              v-model="form.date"
              required
            />
          </div>

          <!-- search botton -->
          <div>
            <jet-secondary-button @click="searchData()">
              {{ __("Search") }}
            </jet-secondary-button>
          </div>

          <!-- available appointmaents -->
          <div class="col-span-1">
            <jet-label :value="__('Doctor')" />
            <select
              v-model="form.doctor_id"
              class="mt-1 block w-full border-slate-300 rounded-md"
            >
              <option
                v-for="doctor in doctors"
                :value="doctor.id"
                :key="doctor.id"
              >
                {{ doctor.name }}
              </option>
            </select>
          </div>

          <!-- <div class="col-span-1">
              <jet-label :value="__('Clinic')" />
              <select
                v-model="clinic_id"
                class="mt-1 block w-full border-slate-300 rounded-md"
                @change="updateAvailableRooms(clinic_id)"
              >
                <option
                  v-for="clinic in clinics"
                  :value="clinic.id"
                  :key="clinic.id"
                >
                  {{ clinic.name }}
                </option>
              </select>
            </div>
  
            <div
              v-for="(record, idx1) in form.records"
              :key="idx1"
              class="bg-gray-200 grid grid-cols-6 gap-3 col-span-2 py-2"
            >
              <div class="col-span-1">
                <jet-label :value="__('Date')" class="mt-4" />
                <jet-input
                  type="date"
                  class="mt-1 block w-full text-sm"
                  v-model="record.date"
                  required
                />
              </div>
  
              <div class="col-span-1">
                <jet-label :value="__('From')" class="mt-4" />
                <jet-input
                  type="time"
                  class="mt-1 block w-full text-sm"
                  v-model="record.from"
                  required
                />
              </div>
  
              <div class="col-span-1">
                <jet-label :value="__('To')" class="mt-4" />
                <jet-input
                  type="time"
                  class="mt-1 block w-full text-sm"
                  v-model="record.to"
                  required
                />
              </div>
  
              <div class="col-span-1">
                <jet-label :value="__('Number Of Cases')" class="mt-4" />
                <jet-input
                  type="number"
                  class="mt-1 block w-full text-sm"
                  v-model="record.num_of_cases"
                  required
                />
              </div>
  
              <div class="col-span-1">
              <jet-label :value="__('Room')"  class="mt-4"/>
              <select
                v-model="record.room_id"
                class="mt-1 block w-full border-slate-300 rounded-md text-sm"
              >
                <option
                  v-for="room in availableRooms"
                  :value="room.id"
                  :key="room.id"
                >
                  {{ room.name }}
                </option>
              </select>
            </div>
  
              <div class="col-span-1">
                <jet-label value=" " class="mt-4" />
                <jet-danger-button
                  @click="deleteEntry(idx1)"
                  class="mt-8 block min-w-fit"
                >
                  {{ __("Delete") }}
                </jet-danger-button>
              </div>
            </div> -->
        </div>
      </div>
    </template>

    <template #footer>
      <div class="flex items-center justify-end">
        <jet-secondary-button @click="CancelDlg()">
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
import Multiselect from "@suadelabs/vue3-multiselect";
import TextField from "@/UI/TextField.vue";
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
    Multiselect,
    TextField,
  },

  props: {},

  data() {
    return {
      errors: [],
      form: this.$inertia.form({
        doctor_id: "",
        date: "",
      }),
          doctors: [],
      availableAppointments:[],
      showDialog: false,
    };
  },

  methods: {
    ShowDialog() {
      this.showDialog = true;
    },
    CancelDlg() {
      this.showDialog = false;
    },
    searchData() {
          axios.post(route("appointments.search"), this.form)
              .then((response) => {
                  this.availableAppointments = response.data;
              });
    },
    SaveNewAppointment() {
      axios
        .post(route("appointments.store"), this.form)
        .then((response) => {
          this.$store.dispatch("setSuccessFlashMessage", true);
          this.processing = false;
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
          this.errors = error.response.data.errors;
        });
    },
    SaveAppointment() {
      axios
        .put(
          route("appointments.store", { appointment: this.appointment.id }),
          this.form
        )
        .then((response) => {
          this.$store.dispatch("setSuccessFlashMessage", true);
          this.processing = false;
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
          this.errors = error.response.data.errors;
        });
    },
    submit() {
      if (this.appointment == null) {
        this.SaveNewAppointment();
      } else {
        this.SaveAppointment();
      }
    },
  },

  created() {
    axios.get(route("doctor.all")).then((response) => {
      this.doctors = response.data;
    });
  },
};
</script>
  
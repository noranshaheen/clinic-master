<template>
  <jet-dialog-modal :show="showDialog" maxWidth="5xl" @close="showDialog = false">
    <template #title>
      {{ __("Add An Appointment Dialog") }}
    </template>

    <template #content>
      <jet-validation-errors class="mb-4" />

      <div class="grid grid-cols-1">
        <div class="grid grid-cols-2 gap-3">
          <div class="col-span-1">
            <jet-label :value="__('Doctor')" />
            <select v-model="form.doctor_id" class="mt-1 block w-full border-slate-300 rounded-md">
              <option v-for="doctor in doctors" :value="doctor.id" :key="doctor.id">
                {{ doctor.name }}
              </option>
            </select>
          </div>

          <div class="col-span-1">
            <jet-label :value="__('Clinic')" />
            <select v-model="clinic_id" class="mt-1 block w-full border-slate-300 rounded-md"
              @change="updateAvailableRooms(clinic_id)">
              <option v-for="clinic in clinics" :value="clinic.id" :key="clinic.id">
                {{ clinic.name }}
              </option>
            </select>
          </div>

          <div v-for="(record, idx1) in form.records" :key="idx1"
            class="bg-gray-200 grid grid-cols-6 gap-3 col-span-2 p-2">
            <div class="col-span-1">
              <jet-label :value="__('Date')" class="mt-4" />
              <jet-input type="date" class="mt-1 block w-full text-sm" v-model="record.date" required />
            </div>

            <div class="col-span-1">
              <jet-label :value="__('From')" class="mt-4" />
              <jet-input type="time" class="mt-1 block w-full text-sm" v-model="record.from" required />
            </div>

            <div class="col-span-1">
              <jet-label :value="__('To')" class="mt-4" />
              <jet-input type="time" class="mt-1 block w-full text-sm" v-model="record.to" required />
            </div>

            <div class="col-span-1">
              <jet-label :value="__('Number Of Cases')" class="mt-4" />
              <jet-input type="number" class="mt-1 block w-full text-sm" v-model="record.num_of_cases" required />
            </div>

            <div class="col-span-1">
              <jet-label :value="__('Room')" class="mt-4" />
              <select v-model="record.room_id" class="mt-1 block w-full border-slate-300 rounded-md text-sm">
                <option v-for="room in availableRooms" :value="room.id" :key="room.id">
                  {{ room.name }}
                </option>
              </select>
            </div>

            <div class="col-span-1 flex justify-end">
                <jet-danger-button @click="deleteEntry(idx1)" class="mt-8 block min-w-fit">
                  {{ __("Delete") }}
                </jet-danger-button>
            </div>
          </div>
        </div>

        <div class="col-span-1 w-1/5 my-2 mx-auto">
          <jet-button class="ps-2 w-full mt-1" @click="addBalance" :disabled="form.processing">
            {{ __("Add An Appointment") }}
          </jet-button>
        </div>
      </div>
    </template>

    <template #footer>
      <div class="flex items-center justify-end">
        <jet-secondary-button @click="CancelDlg()">
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

  props: {
    appointment: {
      type: Object,
      default: null,
    },
  },

  data() {
    return {
      errors: [],
      form: this.$inertia.form({
        doctor_id: "",
        records: [],
      }),
      allrooms: [],
      availableRooms: [],
      clinic_id: "",
      clinics: [],
      doctors: [],
      showDialog: false,
    };
  },

  methods: {
    ShowDialog() {
      if (this.appointment != null) {
        this.form.doctor_id = this.appointment.doctor_id;
        this.form.records.room_id = this.appointment.room_id;
        this.form.records.date = new Date(this.appointment.date).toISOString();
        this.form.records.from = new Date(this.appointment.from).toLocaleTimeString();
        this.form.records.to = new Date(this.appointment.to).toLocaleTimeString();
      }
      this.showDialog = true;
    },
    CancelDlg() {
      this.showDialog = false;
    },
    updateAvailableRooms(clinic_id) {
      this.availableRooms = this.allrooms.filter((room) => {
        return room.clinic_id == clinic_id ? true : false;
        // console.log(room.clinic_id)
      });
      console.log(clinic_id);
      console.log(this.availableRooms);
      // console.log("update");
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
    addBalance() {
      this.form.records.push({
        date: new Date().toISOString().slice(0, 10),
        from: "",
        to: "",
        room_id: "",
        num_of_cases: 0
      });
    },
    deleteEntry(idx1) {
      this.form.records.splice(idx1, 1);
    },
  },

  created() {
    this.addBalance();
    axios.get(route("doctor.all")).then((response) => {
      this.doctors = response.data;
    });
    axios.get(route("clinic.all")).then((response) => {
      this.clinics = response.data;
    });
    axios.get(route("room.all")).then((response) => {
      this.allrooms = response.data;
      // console.log(this.allrooms);
    });
  },
};
</script>

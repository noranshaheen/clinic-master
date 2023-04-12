<template>
  <app-layout>
    <edit-patient ref="dlg2" :patient="patient" />
    <confirm ref="dlg1" @confirmed="remove()">
      {{ __("Are you sure you want to delete this patient ?") }}
    </confirm>
    <div class="py-4">
      <div class="mx-auto sm:px-6 lg:px-8">
        <div
          class="wrapper Gbg-white overflow-hidden shadow-xl sm:rounded-lg p-4"
        >
          <Table :resource="patients">
            <template #cell(type)="{ item: patient }">
              {{
                patient.type == "I"
                  ? __("Insurance")
                  : patient.type == "P"
                  ? __("Personal")
                  : null
              }}
            </template>
            <template #cell(gender)="{ item: patient }">
              {{
                patient.gender == "F"
                  ? __("Female")
                  : patient.gender == "M"
                  ? __("Male")
                  : null
              }}
            </template>
            <template #cell(date_of_birth)="{ item: patient }">
              {{ new Date().getFullYear() - new Date(patient.date_of_birth).getFullYear() }}
            </template>
            <template #cell(actions)="{ item: patient }">
              <secondary-button @click="editCustomer(patient)">
                <i class="fa fa-edit"></i> {{ __("Edit") }}
              </secondary-button>
              <jet-button class="ms-2" @click="removeCustomer(patient)">
                <i class="fa fa-trash"></i> {{ __("Delete") }}
              </jet-button>
            </template>
          </Table>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import Confirm from "@/UI/Confirm.vue";
import EditPatient from "@/Pages/Patients/Edit.vue";
import { Table } from "@protonemedia/inertiajs-tables-laravel-query-builder";
import SecondaryButton from "@/Jetstream/SecondaryButton.vue";
import JetButton from "@/Jetstream/Button.vue";
import axios from "axios";

export default {
  components: {
    EditPatient,
    Confirm,
    AppLayout,
    Table,
    SecondaryButton,
    JetButton,
  },
  props: {
    patients: Object,
  },
  data() {
    return {
      patient: Object,
    };
  },
  methods: {
    editCustomer(cust) {
      this.patient = cust;
      this.$nextTick(() => this.$refs.dlg2.ShowDialog());
      //this.$refs.dlg2.ShowDialog();
    },
    removeCustomer(cust) {
      this.patient = cust;
      this.$refs.dlg1.ShowModal();
    },
    remove() {
      axios
        .delete(route("patients.destroy", { patient: this.patient.id }))
        .then((response) => {
          this.$store.dispatch("setSuccessFlashMessage", true);
          setTimeout(() => {
            window.location.reload();
          }, 500);
        })
        .catch((error) => {});
    },
    showColumn(columnKey) {
      if (!this.$inertia.page.props.queryBuilderProps.default.columns) {
        return false;
      }
      const column =
        this.$inertia.page.props.queryBuilderProps.default.columns.find(
          (item) => item.key === columnKey
        );
      return column ? !column.hidden : false;
    },
  },
};
</script>
<style scoped>
:deep(table th) {
  text-align: start;
  margin-block-start: 4px;
}
</style>

<template>
  <app-layout>
    <edit-diagnose ref="dlg2" :diagnose="diagnose" />
    <confirm ref="dlg1" @confirmed="remove()">
      {{ __("Are you sure you want to delete this diagnose ?") }}
    </confirm>
    <div class="py-4">
      <div class="mx-auto sm:px-6 lg:px-8">
        <div
          class="wrapper Gbg-white shadow-xl sm:rounded-lg p-4"
        >
          <Table :resource="diagnosis">
            <template #cell(specialty_id)="{ item: diagnose }">
              {{ diagnose.specialty.name }}
            </template>
            <template #cell(actions)="{ item: diagnose }">
              <secondary-button @click="editCustomer(diagnose)">
                <i class="fa fa-edit"></i> {{ __("Edit") }}
              </secondary-button>
              <JetDangerButton class="ms-2" @click="removeCustomer(diagnose)">
                <i class="fa fa-trash"></i> {{ __("Delete") }}
              </JetDangerButton>
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
import EditDiagnose from "@/Pages/Diagnosis/Edit.vue";
import { Table } from "@protonemedia/inertiajs-tables-laravel-query-builder";
import SecondaryButton from "@/Jetstream/SecondaryButton.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetDangerButton from "@/Jetstream/DangerButton.vue";
import axios from "axios";

export default {
  components: {
    EditDiagnose,
    Confirm,
    AppLayout,
    Table,
    SecondaryButton,
    JetButton,
    JetDangerButton
  },
  props: {
    diagnosis: Object,
  },
  data() {
    return {
      diagnose: Object,
    };
  },
  methods: {
    editCustomer(cust) {
      this.diagnose = cust;
      this.$nextTick(() => this.$refs.dlg2.ShowDialog());
      //this.$refs.dlg2.ShowDialog();
    },
    removeCustomer(cust) {
      this.diagnose = cust;
      this.$refs.dlg1.ShowModal();
    },
    remove() {
      axios
        .delete(route("diagnosis.destroy", { diagnosi: this.diagnose.id }))
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
  created: function created() {
    // console.log(this.diagnosis);
  },
};
</script>
<style scoped>
:deep(table th) {
  text-align: start;
  margin-block-start: 4px;
}
</style>

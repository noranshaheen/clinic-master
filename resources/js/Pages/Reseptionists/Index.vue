<template>
  <app-layout>
    <edit-patient ref="dlg2" :reseptionist="reseptionist" />
    <confirm ref="dlg1" @confirmed="remove()">
      {{ __("Are you sure you want to delete this reseptionist ?") }}
    </confirm>
    <div class="py-4">
      <div class="mx-auto sm:px-6 lg:px-8">
        <div
          class="wrapper Gbg-white shadow-xl sm:rounded-lg p-4"
        >
          <Table :resource="reseptionists">
            <template #cell(gender)="{ item: reseptionist }">
              {{
                reseptionist.gender == "F"
                  ? __("Female")
                  : reseptionist.gender == "M"
                  ? __("Male")
                  : null
              }}
            </template>
            <template #cell(date_of_birth)="{ item: reseptionist }">
              {{ new Date().getFullYear() - new Date(reseptionist.date_of_birth).getFullYear() }}
            </template>
            <template #cell(actions)="{ item: reseptionist }">
              <secondary-button @click="editCustomer(reseptionist)">
                <i class="fa fa-edit"></i> {{ __("Edit") }}
              </secondary-button>
              <JetDangerButton class="ms-2" @click="removeCustomer(reseptionist)">
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
import EditPatient from "@/Pages/Reseptionists/Edit.vue";
import { Table } from "@protonemedia/inertiajs-tables-laravel-query-builder";
import SecondaryButton from "@/Jetstream/SecondaryButton.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetDangerButton from "@/Jetstream/DangerButton.vue";
import axios from "axios";

export default {
  components: {
    EditPatient,
    Confirm,
    AppLayout,
    Table,
    SecondaryButton,
    JetButton,
    JetDangerButton
  },
  props: {
    reseptionists: Object,
  },
  data() {
    return {
      reseptionist: Object,
    };
  },
  methods: {
    editCustomer(cust) {
      this.reseptionist = cust;
      this.$nextTick(() => this.$refs.dlg2.ShowDialog());
      //this.$refs.dlg2.ShowDialog();
    },
    removeCustomer(cust) {
      this.reseptionist = cust;
      this.$refs.dlg1.ShowModal();
    },
    remove() {
      axios
        .delete(route("reseptionists.destroy", { reseptionist: this.reseptionist.id }))
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

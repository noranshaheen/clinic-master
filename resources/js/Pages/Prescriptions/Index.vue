<template>
    <app-layout>
        <show-prescription ref="dlg2" :prescription="prescription_details" />
        <confirm ref="dlg1" @confirmed="remove()">
            {{ __("Are you sure you want to delete this prescription ?") }}
        </confirm>
        <div class="py-4">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div
                    class="wrapper Gbg-white shadow-xl sm:rounded-lg p-4"
                >
                    <Table :resource="prescriptions" >
                        <template #cell(doctor)="{ item: prescription }">
                            {{ prescription.doctor? prescription.doctor.name:__('N/A') }}
                        </template>
                        <template #cell(patient)="{item : prescription}">
                            {{  prescription.patient.name}}
                        </template>
                        <template #cell(dateTimeIssued)="{item : prescription}">
                            {{  new Date(prescription.dateTimeIssued).toLocaleDateString()}}
                        </template>
                        <template #cell(actions)="{ item: prescription }">
                            <secondary-button @click="showItems(prescription)">
                                <i class="fa fa-circle-info"></i> {{ __("Show") }}
                            </secondary-button>
                            <!-- <secondary-button @click="editCustomer(prescription)">
                                <i class="fa fa-edit"></i> {{ __("Edit") }}
                            </secondary-button> -->
                            <jet-button class="ms-2" @click="removeCustomer(prescription)">
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
import axios from 'axios';
import ShowPrescription from './Show.vue';

export default {
    components: {
        EditPatient,
        Confirm,
        AppLayout,
        Table,
        SecondaryButton,
        JetButton,
        ShowPrescription,
    },
    props: {
        prescriptions: Object,
    },
    data() {
        return {
            prescription: Object,
            prescription_details:""
        };
    },
    methods: {
        showItems(cust) {
            console.log(cust)
            this.prescription_details = cust;
            this.$nextTick(() => this.$refs.dlg2.ShowDialog());
            // this.$refs.dlg1.ShowDialog();
        },
        removeCustomer(cust) {
            this.prescription = cust;
            this.$refs.dlg1.ShowModal();
        },
        remove() {
            axios
                .delete(
                    route("prescriptions.destroy", { prescription: this.prescription.id })
                )
                .then((response) => {
                    this.$store.dispatch("setSuccessFlashMessage", true);
                    setTimeout(() => {
                        window.location.reload();
                    }, 500);
                })
                .catch((error) => {
                });
        },
        showColumn(columnKey) {
          if (!this.$inertia.page.props.queryBuilderProps.default.columns) {
            return false;
          }
          const column = this.$inertia.page.props.queryBuilderProps.default.columns.find(
            item => item.key === columnKey
          );
          return column ? !column.hidden : false;
        },
    },
    created() {
        console.log(this.prescriptions);
    }
};
</script>
<style scoped>
:deep(table th) {
    text-align: start;
    margin-block-start: 4px;
}
</style>

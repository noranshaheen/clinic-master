<template>
    <app-layout>
        <bill-details ref="dlg2" :bill_details="billDetails" />
        <div class="py-4">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div
                    class="wrapper Gbg-white shadow-xl sm:rounded-lg p-4"
                >
                    <Table :resource="bills" >
                        <template #cell(date)="{item : bill}">
                            {{ new Date(bill.date).toLocaleDateString() }}
                        </template>
                        <template #cell(doctor)="{item : bill}">
                            {{ bill.doctor.name }}
                        </template>
                        <template #cell(clinic)="{item : bill}">
                            {{ bill.clinic.name }}
                        </template>
                        <template #cell(actions)="{ item: bill }">
                            <secondary-button @click="showDetails(bill.id)">
                                <i class="fa fa-edit"></i> {{ __("Details") }}
                            </secondary-button>
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
import billDetails from "@/Pages/Bills/BillDetails.vue";
import { Table } from "@protonemedia/inertiajs-tables-laravel-query-builder";
import SecondaryButton from "@/Jetstream/SecondaryButton.vue";
import JetButton from "@/Jetstream/Button.vue";
import axios from 'axios';

export default {
    components: {
        billDetails,
        Confirm,
        AppLayout,
        Table,
        SecondaryButton,
        JetButton,
    },
    props: {
        bills: Object,
    },
    data() {
        return {
            bill: Object,
            billDetails: null
        };
    },
    methods: {
        showDetails(bill_id) {
            axios
                .get(route('billDetails.show', bill_id ))
                .then((response) => {
                    console.log(response.data);
                    this.billDetails = response.data;
                    this.$refs.dlg2.ShowDialog();
                })
        },
        // removeCustomer(clinic) {
        //     this.clinic = clinic;
        //     this.$refs.dlg1.ShowModal();
        // },
        // remove() {
        //     axios
        //         .delete(
        //             route("clinics.destroy", { clinic: this.clinic.id })
        //         )
        //         .then((response) => {
        //             this.$store.dispatch("setSuccessFlashMessage", true);
        //             setTimeout(() => {
        //                 window.location.reload();
        //             }, 500);
        //         })
        //         .catch((error) => {
        //         });
        // },
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
        console.log(this.bills);
    }
};
</script>
<style scoped>
:deep(table th) {
    text-align: start;
    margin-block-start: 4px;
}
</style>

<template>
    <app-layout>
        <edit-doctor ref="dlg2" :doctor="doctor" />
        <confirm ref="dlg1" @confirmed="remove()">
            {{ __("Are you sure you want to delete this doctor?") }}
        </confirm>
        <div class="py-4">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div
                    class="wrapper Gbg-white shadow-xl sm:rounded-lg p-4"
                >
                    <Table :resource="doctors" >
                        <template #cell(date_of_birth)="{ item: doctor }">
                            {{ new Date().getFullYear() - new Date(doctor.date_of_birth).getFullYear() }}
                        </template>
                        <template #cell(specialty_id)="{ item: doctor }">
                            {{ doctor.specialties.name }}
                        </template>
                        <template #cell(actions)="{ item: doctor }">
                            <secondary-button @click="editCustomer(doctor)">
                                <i class="fa fa-edit"></i> {{ __("Edit") }}
                            </secondary-button>
                            <jet-button class="ms-2" @click="removeCustomer(doctor)">
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
import EditDoctor from "@/Pages/Doctors/Edit.vue";
import { Table } from "@protonemedia/inertiajs-tables-laravel-query-builder";
import SecondaryButton from "@/Jetstream/SecondaryButton.vue";
import JetButton from "@/Jetstream/Button.vue";
import axios from 'axios';

export default {
    components: {
        EditDoctor,
        Confirm,
        AppLayout,
        Table,
        SecondaryButton,
        JetButton,
    },
    props: {
        doctors: Object,
    },
    data() {
        return {
            doctor: Object,
        };
    },
    methods: {
        editCustomer(cust) {
            this.doctor = cust;
            this.$nextTick(() => this.$refs.dlg2.ShowDialog());
            //this.$refs.dlg2.ShowDialog();
        },
        removeCustomer(cust) {
            this.doctor = cust;
            this.$refs.dlg1.ShowModal();
        },
        remove() {
            axios
                .delete(
                    route("doctors.destroy", { doctor: this.doctor.id })
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
};
</script>
<style scoped>
:deep(table th) {
    text-align: start;
    margin-block-start: 4px;
}
</style>

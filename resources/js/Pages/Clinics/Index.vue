<template>
    <app-layout>
        <edit-clinic ref="dlg2" :clinic="clinic" />
        <confirm ref="dlg1" @confirmed="remove()">
            {{ __("Are you sure you want to delete this clinic?") }}
        </confirm>
        <div class="py-4">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div
                    class="wrapper Gbg-white overflow-hidden shadow-xl sm:rounded-lg p-4"
                >
                    <Table :resource="clinics" >
                        <template #cell(actions)="{ item: clinic }">
                            <secondary-button @click="editCustomer(clinic)">
                                <i class="fa fa-edit"></i> {{ __("Edit") }}
                            </secondary-button>
                            <jet-button class="ms-2" @click="removeCustomer(clinic)">
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
import EditClinic from "@/Pages/Clinics/Edit.vue";
import { Table } from "@protonemedia/inertiajs-tables-laravel-query-builder";
import SecondaryButton from "@/Jetstream/SecondaryButton.vue";
import JetButton from "@/Jetstream/Button.vue";
import axios from 'axios';

export default {
    components: {
        EditClinic,
        Confirm,
        AppLayout,
        Table,
        SecondaryButton,
        JetButton,
    },
    props: {
        clinics: Object,
    },
    data() {
        return {
            clinic: Object,
        };
    },
    methods: {
        editCustomer(clinic) {
            this.clinic = clinic;
            this.$nextTick(() => this.$refs.dlg2.ShowDialog());
            //this.$refs.dlg2.ShowDialog();
        },
        removeCustomer(clinic) {
            this.clinic = clinic;
            this.$refs.dlg1.ShowModal();
        },
        remove() {
            axios
                .delete(
                    route("clinics.destroy", { clinic: this.clinic.id })
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
        console.log(this.clinics);
    }
};
</script>
<style scoped>
:deep(table th) {
    text-align: start;
    margin-block-start: 4px;
}
</style>

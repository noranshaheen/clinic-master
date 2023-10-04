<template>
    <app-layout>
        <!-- <edit-inventory ref="dlg2" :inventory="inventory" /> -->
        <!-- <confirm ref="dlg1" @confirmed="remove()">
            {{ __("Are you sure you want to delete this warehouse?") }}
        </confirm> -->
        <div class="py-4">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="wrapper Gbg-white overflow-hidden shadow-xl sm:rounded-lg p-4 flex-col">
                    <!-- <div class="flex justify-end">
                        <JetButton class="-mb-8" @click="newOutMovement()">
                            {{ __("Withdraw Items From Stock") }}
                        </JetButton>
                    </div> -->
                    <Table :resource="out_movements">

                        <template #cell(clinic)="{ item: out_movement }">
                            {{ out_movement.stock.inventory.clinic.name }}
                        </template>
                        <template #cell(warehouse)="{ item: out_movement }">
                            {{ out_movement.stock.inventory.name + "/" + out_movement.stock.inventory.location }}
                        </template>
                        <template #cell(stock)="{ item: out_movement }">
                            {{ out_movement.stock.name }}
                        </template>
                        <template #cell(item)="{ item: out_movement }">
                            {{ out_movement.item.name }}
                        </template>
                        <template #cell(type)="{ item: out_movement }">
                            {{ out_movement.type == 'out' ? __("Outbound") : "" }}
                        </template>

                        <template #cell(actions)="{ item: inventory }">
                            <!-- <secondary-button @click="editCustomer(inventory)">
                                <i class="fa fa-edit"></i> {{ __("Edit") }}
                            </secondary-button> -->
                            <!-- <JetDangerButton class="ms-2" @click="removeCustomer(inventory)">
                                <i class="fa fa-trash"></i> {{ __("Delete") }}
                            </JetDangerButton> -->
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
import EditInventory from "@/Pages/Inventories/Edit.vue";
import { Table } from "@protonemedia/inertiajs-tables-laravel-query-builder";
import SecondaryButton from "@/Jetstream/SecondaryButton.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetDangerButton from "@/Jetstream/DangerButton.vue";
import axios from 'axios';

export default {
    components: {
        EditInventory,
        Confirm,
        AppLayout,
        Table,
        SecondaryButton,
        JetButton,
        JetDangerButton
    },
    props: {
        out_movements: Object,
    },
    data() {
        return {
            out_movement: Object,
        };
    },
    methods: {
        newOutMovement(){
            this.$inertia.visit(route("inventory.create.outs"));
        },
        editCustomer(cust) {
            this.inventory = cust;
            this.$nextTick(() => this.$refs.dlg2.ShowDialog());
            //this.$refs.dlg2.ShowDialog();
        },
        removeCustomer(cust) {
            this.appointment = cust;
            this.$refs.dlg1.ShowModal();
        },
        remove() {
            axios
                .delete(
                    route("appointments.destroy", { appointment: this.appointment.id })
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
    created: function created() {
        console.log(this.in_movements);
    }
};
</script>
<style scoped>
:deep(table th) {
    text-align: start;
    margin-block-start: 4px;
}
</style>

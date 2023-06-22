<template>
    <app-layout>
        <edit-item ref="dlg2" :item="item" />
        <confirm ref="dlg1" @confirmed="remove()">
            {{ __("Are you sure you want to delete this item?") }}
        </confirm>
        <div class="py-4">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div
                    class="wrapper Gbg-white shadow-xl sm:rounded-lg p-4"
                >
                    <Table :resource="items" >
						<template #cell(hidden)="{item:item}">
							{{ item.hidden == 0? "No":"Yes" }}
						</template>
                        <template #cell(actions)="{ item: item }">
                            <secondary-button @click="editCustomer(item)">
                                <i class="fa fa-edit"></i> {{ __("Edit") }}
                            </secondary-button>
                            <!-- <jet-button class="ms-2" @click="removeCustomer(item)">
                                <i class="fa fa-trash"></i> {{ __("Delete") }}
                            </jet-button> -->
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
import EditItem from "@/Pages/Items/Edit.vue";
import { Table } from "@protonemedia/inertiajs-tables-laravel-query-builder";
import SecondaryButton from "@/Jetstream/SecondaryButton.vue";
import JetButton from "@/Jetstream/Button.vue";
import axios from 'axios';

export default {
    components: {
        EditItem,
        Confirm,
        AppLayout,
        Table,
        SecondaryButton,
        JetButton,
    },
    props: {
        items: Object,
    },
    data() {
        return {
            item: Object,
        };
    },
    methods: {
        editCustomer(cust) {
            this.item = cust;
            this.$nextTick(() => this.$refs.dlg2.ShowDialog());
            //this.$refs.dlg2.ShowDialog();
        },
        removeCustomer(cust) {
            this.item = cust;
            this.$refs.dlg1.ShowModal();
        },
        remove() {
            axios
                .delete(
                    route("items.destroy", { item: this.item.id })
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
        console.log(this.items);
    }
};
</script>
<style scoped>
:deep(table th) {
    text-align: start;
    margin-block-start: 4px;
}
</style>

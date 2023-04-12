<template>
    <!-- prettier-ignore -->
    <app-layout>
        <upload-accounting-chart ref="dlg1" />
        <edit-item ref="dlg2" :accounting_item="currentItem" />
        <div class="py-4">
            <div class="mx-auto sm:px-6 lg:px-8">
                <jet-button @click="newItem()">
                    {{ __("New") }}
                </jet-button>
                <jet-button @click="$refs.dlg1.ShowDialog()">
                    {{ __("Upload") }}
                </jet-button>
                <jet-button>
                    <a :href="route('accounting.chart.download')">
                        {{ __("Download") }}
                    </a>
                </jet-button>
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4 mt-4">
                    <Table :resource="items">
                        <template #cell(latest_balance.credit_amount)="{ item: item }">
                            {{ approximate(item.latest_balance.credit_amount) }}
                        </template>
                        <template #cell(latest_balance.debit_amount)="{ item: item }">
                            {{ approximate(item.latest_balance.debit_amount) }}
                        </template>
                        <template #cell(actions)="{ item: item }">
                            <jet-danger-button class="me-2 mt-2" @click="toggleItemStatus(item)">
                                {{ item.status == "Active" ? __("Deactivate") : __("Activate") }}
                            </jet-danger-button>
                            <jet-button class="me-2 mt-2" @click="editItem(item)">
                                {{ __("Edit") }}
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
import {
    Table
} from "@protonemedia/inertiajs-tables-laravel-query-builder";
import Confirm from "@/UI/Confirm.vue";
import JetLabel from "@/Jetstream/Label.vue";
import SecondaryButton from "@/Jetstream/SecondaryButton.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetDangerButton from '@/Jetstream/DangerButton.vue';
import Dropdown from "@/Jetstream/Dropdown.vue";
import EditItem from "@/Pages/Accounting/Chart/Edit.vue";
import UploadAccountingChart from "@/Pages/Accounting/Chart/Upload.vue";

export default {
    components: {
        Dropdown,
        AppLayout,
        Confirm,
        JetLabel,
        Table,
        JetButton,
        JetDangerButton,
        SecondaryButton,
        EditItem, UploadAccountingChart,
    },
    props: {
        items: Object,
    },
    data() {
        return {
            currentItem: {},
            notSortableCols: [
            ],
        };
    },
    methods: {
        newItem() {
            this.currentItem = null;
            this.$nextTick(() => this.$refs.dlg2.ShowDialog());
        },
        editItem(item) {
            this.currentItem = item;
            this.$nextTick(() => this.$refs.dlg2.ShowDialog());
        },
        toggleItemStatus(item) {
            this.currentItem = item;
            axios
                .post(route("accounting.chart.delete"), {
                    id: this.currentItem.id,
                    status: this.currentItem.status == "Active" ? "Inactive" : "Active",
                })
                .then((response) => {
                    this.$store.dispatch("setSuccessFlashMessage", true);
                    this.currentItem.status = this.currentItem.status == "Active" ? "Inactive" : "Active";
                })
                .catch((error) => {
                    this.$page.props.errors = error.response.data.errors;
                    this.errors = error.response.data.errors;
                });
        },
        nestedIndex: function (item, key) {
            try {
                var keys = key.split(".");
                if (keys.length == 1) return item[key].toString();
                if (keys.length == 2) return item[keys[0]][keys[1]].toString();
                if (keys.length == 3)
                    return item[keys[0]][keys[1]][keys[2]].toString();
                return "Unsupported Nested Index";
            } catch (err) { }
            return "N/A";
        },
    },
};
</script>

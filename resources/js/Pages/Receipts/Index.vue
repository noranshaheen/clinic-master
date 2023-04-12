<template>
    <!-- prettier-ignore -->
    <app-layout>
        <div class="py-4">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                    <Table :resource="items">
                        <template #cell(status)="{ item: item }">
                            {{ __(item.status) }}
                        </template>
                        <template #cell(statusReason)="{ item: item }">
                            {{ __(item.statusReason) }}
                        </template>
                        <template #cell(dateTimeIssued)="{ item: item }">
                            {{ new Date(item.dateTimeIssued).toLocaleDateString() }}
                        </template>
                        <template #cell(dateTimeReceived)="{ item: item }">
                            {{ new Date(item.dateTimeReceived).toLocaleDateString() }}
                        </template>
                        <template #cell(actions)="{ item: item }">
                            <jet-button class="me-2 mt-2" @click="sendToETA(item)" v-show="item.status == 'In Review'">
                                {{ __("Send") }}
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
    Table,
} from "@protonemedia/inertiajs-tables-laravel-query-builder";
import AddEditItem from "@/Pages/Items/AddEdit.vue";
import Confirm from "@/UI/Confirm.vue";
import JetLabel from "@/Jetstream/Label.vue";
import PreviewInvoice from "@/Pages/Invoices/Preview.vue";
import SecondaryButton from "@/Jetstream/SecondaryButton.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetDangerButton from '@/Jetstream/DangerButton.vue';
import Dropdown from "@/Jetstream/Dropdown.vue";
import axios from 'axios';

export default {
    components: {
        Dropdown,
        AppLayout,
        Confirm,
        PreviewInvoice,
        JetLabel,
        Table,
        JetButton,
        JetDangerButton,
        AddEditItem,
        SecondaryButton,
    },
    props: {
        items: Object,
    },
    data() {
        return {
            invItem: {},
            notSortableCols: [
                "statusReason",
                "receiver.name",
                "receiver.receiver_id",
                "issuerName",
                "receiverId",
                "receiverName",
            ],
        };
    },
    methods: {
        sendToETA(item) {
            this.invItem = item;
            axios
                .post(route("eta.receipts.send"), {
                    id: this.invItem.id,
                })
                .then((response) => {
                    //console.log(response);
                    //alert(response.data);
                })
                .catch((error) => {
                    //console.log(error);
                    //alert(error.response.data);
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
        }
    },
};
</script>
<style scoped>
:deep(table th) {
    text-align: start;
}
</style>

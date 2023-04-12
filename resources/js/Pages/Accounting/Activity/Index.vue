<template>
    <!-- prettier-ignore -->
    <app-layout>
        <edit-item ref="dlg2" :accounting_item="currentItem" />
        <div class="py-4">
            <div class="mx-auto sm:px-6 lg:px-8">
                <jet-button @click="newItem()">
                    {{ __("Add") }}
                </jet-button>
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4 mt-4">
                    <Table :resource="items">
                        <template #cell(actions)="{ item: item }">
                            <jet-danger-button class="me-2 mt-2" @click="toggleItemStatus(item)">
                                {{ item.status == "Active" ? __("Deactivate") : __("Activate") }}
                            </jet-danger-button>
                            <jet-button class="me-2 mt-2" @click="editItem(item)">
                                {{ __("Edit") }}
                            </jet-button>
                            <jet-danger-button class="me-2 mt-2" @click="deleteItem(item)">
                                {{ __("Delete") }}
                            </jet-danger-button>
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
import EditItem from "@/Pages/Accounting/Activity/Edit.vue";
import swal from "sweetalert";

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
        EditItem,
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
            this.currentItem.status = this.currentItem.status == "Active" ? "Inactive" : "Active"
            axios
                .post(route("accounting.activity.store"), this.currentItem)
                .then((response) => {
                    this.$store.dispatch("setSuccessFlashMessage", true);
                })
                .catch((error) => {
                    this.currentItem.status = this.currentItem.status == "Active" ? "Inactive" : "Active"
                    this.$page.props.errors = error.response.data.errors;
                    this.errors = error.response.data.errors;
                });
        },
        deleteItem(item) {
            swal({
                title: this.__("Warning"),
                text: this.__("Are you sure?"),
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willApprove) => {
                if (willApprove) {
                    this.currentItem = item;
                    axios
                        .post(route("accounting.activity.delete"), this.currentItem)
                        .then((response) => {
                            this.$store.dispatch("setSuccessFlashMessage", true);
                            setTimeout(() => {
                                window.location.reload();
                            }, 500);
                        })
                        .catch((error) => {
                            this.$page.props.errors = error.response.data.errors;
                            this.errors = error.response.data.errors;
                        });
                }
            });

        }
    },
};
</script>

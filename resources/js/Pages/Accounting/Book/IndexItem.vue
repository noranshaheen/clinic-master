<template>
    <!-- prettier-ignore -->
    <app-layout>
        <edit-item ref="dlg2" :book_item="currentItem" />
        <div class="py-4">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="text-2xl text-center">{{ __('The book entries for ')}}{{book.name}}</div>
                <jet-button @click="newItem()">
                    {{ __("Add Book Entry") }}
                </jet-button>
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4 mt-4">
                    <Table :resource="items">
                        <template #cell(transaction_date)="{ item: item }">
                            {{ new Date(item.transaction_date).toLocaleDateString() }}
                        </template>
                        <template #cell(actions)="{ item: item }">
                            <jet-danger-button class="me-2 mt-2" @click="approveItem(item)" v-show="item.status=='Draft'">
                                {{ __("Approve") }}
                            </jet-danger-button>
                            <jet-button class="me-2 mt-2" @click="editItem(item)" v-show="item.status=='Draft'">
                                {{ __("Edit") }}
                            </jet-button>
                            <jet-danger-button class="me-2 mt-2" @click="deleteItem(item)">
                                {{ __("Delete") }}
                            </jet-danger-button>
                            <!--if item.attachment is not null show the button-->
                            <jet-button class="me-2 mt-2" @click="downloadPDF(item)" v-show="item.attachment != null">
                                {{ __("Attachment") }}
                            </jet-button>
                            <jet-button class="me-2 mt-2" @click="printItem(item)">
                                {{ __("Print") }}
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
import EditItem from "@/Pages/Accounting/Book/EditItem.vue";
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
        book: Object
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
        approveItem(item) {
            this.currentItem = item;
            this.currentItem.status = "Approved";
            this.currentItem.attachment = null;
            this.currentItem.approved_by = this.$page.props.auth.user.id;
            this.currentItem.activities.forEach((element) => {
                element.contribution_percentage = element.pivot.contribution_percentage;
                element.accounting_activity_id = element.id;
            });
            axios
                .post(route("accounting.book.item.store", route().params.book), this.currentItem)
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
                        .post(route("accounting.book.item.delete", route().params.book), this.currentItem)
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

        },
        downloadPDF(item) {
            var bookId = route().params.book;
            var bookItemId = item.id;
            window.open(route("accounting.book.item.download", [bookId, bookItemId]));
        },
        printItem(item) {
            var bookId = route().params.book;
            var bookItemId = item.id;
            window.open(route("accounting.book.item.print", [bookId, bookItemId]));
        },
    },
};
</script>

<template>
    <app-layout>
        <edit-user ref="dlg2" :p-user="user" />
        <confirm ref="dlg1" @confirmed="remove()">
            {{ __("Are you sure you want to delete this user?") }}
        </confirm>
        <div class="py-4">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-xl sm:rounded-lg p-4">
                    <Table :resource="users">
                        <template #cell(actions)="{ item: user }">
                            <button class="p-1 rounded-md bg-green-500 text-white hover:bg-green-600 mx-2"
                                @click="edituser(user)">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                            </button>
                            <button class="p-1 rounded-md bg-red-500 text-white hover:bg-red-600 mx-2" i
                                @click="removeuser(user)">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                            </button>
                        </template>
                    </Table>
                </div>
            </div>
            <!-- <div v-else class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                    {{ __("You are not authorized to view users") }}
                </div>
            </div> -->
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import Confirm from "@/UI/Confirm.vue";
import EditUser from "@/Pages/Users/Edit.vue";
import {
    Table,
} from "@protonemedia/inertiajs-tables-laravel-query-builder";
import axios from 'axios';

export default {
    components: {
        AppLayout,
        Confirm,
        EditUser,
        Table,
    },
    props: {
        users: Object,
    },
    data() {
        return {
            user: Object,
        };
    },
    methods: {
        edituser(cust) {
            this.user = cust;
            this.$nextTick(() => this.$refs.dlg2.ShowDialog());
            //this.$refs.dlg2.ShowDialog();
        },
        removeuser(cust) {
            this.user = cust;
            this.$refs.dlg1.ShowModal();
        },
        remove() {
            axios
                .delete(route("users.destroy", { user: this.user.id }))
                .then((response) => {
                    location.reload();
                })
                .catch((error) => {
                    //this.$refs.password.focus()
                });
        },
    },
};
</script>
<style scoped>
:deep(table th) {
    text-align: start;
}
</style>

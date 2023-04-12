<template>
    <app-layout>
        <edit-pos ref="dlg2" :positem="pos_item" />
        <confirm ref="dlg1" @confirmed="remove()">
            {{ __("Are you sure you want to delete this pos?") }}
        </confirm>
        <div class="py-4">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                    <Table :resource="poses">
                        <template #cell(actions)="{ item: item }">
                            <secondary-button @click="editPOS(item)">
                                <i class="fa fa-edit"></i>
                                {{ __("Edit") }}
                            </secondary-button>
                            <jet-button class="ms-2" @click="removePOS(item)">
                                <i class="fa fa-trash"></i>
                                {{ __("Delete") }}
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
import EditPos from "@/Pages/POS/Add.vue";
import {
    Table,
} from "@protonemedia/inertiajs-tables-laravel-query-builder";
import SecondaryButton from "@/Jetstream/SecondaryButton.vue";
import JetButton from "@/Jetstream/Button.vue";
import axios from "axios";

export default {
    components: {
        AppLayout,
        Confirm,
        EditPos,
        Table,
        SecondaryButton,
        JetButton,
    },
    props: {
        poses: Object,
    },
    data() {
        return {
            pos_item: Object,
            notSortableCols: [
                "issuer.name",
                "grant_type"
            ],
        };
    },
    methods: {
        editPOS(p_pos) {
            this.pos_item = p_pos;
            this.$nextTick(() => this.$refs.dlg2.ShowDialog());
            //this.$refs.dlg2.ShowDialog();
        },
        removePOS(p_pos) {
            this.pos_item = p_pos;
            this.$refs.dlg1.ShowModal();
        },
        remove() {
            axios
                .delete(route("pos.destroy", this.pos_item.id))
                .then((response) => {
                    this.$store.dispatch("setSuccessFlashMessage", true);
                    setTimeout(() => {
                        window.location.reload();
                    }, 500);
                })
                .catch((error) => {
                    //this.$refs.password.focus()
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
    mounted() {

    },
};
</script>
<style scoped>
:deep(table th) {
    text-align: start;
}
</style>

<template>
	<app-layout>
		<div class="py-4">
			<div class="mx-auto sm:px-6 lg:px-8">
				<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
					<Table :resource="items">
						<template #cell(description)="{ item: item }"> {{ __(item.description) }}</template>
						<template #cell(internal_code)="{ item: item }"> {{ __(item.internal_code) }}</template>
						<template #cell(gs1_code)="{ item: item }"> {{ __(item.gs1_code) }}</template>
						<template #cell(egs_code)="{ item: item }"> {{ __(item.egs_code) }}</template>
						<template #cell(unit_type)="{ item: item }"> {{ __(item.unit_type) }}</template>
						<template #cell(unit_value)="{ item: item }"> {{ __(item.unit_value) }}</template>
						<template #cell(actions)="{ item: item }">
							<jet-button type="button">
								<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px"
									fill="#FFFFFF">
									<path d="M0 0h24v24H0V0z" fill="none" />
									<path
										d="M14.06 9.02l.92.92L5.92 19H5v-.92l9.06-9.06M17.66 3c-.25 0-.51.1-.7.29l-1.83 1.83 3.75 3.75 1.83-1.83c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.2-.2-.45-.29-.71-.29zm-3.6 3.19L3 17.25V21h3.75L17.81 9.94l-3.75-3.75z" />
								</svg>
							</jet-button>
						</template>
					</Table>
				</div>
			</div>
		</div>
	</app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Table } from '@protonemedia/inertiajs-tables-laravel-query-builder';
import JetButton from '@/Jetstream/Button.vue';
import AddEditItem from '@/Pages/Items/AddEdit.vue';
import axios from 'axios';

export default {
	components: {
		AppLayout,
		Table,
		JetButton,
		AddEditItem,
	},
	props: {
		items: Object
	},
	methods: {
		editItem: function (item_id) {
			//alert(JSON.stringify(item_id));
		}
	}
}
</script>
<style scoped>
:deep(table td) {
	text-align: start;
	white-space: pre-line;
}

:deep(table th) {
	text-align: start;
	white-space: pre-line;
}
</style>

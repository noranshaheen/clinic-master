<template>
	<jet-dialog-modal :show="addingNew" @close="addingNew = false">
		<template #title>
			{{ __('Add Bill Item ') }}
		</template>

		<template #content>
			<div class="md:grid md:grid-cols-2 md:gap-4">
				<div>
					<jet-label for="measurement_unit" :value="__('Items')" />
					<multiselect v-model="form.item" :options="items" label="name" :searchable="true"
						:placeholder="__('Select Item')" class="mt-1 block w-full" />
				</div>
				<div>
					<jet-label for="measurement_unit" :value="__('Unit')" />
					<multiselect v-model="form.unit" :options="units" label="desc_en" :searchable="true"
						:placeholder="__('Unit')" class="mt-1 block w-full" />
				</div>
				<div>
					<jet-label for="itemName" :value="__('/Unit Price')"/>
					<TextField v-model="form.unitPrice" itemType="number" />
				</div>
				<div>
					<jet-label for="itemName" :value="__('Quantity')" />
					<TextField v-model="form.quantity" itemType="number" />
				</div>
				<div>
					<jet-label for="itemName" :value="__('Total')" />
					<TextField v-model="form.total" itemType="number" />
				</div>

			</div>
		</template>
		<template #footer>
			<div class="flex items-center justify-end mt-4">
				<jet-secondary-button @click="CancelAddBranch()">
					{{ __('Cancel') }}
				</jet-secondary-button>

				<jet-button class="ms-2" @click="SaveNew()" :class="{ 'opacity-25': form.processing }"
					:disabled="form.processing">
					{{ __('Save') }}
				</jet-button>
			</div>
		</template>
	</jet-dialog-modal>
</template>

<script>
import JetActionMessage from '@/Jetstream/ActionMessage.vue'
import JetActionSection from '@/Jetstream/ActionSection.vue';
import TextField from "@/UI/TextField.vue";
import Multiselect from "@suadelabs/vue3-multiselect";
import JetButton from '@/Jetstream/Button.vue'
import JetConfirmationModal from '@/Jetstream/ConfirmationModal.vue'
import JetDangerButton from '@/Jetstream/DangerButton.vue'
import JetDialogModal from '@/Jetstream/DialogModal.vue'
import JetFormSection from '@/Jetstream/FormSection.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetCheckbox from '@/Jetstream/Checkbox.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetLabel from '@/Jetstream/Label.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
import JetSectionBorder from '@/Jetstream/SectionBorder.vue'
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'
import axios from 'axios';

export default {
	components: {
		JetActionMessage,
		Multiselect,
		JetActionSection,
		TextField,
		JetButton,
		JetConfirmationModal,
		JetDangerButton,
		JetDialogModal,
		JetFormSection,
		JetInput,
		JetCheckbox,
		JetInputError,
		JetLabel,
		JetSecondaryButton,
		JetSectionBorder,
		JetValidationErrors,
	},

	props: ['item', 'idx'],
	data() {
		return {
			errors: [],
			units: [],
			items: [],
			form:{
				item: "",
				unit: "",
				unitPrice: "",
				quantity: "",
				total: "",
			},
			addingNew: false,
		}
	},

	methods: {
		ShowDialog() {
			// this.form.reset();
			this.form.item = this.item.item;
			this.form.unit = this.item.unit;
			this.form.unitPrice = this.item.unitPrice;
			this.form.quantity = this.item.quantity;
			this.form.total = this.item.total;
			this.addingNew = true;
		},
		CancelAddBranch() {
			this.addingNew = false;
		},
		SaveNew() {
			// console.log(this.form);
			// console.log(this.idx);
			this.$nextTick(() => this.$emit("save", this.form, this.idx));
			this.CancelAddBranch();
		},
	},
	created: function () {
		axios
			.get("/json/UnitTypes.json")
			.then((response) => {
				this.units = response.data;
			})
			.catch((error) => { });
		axios
			.get((route('items.index')))
			.then((response) => {
				this.items = response.data;
				// console.log(this.items);
			})
	}
}
</script>

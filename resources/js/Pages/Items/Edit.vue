<template>
	<jet-dialog-modal :show="addingNew" @close="addingNew = false">
		<template #title>
			{{ __('Add new item') }}
		</template>

		<template #content>
			<jet-validation-errors class="mb-4" />

			<form @submit.prevent="submit">
				<div class="sm:grid sm:grid-cols-1 sm:gap-4">
					<div>
						<div class="">
							<jet-label for="itemName" :value="__('Name')" />
							<jet-input id="itemName" type="text" class="mt-1 block w-full" v-model="form.name" required
								autofocus />
						</div>
						<div class="mt-1">
							<jet-label :value="__('Measurement Unit')" />
							<multiselect 
							v-model="form.measurement_unit" 
							:options="units" 
							label="desc_en" 
							:searchable="true"
							track-by="id" 
							:placeholder="__('Select Unit')" class="mt-1 block w-full" />
						</div>
						<div class="hidden sm:block mt-2">
							<input type="checkbox" class="m-1" name="storableItem" :true-value="1"
								:false-value="0" v-model="form.storableItem" />
							<jet-label :value="__('Storable Item')" />
						</div>

					</div>
					<!-- <div>
						<jet-label for="weight" :value="__('Item Weight/Volume')" />
						<span class="text-sm text-gray-500">{{ __(' (optional)') }}</span>
						<jet-input id="weight" type="number" class="mt-1 block w-full" v-model="form.weight" required
							autofocus />

						<jet-label for="selling_price" :value="__('Selling Price per unit')" />
						<jet-input id="selling_price" type="number" class="mt-1 block w-full" v-model="form.selling_price"
							required autofocus />
						<div class="sm:hidden mt-1">
							<jet-input class="m-1" type="checkbox" name="hidden" value="1" v-model="form.hiddenItem" />
							<jet-label :value="__('Hidden Item')" />
						</div>
					</div> -->
				</div>
			</form>
		</template>
		<template #footer>
			<div class="flex items-center justify-end mt-4">
				<jet-secondary-button @click="CancelAddBranch()">
					{{ __('Cancel') }}
				</jet-secondary-button>

				<jet-button class="ms-2" @click="submit()" :class="{ 'opacity-25': form.processing }"
					:disabled="form.processing">
					{{ __('Save') }}
				</jet-button>
			</div>
		</template>
	</jet-dialog-modal>
</template>

<script>
import JetActionMessage from '@/Jetstream/ActionMessage.vue'
import JetActionSection from '@/Jetstream/ActionSection.vue'
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

	props: {
		item: {
			Type: Object,
			default: null
		}
	},
	data() {
		return {
			errors: [],
			units: [],
			form: this.$inertia.form({
				name: "",
				measurement_unit: "",
				storableItem: 0,
				// selling_price: "",
				// weight: "",
			}),
			addingNew: false,
		}
	},

	methods: {
		ShowDialog() {
			if (this.item !== null) {
				this.form.name = this.item.name;
				// this.form.measurement_unit = this.item.unit;
				this.form.storableItem = this.item.storable;
				// this.form.selling_price = this.item.selling_price;
				// this.form.weight = this.item.weight;
			}
			this.addingNew = true;
		},
		CancelAddBranch() {
			this.addingNew = false;
		},
		SaveNew() {
			axios.post(route('items.store'), this.form)
				.then(response => {
					this.processing = false;
					this.$nextTick(() => this.$emit('dataUpdated'));
					this.form.reset();
					this.form.processing = false;
					this.addingNew = false;
				}).catch(error => {
					this.form.processing = false;
					this.$page.props.errors = error.response.data.errors;
					this.errors = error.response.data.errors;//.password[0];
					//this.$refs.password.focus()
				});
		},
		Save() {
			axios
				.put(route('items.update', { item: this.item.id }), this.form)
				.then(response => {
					this.processing = false;
					this.$nextTick(() => this.$emit('dataUpdated'));
					this.form.reset();
					this.form.processing = false;
					this.addingNew = false;
				}).catch(error => {
					this.form.processing = false;
					this.$page.props.errors = error.response.data.errors;
					this.errors = error.response.data.errors;//.password[0];
					//this.$refs.password.focus()
				});
		},
		submit() {
			if (this.item !== null) {
				this.Save();
			} else {
				this.SaveNew();
			}
		}
	},
	created: function () {
		axios
			.get("/json/UnitTypes.json")
			.then((response) => {
				this.units = response.data;
			})
			.catch((error) => { });
	}
}
</script>

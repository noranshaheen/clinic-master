<template>
	<jet-dialog-modal :show="showDialog" @close="showDialog = false">
		<template #title>
			{{ __("Warehouse Information") }}
		</template>

		<template #content>
			<jet-validation-errors class="mb-4" />

			<form @submit.prevent="submit">
				<div class="grid grid-cols-1 gap-4">
					<div>

						<div class="mt-4">
							<jet-label for="type" :value='__("Name")' />
							<jet-input id="type" type="text" class="mt-1 block w-full" v-model="form.name" required />
						</div>

						<div class="mt-4">
							<jet-label for="type" :value='__("Address")' />
							<jet-input id="type" type="text" class="mt-1 block w-full" v-model="form.address" required />
						</div>

						<div>
							<jet-label for="branch" :value='__("Clinic")' />
							<select id="branch" required v-model="form.clinic_id"
								class="mt-1 block w-full rounded border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow-sm">
								<option v-for="cl in allClinics" :key="cl.id" :value="cl.id">
									{{ cl.name }}
								</option>
							</select>
						</div>

						<div v-for="(stock, idx1) in form.stocks" :key="idx1" class="mt-4">
							<jet-label :value="__('Stock Name')" class="block" />
							<div class="flex justify-between items-center">
								<jet-input type="text" class="mt-1 text-sm w-full"
								:class="{'w-11/12': !inventory}"
								v-model="stock.name" required />
								<i v-if="!inventory" class="fa-solid fa-trash text-red-600 w-1/12 px-5" @click="deleteEntry(idx1)"></i>
							</div>

						</div>
						<div class="col-span-1 w-1/5 my-2 mx-auto">
							<jet-button class="ps-2 w-full mt-1" @click="addStock" :disabled="form.processing">
								<span class="">{{ __("Add") }}</span>
								<span class="hidden lg:inline">{{ __(" A Stock") }}</span>
							</jet-button>
						</div>
					</div>
				</div>
			</form>
		</template>
		<template #footer>
			<div class="flex items-center justify-end">
				<jet-secondary-button @click="CancelAddcustomer()">
					{{ __("Cancel") }}
				</jet-secondary-button>

				<jet-button class="ms-2" @click="submit" :class="{ 'opacity-25': form.processing }"
					:disabled="form.processing">
					{{ __("Save") }}
				</jet-button>
			</div>
		</template>
	</jet-dialog-modal>
</template>
  
<script>
import JetActionMessage from "@/Jetstream/ActionMessage.vue";
import JetActionSection from "@/Jetstream/ActionSection.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetConfirmationModal from "@/Jetstream/ConfirmationModal.vue";
import JetDangerButton from "@/Jetstream/DangerButton.vue";
import JetDialogModal from "@/Jetstream/DialogModal.vue";
import JetFormSection from "@/Jetstream/FormSection.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetCheckbox from "@/Jetstream/Checkbox.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import JetSectionBorder from "@/Jetstream/SectionBorder.vue";
import JetValidationErrors from "@/Jetstream/ValidationErrors.vue";
import axios from "axios";

export default {
	components: {
		JetActionMessage,
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
		inventory: {
			Type: Object,
			default: null,
		},
	},

	data() {
		return {
			errors: [],
			allClinics: [],
			form: this.$inertia.form({
				name: "",
				address: "",
				clinic_id: "",
				stocks: []
			}),
			showDialog: false,
		};
	},

	methods: {
		ShowDialog() {
			if (this.inventory !== null) {
				this.form.name = this.inventory.name;
				this.form.address = this.inventory.location;
				this.form.clinic_id = this.inventory.clinic_id;
				this.form.stocks = this.inventory.stocks;
			}
			this.showDialog = true;
		},
		CancelAddcustomer() {
			this.showDialog = false;
		},
		addStock() {
			this.form.stocks.push({
				name: ""
			});
		},
		deleteEntry(idx1) {
			this.form.stocks.splice(idx1, 1);
		},
		SaveCustomer() {
			axios
				.put(
					route("inventories.update", { id: this.inventory.id }),
					this.form
				)
				.then((response) => {
					this.$store.dispatch("setSuccessFlashMessage", true);
					this.showDialog = false;
					setTimeout(() => {
						window.location.reload();
					}, 500);
				})
				.catch((error) => {
					console.log(error);
					this.form.processing = false;
					this.$page.props.errors = error.response.data.errors;
					this.errors = error.response.data.errors; //.password[0];
					//this.$refs.password.focus()
				});
		},
		SaveNewCustomer() {
			axios
				.post(route("inventories.store"), this.form)
				.then((response) => {
					this.$store.dispatch("setSuccessFlashMessage", true);
					this.processing = false;
					this.$nextTick(() => this.$emit("dataUpdated"));
					this.form.reset();
					this.form.processing = false;
					this.showDialog = false;
					setTimeout(() => {
						window.location.reload();
					}, 500);
				})
				.catch((error) => {
					this.form.processing = false;
					this.$page.props.errors = error.response.data.errors;
					this.errors = error.response.data.errors; //.password[0];
					//this.$refs.password.focus()
				});
		},
		submit() {
			if (this.inventory == null) this.SaveNewCustomer();
			else this.SaveCustomer();
		},
	},
	created: function created() {
		this.addStock();
		axios
			.get(route("clinic.all"))
			.then((response) => {
				// console.log(response.data);
				this.allClinics = response.data;;
			})
			.catch((error) => {
				console.log(error);
			});
	},
};
</script>
  
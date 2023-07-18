<template>
    <!-- New Customer Modal -->
    <jet-dialog-modal :show="uploadingCustomers" @close="uploadingCustomers = false" class="min-w-min">
            <template #title>
                {{__('Upload Patients')}}
            </template>

            <template #content>
                <div class="text-md md:text-lg">
					<!-- <label>{{__('Choose File')}} -->
						<input type="file" @change="handleFileUpload($event)" ref="inputFile"/>
					<!-- </label> -->
                </div>
                <div class="flex justify-start mt-4 underline decoration-1 text-md md:text-lg">
                    <a href="/ExcelTemplates/PatientUpload.xlsx">{{__('Download excel template')}}</a>
                </div>
            </template>

            <template #footer>
                <jet-secondary-button @click="CancelAddCustomer()">
                    {{__('Cancel')}}
                </jet-secondary-button>

                <jet-button class="ms-2" @click="submitFile()" :disabled="processing">
                    {{__('Save')}}
                </jet-button>
            </template>
        </jet-dialog-modal>
</template>

<script>
    import JetActionMessage from '@/Jetstream/ActionMessage.vue'
    import JetActionSection from '@/Jetstream/ActionSection.vue'
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
        },

        // props: [
        //     'customer',
        // ],

        data() {
            return {
				file: '',
				uploadingCustomers: false,
				processing: false
            }
        },

        methods: {
			ShowDialog() {
				this.uploadingCustomers = true;
			},
			CancelAddCustomer() {
				this.uploadingCustomers = false;
			},
			// SaveNewCustomer() {
			// 	this.uploadingCustomers = false;
			// },
			handleFileUpload(event){
  				this.file = event.target.files[0];
  			},
			submitFile() {
				let formData = new FormData();
				formData.append('file', this.file);
				this.processing = true;
				let temp = this;

				axios.post(route('patient.upload'),
				  formData,
				  {
					headers: {
						'Content-Type': 'multipart/form-data'
					}
				  }
				).then(()=>{
					temp.processing = false;
					temp.$refs.inputFile.value = null;
                    temp.uploadingCustomers = false
                    window.location.reload();                    
				})
				.catch(()=>{
					temp.processing = false;
					temp.$refs.inputFile.value = null;
				    console.log('FAILURE!!');
				});
			}
			
        },
    }
</script>

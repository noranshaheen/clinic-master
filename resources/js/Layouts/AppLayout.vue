<template>
    <div>
        <nav-bar @open_dlg="openDlg" />
        <settings-dialog1 ref="dlg9" />
        <settings-dialog2 ref="dlg10" />

        <new-doctor-dialog ref="dlg1" />
        <new-patient-dialog ref="dlg2" />
        <new-reseptionist-dialog ref="dlg11" />
        <new-clinic-dialog ref="dlg3" />
        <new-room-dialog ref="dlg4" />
        <new-drug-dialog ref="dlg5" />
        <new-diagnosis-dialog ref="dlg6" />
        <new-appointment-dialog ref="dlg7" />
        <new-user-dialog ref="dlg8" />
        <upload-drugs-dialog ref="dlg12"/>
        <upload-patients-dialog ref="dlg14"/>
        <new-item-dialog ref="dlg13" />

        <!-- <new-customer-dialog ref="dlg1" />
        <new-branch-dialog ref="dlg2" />
        <load-items-dialog ref="dlg3" />
        
        <load-invoices-dialog ref="dlg5" />
        <upload-invoices-dialog ref="dlg6" />
        <upload-items-dialog ref="dlg7" />
        
        <archive-request-dialog ref="dlg11" />
        <add-pos ref="addPOS" />
        <load-receipts ref="loadReceipts" />
        <upload-receipts ref="uploadReceipts" />
        <archive-request-dialog2 ref="dlg12" />
        <archive-request-dialog2 ref="dlg12" />
        <sb-load-invoices-dialog ref="dlg13" />
        <sb-items-map-dialog ref="dlg14" />
        <upload-customers-dialog ref="dlg15"/>
        <ms-items-map-dialog ref="msItemsMapUploadDlg" />
        <ms-Upload-invoices-dialog ref="msLoadInvoicesDlg" /> -->
        
        <div class="min-h-screen bg-gray-100 pb-5">
            <main>
                <div class="pt-6">
                    <flash-message type="success" v-if="successFlashMessage" />
                </div>
                <slot></slot>
            </main>
        </div>
        <app-footer />
    </div>
</template>

<script>
// modals
import NewDoctorDialog from "@/Pages/Doctors/Edit.vue";
import NewPatientDialog from "@/Pages/Patients/Edit.vue";
import NewReseptionistDialog from "@/Pages/Reseptionists/Edit.vue";
import NewClinicDialog from "@/Pages/Clinics/Edit.vue";
import NewRoomDialog from "@/Pages/Rooms/Edit.vue";
import NewDrugDialog from "@/Pages/Drugs/Edit.vue";
import NewDiagnosisDialog from "@/Pages/Diagnosis/Edit.vue";
import NewAppointmentDialog from "@/Pages/Appointments/Edit.vue";
import NewCustomerDialog from "@/Pages/Customers/Edit.vue";
import NewBranchDialog from "@/Pages/Branches/Edit.vue";
import NewUserDialog from "@/Pages/Users/Edit.vue";
import LoadItemsDialog from "@/Pages/Items/Load.vue";
import LoadInvoicesDialog from "@/Pages/Invoices/Load.vue";
import NewItemDialog from "@/Pages/Items/Edit.vue";
import UploadInvoicesDialog from "@/Pages/Invoices/Upload.vue";
import UploadCustomersDialog from "@/Pages/Customers/Upload.vue";
import UploadPatientsDialog from "@/Pages/Patients/Upload.vue";
import UploadDrugsDialog from "@/Pages/Drugs/Upload.vue";
import SettingsDialog1 from "@/Pages/Reports/Settings.vue";
import SettingsDialog2 from "@/Pages/Application/Settings.vue";
import UploadItemsDialog from "@/Pages/Items/Upload.vue";
import ArchiveRequestDialog from "@/Pages/Archives/Request.vue";
import AddPos from "@/Pages/POS/Add.vue";
import LoadReceipts from "@/Pages/Receipts/Load.vue";
import UploadReceipts from "@/Pages/Receipts/Upload.vue";
import SbLoadInvoicesDialog from "@/Pages/SalesBuzz/Load.vue";
import SbItemsMapDialog from "@/Pages/SalesBuzz/ItemsMap.vue";
import MsUploadInvoicesDialog from "@/Pages/Mobis/Upload.vue";
import MsItemsMapDialog from "@/Pages/Mobis/ItemsMap.vue";
import ArchiveRequestDialog2 from "@/Pages/Archives/RequestEx.vue";
import NavBar from "@/shared/NavBar.vue";
import AppFooter from "@/shared/AppFooter.vue";
import FlashMessage from "@/shared/FlashMessage.vue";
import { mapGetters } from "vuex";
export default {
    components: {
        AddPos,
        LoadReceipts,
        UploadReceipts,
        ArchiveRequestDialog,
        ArchiveRequestDialog2,
        UploadItemsDialog,
        UploadInvoicesDialog,
        UploadCustomersDialog,
        UploadPatientsDialog,
        UploadDrugsDialog,
        NewCustomerDialog,
        NewItemDialog,
        NewUserDialog,
        NewBranchDialog,
        LoadItemsDialog,
        LoadInvoicesDialog,
		SettingsDialog1, SettingsDialog2,
        SbItemsMapDialog, SbLoadInvoicesDialog,
        MsItemsMapDialog, MsUploadInvoicesDialog,
        NavBar,
        AppFooter,
        FlashMessage,
        NewDoctorDialog,
        NewPatientDialog,
        NewClinicDialog,
        NewRoomDialog,
        NewDrugDialog,
        NewDiagnosisDialog,
        NewAppointmentDialog,
        NewReseptionistDialog
    },

    data() {
        return {
            showingNavigationDropdown: false,
        };
    },
    methods: {
        openDlg($dlg) {
            this.$refs[$dlg].ShowDialog();
        }
    },
    computed: {
        ...mapGetters(["successFlashMessage"]),
    },
};
</script>

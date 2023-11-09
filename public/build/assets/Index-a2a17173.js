import{A as C}from"./AppLayout-336b7499.js";import{C as B}from"./Confirm-3a44cc87.js";import x from"./Edit-cfad98b4.js";import{O as S}from"./inertiajs-tables-laravel-query-builder.es-72bd3d80.js";import{J as k}from"./SecondaryButton-fb7ef34d.js";import{J as D}from"./Button-fce1e67a.js";import{J as I}from"./DangerButton-bf3f8f1f.js";import{k as J,c as b,w as t,r as e,o as P,b as i,f as n,t as m,a as s,p as T,l as $}from"./app-98cccb0d.js";import O from"./Show-70d6b51d.js";import{_ as A}from"./_plugin-vue_export-helper-c27b6911.js";import"./Edit-7ca2eef9.js";import"./ActionMessage-529841b6.js";import"./ActionSection-14bbef3c.js";import"./SectionTitle-f26ec90c.js";import"./ConfirmationModal-2d2586d4.js";import"./Modal-2ccc6cf7.js";import"./DialogModal-9cb7d35f.js";import"./FormSection-60b88c5f.js";import"./Input-9c9fd5b2.js";import"./Checkbox-7ff4e1d6.js";import"./InputError-48880b4d.js";import"./Label-c6c7e0c2.js";import"./SectionBorder-a45d0249.js";import"./ValidationErrors-ce3c07bd.js";/* empty css            */import"./Edit-04381c68.js";import"./Edit-c883850a.js";import"./Edit-663be45d.js";import"./Edit-833659c9.js";import"./vue3-multiselect.umd.min-89fe1e95.js";import"./Edit-e905c401.js";import"./Edit-fb9e1a40.js";import"./TextField-4dc08153.js";import"./Edit-8b049cff.js";import"./Edit-7210d6e2.js";import"./Edit-9520adfe.js";/* empty css                                                                  */import"./Load-c81154ca.js";import"./Load-269b27e0.js";import"./Edit-470aa9e5.js";import"./Edit-ae0efa3b.js";import"./Upload-3f7847e9.js";import"./Upload-cab6aca1.js";import"./Upload-4bb109cf.js";import"./Upload-91640e3b.js";import"./Settings-281c0c2c.js";import"./Settings-3a181d36.js";import"./Upload-b3182070.js";import"./Request-264efc19.js";import"./Add-983c5f77.js";import"./Load-b9d12279.js";import"./Upload-0c9409a0.js";import"./Load-c588859c.js";import"./sweetalert.min-9f604034.js";import"./ItemsMap-ac429fa2.js";import"./Upload-69a7afe4.js";import"./ItemsMap-99c5c9fb.js";import"./RequestEx-4f93fb5e.js";const F={components:{EditPatient:x,Confirm:B,AppLayout:C,Table:S,SecondaryButton:k,JetButton:D,ShowPrescription:O,JetDangerButton:I},props:{prescriptions:Object},data(){return{prescription:Object,prescription_details:""}},methods:{showItems(o){console.log(o),this.prescription_details=o,this.$nextTick(()=>this.$refs.dlg2.ShowDialog())},downloadPrescriptionPDF(o){window.open(route("pdf.prescription.preview",[o.id]))},removeCustomer(o){this.prescription=o,this.$refs.dlg1.ShowModal()},remove(){J.delete(route("prescriptions.destroy",{prescription:this.prescription.id})).then(o=>{this.$store.dispatch("setSuccessFlashMessage",!0),setTimeout(()=>{window.location.reload()},500)}).catch(o=>{})},showColumn(o){if(!this.$inertia.page.props.queryBuilderProps.default.columns)return!1;const p=this.$inertia.page.props.queryBuilderProps.default.columns.find(c=>c.key===o);return p?!p.hidden:!1}},created(){console.log(this.prescriptions)}},l=o=>(T("data-v-5c880164"),o=o(),$(),o),N={class:"py-4"},V={class:"mx-auto sm:px-6 lg:px-8"},j={class:"wrapper Gbg-white shadow-xl sm:rounded-lg p-4"},q=l(()=>s("i",{class:"fa fa-circle-info"},null,-1)),L=l(()=>s("i",{class:"fa fa-print pointer-events-none"},null,-1)),M=l(()=>s("i",{class:"fa fa-trash"},null,-1));function E(o,p,c,G,_,a){const u=e("show-prescription"),f=e("confirm"),h=e("secondary-button"),w=e("JetButton"),g=e("JetDangerButton"),v=e("Table"),y=e("app-layout");return P(),b(y,null,{default:t(()=>[i(u,{ref:"dlg2",prescription:_.prescription_details},null,8,["prescription"]),i(f,{ref:"dlg1",onConfirmed:p[0]||(p[0]=r=>a.remove())},{default:t(()=>[n(m(o.__("Are you sure you want to delete this prescription ?")),1)]),_:1},512),s("div",N,[s("div",V,[s("div",j,[i(v,{resource:c.prescriptions},{"cell(dateTimeIssued)":t(({item:r})=>[n(m(new Date(r.dateTimeIssued).toLocaleDateString()),1)]),"cell(actions)":t(({item:r})=>[i(h,{class:"mx-1",onClick:d=>a.showItems(r)},{default:t(()=>[q,n(" "+m(o.__("Show")),1)]),_:2},1032,["onClick"]),i(w,{class:"w-full sm:w-min",onClick:d=>a.downloadPrescriptionPDF(r)},{default:t(()=>[L,n(" "+m(o.__("Print")),1)]),_:2},1032,["onClick"]),i(g,{class:"mx-1",onClick:d=>a.removeCustomer(r)},{default:t(()=>[M,n(" "+m(o.__("Delete")),1)]),_:2},1032,["onClick"])]),_:1},8,["resource"])])])])]),_:1})}const Uo=A(F,[["render",E],["__scopeId","data-v-5c880164"]]);export{Uo as default};
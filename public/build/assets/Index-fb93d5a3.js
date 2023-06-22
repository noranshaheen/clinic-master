import{A as v}from"./AppLayout-f49bf28b.js";import{C as b}from"./Confirm-bf02ee04.js";import C from"./Edit-0682400b.js";import{O as S}from"./inertiajs-tables-laravel-query-builder.es-f3abfc1e.js";import{J as x}from"./SecondaryButton-713ac718.js";import{J as I}from"./Button-4bcf952d.js";import{k,c as B,w as e,r,o as T,b as n,f as i,t as s,a as m,p as $,l as D}from"./app-150d5054.js";import j from"./Show-2c593934.js";import{_ as A}from"./_plugin-vue_export-helper-c27b6911.js";import"./Edit-bcfc13f2.js";import"./ActionMessage-61e2ac70.js";import"./ActionSection-b2837b81.js";import"./SectionTitle-3e354ea0.js";import"./ConfirmationModal-25a9f4bd.js";import"./Modal-af9a88ec.js";import"./DangerButton-8bc4ac7b.js";import"./DialogModal-abac778c.js";import"./FormSection-88b4b82e.js";import"./Input-1c19b971.js";import"./Checkbox-4a56b901.js";import"./InputError-a5d97e62.js";import"./Label-df30c280.js";import"./SectionBorder-e50f0f2f.js";import"./ValidationErrors-d148bef4.js";/* empty css            */import"./Edit-3c089fa6.js";import"./Edit-be99b5ee.js";import"./Edit-597f2255.js";import"./Edit-f9922137.js";import"./vue3-multiselect.umd.min-0e68115f.js";import"./Edit-faa18d1d.js";import"./Edit-cd91fcb4.js";import"./TextField-3250345e.js";import"./Edit-07cd30d2.js";import"./Edit-34545e2b.js";import"./Edit-db4f3217.js";/* empty css                                                                  */import"./Load-49470aa5.js";import"./Load-63f267b7.js";import"./Edit-ae599c19.js";import"./Upload-84ea7cbc.js";import"./Upload-9f5fa312.js";import"./Settings-16afee17.js";import"./Settings-c1b5727e.js";import"./Upload-ac8dd442.js";import"./Request-7a72620a.js";import"./Add-a5bec431.js";import"./Load-9cedd89f.js";import"./Upload-8acddc09.js";import"./Load-38871443.js";import"./sweetalert.min-d55a1c1c.js";import"./ItemsMap-522638f4.js";import"./Upload-92e0933c.js";import"./ItemsMap-e43ca060.js";import"./RequestEx-92427893.js";const J={components:{EditPatient:C,Confirm:b,AppLayout:v,Table:S,SecondaryButton:x,JetButton:I,ShowPrescription:j},props:{prescriptions:Object},data(){return{prescription:Object,prescription_details:""}},methods:{showItems(o){console.log(o),this.prescription_details=o,this.$nextTick(()=>this.$refs.dlg2.ShowDialog())},removeCustomer(o){this.prescription=o,this.$refs.dlg1.ShowModal()},remove(){k.delete(route("prescriptions.destroy",{prescription:this.prescription.id})).then(o=>{this.$store.dispatch("setSuccessFlashMessage",!0),setTimeout(()=>{window.location.reload()},500)}).catch(o=>{})},showColumn(o){if(!this.$inertia.page.props.queryBuilderProps.default.columns)return!1;const p=this.$inertia.page.props.queryBuilderProps.default.columns.find(a=>a.key===o);return p?!p.hidden:!1}},created(){console.log(this.prescriptions)}},l=o=>($("data-v-03bed335"),o=o(),D(),o),N={class:"py-4"},O={class:"mx-auto sm:px-6 lg:px-8"},P={class:"wrapper Gbg-white shadow-xl sm:rounded-lg p-4"},V=l(()=>m("i",{class:"fa fa-circle-info"},null,-1)),q=l(()=>m("i",{class:"fa fa-trash"},null,-1));function L(o,p,a,M,d,c){const _=r("show-prescription"),u=r("confirm"),f=r("secondary-button"),h=r("jet-button"),w=r("Table"),y=r("app-layout");return T(),B(y,null,{default:e(()=>[n(_,{ref:"dlg2",prescription:d.prescription_details},null,8,["prescription"]),n(u,{ref:"dlg1",onConfirmed:p[0]||(p[0]=t=>c.remove())},{default:e(()=>[i(s(o.__("Are you sure you want to delete this prescription ?")),1)]),_:1},512),m("div",N,[m("div",O,[m("div",P,[n(w,{resource:a.prescriptions},{"cell(doctor)":e(({item:t})=>[i(s(t.doctor?t.doctor.name:o.__("N/A")),1)]),"cell(patient)":e(({item:t})=>[i(s(t.patient.name),1)]),"cell(dateTimeIssued)":e(({item:t})=>[i(s(new Date(t.dateTimeIssued).toLocaleDateString()),1)]),"cell(actions)":e(({item:t})=>[n(f,{onClick:g=>c.showItems(t)},{default:e(()=>[V,i(" "+s(o.__("Show")),1)]),_:2},1032,["onClick"]),n(h,{class:"ms-2",onClick:g=>c.removeCustomer(t)},{default:e(()=>[q,i(" "+s(o.__("Delete")),1)]),_:2},1032,["onClick"])]),_:1},8,["resource"])])])])]),_:1})}const Go=A(J,[["render",L],["__scopeId","data-v-03bed335"]]);export{Go as default};
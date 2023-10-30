import{A as w}from"./AppLayout-336b7499.js";import{C}from"./Confirm-3a44cc87.js";import S from"./Edit-fb9e1a40.js";import{O as x}from"./inertiajs-tables-laravel-query-builder.es-72bd3d80.js";import{J as B}from"./SecondaryButton-fb7ef34d.js";import{J as D}from"./Button-fce1e67a.js";import{J as b}from"./DangerButton-bf3f8f1f.js";import{k,c as J,w as e,r as n,o as T,b as m,f as r,t as i,a as s,p as $,l as I}from"./app-98cccb0d.js";import{_ as A}from"./_plugin-vue_export-helper-c27b6911.js";import"./Edit-7ca2eef9.js";import"./ActionMessage-529841b6.js";import"./ActionSection-14bbef3c.js";import"./SectionTitle-f26ec90c.js";import"./ConfirmationModal-2d2586d4.js";import"./Modal-2ccc6cf7.js";import"./DialogModal-9cb7d35f.js";import"./FormSection-60b88c5f.js";import"./Input-9c9fd5b2.js";import"./Checkbox-7ff4e1d6.js";import"./InputError-48880b4d.js";import"./Label-c6c7e0c2.js";import"./SectionBorder-a45d0249.js";import"./ValidationErrors-ce3c07bd.js";import"./Edit-cfad98b4.js";import"./TextField-4dc08153.js";import"./Edit-04381c68.js";import"./Edit-c883850a.js";import"./Edit-663be45d.js";import"./Edit-833659c9.js";import"./vue3-multiselect.umd.min-89fe1e95.js";import"./Edit-e905c401.js";import"./Edit-8b049cff.js";import"./Edit-7210d6e2.js";import"./Edit-9520adfe.js";/* empty css                                                                  */import"./Load-c81154ca.js";import"./Load-269b27e0.js";import"./Edit-470aa9e5.js";import"./Edit-ae0efa3b.js";import"./Upload-3f7847e9.js";import"./Upload-cab6aca1.js";import"./Upload-4bb109cf.js";import"./Upload-91640e3b.js";import"./Settings-281c0c2c.js";import"./Settings-3a181d36.js";import"./Upload-b3182070.js";import"./Request-264efc19.js";import"./Add-983c5f77.js";import"./Load-b9d12279.js";import"./Upload-0c9409a0.js";import"./Load-c588859c.js";import"./sweetalert.min-9f604034.js";import"./ItemsMap-ac429fa2.js";import"./Upload-69a7afe4.js";import"./ItemsMap-99c5c9fb.js";import"./RequestEx-4f93fb5e.js";/* empty css            */const L={components:{EditAppointment:S,Confirm:C,AppLayout:w,Table:x,SecondaryButton:B,JetButton:D,JetDangerButton:b},props:{appointments:Object},data(){return{appointment:Object}},methods:{editCustomer(t){this.appointment=t,this.$nextTick(()=>this.$refs.dlg2.ShowDialog())},removeCustomer(t){this.appointment=t,this.$refs.dlg1.ShowModal()},remove(){k.delete(route("appointments.destroy",{appointment:this.appointment.id})).then(t=>{this.$store.dispatch("setSuccessFlashMessage",!0),setTimeout(()=>{window.location.reload()},500)}).catch(t=>{})},showColumn(t){if(!this.$inertia.page.props.queryBuilderProps.default.columns)return!1;const p=this.$inertia.page.props.queryBuilderProps.default.columns.find(a=>a.key===t);return p?!p.hidden:!1}},created:function(){console.log(this.appointments)}},l=t=>($("data-v-833c0149"),t=t(),I(),t),O={class:"py-4"},N={class:"mx-auto sm:px-6 lg:px-8"},V={class:"wrapper Gbg-white overflow-hidden shadow-xl sm:rounded-lg p-4"},j=l(()=>s("i",{class:"fa fa-edit"},null,-1)),q=l(()=>s("i",{class:"fa fa-trash"},null,-1));function E(t,p,a,M,d,c){const u=n("edit-appointment"),_=n("confirm"),f=n("secondary-button"),h=n("JetDangerButton"),g=n("Table"),y=n("app-layout");return T(),J(y,null,{default:e(()=>[m(u,{ref:"dlg2",appointment:d.appointment},null,8,["appointment"]),m(_,{ref:"dlg1",onConfirmed:p[0]||(p[0]=o=>c.remove())},{default:e(()=>[r(i(t.__("Are you sure you want to delete this appointment?")),1)]),_:1},512),s("div",O,[s("div",N,[s("div",V,[m(g,{resource:a.appointments},{"cell(date)":e(({item:o})=>[r(i(new Date(o.date).toLocaleDateString()),1)]),"cell(from)":e(({item:o})=>[r(i(new Date(o.from).toLocaleTimeString()),1)]),"cell(to)":e(({item:o})=>[r(i(new Date(o.to).toLocaleTimeString()),1)]),"cell(doctor)":e(({item:o})=>[r(i(o.doctor.name),1)]),"cell(room)":e(({item:o})=>[r(i(o.room.id+" - "+o.room.name),1)]),"cell(actions)":e(({item:o})=>[m(f,{onClick:v=>c.editCustomer(o)},{default:e(()=>[j,r(" "+i(t.__("Edit")),1)]),_:2},1032,["onClick"]),m(h,{class:"ms-2",onClick:v=>c.removeCustomer(o)},{default:e(()=>[q,r(" "+i(t.__("Delete")),1)]),_:2},1032,["onClick"])]),_:1},8,["resource"])])])])]),_:1})}const zt=A(L,[["render",E],["__scopeId","data-v-833c0149"]]);export{zt as default};

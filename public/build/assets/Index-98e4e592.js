import{A as v}from"./AppLayout-336b7499.js";import{C as f}from"./Confirm-3a44cc87.js";import w from"./Edit-9520adfe.js";import{O as g}from"./inertiajs-tables-laravel-query-builder.es-72bd3d80.js";import{k as x,c as k,w as i,r as e,o as b,b as p,f as C,t as y,a as t,p as I,l as S}from"./app-98cccb0d.js";import{_ as B}from"./_plugin-vue_export-helper-c27b6911.js";import"./Edit-7ca2eef9.js";import"./ActionMessage-529841b6.js";import"./ActionSection-14bbef3c.js";import"./SectionTitle-f26ec90c.js";import"./Button-fce1e67a.js";import"./ConfirmationModal-2d2586d4.js";import"./Modal-2ccc6cf7.js";import"./DangerButton-bf3f8f1f.js";import"./DialogModal-9cb7d35f.js";import"./FormSection-60b88c5f.js";import"./Input-9c9fd5b2.js";import"./Checkbox-7ff4e1d6.js";import"./InputError-48880b4d.js";import"./Label-c6c7e0c2.js";import"./SecondaryButton-fb7ef34d.js";import"./SectionBorder-a45d0249.js";import"./ValidationErrors-ce3c07bd.js";/* empty css            */import"./Edit-cfad98b4.js";import"./TextField-4dc08153.js";import"./Edit-04381c68.js";import"./Edit-c883850a.js";import"./Edit-663be45d.js";import"./Edit-833659c9.js";import"./vue3-multiselect.umd.min-89fe1e95.js";import"./Edit-e905c401.js";import"./Edit-fb9e1a40.js";import"./Edit-8b049cff.js";import"./Edit-7210d6e2.js";import"./Load-c81154ca.js";import"./Load-269b27e0.js";import"./Edit-470aa9e5.js";import"./Edit-ae0efa3b.js";import"./Upload-3f7847e9.js";import"./Upload-cab6aca1.js";import"./Upload-4bb109cf.js";import"./Upload-91640e3b.js";import"./Settings-281c0c2c.js";/* empty css                                                                  */import"./Settings-3a181d36.js";import"./Upload-b3182070.js";import"./Request-264efc19.js";import"./Add-983c5f77.js";import"./Load-b9d12279.js";import"./Upload-0c9409a0.js";import"./Load-c588859c.js";import"./sweetalert.min-9f604034.js";import"./ItemsMap-ac429fa2.js";import"./Upload-69a7afe4.js";import"./ItemsMap-99c5c9fb.js";import"./RequestEx-4f93fb5e.js";const T={components:{AppLayout:v,Confirm:f,EditUser:w,Table:g},props:{users:Object},data(){return{user:Object}},methods:{edituser(o){this.user=o,this.$nextTick(()=>this.$refs.dlg2.ShowDialog())},removeuser(o){this.user=o,this.$refs.dlg1.ShowModal()},remove(){x.delete(route("users.destroy",{user:this.user.id})).then(o=>{location.reload()}).catch(o=>{})}}},n=o=>(I("data-v-d4af390c"),o=o(),S(),o),$={class:"py-4"},j={class:"mx-auto sm:px-6 lg:px-8"},A={class:"bg-white shadow-xl sm:rounded-lg p-4"},M=["onClick"],O=n(()=>t("svg",{xmlns:"http://www.w3.org/2000/svg",class:"h-4 w-4",fill:"none",viewBox:"0 0 24 24",stroke:"currentColor"},[t("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"})],-1)),V=[O],H=["onClick"],L=n(()=>t("svg",{xmlns:"http://www.w3.org/2000/svg",class:"h-4 w-4",fill:"none",viewBox:"0 0 24 24",stroke:"currentColor"},[t("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"})],-1)),N=[L];function D(o,m,a,z,d,r){const c=e("edit-user"),l=e("confirm"),_=e("Table"),u=e("app-layout");return b(),k(u,null,{default:i(()=>[p(c,{ref:"dlg2","p-user":d.user},null,8,["p-user"]),p(l,{ref:"dlg1",onConfirmed:m[0]||(m[0]=s=>r.remove())},{default:i(()=>[C(y(o.__("Are you sure you want to delete this user?")),1)]),_:1},512),t("div",$,[t("div",j,[t("div",A,[p(_,{resource:a.users},{"cell(actions)":i(({item:s})=>[t("button",{class:"p-1 rounded-md bg-green-500 text-white hover:bg-green-600 mx-2",onClick:h=>r.edituser(s)},V,8,M),t("button",{class:"p-1 rounded-md bg-red-500 text-white hover:bg-red-600 mx-2",i:"",onClick:h=>r.removeuser(s)},N,8,H)]),_:1},8,["resource"])])])])]),_:1})}const Go=B(T,[["render",D],["__scopeId","data-v-d4af390c"]]);export{Go as default};

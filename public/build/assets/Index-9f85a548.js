import{A as b}from"./AppLayout-336b7499.js";import{C as w}from"./Confirm-3a44cc87.js";import C from"./Add-983c5f77.js";import{O as y}from"./inertiajs-tables-laravel-query-builder.es-72bd3d80.js";import{J as I}from"./SecondaryButton-fb7ef34d.js";import{J as O}from"./Button-fce1e67a.js";import{k as B,c as T,w as i,r as e,o as $,b as s,f as a,t as d,a as p,p as N,l as P}from"./app-98cccb0d.js";import{_ as j}from"./_plugin-vue_export-helper-c27b6911.js";import"./Edit-7ca2eef9.js";import"./ActionMessage-529841b6.js";import"./ActionSection-14bbef3c.js";import"./SectionTitle-f26ec90c.js";import"./ConfirmationModal-2d2586d4.js";import"./Modal-2ccc6cf7.js";import"./DangerButton-bf3f8f1f.js";import"./DialogModal-9cb7d35f.js";import"./FormSection-60b88c5f.js";import"./Input-9c9fd5b2.js";import"./Checkbox-7ff4e1d6.js";import"./InputError-48880b4d.js";import"./Label-c6c7e0c2.js";import"./SectionBorder-a45d0249.js";import"./ValidationErrors-ce3c07bd.js";/* empty css            */import"./Edit-cfad98b4.js";import"./TextField-4dc08153.js";import"./Edit-04381c68.js";import"./Edit-c883850a.js";import"./Edit-663be45d.js";import"./Edit-833659c9.js";import"./vue3-multiselect.umd.min-89fe1e95.js";import"./Edit-e905c401.js";import"./Edit-fb9e1a40.js";import"./Edit-8b049cff.js";import"./Edit-7210d6e2.js";import"./Edit-9520adfe.js";/* empty css                                                                  */import"./Load-c81154ca.js";import"./Load-269b27e0.js";import"./Edit-470aa9e5.js";import"./Edit-ae0efa3b.js";import"./Upload-3f7847e9.js";import"./Upload-cab6aca1.js";import"./Upload-4bb109cf.js";import"./Upload-91640e3b.js";import"./Settings-281c0c2c.js";import"./Settings-3a181d36.js";import"./Upload-b3182070.js";import"./Request-264efc19.js";import"./Load-b9d12279.js";import"./Upload-0c9409a0.js";import"./Load-c588859c.js";import"./sweetalert.min-9f604034.js";import"./ItemsMap-ac429fa2.js";import"./Upload-69a7afe4.js";import"./ItemsMap-99c5c9fb.js";import"./RequestEx-4f93fb5e.js";const A={components:{AppLayout:b,Confirm:w,EditPos:C,Table:y,SecondaryButton:I,JetButton:O},props:{poses:Object},data(){return{pos_item:Object,notSortableCols:["issuer.name","grant_type"]}},methods:{editPOS(t){this.pos_item=t,this.$nextTick(()=>this.$refs.dlg2.ShowDialog())},removePOS(t){this.pos_item=t,this.$refs.dlg1.ShowModal()},remove(){B.delete(route("pos.destroy",this.pos_item.id)).then(t=>{this.$store.dispatch("setSuccessFlashMessage",!0),setTimeout(()=>{window.location.reload()},500)}).catch(t=>{})},nestedIndex:function(t,r){try{var o=r.split(".");return o.length==1?t[r].toString():o.length==2?t[o[0]][o[1]].toString():o.length==3?t[o[0]][o[1]][o[2]].toString():"Unsupported Nested Index"}catch{}return"N/A"}},mounted(){}},c=t=>(N("data-v-82c6dad4"),t=t(),P(),t),J={class:"py-4"},D={class:"mx-auto sm:px-6 lg:px-8"},V={class:"bg-white overflow-hidden shadow-xl sm:rounded-lg p-4"},E=c(()=>p("i",{class:"fa fa-edit"},null,-1)),M=c(()=>p("i",{class:"fa fa-trash"},null,-1));function F(t,r,o,l,_,n){const u=e("edit-pos"),f=e("confirm"),h=e("secondary-button"),g=e("jet-button"),v=e("Table"),S=e("app-layout");return $(),T(S,null,{default:i(()=>[s(u,{ref:"dlg2",positem:_.pos_item},null,8,["positem"]),s(f,{ref:"dlg1",onConfirmed:r[0]||(r[0]=m=>n.remove())},{default:i(()=>[a(d(t.__("Are you sure you want to delete this pos?")),1)]),_:1},512),p("div",J,[p("div",D,[p("div",V,[s(v,{resource:o.poses},{"cell(actions)":i(({item:m})=>[s(h,{onClick:x=>n.editPOS(m)},{default:i(()=>[E,a(" "+d(t.__("Edit")),1)]),_:2},1032,["onClick"]),s(g,{class:"ms-2",onClick:x=>n.removePOS(m)},{default:i(()=>[M,a(" "+d(t.__("Delete")),1)]),_:2},1032,["onClick"])]),_:1},8,["resource"])])])])]),_:1})}const qt=j(A,[["render",F],["__scopeId","data-v-82c6dad4"]]);export{qt as default};

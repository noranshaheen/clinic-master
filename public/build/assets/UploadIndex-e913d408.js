import{A as g}from"./AppLayout-f49bf28b.js";import{O as w}from"./inertiajs-tables-laravel-query-builder.es-f3abfc1e.js";import{J as x}from"./Button-4bcf952d.js";import C from"./AddEdit-83644bc6.js";import{C as I}from"./Confirm-bf02ee04.js";import{J as S}from"./Label-df30c280.js";import{J as U}from"./SecondaryButton-713ac718.js";import{c as j,w as r,r as e,o as B,b as i,a as m,f as s,t as c,i as J,v as y}from"./app-150d5054.js";import{_ as A}from"./_plugin-vue_export-helper-c27b6911.js";import"./Edit-bcfc13f2.js";import"./ActionMessage-61e2ac70.js";import"./ActionSection-b2837b81.js";import"./SectionTitle-3e354ea0.js";import"./ConfirmationModal-25a9f4bd.js";import"./Modal-af9a88ec.js";import"./DangerButton-8bc4ac7b.js";import"./DialogModal-abac778c.js";import"./FormSection-88b4b82e.js";import"./Input-1c19b971.js";import"./Checkbox-4a56b901.js";import"./InputError-a5d97e62.js";import"./SectionBorder-e50f0f2f.js";import"./ValidationErrors-d148bef4.js";/* empty css            */import"./Edit-0682400b.js";import"./TextField-3250345e.js";import"./Edit-3c089fa6.js";import"./Edit-be99b5ee.js";import"./Edit-597f2255.js";import"./Edit-f9922137.js";import"./vue3-multiselect.umd.min-0e68115f.js";import"./Edit-faa18d1d.js";import"./Edit-cd91fcb4.js";import"./Edit-07cd30d2.js";import"./Edit-34545e2b.js";import"./Edit-db4f3217.js";/* empty css                                                                  */import"./Load-49470aa5.js";import"./Load-63f267b7.js";import"./Edit-ae599c19.js";import"./Upload-84ea7cbc.js";import"./Upload-9f5fa312.js";import"./Settings-16afee17.js";import"./Settings-c1b5727e.js";import"./Upload-ac8dd442.js";import"./Request-7a72620a.js";import"./Add-a5bec431.js";import"./Load-9cedd89f.js";import"./Upload-8acddc09.js";import"./Load-38871443.js";import"./sweetalert.min-d55a1c1c.js";import"./ItemsMap-522638f4.js";import"./Upload-92e0933c.js";import"./ItemsMap-e43ca060.js";import"./RequestEx-92427893.js";const N={components:{AppLayout:g,Confirm:I,JetLabel:S,Table:w,JetButton:x,AddEditItem:C,SecondaryButton:U},props:{items:Object},data(){return{uploadItem:Object,cancelReason:""}},methods:{cancelUpload(t){this.uploadItem=t,this.$refs.dlg1.ShowModal()},cancelUpload2(){axios.post(route("eta.invoices.upload.cancel"),{id:this.uploadItem.Id,status:"cancelled"}).then(t=>{alert(t.data)}).catch(t=>{alert(t.response.data)})},reviewUpload(t){window.location.href=route("eta.invoices.sent.index",{upload_id:t.Id})},nestedIndex:function(t,a){try{var o=a.split(".");return o.length==1?t[a].toString():o.length==2?t[o[0]][o[1]].toString():o.length==3?t[o[0]][o[1]][o[2]].toString():"Unsupported Nested Index"}catch{}return"N/A"},editItem:function(t){}}},O={class:"py-4"},T={class:"mx-auto sm:px-6 lg:px-8"},V={class:"bg-white overflow-hidden shadow-xl sm:rounded-lg p-4"};function $(t,a,o,l,D,p){const d=e("jet-label"),u=e("confirm"),_=e("jet-button"),f=e("secondary-button"),h=e("Table"),v=e("app-layout");return B(),j(v,null,{default:r(()=>[i(u,{ref:"dlg1",onConfirmed:p.cancelUpload2},{default:r(()=>[i(d,{for:"type",value:"Are you sure you want to delete this file?"})]),_:1},8,["onConfirmed"]),m("div",O,[m("div",T,[m("div",V,[i(h,{resource:o.items},{"cell(actions)":r(({item:n})=>[i(_,{class:"me-2",onClick:b=>p.reviewUpload(n)},{default:r(()=>[s(c(t.__("Review")),1)]),_:2},1032,["onClick"]),J(i(f,{onClick:b=>p.cancelUpload(n)},{default:r(()=>[s(c(t.__("Cancel")),1)]),_:2},1032,["onClick"]),[[y,n.status=="pending"||n.status=="uploading"]])]),_:1},8,["resource"])])])])]),_:1})}const Rt=A(N,[["render",$]]);export{Rt as default};

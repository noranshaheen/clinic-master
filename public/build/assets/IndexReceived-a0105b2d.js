import{D as R,A as j}from"./AppLayout-f49bf28b.js";import{O as x}from"./inertiajs-tables-laravel-query-builder.es-f3abfc1e.js";import D from"./AddEdit-83644bc6.js";import{C as T}from"./Confirm-bf02ee04.js";import{J as V}from"./Label-df30c280.js";import J from"./Preview-cbffe977.js";import N from"./UpdateReceived-b9a65588.js";import y from"./CreditNote-9cb34e9c.js";import{J as B}from"./SecondaryButton-713ac718.js";import{J as E}from"./Button-4bcf952d.js";import{J as A}from"./DangerButton-8bc4ac7b.js";import"./sweetalert.min-d55a1c1c.js";import{c as k,w as o,r as n,o as L,b as a,i as c,C as U,a as l,f as s,t as p,v as u,p as O,l as $}from"./app-150d5054.js";import{_ as M}from"./_plugin-vue_export-helper-c27b6911.js";import"./Edit-bcfc13f2.js";import"./ActionMessage-61e2ac70.js";import"./ActionSection-b2837b81.js";import"./SectionTitle-3e354ea0.js";import"./ConfirmationModal-25a9f4bd.js";import"./Modal-af9a88ec.js";import"./DialogModal-abac778c.js";import"./FormSection-88b4b82e.js";import"./Input-1c19b971.js";import"./Checkbox-4a56b901.js";import"./InputError-a5d97e62.js";import"./SectionBorder-e50f0f2f.js";import"./ValidationErrors-d148bef4.js";/* empty css            */import"./Edit-0682400b.js";import"./TextField-3250345e.js";import"./Edit-3c089fa6.js";import"./Edit-be99b5ee.js";import"./Edit-597f2255.js";import"./Edit-f9922137.js";import"./vue3-multiselect.umd.min-0e68115f.js";import"./Edit-faa18d1d.js";import"./Edit-cd91fcb4.js";import"./Edit-07cd30d2.js";import"./Edit-34545e2b.js";import"./Edit-db4f3217.js";/* empty css                                                                  */import"./Load-49470aa5.js";import"./Load-63f267b7.js";import"./Edit-ae599c19.js";import"./Upload-84ea7cbc.js";import"./Upload-9f5fa312.js";import"./Settings-16afee17.js";import"./Settings-c1b5727e.js";import"./Upload-ac8dd442.js";import"./Request-7a72620a.js";import"./Add-a5bec431.js";import"./Load-9cedd89f.js";import"./Upload-8acddc09.js";import"./Load-38871443.js";import"./ItemsMap-522638f4.js";import"./Upload-92e0933c.js";import"./ItemsMap-e43ca060.js";import"./RequestEx-92427893.js";const W={components:{Dropdown:R,AppLayout:j,Confirm:T,PreviewInvoice:J,UpdateReceived:N,CreditNote:y,JetLabel:V,Table:x,JetButton:E,JetDangerButton:A,AddEditItem:D,SecondaryButton:B},props:{items:Object},data(){return{invItem:{quantity:1009},cancelReason:"",notSortableCols:["statusReason","receiver.name","receiver.receiver_id","issuerName","receiverId","receiverName"]}},methods:{openExternal2(e){window.open(route("eta.invoice.download",{uuid:e.uuid}),"_blank")},openExternal(e){window.open(this.$page.props.preview_url+e.uuid+"/share/"+e.longId)},updateReceived(e){this.invItem=e,this.$nextTick(()=>{this.$refs.dlg6.ShowDialog()})},rejectInvoice(e){this.invItem=e,this.$refs.dlg1.ShowModal()},rejectInv2(){axios.post(route("eta.invoices.cancel"),{uuid:this.invItem.uuid,status:"rejected",reason:this.cancelReason}).then(e=>{alert(e.data)}).catch(e=>{alert(e.response.data)})},nestedIndex:function(e,i){try{var r=i.split(".");return r.length==1?e[i].toString():r.length==2?e[r[0]][r[1]].toString():r.length==3?e[r[0]][r[1]][r[2]].toString():"Unsupported Nested Index"}catch{}return"N/A"}}},q=e=>(O("data-v-2be4bdf9"),e=e(),$(),e),P=q(()=>l("option",{value:"Wrong invoice details"},"Wrong invoice details",-1)),z=[P],F={class:"py-4"},G={class:"mx-auto sm:px-6 lg:px-8"},H={class:"bg-white overflow-hidden shadow-xl sm:rounded-lg p-4"};function K(e,i,r,f,d,m){const h=n("update-received"),g=n("jet-label"),b=n("confirm"),I=n("jet-danger-button"),v=n("jet-button"),w=n("secondary-button"),S=n("Table"),C=n("app-layout");return L(),k(C,null,{default:o(()=>[a(h,{ref:"dlg6",modelValue:d.invItem,"onUpdate:modelValue":i[0]||(i[0]=t=>d.invItem=t)},null,8,["modelValue"]),a(b,{ref:"dlg1",onConfirmed:i[2]||(i[2]=t=>m.rejectInv2())},{default:o(()=>[a(g,{for:"type",value:"Select rejection reason:"}),c(l("select",{id:"type","onUpdate:modelValue":i[1]||(i[1]=t=>d.cancelReason=t),class:"mt-1 block w-full"},z,512),[[U,d.cancelReason]])]),_:1},512),l("div",F,[l("div",G,[l("div",H,[a(S,{resource:r.items},{"cell(status)":o(({item:t})=>[s(p(e.__(t.status)),1)]),"cell(statusReason)":o(({item:t})=>[s(p(e.__(t.statusReason)),1)]),"cell(dateTimeIssued)":o(({item:t})=>[s(p(new Date(t.dateTimeIssued).toLocaleDateString()),1)]),"cell(dateTimeReceived)":o(({item:t})=>[s(p(new Date(t.dateTimeReceived).toLocaleDateString()),1)]),"cell(actions)":o(({item:t})=>[c(a(I,{class:"me-2 mt-2",onClick:_=>m.rejectInvoice(t)},{default:o(()=>[s(p(e.__("Reject")),1)]),_:2},1032,["onClick"]),[[u,t.status=="Valid"]]),c(a(v,{class:"me-2 mt-2",onClick:_=>m.updateReceived(t)},{default:o(()=>[s(p(e.__("Direction")),1)]),_:2},1032,["onClick"]),[[u,t.status=="Valid"]]),c(a(w,{class:"me-2 mt-2",onClick:_=>m.openExternal(t)},{default:o(()=>[s(p(e.__("ETA1")),1)]),_:2},1032,["onClick"]),[[u,t.status=="Valid"]]),c(a(v,{class:"me-2 mt-2",onClick:_=>m.openExternal2(t)},{default:o(()=>[s(p(e.__("ETA2")),1)]),_:2},1032,["onClick"]),[[u,t.status=="Valid"]])]),_:1},8,["resource"])])])])]),_:1})}const et=M(W,[["render",K],["__scopeId","data-v-2be4bdf9"]]);export{et as default};
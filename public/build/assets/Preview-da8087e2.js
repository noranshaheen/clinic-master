import{J as w}from"./ActionMessage-c078ab58.js";import{J as D}from"./ActionSection-503f6cc4.js";import{J as C}from"./Button-caddf70d.js";import{J as S}from"./SecondaryButton-3445fa1d.js";import{J as T}from"./DangerButton-0ca7bbd2.js";import{J as F}from"./ConfirmationModal-747d8d1a.js";import{J as I}from"./DialogModal-08c723b0.js";import{J as x}from"./FormSection-f05163be.js";import{J as M}from"./Input-2cb00575.js";import{J as B}from"./Checkbox-0b804630.js";import{J as k}from"./InputError-1ce94fe9.js";import{J as V}from"./Label-715dcd10.js";import{J as A}from"./SectionBorder-30338fa4.js";import{J as N}from"./ValidationErrors-deb0d81a.js";import{T as E}from"./TextField-f2f734f3.js";import{M as P}from"./vue3-multiselect.umd.min-7dc826ba.js";import{k as u,c as j,w as d,r as p,o as _,f as g,t as o,a as s,d as h,g as O,F as v,n,b as f,i as q,v as z}from"./app-5577a803.js";import{s as G}from"./sweetalert.min-ea747d9b.js";import{_ as L}from"./_plugin-vue_export-helper-c27b6911.js";import"./SectionTitle-75c86d6b.js";import"./Modal-5b92d53d.js";/* empty css            */const Q={components:{TextField:E,Multiselect:P,JetActionMessage:w,JetActionSection:D,JetButton:C,JetConfirmationModal:F,JetDangerButton:T,JetDialogModal:I,JetFormSection:x,JetInput:M,JetCheckbox:B,JetInputError:k,JetLabel:V,JetSecondaryButton:S,JetSectionBorder:A,JetValidationErrors:N},props:["modelValue"],data(){return{item:this.modelValue,count:1,units:[],items:[],taxTypes:[],taxSubtypes:[],taxSubtypes1:[],taxType:null,taxSubtype:null,showDlg:!1}},methods:{ShowDialog(){this.item=JSON.parse(JSON.stringify(this.modelValue)),this.showDlg=!0},CancelDlg(){this.showDlg=!1},getDate(t){return new Date(t).toLocaleDateString()},getTaxlines(t){for(var e=0,l=0;l<t.taxable_items.length;l++){var c=t.taxable_items[l];e=e+parseFloat(c.amount)}return e},getTotalTax(){for(var t=0,e=0;e<this.item.invoice_lines.length;e++)for(var l=this.item.invoice_lines[e],c=0;c<l.taxable_items.length;c++){var a=l.taxable_items[c];t=t+parseFloat(a.amount)}return t},ApproveItem(){u.post(route("eta.invoices.approve"),{Id:this.item.Id}).then(t=>{alert(t.data)}).catch(t=>{alert(t.response.data)})},CopyItem(){u.post(route("invoices.copy"),{Id:this.item.Id}).then(t=>{G({title:"Invoice Was Copied",icon:"success"}),setTimeout(()=>{window.location.reload()},200)}).catch(t=>{console.error(t)})}},created:function(){}},U={class:"grid grid-cols-10 gap-0 mt-2"},W={class:"col-span-5"},H={class:"col-span-5"},K={class:"col-span-5"},R={class:"grid grid-cols-10 gap-0 mt-2"},X={class:"bg-gray-400 col-span-3"},Y={class:"bg-gray-400 col-span-2"},Z={class:"bg-gray-400 col-span-1"},$={class:"bg-gray-400 col-span-1"},tt={class:"bg-gray-400 col-span-1"},ot={class:"bg-gray-400 col-span-1"},st={class:"bg-gray-400 col-span-1"},et={class:"bg-gray-400 col-span-5"},at=s("div",{class:"bg-gray-400 col-span-1"},"****",-1),rt=s("div",{class:"bg-gray-400 col-span-1"},"****",-1),it={class:"bg-gray-400 col-span-1"},lt={class:"bg-gray-400 col-span-1"},nt={class:"bg-gray-400 col-span-1"},ct={class:"flex items-center justify-between mt-4"};function mt(t,e,l,c,a,m){const y=p("jet-secondary-button"),b=p("jet-button"),J=p("jet-dialog-modal");return _(),j(J,{show:a.showDlg,"max-width":"5xl",onClose:e[2]||(e[2]=r=>a.showDlg=!1)},{title:d(()=>[g(o(t.__("Invoice Preview")),1)]),content:d(()=>[s("div",U,[s("div",W,o(t.__("Branch"))+": "+o(a.item.issuer.name),1),s("div",H,o(t.__("Customer"))+": "+o(a.item.receiver.name),1),s("div",K,o(t.__("Date"))+": "+o(m.getDate(a.item.dateTimeIssued)),1)]),s("div",R,[s("div",X,o(t.__("Item")),1),s("div",Y,o(t.__("Code")),1),s("div",Z,o(t.__("Quantity")),1),s("div",$,o(t.__("Unit Price")),1),s("div",tt,o(t.__("Sales")),1),s("div",ot,o(t.__("Tax")),1),s("div",st,o(t.__("Total")),1),(_(!0),h(v,null,O(a.item.invoice_lines,(r,i)=>(_(),h(v,{key:i},[s("div",{class:n(["col-span-3",{"bg-gray-200":i%2==1}])},o(r.description),3),s("div",{class:n(["col-span-2",{"bg-gray-200":i%2==1}])},o(r.itemCode),3),s("div",{class:n(["col-span-1",{"bg-gray-200":i%2==1}])},o(r.quantity.toFixed(2)),3),s("div",{class:n(["col-span-1",{"bg-gray-200":i%2==1}])},o((Math.round(100*r.unit_value.amountEGP)/100).toFixed(2)),3),s("div",{class:n(["col-span-1",{"bg-gray-200":i%2==1}])},o((Math.round(100*r.salesTotal)/100).toFixed(2)),3),s("div",{class:n(["col-span-1",{"bg-gray-200":i%2==1}])},o(m.getTaxlines(r).toFixed(2)),3),s("div",{class:n(["col-span-1",{"bg-gray-200":i%2==1}])},o((Math.round(100*r.total)/100).toFixed(2)),3)],64))),128)),s("div",et,o(t.__("Summary")),1),at,rt,s("div",it,o((Math.round(100*a.item.totalSalesAmount)/100).toFixed(2)),1),s("div",lt,o(m.getTotalTax().toFixed(2)),1),s("div",nt,o((Math.round(100*a.item.totalAmount)/100).toFixed(2)),1)])]),footer:d(()=>[s("div",ct,[f(y,{onClick:e[0]||(e[0]=r=>m.CancelDlg())},{default:d(()=>[g(o(t.__("Close")),1)]),_:1}),q(s("div",null,[f(b,{class:"ms-2",onClick:e[1]||(e[1]=r=>m.ApproveItem())},{default:d(()=>[g(o(t.__("Approve")),1)]),_:1})],512),[[z,a.item.status!="Valid"]])])]),_:1},8,["show"])}const Vt=L(Q,[["render",mt]]);export{Vt as default};

import{J as x}from"./ActionMessage-c078ab58.js";import{J as S}from"./ActionSection-503f6cc4.js";import{J as F}from"./Button-caddf70d.js";import{J as V}from"./SecondaryButton-3445fa1d.js";import{J as w}from"./DangerButton-0ca7bbd2.js";import{J as A}from"./ConfirmationModal-747d8d1a.js";import{J as C}from"./DialogModal-08c723b0.js";import{J as I}from"./FormSection-f05163be.js";import{J as N}from"./Input-2cb00575.js";import{J as k}from"./Checkbox-0b804630.js";import{J as B}from"./InputError-1ce94fe9.js";import{J as M}from"./Label-715dcd10.js";import{J as E}from"./SectionBorder-30338fa4.js";import{J as U}from"./ValidationErrors-deb0d81a.js";import{T as O}from"./TextField-f2f734f3.js";import{M as P}from"./vue3-multiselect.umd.min-7dc826ba.js";import{k as q,c as G,w as d,r as _,o as h,f as b,t as a,a as e,b as p,d as f,g as L,F as y,n as c,i as R,v as z}from"./app-5577a803.js";import{s as T}from"./sweetalert.min-ea747d9b.js";import{_ as Q}from"./_plugin-vue_export-helper-c27b6911.js";import"./SectionTitle-75c86d6b.js";import"./Modal-5b92d53d.js";/* empty css            */const j={components:{TextField:O,Multiselect:P,JetActionMessage:x,JetActionSection:S,JetButton:F,JetConfirmationModal:A,JetDangerButton:w,JetDialogModal:C,JetFormSection:I,JetInput:N,JetCheckbox:k,JetInputError:B,JetLabel:M,JetSecondaryButton:V,JetSectionBorder:E,JetValidationErrors:U},props:["modelValue"],data(){return{item:this.modelValue,count:1,units:[],items:[],taxTypes:[],taxSubtypes:[],taxSubtypes1:[],taxType:null,taxSubtype:null,showDlg:!1}},methods:{ShowDialog(){this.item=JSON.parse(JSON.stringify(this.modelValue)),this.item.dateTimeIssued=new Date().toISOString().slice(0,16),this.showDlg=!0},CancelDlg(){this.showDlg=!1},getDate(t){return new Date(t).toLocaleDateString()},updateValues(t){t.salesTotal=this.parse(t.quantity)*this.parse(t.unit_value.amountEGP),t.netTotal=t.salesTotal-this.parse(t.itemsDiscount),this.calculateTax(t),this.RecalculateTax()},calculateTax(t){if(t.total=t.netTotal+0,t.taxable_items)for(var o=0;o<t.taxable_items.length;o++){var s=t.taxable_items[o];s.amount=s.rate*t.netTotal/100,s.taxType=="T4"?t.total-=s.amount:t.total+=s.amount}},RecalculateTax:function(){this.item.totalSalesAmount=0,this.item.totalDiscountAmount=0,this.item.netAmount=0,this.item.totalAmount=0,this.item.extraDiscountAmount=0,this.item.totalItemsDiscountAmount=0;var t={};this.item.taxTotals=[];for(var o=0;o<this.item.invoice_lines.length;o++){var s=this.item.invoice_lines[o];this.item.totalSalesAmount+=parseFloat(s.salesTotal),this.item.totalDiscountAmount+=parseFloat(s.itemsDiscount),this.item.netAmount+=parseFloat(s.netTotal),this.item.totalAmount+=parseFloat(s.total),this.item.extraDiscountAmount+=0,this.item.totalItemsDiscountAmount+=parseFloat(s.itemsDiscount);for(var r=0;r<s.taxable_items.length;r++){var l=s.taxable_items[r];l.taxType in t?t[l.taxType]=t[l.taxType.Code]+parseFloat(l.amount):t[l.taxType]=parseFloat(l.amount)}}for(let n of Object.keys(t))this.item.taxTotals.push({taxType:n,amount:t[n]})},getTaxlines(t){for(var o=0,s=0;s<t.taxable_items.length;s++){var r=t.taxable_items[s];o=o+parseFloat(r.amount)}return o},getTotalTax(){for(var t=0,o=0;o<this.item.invoice_lines.length;o++)for(var s=this.item.invoice_lines[o],r=0;r<s.taxable_items.length;r++){var l=s.taxable_items[r];t=t+parseFloat(l.amount)}return t},SubmitDebitNote(){q.post(route("eta.invoices.debit.store"),this.item).then(t=>{T({title:"Invoice Debit Note Saved!",icon:"success"})}).catch(t=>{T({title:"Invoice Debit Note Failed",icon:"error"})})}},created:function(){}},H={class:"grid grid-cols-10 gap-0 mt-2"},K={class:"col-span-5"},W={class:"col-span-5"},X={class:"col-span-5"},Y={class:"grid grid-cols-10 gap-0 mt-2"},Z={class:"bg-gray-400 col-span-3"},$={class:"bg-gray-400 col-span-2"},tt={class:"bg-gray-400 col-span-1"},et={class:"bg-gray-400 col-span-1"},ot={class:"bg-gray-400 col-span-1"},at={class:"bg-gray-400 col-span-1"},st={class:"bg-gray-400 col-span-1"},lt={class:"bg-gray-400 col-span-5"},it=e("div",{class:"bg-gray-400 col-span-1"},"****",-1),rt=e("div",{class:"bg-gray-400 col-span-1"},"****",-1),nt={class:"bg-gray-400 col-span-1"},mt={class:"bg-gray-400 col-span-1"},ct={class:"bg-gray-400 col-span-1"},ut={class:"flex items-center justify-between mt-4"};function dt(t,o,s,r,l,n){const g=_("TextField"),v=_("jet-secondary-button"),D=_("jet-button"),J=_("jet-dialog-modal");return h(),G(J,{show:l.showDlg,"max-width":"5xl",onClose:o[3]||(o[3]=i=>l.showDlg=!1)},{title:d(()=>[b(a(t.__("Invoice Debit Note")),1)]),content:d(()=>[e("div",H,[e("div",K,a(t.__("Branch"))+": "+a(l.item.issuer.name),1),e("div",W,a(t.__("Customer"))+": "+a(l.item.receiver.name),1),e("div",X,[p(g,{modelValue:l.item.dateTimeIssued,"onUpdate:modelValue":o[0]||(o[0]=i=>l.item.dateTimeIssued=i),itemType:"datetime-local",itemLabel:t.__("Invoice Date")},null,8,["modelValue","itemLabel"])])]),e("div",Y,[e("div",Z,a(t.__("Item")),1),e("div",$,a(t.__("Code")),1),e("div",tt,a(t.__("Quantity")),1),e("div",et,a(t.__("Unit Price")),1),e("div",ot,a(t.__("Sales")),1),e("div",at,a(t.__("Tax")),1),e("div",st,a(t.__("Total")),1),(h(!0),f(y,null,L(l.item.invoice_lines,(i,m)=>(h(),f(y,{key:m},[e("div",{class:c(["col-span-3",{"bg-gray-200":m%2==1}])},a(i.description),3),e("div",{class:c(["col-span-2",{"bg-gray-200":m%2==1}])},a(i.itemCode),3),e("div",{class:c(["col-span-1",{"bg-gray-200":m%2==1}])},[p(g,{modelValue:i.quantity,"onUpdate:modelValue":[u=>i.quantity=u,u=>n.updateValues(i)],itemType:"number"},null,8,["modelValue","onUpdate:modelValue"])],2),e("div",{class:c(["col-span-1",{"bg-gray-200":m%2==1}])},[p(g,{modelValue:i.unit_value.amountEGP,"onUpdate:modelValue":[u=>i.unit_value.amountEGP=u,u=>n.updateValues(i)],itemType:"number"},null,8,["modelValue","onUpdate:modelValue"])],2),e("div",{class:c(["col-span-1",{"bg-gray-200":m%2==1}])},a((Math.round(100*i.salesTotal)/100).toFixed(2)),3),e("div",{class:c(["col-span-1",{"bg-gray-200":m%2==1}])},a(n.getTaxlines(i).toFixed(2)),3),e("div",{class:c(["col-span-1",{"bg-gray-200":m%2==1}])},a((Math.round(100*i.total)/100).toFixed(2)),3)],64))),128)),e("div",lt,a(t.__("Summary")),1),it,rt,e("div",nt,a((Math.round(100*l.item.totalSalesAmount)/100).toFixed(2)),1),e("div",mt,a(n.getTotalTax().toFixed(2)),1),e("div",ct,a((Math.round(100*l.item.totalAmount)/100).toFixed(2)),1)])]),footer:d(()=>[e("div",ut,[p(v,{onClick:o[1]||(o[1]=i=>n.CancelDlg())},{default:d(()=>[b(a(t.__("Close")),1)]),_:1}),R(e("div",null,[p(D,{class:"ms-2",onClick:o[2]||(o[2]=i=>n.SubmitDebitNote())},{default:d(()=>[b(a(t.__("Approve")),1)]),_:1})],512),[[z,l.item.status=="Valid"]])])]),_:1},8,["show"])}const Mt=Q(j,[["render",dt]]);export{Mt as default};

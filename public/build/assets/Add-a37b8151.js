import{A as C}from"./AppLayout-336b7499.js";import{J as T}from"./Label-c6c7e0c2.js";import{J as S}from"./Button-fce1e67a.js";import{J as U}from"./SecondaryButton-fb7ef34d.js";import{J as I}from"./DangerButton-bf3f8f1f.js";import{T as N}from"./TextField-4dc08153.js";import{M as j}from"./vue3-multiselect.umd.min-89fe1e95.js";import J from"./EditLine-64c486c6.js";import{k as p,c as B,w as m,r as a,o as u,b as i,a as e,t as l,f as c,d as b,g as w,F as D}from"./app-98cccb0d.js";import E from"./Edit-470aa9e5.js";import q from"./AddLine-21288255.js";import P from"./EditLine-42cda913.js";/* empty css                                                                  */import{_ as F}from"./_plugin-vue_export-helper-c27b6911.js";import"./Edit-7ca2eef9.js";import"./ActionMessage-529841b6.js";import"./ActionSection-14bbef3c.js";import"./SectionTitle-f26ec90c.js";import"./ConfirmationModal-2d2586d4.js";import"./Modal-2ccc6cf7.js";import"./DialogModal-9cb7d35f.js";import"./FormSection-60b88c5f.js";import"./Input-9c9fd5b2.js";import"./Checkbox-7ff4e1d6.js";import"./InputError-48880b4d.js";import"./SectionBorder-a45d0249.js";import"./ValidationErrors-ce3c07bd.js";/* empty css            */import"./Edit-cfad98b4.js";import"./Edit-04381c68.js";import"./Edit-c883850a.js";import"./Edit-663be45d.js";import"./Edit-833659c9.js";import"./Edit-e905c401.js";import"./Edit-fb9e1a40.js";import"./Edit-8b049cff.js";import"./Edit-7210d6e2.js";import"./Edit-9520adfe.js";import"./Load-c81154ca.js";import"./Load-269b27e0.js";import"./Edit-ae0efa3b.js";import"./Upload-3f7847e9.js";import"./Upload-cab6aca1.js";import"./Upload-4bb109cf.js";import"./Upload-91640e3b.js";import"./Settings-281c0c2c.js";import"./Settings-3a181d36.js";import"./Upload-b3182070.js";import"./Request-264efc19.js";import"./Add-983c5f77.js";import"./Load-b9d12279.js";import"./Upload-0c9409a0.js";import"./Load-c588859c.js";import"./sweetalert.min-9f604034.js";import"./ItemsMap-ac429fa2.js";import"./Upload-69a7afe4.js";import"./ItemsMap-99c5c9fb.js";import"./RequestEx-4f93fb5e.js";const M={components:{AppLayout:C,NewItemDialog:E,JetLabel:T,JetButton:S,JetSecondaryButton:U,JetDangerButton:I,DialogInvoiceLine:J,TextField:N,Multiselect:j,AddLineDialog:q,EditLineDialog:P},props:{},data(){return{item:"",idx:"",doctors:[],clinics:[],items:[],units:[],errors:[],form:this.$inertia.form({billLines:[],doctor:"",clinic:"",date:"",billTotalAmount:0})}},methods:{AddItem:function(){this.form.billLines.push({item:"",unit:"",unitPrice:"",quantity:0,total:0})},addNewItemDialog(){this.$refs.dlg1.ShowDialog()},addNewILineDialog(){this.$nextTick(()=>{this.$refs.dlg2.ShowDialog()})},editLineDialog(t){this.item=JSON.parse(JSON.stringify(this.form.billLines[t])),this.idx=t,this.$nextTick(()=>{this.$refs.dlg3.ShowDialog()})},onAddLine(t){this.form.billLines.push({item:t.item,unit:t.unit,unitPrice:t.unitPrice,quantity:t.quantity,total:t.total})},onEditLine(t,o){this.form.billLines[o]=t,console.log(this.form.billLines)},deleteLine:function(t){this.form.billLines.splice(t,1)},onCancel:function(){window.location.reload()},totalAmount(){var t=0;if(this.form.billLines.length!=0)return this.form.billLines.forEach(o=>{t+=Number(o.total)}),this.form.billTotalAmount=t,t},onSave:function(){p.post(route("bills.store"),this.form).then(t=>{this.processing=!1,this.$nextTick(()=>this.$emit("dataUpdated")),this.form.reset(),this.form.processing=!1,this.tab_idx=1}).catch(t=>{this.form.processing=!1,this.$page.props.errors=t.response.data.errors,this.errors=t.response.data.errors})}},created:function(){p.get(route("doctor.all")).then(o=>{this.doctors=o.data}),p.get(route("clinic.all")).then(o=>{this.clinics=o.data}),p.get(route("items.index")).then(o=>{this.items=o.data}),p.get("/json/UnitTypes.json").then(o=>{this.units=o.data}).catch(o=>{})}},O={class:"lg:py-4"},Q={class:"px-2 my-2 w-fit sm:px-6 lg:px-8"},z={class:"mx-auto sm:px-6 lg:px-8"},G={class:"bg-white shadow-xl sm:rounded-lg px-4 pb-4 pt-0"},H={class:"grid lg:grid-cols-3 gap-4 sm:grid-cols-1 h-1/2"},K={class:""},R={class:""},W={class:""},X={class:"w-full"},Y={class:"w-full"},Z={class:"result my-5 w-full"},$={class:"w-full mx-auto md:hidden max-w-4xl lg:max-w-full"},ee={class:"text-center bg-gray-300"},te={class:"bg-[#f8f9fa] p-1 border border-[#eceeef] w-3/12"},oe=e("i",{class:"fa-solid fa-plus"},null,-1),se=[oe],le={class:"bg-[#f8f9fa] p-1 border border-[#eceeef]"},ie={class:"bg-[#f8f9fa] p-1 border border-[#eceeef]"},re={class:"bg-[#f8f9fa] p-1 border border-[#eceeef]"},ne={class:"text-center border border-[#eceeef] w-5/12"},de={class:"border border-[#eceeef]"},ae={class:"p-1 border border-[#eceeef]"},me={class:"p-1 border border-[#eceeef]"},ce={class:"p-1 border border-[#eceeef]"},pe={class:"p-1 border border-[#eceeef]"},ue=e("i",{class:"fa fa-edit"},null,-1),_e=e("i",{class:"fa fa-trash"},null,-1),fe={class:"mx-auto hidden md:block w-full"},he={class:"w-full text-center bg-gray-300"},be={class:"bg-[#f8f9fa] p-1 border border-[#eceeef] w-3/12"},ge=e("i",{class:"fa-solid fa-plus"},null,-1),ve=[ge],ye={class:"bg-[#f8f9fa] p-1 border border-[#eceeef] w-3/12"},Ve={class:"bg-[#f8f9fa] p-1 border border-[#eceeef]"},we={class:"bg-[#f8f9fa] p-1 border border-[#eceeef]"},De={class:"bg-[#f8f9fa] p-1 border border-[#eceeef]"},Le={class:"bg-[#f8f9fa] p-1 border border-[#eceeef]"},ke={class:"w-full text-center border border-[#eceeef]"},Ae={class:"border border-[#eceeef]"},xe={class:"p-1 border border-[#eceeef]"},Ce={class:"p-1 border border-[#eceeef]"},Te={class:"p-1 border border-[#eceeef]"},Se={class:"p-1 border border-[#eceeef]"},Ue={class:"p-1 border border-[#eceeef]"},Ie={class:"p-1 border border-[#eceeef]"},Ne={class:"flex items-center justify-end mt-4"},je={class:"capitalize py-2 text-gray-600 text-lg font-bold"},Je={class:"flex items-center justify-end mt-20"};function Be(t,o,Ee,qe,r,n){const L=a("NewItemDialog"),k=a("AddLineDialog"),A=a("EditLineDialog"),v=a("jet-label"),_=a("multiselect"),f=a("TextField"),y=a("jet-secondary-button"),V=a("jet-danger-button"),g=a("jet-button"),x=a("app-layout");return u(),B(x,null,{default:m(()=>[i(L,{ref:"dlg1"},null,512),i(k,{ref:"dlg2",onSave:n.onAddLine},null,8,["onSave"]),i(A,{item:r.item,idx:r.idx,ref:"dlg3",onSave:n.onEditLine},null,8,["item","idx","onSave"]),e("div",O,[e("p",Q,l(t.__("Add Bill")),1),e("div",z,[e("div",G,[e("div",H,[e("div",K,[i(v,{value:t.__("Clinic")},null,8,["value"]),i(_,{modelValue:r.form.clinic,"onUpdate:modelValue":o[0]||(o[0]=s=>r.form.clinic=s),label:"name",options:r.clinics,placeholder:"Select branch"},null,8,["modelValue","options"])]),e("div",R,[i(v,{value:t.__("Doctor")},null,8,["value"]),i(_,{modelValue:r.form.doctor,"onUpdate:modelValue":o[1]||(o[1]=s=>r.form.doctor=s),label:"name",options:r.doctors,placeholder:"Select doctor"},null,8,["modelValue","options"])]),e("div",W,[i(f,{modelValue:r.form.date,"onUpdate:modelValue":o[2]||(o[2]=s=>r.form.date=s),itemType:"date",itemLabel:t.__("Date")},null,8,["modelValue","itemLabel"])])]),e("div",X,[e("div",Y,[e("div",Z,[e("table",$,[e("thead",ee,[e("th",te,[c(l(t.__("Item"))+" ",1),e("button",{onClick:o[3]||(o[3]=s=>n.addNewItemDialog()),class:"cursor-pointer ml-4"},se)]),e("th",le,l(t.__("Quantity")),1),e("th",ie,l(t.__("Total")),1),e("th",re,l(t.__("Action")),1)]),e("tbody",ne,[(u(!0),b(D,null,w(r.form.billLines,(s,h)=>(u(),b("tr",de,[e("td",ae,[e("p",null,l(s.item.name),1)]),e("td",me,[e("p",null,l(s.quantity),1)]),e("td",ce,[e("p",null,l(s.total),1)]),e("td",pe,[e("div",null,[i(y,{class:"ms-2",onClick:d=>n.editLineDialog(h)},{default:m(()=>[ue]),_:2},1032,["onClick"]),i(V,{class:"ms-2",onClick:d=>n.deleteLine(h)},{default:m(()=>[_e]),_:2},1032,["onClick"])])])]))),256))])]),e("table",fe,[e("thead",he,[e("th",be,[c(l(t.__("Item"))+" ",1),e("button",{onClick:o[4]||(o[4]=s=>n.addNewItemDialog()),class:"cursor-pointer ml-4"},ve)]),e("th",ye,l(t.__("Unit")),1),e("th",Ve,l(t.__("Unit Price")),1),e("th",we,l(t.__("Quantity")),1),e("th",De,l(t.__("Total")),1),e("th",Le,l(t.__("Action")),1)]),e("tbody",ke,[(u(!0),b(D,null,w(r.form.billLines,(s,h)=>(u(),b("tr",Ae,[e("td",xe,[i(_,{modelValue:s.item,"onUpdate:modelValue":d=>s.item=d,label:"name",options:r.items,placeholder:"Select Item",searchable:!0},null,8,["modelValue","onUpdate:modelValue","options"])]),e("td",Ce,[i(_,{modelValue:s.unit,"onUpdate:modelValue":d=>s.unit=d,options:r.units,label:"desc_en",placeholder:"unit",searchable:!0},null,8,["modelValue","onUpdate:modelValue","options"])]),e("td",Te,[i(f,{modelValue:s.unitPrice,"onUpdate:modelValue":d=>s.unitPrice=d,itemType:"number"},null,8,["modelValue","onUpdate:modelValue"])]),e("td",Se,[i(f,{modelValue:s.quantity,"onUpdate:modelValue":d=>s.quantity=d,itemType:"number"},null,8,["modelValue","onUpdate:modelValue"])]),e("td",Ue,[i(f,{modelValue:s.total,"onUpdate:modelValue":d=>s.total=d,itemType:"number"},null,8,["modelValue","onUpdate:modelValue"])]),e("td",Ie,[i(V,{class:"ms-2",onClick:d=>n.deleteLine(h)},{default:m(()=>[c(l(t.__("Delete")),1)]),_:2},1032,["onClick"])])]))),256))])])]),e("div",Ne,[i(g,{class:"ms-2 md:hidden",onClick:o[5]||(o[5]=s=>n.addNewILineDialog())},{default:m(()=>[c(l(t.__("Add Line")),1)]),_:1}),i(g,{class:"ms-2 hidden md:inline-block",onClick:o[6]||(o[6]=s=>n.AddItem())},{default:m(()=>[c(l(t.__("Add Line")),1)]),_:1})]),e("h3",je,[c(l(t.__("Invoice Total")+" :")+" ",1),e("span",null,l(n.totalAmount()),1)])]),e("div",Je,[i(y,{onClick:o[7]||(o[7]=s=>n.onCancel())},{default:m(()=>[c(l(t.__("Cancel")),1)]),_:1}),i(g,{class:"ms-2",onClick:o[8]||(o[8]=s=>n.onSave())},{default:m(()=>[c(l(t.__("Save")),1)]),_:1})])])])])])]),_:1})}const Qt=F(M,[["render",Be]]);export{Qt as default};
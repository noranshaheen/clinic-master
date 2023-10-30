import{A as y}from"./AppLayout-336b7499.js";import{J as v}from"./Label-c6c7e0c2.js";import{J as T}from"./Button-fce1e67a.js";import{J as D}from"./SecondaryButton-fb7ef34d.js";import{J as S}from"./DangerButton-bf3f8f1f.js";import{T as j}from"./TextField-4dc08153.js";import{M as V}from"./vue3-multiselect.umd.min-89fe1e95.js";import{k as c,c as k,w as p,r as n,o as d,a as e,t as o,b as i,f as _,d as m,F as B,g as L}from"./app-98cccb0d.js";import"./sweetalert.min-9f604034.js";/* empty css                                                                  */import{_ as C}from"./_plugin-vue_export-helper-c27b6911.js";import"./Edit-7ca2eef9.js";import"./ActionMessage-529841b6.js";import"./ActionSection-14bbef3c.js";import"./SectionTitle-f26ec90c.js";import"./ConfirmationModal-2d2586d4.js";import"./Modal-2ccc6cf7.js";import"./DialogModal-9cb7d35f.js";import"./FormSection-60b88c5f.js";import"./Input-9c9fd5b2.js";import"./Checkbox-7ff4e1d6.js";import"./InputError-48880b4d.js";import"./SectionBorder-a45d0249.js";import"./ValidationErrors-ce3c07bd.js";/* empty css            */import"./Edit-cfad98b4.js";import"./Edit-04381c68.js";import"./Edit-c883850a.js";import"./Edit-663be45d.js";import"./Edit-833659c9.js";import"./Edit-e905c401.js";import"./Edit-fb9e1a40.js";import"./Edit-8b049cff.js";import"./Edit-7210d6e2.js";import"./Edit-9520adfe.js";import"./Load-c81154ca.js";import"./Load-269b27e0.js";import"./Edit-470aa9e5.js";import"./Edit-ae0efa3b.js";import"./Upload-3f7847e9.js";import"./Upload-cab6aca1.js";import"./Upload-4bb109cf.js";import"./Upload-91640e3b.js";import"./Settings-281c0c2c.js";import"./Settings-3a181d36.js";import"./Upload-b3182070.js";import"./Request-264efc19.js";import"./Add-983c5f77.js";import"./Load-b9d12279.js";import"./Upload-0c9409a0.js";import"./Load-c588859c.js";import"./ItemsMap-ac429fa2.js";import"./Upload-69a7afe4.js";import"./ItemsMap-99c5c9fb.js";import"./RequestEx-4f93fb5e.js";const J={components:{AppLayout:y,JetLabel:v,JetButton:T,JetSecondaryButton:D,JetDangerButton:S,TextField:j,Multiselect:V},props:{invoice:{Type:Object,default:null},items:{Type:Object,default:null}},data(){return{branches:[],data:[],errors:[],form:this.$inertia.form({issuer:"",startDate:new Date().toISOString().slice(0,10),endDate:new Date().toISOString().slice(0,10)})}},methods:{onShow:function(){c.post(route("reports.customers.sales.data"),this.form).then(t=>{this.data=t.data}).catch(t=>{})},onDownload:function(){c({url:route("reports.customers.sales.download"),method:"POST",data:this.form,responseType:"blob"}).then(t=>{const r=window.URL.createObjectURL(new Blob([t.data])),l=document.createElement("a");l.href=r,l.setAttribute("download","report.xlsx"),document.body.appendChild(l),l.click()})}},created:function(){c.get(route("json.branches")).then(r=>{var l=[{Id:-1,name:"All"}];this.branches=l.concat(r.data)}).catch(r=>{console.log(r)})}},N={class:"py-4"},F={class:"mx-auto sm:px-6 lg:px-8"},O={class:"card-title flex flex-col lg:flex-row justify-between p-3"},A={class:"capitalize"},R={class:"bg-white shadow-xl sm:rounded-lg px-4 pb-4 pt-4"},U={class:"grid lg:grid-cols-4 gap-4 sm:grid-cols-1 h-1/2 overflow"},E={class:"flex items-center justify-end mt-4"},I={class:"mx-auto sm:px-6 lg:px-8"},M={class:"bg-white overflow-hidden shadow-xl sm:rounded-lg"},z={key:0,class:"result my-5 overflow-x-auto w-full"},P={class:"w-11/12 mx-auto max-w-4xl lg:max-w-full"},W={class:"text-center bg-gray-300"},q={class:"bg-[#f8f9fa] p-3 border border-[#eceeef]"},G={class:"bg-[#f8f9fa] p-3 border border-[#eceeef]"},H={class:"bg-[#f8f9fa] p-3 border border-[#eceeef]"},K={class:"bg-[#f8f9fa] p-3 border border-[#eceeef]"},Q={class:"bg-[#f8f9fa] p-3 border border-[#eceeef]"},X={class:"bg-[#f8f9fa] p-3 border border-[#eceeef]"},Y={class:"bg-[#f8f9fa] p-3 border border-[#eceeef]"},Z={class:"text-center border border-[#eceeef]"},$={class:"p-2 border border-[#eceeef]"},ee={class:"p-2 border border-[#eceeef]"},te={class:"p-2 border border-[#eceeef]"},oe={class:"p-2 border border-[#eceeef]"},re={class:"p-2 border border-[#eceeef]"},se={class:"p-2 border border-[#eceeef]"},ae={class:"p-2 border border-[#eceeef]"},le={key:1},ne={class:"text-center text-red-600 my-5"},ie=e("i",{class:"fa fa-exclamation-circle mr-1"},null,-1);function de(t,r,l,me,a,f){const b=n("jet-label"),h=n("multiselect"),u=n("TextField"),g=n("jet-secondary-button"),w=n("jet-button"),x=n("app-layout");return d(),k(x,null,{default:p(()=>[e("div",N,[e("div",F,[e("div",O,[e("h4",A,o(t.__("Customers Sales Report")),1)]),e("div",R,[e("div",U,[e("div",null,[i(b,{value:t.__("Branch")},null,8,["value"]),i(h,{modelValue:a.form.issuer,"onUpdate:modelValue":r[0]||(r[0]=s=>a.form.issuer=s),label:"name",options:a.branches,placeholder:"Select branch"},null,8,["modelValue","options"])]),i(u,{modelValue:a.form.startDate,"onUpdate:modelValue":r[1]||(r[1]=s=>a.form.startDate=s),itemType:"date",itemLabel:t.__("Start Date")},null,8,["modelValue","itemLabel"]),i(u,{modelValue:a.form.endDate,"onUpdate:modelValue":r[2]||(r[2]=s=>a.form.endDate=s),itemType:"date",itemLabel:t.__("End Date")},null,8,["modelValue","itemLabel"]),e("div",E,[i(g,{onClick:r[3]||(r[3]=s=>f.onDownload())},{default:p(()=>[_(o(t.__("Download")),1)]),_:1}),i(w,{class:"ms-2",onClick:r[4]||(r[4]=s=>f.onShow())},{default:p(()=>[_(o(t.__("Show")),1)]),_:1})])])])])]),e("div",I,[e("div",M,[a.data.length>0?(d(),m("div",z,[e("table",P,[e("thead",W,[e("th",q,o(t.__("Customer Name")),1),e("th",G,o(t.__("Tax Registration Number")),1),e("th",H,o(t.__("Start Date")),1),e("th",K,o(t.__("End Date")),1),e("th",Q,o(t.__("Tax Total")),1),e("th",X,o(t.__("Sales Total")),1),e("th",Y,o(t.__("Total Amount")),1)]),e("tbody",Z,[(d(!0),m(B,null,L(a.data,s=>(d(),m("tr",{class:"border border-[#eceeef]",key:s},[e("td",$,o(s.Name),1),e("td",ee,o(s.Id),1),e("td",te,o(a.form.startDate),1),e("td",oe,o(a.form.endDate),1),e("td",re,o(s.TaxTotal),1),e("td",se,o(s.SalesTotal),1),e("td",ae,o(s.Total),1)]))),128))])])])):(d(),m("div",le,[e("p",ne,[ie,_(" "+o(t.__("No Records Were Found")),1)])]))])])]),_:1})}const pt=C(J,[["render",de]]);export{pt as default};

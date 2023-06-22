import{A as y}from"./AppLayout-f49bf28b.js";import{J as v}from"./Label-df30c280.js";import{J as T}from"./Button-4bcf952d.js";import{J as D}from"./SecondaryButton-713ac718.js";import{J as S}from"./DangerButton-8bc4ac7b.js";import{T as j}from"./TextField-3250345e.js";import{M as V}from"./vue3-multiselect.umd.min-0e68115f.js";import{k as c,c as k,w as p,r as n,o as i,a as e,t as o,b as d,f as _,d as m,F as B,g as L}from"./app-150d5054.js";import"./sweetalert.min-d55a1c1c.js";/* empty css                                                                  */import{_ as C}from"./_plugin-vue_export-helper-c27b6911.js";import"./Edit-bcfc13f2.js";import"./ActionMessage-61e2ac70.js";import"./ActionSection-b2837b81.js";import"./SectionTitle-3e354ea0.js";import"./ConfirmationModal-25a9f4bd.js";import"./Modal-af9a88ec.js";import"./DialogModal-abac778c.js";import"./FormSection-88b4b82e.js";import"./Input-1c19b971.js";import"./Checkbox-4a56b901.js";import"./InputError-a5d97e62.js";import"./SectionBorder-e50f0f2f.js";import"./ValidationErrors-d148bef4.js";/* empty css            */import"./Edit-0682400b.js";import"./Edit-3c089fa6.js";import"./Edit-be99b5ee.js";import"./Edit-597f2255.js";import"./Edit-f9922137.js";import"./Edit-faa18d1d.js";import"./Edit-cd91fcb4.js";import"./Edit-07cd30d2.js";import"./Edit-34545e2b.js";import"./Edit-db4f3217.js";import"./Load-49470aa5.js";import"./Load-63f267b7.js";import"./Edit-ae599c19.js";import"./Upload-84ea7cbc.js";import"./Upload-9f5fa312.js";import"./Settings-16afee17.js";import"./Settings-c1b5727e.js";import"./Upload-ac8dd442.js";import"./Request-7a72620a.js";import"./Add-a5bec431.js";import"./Load-9cedd89f.js";import"./Upload-8acddc09.js";import"./Load-38871443.js";import"./ItemsMap-522638f4.js";import"./Upload-92e0933c.js";import"./ItemsMap-e43ca060.js";import"./RequestEx-92427893.js";const J={components:{AppLayout:y,JetLabel:v,JetButton:T,JetSecondaryButton:D,JetDangerButton:S,TextField:j,Multiselect:V},props:{invoice:{Type:Object,default:null},items:{Type:Object,default:null}},data(){return{branches:[],data:[],errors:[],form:this.$inertia.form({issuer:"",startDate:new Date().toISOString().slice(0,10),endDate:new Date().toISOString().slice(0,10)})}},methods:{onShow:function(){c.post(route("reports.customers.sales.data"),this.form).then(t=>{this.data=t.data}).catch(t=>{})},onDownload:function(){c({url:route("reports.customers.sales.download"),method:"POST",data:this.form,responseType:"blob"}).then(t=>{const s=window.URL.createObjectURL(new Blob([t.data])),l=document.createElement("a");l.href=s,l.setAttribute("download","report.xlsx"),document.body.appendChild(l),l.click()})}},created:function(){c.get(route("json.branches")).then(s=>{var l=[{Id:-1,name:"All"}];this.branches=l.concat(s.data)}).catch(s=>{console.log(s)})}},N={class:"py-4"},F={class:"mx-auto sm:px-6 lg:px-8"},O={class:"card-title flex flex-col lg:flex-row justify-between p-3"},A={class:"capitalize"},R={class:"bg-white shadow-xl sm:rounded-lg px-4 pb-4 pt-4"},U={class:"grid lg:grid-cols-4 gap-4 sm:grid-cols-1 h-1/2 overflow"},E={class:"flex items-center justify-end mt-4"},I={class:"mx-auto sm:px-6 lg:px-8"},M={class:"bg-white overflow-hidden shadow-xl sm:rounded-lg"},z={key:0,class:"result my-5 overflow-x-auto w-full"},P={class:"w-11/12 mx-auto max-w-4xl lg:max-w-full"},W={class:"text-center bg-gray-300"},q={class:"bg-[#f8f9fa] p-3 border border-[#eceeef]"},G={class:"bg-[#f8f9fa] p-3 border border-[#eceeef]"},H={class:"bg-[#f8f9fa] p-3 border border-[#eceeef]"},K={class:"bg-[#f8f9fa] p-3 border border-[#eceeef]"},Q={class:"bg-[#f8f9fa] p-3 border border-[#eceeef]"},X={class:"bg-[#f8f9fa] p-3 border border-[#eceeef]"},Y={class:"bg-[#f8f9fa] p-3 border border-[#eceeef]"},Z={class:"text-center border border-[#eceeef]"},$={class:"p-2 border border-[#eceeef]"},ee={class:"p-2 border border-[#eceeef]"},te={class:"p-2 border border-[#eceeef]"},oe={class:"p-2 border border-[#eceeef]"},se={class:"p-2 border border-[#eceeef]"},re={class:"p-2 border border-[#eceeef]"},ae={class:"p-2 border border-[#eceeef]"},le={key:1},ne={class:"text-center text-red-600 my-5"},de=e("i",{class:"fa fa-exclamation-circle mr-1"},null,-1);function ie(t,s,l,me,a,f){const b=n("jet-label"),h=n("multiselect"),u=n("TextField"),g=n("jet-secondary-button"),w=n("jet-button"),x=n("app-layout");return i(),k(x,null,{default:p(()=>[e("div",N,[e("div",F,[e("div",O,[e("h4",A,o(t.__("Customers Sales Report")),1)]),e("div",R,[e("div",U,[e("div",null,[d(b,{value:t.__("Branch")},null,8,["value"]),d(h,{modelValue:a.form.issuer,"onUpdate:modelValue":s[0]||(s[0]=r=>a.form.issuer=r),label:"name",options:a.branches,placeholder:"Select branch"},null,8,["modelValue","options"])]),d(u,{modelValue:a.form.startDate,"onUpdate:modelValue":s[1]||(s[1]=r=>a.form.startDate=r),itemType:"date",itemLabel:t.__("Start Date")},null,8,["modelValue","itemLabel"]),d(u,{modelValue:a.form.endDate,"onUpdate:modelValue":s[2]||(s[2]=r=>a.form.endDate=r),itemType:"date",itemLabel:t.__("End Date")},null,8,["modelValue","itemLabel"]),e("div",E,[d(g,{onClick:s[3]||(s[3]=r=>f.onDownload())},{default:p(()=>[_(o(t.__("Download")),1)]),_:1}),d(w,{class:"ms-2",onClick:s[4]||(s[4]=r=>f.onShow())},{default:p(()=>[_(o(t.__("Show")),1)]),_:1})])])])])]),e("div",I,[e("div",M,[a.data.length>0?(i(),m("div",z,[e("table",P,[e("thead",W,[e("th",q,o(t.__("Customer Name")),1),e("th",G,o(t.__("Tax Registration Number")),1),e("th",H,o(t.__("Start Date")),1),e("th",K,o(t.__("End Date")),1),e("th",Q,o(t.__("Tax Total")),1),e("th",X,o(t.__("Sales Total")),1),e("th",Y,o(t.__("Total Amount")),1)]),e("tbody",Z,[(i(!0),m(B,null,L(a.data,r=>(i(),m("tr",{class:"border border-[#eceeef]",key:r},[e("td",$,o(r.Name),1),e("td",ee,o(r.Id),1),e("td",te,o(a.form.startDate),1),e("td",oe,o(a.form.endDate),1),e("td",se,o(r.TaxTotal),1),e("td",re,o(r.SalesTotal),1),e("td",ae,o(r.Total),1)]))),128))])])])):(i(),m("div",le,[e("p",ne,[de,_(" "+o(t.__("No Records Were Found")),1)])]))])])]),_:1})}const it=C(J,[["render",ie]]);export{it as default};
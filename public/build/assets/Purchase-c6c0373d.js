import{c as k,w as m,r as i,o as p,a as t,t as s,b as n,f as c,d as u,i as b,u as v,F as D,g as C}from"./app-98cccb0d.js";import{A as T}from"./AppLayout-336b7499.js";import{J as S}from"./Label-c6c7e0c2.js";import{J as V}from"./Button-fce1e67a.js";import{J as j}from"./SecondaryButton-fb7ef34d.js";import{J as L}from"./DangerButton-bf3f8f1f.js";import{T as A}from"./TextField-4dc08153.js";import{M as B}from"./vue3-multiselect.umd.min-89fe1e95.js";import U from"./EditLine-64c486c6.js";import{s as F}from"./sweetalert.min-9f604034.js";/* empty css                                                                  */import{_ as O}from"./_plugin-vue_export-helper-c27b6911.js";/* empty css            */import"./Edit-7ca2eef9.js";import"./ActionMessage-529841b6.js";import"./ActionSection-14bbef3c.js";import"./SectionTitle-f26ec90c.js";import"./ConfirmationModal-2d2586d4.js";import"./Modal-2ccc6cf7.js";import"./DialogModal-9cb7d35f.js";import"./FormSection-60b88c5f.js";import"./Input-9c9fd5b2.js";import"./Checkbox-7ff4e1d6.js";import"./InputError-48880b4d.js";import"./SectionBorder-a45d0249.js";import"./ValidationErrors-ce3c07bd.js";import"./Edit-cfad98b4.js";import"./Edit-04381c68.js";import"./Edit-c883850a.js";import"./Edit-663be45d.js";import"./Edit-833659c9.js";import"./Edit-e905c401.js";import"./Edit-fb9e1a40.js";import"./Edit-8b049cff.js";import"./Edit-7210d6e2.js";import"./Edit-9520adfe.js";import"./Load-c81154ca.js";import"./Load-269b27e0.js";import"./Edit-470aa9e5.js";import"./Edit-ae0efa3b.js";import"./Upload-3f7847e9.js";import"./Upload-cab6aca1.js";import"./Upload-4bb109cf.js";import"./Upload-91640e3b.js";import"./Settings-281c0c2c.js";import"./Settings-3a181d36.js";import"./Upload-b3182070.js";import"./Request-264efc19.js";import"./Add-983c5f77.js";import"./Load-b9d12279.js";import"./Upload-0c9409a0.js";import"./Load-c588859c.js";import"./ItemsMap-ac429fa2.js";import"./Upload-69a7afe4.js";import"./ItemsMap-99c5c9fb.js";import"./RequestEx-4f93fb5e.js";const J={components:{AppLayout:T,JetLabel:S,JetButton:V,JetSecondaryButton:j,JetDangerButton:L,DialogInvoiceLine:U,TextField:A,Multiselect:B},props:{invoice:{Type:Object,default:null},items:{Type:Object,default:null}},data(){return{data:[],errors:[],vendors:[],form:this.$inertia.form({startDate:new Date().toISOString().slice(0,10),endDate:new Date().toISOString().slice(0,10)})}},methods:{onShow:function(){axios.post(route("reports.summary.purchase.data"),this.form).then(e=>{this.data=e.data,this.data.forEach(o=>{o.archive=!1}),this.allChecked=!1}).catch(e=>{})},onDownload:function(){axios({url:route("reports.summary.purchase.download"),method:"POST",data:this.form,responseType:"blob"}).then(e=>{const o=window.URL.createObjectURL(new Blob([e.data])),a=document.createElement("a");a.href=o,a.setAttribute("download","report.xlsx"),document.body.appendChild(a),a.click()})},onDownloadSummary:function(){axios({url:route("reports.summary.purchase.download2"),method:"POST",data:this.form,responseType:"blob"}).then(e=>{const o=window.URL.createObjectURL(new Blob([e.data])),a=document.createElement("a");a.href=o,a.setAttribute("download","report.xlsx"),document.body.appendChild(a),a.click()})},checkAll(){this.$nextTick(()=>{this.data.forEach(e=>{e.archive=this.allChecked})})},updateCheckBoxes(){this.$nextTick(()=>{this.allChecked=this.data.every(e=>e.archive)})},onArchive(){let e=this.data.filter(a=>a.archive),o=e.map(a=>a.LID);e.length>0?window.open(route("pdf.purchases",o.join(","))):F({title:document.body.lang=="en"?"Please Select At Least One Record":"برجاء اختيار فاتورة واحدة على الأقل",icon:"error"})}},created:function(){axios.get(route("json.eta.vendors")).then(o=>{var a=[{id:-1,name:"All"}];this.vendors=a.concat(o.data),this.form.vendor=this.vendors[0]}).catch(o=>{console.log(o)})}},N={class:"py-4"},R={class:"mx-auto sm:px-6 lg:px-8"},E={class:"card-title flex flex-col lg:flex-row justify-between p-3"},I={class:"capitalize"},M={class:"bg-white shadow-xl sm:rounded-lg px-4 pb-4 pt-4"},P={class:"grid lg:grid-cols-3 gap-4 sm:grid-cols-1 h-1/2 overflow"},z={class:"flex items-center justify-start mt-4"},W={class:"mx-auto sm:px-6 lg:px-8"},q={class:"bg-white overflow-hidden shadow-xl sm:rounded-lg"},G={key:0,class:"result my-5 overflow-x-auto w-full"},H={class:"w-11/12 mx-auto max-w-4xl lg:max-w-full"},K={class:"text-center bg-gray-300"},Q={class:"bg-[#f8f9fa] p-3 border border-[#eceeef]"},X={class:"bg-[#f8f9fa] p-3 border border-[#eceeef]"},Y={class:"bg-[#f8f9fa] p-3 border border-[#eceeef]"},Z={class:"bg-[#f8f9fa] p-3 border border-[#eceeef]"},$={class:"bg-[#f8f9fa] p-3 border border-[#eceeef]"},ee={class:"bg-[#f8f9fa] p-3 border border-[#eceeef]"},te={class:"bg-[#f8f9fa] p-3 border border-[#eceeef]"},oe={class:"text-center border border-[#eceeef]"},re={class:"p-2 border border-[#eceeef]"},se=["onUpdate:modelValue"],ae={class:"p-2 border border-[#eceeef]"},le={class:"p-2 border border-[#eceeef]"},ne={class:"p-2 border border-[#eceeef]"},de={class:"p-2 border border-[#eceeef]"},ie={class:"p-2 border border-[#eceeef]"},ce={class:"p-2 border border-[#eceeef]"},me={key:1},pe={class:"text-center text-red-600 my-5"},ue=t("i",{class:"fa fa-exclamation-circle mr-1"},null,-1);function he(e,o,a,fe,l,d){const g=i("jet-label"),y=i("multiselect"),f=i("TextField"),w=i("jet-button"),h=i("jet-secondary-button"),x=i("app-layout");return p(),k(x,null,{default:m(()=>[t("div",N,[t("div",R,[t("div",E,[t("h4",I,s(e.__("Purchase Report")),1)]),t("div",M,[t("div",P,[t("div",null,[n(g,{value:e.__("Vendor")},null,8,["value"]),n(y,{modelValue:l.form.vendor,"onUpdate:modelValue":o[0]||(o[0]=r=>l.form.vendor=r),label:"name",options:l.vendors,placeholder:"Select vendor"},null,8,["modelValue","options"])]),n(f,{modelValue:l.form.startDate,"onUpdate:modelValue":o[1]||(o[1]=r=>l.form.startDate=r),itemType:"date",itemLabel:e.__("Start Date")},null,8,["modelValue","itemLabel"]),n(f,{modelValue:l.form.endDate,"onUpdate:modelValue":o[2]||(o[2]=r=>l.form.endDate=r),itemType:"date",itemLabel:e.__("End Date")},null,8,["modelValue","itemLabel"])]),t("div",z,[n(w,{onClick:o[3]||(o[3]=r=>d.onShow())},{default:m(()=>[c(s(e.__("Show")),1)]),_:1}),n(h,{class:"ms-2",onClick:o[4]||(o[4]=r=>d.onDownload())},{default:m(()=>[c(s(e.__("Download")),1)]),_:1}),n(h,{class:"ms-2",onClick:o[5]||(o[5]=r=>d.onDownloadSummary())},{default:m(()=>[c(s(e.__("Download Summary")),1)]),_:1}),n(h,{class:"ms-2",onClick:d.onArchive},{default:m(()=>[c(s(e.__("Archive")),1)]),_:1},8,["onClick"])])])])]),t("div",W,[t("div",q,[l.data.length>0?(p(),u("div",G,[t("table",H,[t("thead",K,[t("th",Q,[b(t("input",{type:"checkbox","onUpdate:modelValue":o[6]||(o[6]=r=>e.allChecked=r),onChange:o[7]||(o[7]=r=>d.checkAll())},null,544),[[v,e.allChecked]]),c(" "+s(e.__("Archive")),1)]),t("th",X,s(e.__("Invoice Number")),1),t("th",Y,s(e.__("Month")),1),t("th",Z,s(e.__("Date")),1),t("th",$,s(e.__("Tax Total")),1),t("th",ee,s(e.__("Client Name")),1),t("th",te,s(e.__("Total Amount")),1)]),t("tbody",oe,[(p(!0),u(D,null,C(l.data,r=>(p(),u("tr",{class:"border border-[#eceeef]",key:r},[t("td",re,[b(t("input",{type:"checkbox","onUpdate:modelValue":_=>r.archive=_,onChange:o[8]||(o[8]=_=>d.updateCheckBoxes())},null,40,se),[[v,r.archive]])]),t("td",ae,s(r.Id),1),t("td",le,s(r.Month),1),t("td",ne,s(r.Date),1),t("td",de,s((Math.round(100*(r.Total-r.Net))/100).toFixed(2)),1),t("td",ie,s(r.Seller),1),t("td",ce,s(parseFloat(r.Total).toFixed(2)),1)]))),128))])])])):(p(),u("div",me,[t("p",pe,[ue,c(" "+s(e.__("No Records Were Found")),1)])]))])])]),_:1})}const vt=O(J,[["render",he]]);export{vt as default};

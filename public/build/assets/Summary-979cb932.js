import{k as c,c as x,w as m,r as p,o as h,a as o,t as r,b as n,f as d,d as f,i as g,u as k,F as S,g as V}from"./app-010fad37.js";import{A as T}from"./AppLayout-b94f7417.js";import{J as L}from"./Label-e291ccc6.js";import{J as j}from"./Button-11813b5e.js";import{J as A}from"./SecondaryButton-8a1eaf86.js";import{J as U}from"./DangerButton-367e534b.js";import{T as B}from"./TextField-f89d8302.js";import{M as O}from"./vue3-multiselect.umd.min-939aa207.js";import R from"./EditLine-d8888d4a.js";import{s as w}from"./sweetalert.min-679d9ee2.js";/* empty css                                                                  */import{_ as I}from"./_plugin-vue_export-helper-c27b6911.js";/* empty css            */import"./Edit-74f06fe7.js";import"./ActionMessage-517545cc.js";import"./ActionSection-2c866042.js";import"./SectionTitle-8abeab5a.js";import"./ConfirmationModal-0f300aca.js";import"./Modal-97755a3c.js";import"./DialogModal-22356253.js";import"./FormSection-bd296fee.js";import"./Input-8a286b7b.js";import"./Checkbox-ebdeef89.js";import"./InputError-317c03cf.js";import"./SectionBorder-822e764c.js";import"./ValidationErrors-31471297.js";import"./Edit-a73070bb.js";import"./Edit-7abb2ae3.js";import"./Edit-18d907dc.js";import"./Edit-16ea2851.js";import"./Edit-b486f9ab.js";import"./Edit-ec7eaf71.js";import"./Edit-b040ada8.js";import"./Edit-f6f19305.js";import"./Edit-67e94b24.js";import"./Edit-a5179c0a.js";import"./Load-dcf8a148.js";import"./Load-b22526f9.js";import"./Edit-dd846932.js";import"./Upload-b17b92a3.js";import"./Upload-4dcf9d8b.js";import"./Upload-12291f8c.js";import"./Upload-1ea272cb.js";import"./Settings-f203d5a5.js";import"./Settings-3720bcf6.js";import"./Upload-3f1630e8.js";import"./Request-86128435.js";import"./Add-dd2dde44.js";import"./Load-a5c84528.js";import"./Upload-484af51f.js";import"./Load-6372f5e6.js";import"./ItemsMap-0f9ec3d1.js";import"./Upload-cd794d3e.js";import"./ItemsMap-5b7489db.js";import"./RequestEx-322cc660.js";const P={components:{AppLayout:T,JetLabel:L,JetButton:j,JetSecondaryButton:A,JetDangerButton:U,DialogInvoiceLine:R,TextField:B,Multiselect:O},props:{invoice:{Type:Object,default:null},items:{Type:Object,default:null}},data(){return{branches:[],customers:[],data:[],errors:[],statuses:[],selected_status:null,form:this.$inertia.form({issuer:"",receiver:"",startDate:new Date().toISOString().slice(0,10),endDate:new Date().toISOString().slice(0,10),status:""}),allChecked:!1}},methods:{onShow:function(){this.form.status=this.selected_status.value,c.post(route("reports.summary.details.data"),this.form).then(t=>{this.data=t.data,this.data.forEach(e=>{e.print=!1}),this.allChecked=!1}).catch(t=>{})},onDownload:function(){this.form.status=this.selected_status.value,c({url:route("reports.summary.details.download"),method:"POST",data:this.form,responseType:"blob"}).then(t=>{const e=window.URL.createObjectURL(new Blob([t.data])),s=document.createElement("a");s.href=e,s.setAttribute("download","report.xlsx"),document.body.appendChild(s),s.click()})},downloadSummary(){this.form.status=this.selected_status.value,this.form.issuer&&this.form.receiver?c.post(route("reports.summary.summaryOnlyData.download"),this.form,{responseType:"blob"}).then(t=>{const e=window.URL.createObjectURL(new Blob([t.data])),s=document.createElement("a");s.href=e,s.setAttribute("download","report.xlsx"),document.body.appendChild(s),s.click()}).catch(t=>{console.error(t)}):w({title:document.body.lang=="en"?"Please Fill The Required Fileds":"برجاء ملئ الحقول المطلوبة",icon:"error"})},onDownloadV2(){this.form.status=this.selected_status.value,c({url:route("reports.summary.details.download.new"),method:"POST",data:this.form,responseType:"blob"}).then(t=>{const e=window.URL.createObjectURL(new Blob([t.data])),s=document.createElement("a");s.href=e,s.setAttribute("download","report.xlsx"),document.body.appendChild(s),s.click()})},onDownloadV3(){this.form.status=this.selected_status.value,c({url:route("reports.summary.details.download.compact"),method:"POST",data:this.form,responseType:"blob"}).then(t=>{const e=window.URL.createObjectURL(new Blob([t.data])),s=document.createElement("a");s.href=e,s.setAttribute("download","report.xlsx"),document.body.appendChild(s),s.click()})},checkAll(){this.$nextTick(()=>{this.data.forEach(t=>{t.print=this.allChecked})})},updateCheckBoxes(){this.$nextTick(()=>{this.allChecked=this.data.every(t=>t.print)})},onPrint(){let t=this.data.filter(s=>s.print),e=t.map(s=>s.LID);t.length>0?window.open(route("pdf.invoices.preview",e.join(","))):w({title:document.body.lang=="en"?"Please Select At Least One Record":"برجاء اختيار فاتورة واحدة على الأقل",icon:"error"})},onArchive(){let t=this.data.filter(s=>s.print),e=t.map(s=>s.LID);t.length>0?window.open(route("zip.invoices",e.join(","))):w({title:document.body.lang=="en"?"Please Select At Least One Record":"برجاء اختيار فاتورة واحدة على الأقل",icon:"error"})}},created:function(){c.get(route("json.branches")).then(e=>{var s=[{Id:-1,name:"All"}];this.branches=s.concat(e.data)}).catch(e=>{console.log(e)}),c.get(route("json.customers")).then(e=>{var s=[{Id:-1,name:"All"}];this.customers=s.concat(e.data)}).catch(e=>{console.log(e)}),c.get(route("reports.invoices.statuses")).then(e=>{this.statuses=e.data}).catch(e=>{console.log(e)})}},E={class:"py-4"},F={class:"mx-auto sm:px-6 lg:px-8"},J={class:"card-title flex flex-col lg:flex-row justify-between p-3"},N={class:"capitalize"},M={class:"bg-white shadow-xl sm:rounded-lg px-4 pb-4 pt-4"},z={class:"grid lg:grid-cols-2 gap-4 sm:grid-cols-1 h-1/2 overflow"},q={class:"flex items-center justify-start mt-4"},W={class:"mx-auto sm:px-6 lg:px-8"},G={class:"bg-white overflow-hidden shadow-xl sm:rounded-lg"},H={key:0,class:"result my-5 overflow-x-auto w-full"},K={class:"w-11/12 mx-auto max-w-4xl lg:max-w-full"},Q={class:"text-center bg-gray-300"},X={class:"bg-[#f8f9fa] p-3 border border-[#eceeef]"},Y={class:"bg-[#f8f9fa] p-3 border border-[#eceeef]"},Z={class:"bg-[#f8f9fa] p-3 border border-[#eceeef]"},$={class:"bg-[#f8f9fa] p-3 border border-[#eceeef]"},ee={class:"bg-[#f8f9fa] p-3 border border-[#eceeef]"},te={class:"bg-[#f8f9fa] p-3 border border-[#eceeef]"},oe={class:"bg-[#f8f9fa] p-3 border border-[#eceeef]"},se={class:"text-center border border-[#eceeef]"},le={class:"p-2 border border-[#eceeef]"},re=["onUpdate:modelValue"],ae={class:"p-2 border border-[#eceeef]"},ne={class:"p-2 border border-[#eceeef]"},ie={class:"p-2 border border-[#eceeef]"},de={class:"p-2 border border-[#eceeef]"},ce={class:"p-2 border border-[#eceeef]"},me={class:"p-2 border border-[#eceeef]"},ue={key:1},pe={class:"text-center text-red-600 my-5"},he=o("i",{class:"fa fa-exclamation-circle mr-1"},null,-1);function fe(t,e,s,_e,a,i){const _=p("jet-label"),b=p("multiselect"),v=p("TextField"),C=p("jet-button"),u=p("jet-secondary-button"),D=p("app-layout");return h(),x(D,null,{default:m(()=>[o("div",E,[o("div",F,[o("div",J,[o("h4",N,r(t.__("Summary Report")),1)]),o("div",M,[o("div",z,[o("div",null,[n(_,{value:t.__("Branch")},null,8,["value"]),n(b,{modelValue:a.form.issuer,"onUpdate:modelValue":e[0]||(e[0]=l=>a.form.issuer=l),label:"name",options:a.branches,placeholder:"Select branch"},null,8,["modelValue","options"])]),o("div",null,[n(_,{value:t.__("Customer")},null,8,["value"]),n(b,{modelValue:a.form.receiver,"onUpdate:modelValue":e[1]||(e[1]=l=>a.form.receiver=l),label:"name",options:a.customers,placeholder:"Select customer"},null,8,["modelValue","options"])]),n(v,{modelValue:a.form.startDate,"onUpdate:modelValue":e[2]||(e[2]=l=>a.form.startDate=l),itemType:"date",itemLabel:t.__("Start Date")},null,8,["modelValue","itemLabel"]),n(v,{modelValue:a.form.endDate,"onUpdate:modelValue":e[3]||(e[3]=l=>a.form.endDate=l),itemType:"date",itemLabel:t.__("End Date")},null,8,["modelValue","itemLabel"]),o("div",null,[n(_,{value:t.__("Status")},null,8,["value"]),n(b,{modelValue:a.selected_status,"onUpdate:modelValue":e[4]||(e[4]=l=>a.selected_status=l),label:"name",options:a.statuses,placeholder:"Select status"},null,8,["modelValue","options"])])]),o("div",q,[n(C,{onClick:e[5]||(e[5]=l=>i.onShow())},{default:m(()=>[d(r(t.__("Show")),1)]),_:1}),n(u,{class:"ms-2",onClick:e[6]||(e[6]=l=>i.onDownload())},{default:m(()=>[d(r(t.__("Download")),1)]),_:1}),n(u,{class:"ms-2",onClick:i.downloadSummary},{default:m(()=>[d(r(t.__("Download Summary")),1)]),_:1},8,["onClick"]),n(u,{class:"ms-2",onClick:i.onDownloadV2},{default:m(()=>[d(r(t.__("Download Summary V2")),1)]),_:1},8,["onClick"]),n(u,{class:"ms-2",onClick:i.onDownloadV3},{default:m(()=>[d(r(t.__("Download Summary Compact")),1)]),_:1},8,["onClick"]),n(u,{class:"ms-2",onClick:i.onPrint},{default:m(()=>[d(r(t.__("Print")),1)]),_:1},8,["onClick"]),n(u,{class:"ms-2",onClick:i.onArchive},{default:m(()=>[d(r(t.__("Archive")),1)]),_:1},8,["onClick"])])])])]),o("div",W,[o("div",G,[a.data.length>0?(h(),f("div",H,[o("table",K,[o("thead",Q,[o("th",X,[g(o("input",{type:"checkbox","onUpdate:modelValue":e[7]||(e[7]=l=>a.allChecked=l),onChange:e[8]||(e[8]=l=>i.checkAll())},null,544),[[k,a.allChecked]]),d(" "+r(t.__("Select All")),1)]),o("th",Y,r(t.__("Invoice Number")),1),o("th",Z,r(t.__("Month")),1),o("th",$,r(t.__("Date")),1),o("th",ee,r(t.__("Tax Total")),1),o("th",te,r(t.__("Client Name")),1),o("th",oe,r(t.__("Total Amount")),1)]),o("tbody",se,[(h(!0),f(S,null,V(a.data,l=>(h(),f("tr",{class:"border border-[#eceeef]",key:l},[o("td",le,[g(o("input",{type:"checkbox","onUpdate:modelValue":y=>l.print=y,onChange:e[9]||(e[9]=y=>i.updateCheckBoxes())},null,40,re),[[k,l.print]])]),o("td",ae,r(l.Id),1),o("td",ne,r(l.Month),1),o("td",ie,r(l.Date),1),o("td",de,r(l.TaxTotal),1),o("td",ce,r(l.Client),1),o("td",me,r(l.Total),1)]))),128))])])])):(h(),f("div",ue,[o("p",pe,[he,d(" "+r(t.__("No Records Were Found")),1)])]))])])]),_:1})}const wt=I(P,[["render",fe]]);export{wt as default};

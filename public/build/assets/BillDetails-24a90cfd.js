import{J as p}from"./Button-11813b5e.js";import{J as u}from"./DialogModal-22356253.js";import{J as g}from"./SecondaryButton-8a1eaf86.js";import{J as D}from"./Input-8a286b7b.js";import{k as J,d as l,b as i,w as a,r as c,o as d,f as _,t as o,a as e,F as w,g as y}from"./app-010fad37.js";import{_ as B}from"./_plugin-vue_export-helper-c27b6911.js";import"./Modal-97755a3c.js";/* empty css            */const C={components:{JetButton:p,JetDialogModal:u,JetSecondaryButton:g,JetInput:D,axios:J},props:{bill_details:{default:null}},data(){return{showDialog:!1}},methods:{ShowDialog(){this.showDialog=!0,console.log(this.bill_details)},close(){this.showDialog=!1}}},S={class:"w-full"},k={class:"text-center bg-gray-300"},v={class:"bg-[#f8f9fa] p-1 border border-[#eceeef]"},N={class:"bg-[#f8f9fa] p-1 border border-[#eceeef]"},V={class:"bg-[#f8f9fa] p-1 border border-[#eceeef]"},j={class:"bg-[#f8f9fa] p-1 border border-[#eceeef]"},x={class:"bg-[#f8f9fa] p-1 border border-[#eceeef]"},F={class:"text-center border border-[#eceeef] w-5/12"},I={class:"border border-[#eceeef]"},T={class:"p-1 border border-[#eceeef]"},$={class:"p-1 border border-[#eceeef]"},q={class:"p-1 border border-[#eceeef]"},E={class:"p-1 border border-[#eceeef]"},L={class:"p-1 border border-[#eceeef]"};function M(t,r,f,P,n,b){const m=c("JetSecondaryButton"),h=c("jet-dialog-modal");return d(),l("div",null,[i(h,{show:n.showDialog,onClose:r[1]||(r[1]=s=>n.showDialog=!1),maxWidth:"md"},{title:a(()=>[_(o(t.__("Bill Details")),1)]),content:a(()=>[e("table",S,[e("thead",k,[e("th",v,o(t.__("Item")),1),e("th",N,o(t.__("Unit")),1),e("th",V,o(t.__("Price")),1),e("th",j,o(t.__("Quantity")),1),e("th",x,o(t.__("Total")),1)]),e("tbody",F,[(d(!0),l(w,null,y(f.bill_details,s=>(d(),l("tr",I,[e("td",T,o(s.item.name),1),e("td",$,o(s.item.measurement_unit),1),e("td",q,o(s.purches_price),1),e("td",E,o(s.quantity),1),e("td",L,o(s.total),1)]))),256))])])]),footer:a(()=>[i(m,{class:"ml-2",onClick:r[0]||(r[0]=s=>b.close())},{default:a(()=>[_(o(t.__("Close")),1)]),_:1})]),_:1},8,["show"])])}const O=B(C,[["render",M]]);export{O as default};
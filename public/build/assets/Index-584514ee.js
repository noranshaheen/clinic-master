import{A as g}from"./AppLayout-b94f7417.js";import{C as w}from"./Confirm-84247334.js";import b from"./Edit-f6f19305.js";import{O as B}from"./inertiajs-tables-laravel-query-builder.es-c04de20d.js";import{J as k}from"./SecondaryButton-8a1eaf86.js";import{J as S}from"./Button-11813b5e.js";import{k as x,c as $,w as e,r,o as I,b as i,f as p,t as n,a as m,p as T,l as j}from"./app-010fad37.js";import{_ as J}from"./_plugin-vue_export-helper-c27b6911.js";import"./Edit-74f06fe7.js";import"./ActionMessage-517545cc.js";import"./ActionSection-2c866042.js";import"./SectionTitle-8abeab5a.js";import"./ConfirmationModal-0f300aca.js";import"./Modal-97755a3c.js";import"./DangerButton-367e534b.js";import"./DialogModal-22356253.js";import"./FormSection-bd296fee.js";import"./Input-8a286b7b.js";import"./Checkbox-ebdeef89.js";import"./InputError-317c03cf.js";import"./Label-e291ccc6.js";import"./SectionBorder-822e764c.js";import"./ValidationErrors-31471297.js";/* empty css            */import"./Edit-a73070bb.js";import"./TextField-f89d8302.js";import"./Edit-7abb2ae3.js";import"./Edit-18d907dc.js";import"./Edit-16ea2851.js";import"./Edit-b486f9ab.js";import"./vue3-multiselect.umd.min-939aa207.js";import"./Edit-ec7eaf71.js";import"./Edit-b040ada8.js";import"./Edit-67e94b24.js";import"./Edit-a5179c0a.js";/* empty css                                                                  */import"./Load-dcf8a148.js";import"./Load-b22526f9.js";import"./Edit-dd846932.js";import"./Upload-b17b92a3.js";import"./Upload-4dcf9d8b.js";import"./Upload-12291f8c.js";import"./Upload-1ea272cb.js";import"./Settings-f203d5a5.js";import"./Settings-3720bcf6.js";import"./Upload-3f1630e8.js";import"./Request-86128435.js";import"./Add-dd2dde44.js";import"./Load-a5c84528.js";import"./Upload-484af51f.js";import"./Load-6372f5e6.js";import"./sweetalert.min-679d9ee2.js";import"./ItemsMap-0f9ec3d1.js";import"./Upload-cd794d3e.js";import"./ItemsMap-5b7489db.js";import"./RequestEx-322cc660.js";const O={components:{EditCustomer:b,Confirm:w,AppLayout:g,Table:B,SecondaryButton:k,JetButton:S},props:{customers:Object},data(){return{customer:Object}},methods:{editCustomer(o){this.customer=o,this.$nextTick(()=>this.$refs.dlg2.ShowDialog())},removeCustomer(o){this.customer=o,this.$refs.dlg1.ShowModal()},remove(){x.delete(route("customers.destroy",{customer:this.customer.Id})).then(o=>{this.$store.dispatch("setSuccessFlashMessage",!0),setTimeout(()=>{window.location.reload()},500)}).catch(o=>{})},showColumn(o){if(!this.$inertia.page.props.queryBuilderProps.default.columns)return!1;const s=this.$inertia.page.props.queryBuilderProps.default.columns.find(a=>a.key===o);return s?!s.hidden:!1}}},u=o=>(T("data-v-efa6109f"),o=o(),j(),o),P={class:"py-4"},A={class:"mx-auto sm:px-6 lg:px-8"},D={class:"wrapper Gbg-white overflow-hidden shadow-xl sm:rounded-lg p-4"},N=u(()=>m("i",{class:"fa fa-edit"},null,-1)),V=u(()=>m("i",{class:"fa fa-trash"},null,-1));function q(o,s,a,E,d,c){const l=r("edit-customer"),_=r("confirm"),f=r("secondary-button"),h=r("jet-button"),y=r("Table"),v=r("app-layout");return I(),$(v,null,{default:e(()=>[i(l,{ref:"dlg2",customer:d.customer},null,8,["customer"]),i(_,{ref:"dlg1",onConfirmed:s[0]||(s[0]=t=>c.remove())},{default:e(()=>[p(n(o.__("Are you sure you want to delete this customer?")),1)]),_:1},512),m("div",P,[m("div",A,[m("div",D,[i(y,{resource:a.customers},{"cell(type)":e(({item:t})=>[p(n(t.type=="B"?o.__("Business"):t.type=="P"?o.__("Person"):o.__("Foreign Customer")),1)]),"cell(actions)":e(({item:t})=>[i(f,{onClick:C=>c.editCustomer(t)},{default:e(()=>[N,p(" "+n(o.__("Edit")),1)]),_:2},1032,["onClick"]),i(h,{class:"ms-2",onClick:C=>c.removeCustomer(t)},{default:e(()=>[V,p(" "+n(o.__("Delete")),1)]),_:2},1032,["onClick"])]),_:1},8,["resource"])])])])]),_:1})}const Lo=J(O,[["render",q],["__scopeId","data-v-efa6109f"]]);export{Lo as default};
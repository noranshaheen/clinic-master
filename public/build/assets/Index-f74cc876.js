import{A as y}from"./AppLayout-b94f7417.js";import{C as g}from"./Confirm-84247334.js";import v from"./Edit-dd846932.js";import{O as w}from"./inertiajs-tables-laravel-query-builder.es-c04de20d.js";import{J as x}from"./SecondaryButton-8a1eaf86.js";import{J as C}from"./Button-11813b5e.js";import{k as b,c as S,w as e,r,o as B,b as s,f as n,t as a,a as m,p as $,l as k}from"./app-010fad37.js";import{_ as I}from"./_plugin-vue_export-helper-c27b6911.js";import"./Edit-74f06fe7.js";import"./ActionMessage-517545cc.js";import"./ActionSection-2c866042.js";import"./SectionTitle-8abeab5a.js";import"./ConfirmationModal-0f300aca.js";import"./Modal-97755a3c.js";import"./DangerButton-367e534b.js";import"./DialogModal-22356253.js";import"./FormSection-bd296fee.js";import"./Input-8a286b7b.js";import"./Checkbox-ebdeef89.js";import"./InputError-317c03cf.js";import"./Label-e291ccc6.js";import"./SectionBorder-822e764c.js";import"./ValidationErrors-31471297.js";/* empty css            */import"./Edit-a73070bb.js";import"./TextField-f89d8302.js";import"./Edit-7abb2ae3.js";import"./Edit-18d907dc.js";import"./Edit-16ea2851.js";import"./Edit-b486f9ab.js";import"./vue3-multiselect.umd.min-939aa207.js";import"./Edit-ec7eaf71.js";import"./Edit-b040ada8.js";import"./Edit-f6f19305.js";import"./Edit-67e94b24.js";import"./Edit-a5179c0a.js";/* empty css                                                                  */import"./Load-dcf8a148.js";import"./Load-b22526f9.js";import"./Upload-b17b92a3.js";import"./Upload-4dcf9d8b.js";import"./Upload-12291f8c.js";import"./Upload-1ea272cb.js";import"./Settings-f203d5a5.js";import"./Settings-3720bcf6.js";import"./Upload-3f1630e8.js";import"./Request-86128435.js";import"./Add-dd2dde44.js";import"./Load-a5c84528.js";import"./Upload-484af51f.js";import"./Load-6372f5e6.js";import"./sweetalert.min-679d9ee2.js";import"./ItemsMap-0f9ec3d1.js";import"./Upload-cd794d3e.js";import"./ItemsMap-5b7489db.js";import"./RequestEx-322cc660.js";const T={components:{EditItem:v,Confirm:g,AppLayout:y,Table:w,SecondaryButton:x,JetButton:C},props:{items:Object},data(){return{item:Object}},methods:{editCustomer(t){this.item=t,this.$nextTick(()=>this.$refs.dlg2.ShowDialog())},removeCustomer(t){this.item=t,this.$refs.dlg1.ShowModal()},remove(){b.delete(route("items.destroy",{item:this.item.id})).then(t=>{this.$store.dispatch("setSuccessFlashMessage",!0),setTimeout(()=>{window.location.reload()},500)}).catch(t=>{})},showColumn(t){if(!this.$inertia.page.props.queryBuilderProps.default.columns)return!1;const o=this.$inertia.page.props.queryBuilderProps.default.columns.find(p=>p.key===t);return o?!o.hidden:!1}},created(){console.log(this.items)}},J=t=>($("data-v-6fcd3381"),t=t(),k(),t),N={class:"py-4"},O={class:"mx-auto sm:px-6 lg:px-8"},A={class:"wrapper Gbg-white shadow-xl sm:rounded-lg p-4"},V=J(()=>m("i",{class:"fa fa-edit"},null,-1));function j(t,o,p,q,c,d){const l=r("edit-item"),u=r("confirm"),_=r("secondary-button"),f=r("Table"),h=r("app-layout");return B(),S(h,null,{default:e(()=>[s(l,{ref:"dlg2",item:c.item},null,8,["item"]),s(u,{ref:"dlg1",onConfirmed:o[0]||(o[0]=i=>d.remove())},{default:e(()=>[n(a(t.__("Are you sure you want to delete this item?")),1)]),_:1},512),m("div",N,[m("div",O,[m("div",A,[s(f,{resource:p.items},{"cell(hidden)":e(({item:i})=>[n(a(i.hidden==0?"No":"Yes"),1)]),"cell(actions)":e(({item:i})=>[s(_,{onClick:D=>d.editCustomer(i)},{default:e(()=>[V,n(" "+a(t.__("Edit")),1)]),_:2},1032,["onClick"])]),_:1},8,["resource"])])])])]),_:1})}const Pt=I(T,[["render",j],["__scopeId","data-v-6fcd3381"]]);export{Pt as default};

import{A as w}from"./AppLayout-b94f7417.js";import{C}from"./Confirm-84247334.js";import b from"./Edit-7abb2ae3.js";import{O as k}from"./inertiajs-tables-laravel-query-builder.es-c04de20d.js";import{J as x}from"./SecondaryButton-8a1eaf86.js";import{J as S}from"./Button-11813b5e.js";import{k as B,c as $,w as o,r,o as I,b as s,f as p,t as n,a as m,p as T,l as D}from"./app-010fad37.js";import{_ as F}from"./_plugin-vue_export-helper-c27b6911.js";import"./Edit-74f06fe7.js";import"./ActionMessage-517545cc.js";import"./ActionSection-2c866042.js";import"./SectionTitle-8abeab5a.js";import"./ConfirmationModal-0f300aca.js";import"./Modal-97755a3c.js";import"./DangerButton-367e534b.js";import"./DialogModal-22356253.js";import"./FormSection-bd296fee.js";import"./Input-8a286b7b.js";import"./Checkbox-ebdeef89.js";import"./InputError-317c03cf.js";import"./Label-e291ccc6.js";import"./SectionBorder-822e764c.js";import"./ValidationErrors-31471297.js";/* empty css            */import"./Edit-a73070bb.js";import"./TextField-f89d8302.js";import"./Edit-18d907dc.js";import"./Edit-16ea2851.js";import"./Edit-b486f9ab.js";import"./vue3-multiselect.umd.min-939aa207.js";import"./Edit-ec7eaf71.js";import"./Edit-b040ada8.js";import"./Edit-f6f19305.js";import"./Edit-67e94b24.js";import"./Edit-a5179c0a.js";/* empty css                                                                  */import"./Load-dcf8a148.js";import"./Load-b22526f9.js";import"./Edit-dd846932.js";import"./Upload-b17b92a3.js";import"./Upload-4dcf9d8b.js";import"./Upload-12291f8c.js";import"./Upload-1ea272cb.js";import"./Settings-f203d5a5.js";import"./Settings-3720bcf6.js";import"./Upload-3f1630e8.js";import"./Request-86128435.js";import"./Add-dd2dde44.js";import"./Load-a5c84528.js";import"./Upload-484af51f.js";import"./Load-6372f5e6.js";import"./sweetalert.min-679d9ee2.js";import"./ItemsMap-0f9ec3d1.js";import"./Upload-cd794d3e.js";import"./ItemsMap-5b7489db.js";import"./RequestEx-322cc660.js";const j={components:{EditPatient:b,Confirm:C,AppLayout:w,Table:k,SecondaryButton:x,JetButton:S},props:{reseptionists:Object},data(){return{reseptionist:Object}},methods:{editCustomer(t){this.reseptionist=t,this.$nextTick(()=>this.$refs.dlg2.ShowDialog())},removeCustomer(t){this.reseptionist=t,this.$refs.dlg1.ShowModal()},remove(){B.delete(route("reseptionists.destroy",{reseptionist:this.reseptionist.id})).then(t=>{this.$store.dispatch("setSuccessFlashMessage",!0),setTimeout(()=>{window.location.reload()},500)}).catch(t=>{})},showColumn(t){if(!this.$inertia.page.props.queryBuilderProps.default.columns)return!1;const i=this.$inertia.page.props.queryBuilderProps.default.columns.find(a=>a.key===t);return i?!i.hidden:!1}}},c=t=>(T("data-v-68ec7ef9"),t=t(),D(),t),J={class:"py-4"},M={class:"mx-auto sm:px-6 lg:px-8"},O={class:"wrapper Gbg-white shadow-xl sm:rounded-lg p-4"},A=c(()=>m("i",{class:"fa fa-edit"},null,-1)),N=c(()=>m("i",{class:"fa fa-trash"},null,-1));function P(t,i,a,V,d,l){const _=r("edit-patient"),u=r("confirm"),f=r("secondary-button"),h=r("jet-button"),g=r("Table"),y=r("app-layout");return I(),$(y,null,{default:o(()=>[s(_,{ref:"dlg2",reseptionist:d.reseptionist},null,8,["reseptionist"]),s(u,{ref:"dlg1",onConfirmed:i[0]||(i[0]=e=>l.remove())},{default:o(()=>[p(n(t.__("Are you sure you want to delete this reseptionist ?")),1)]),_:1},512),m("div",J,[m("div",M,[m("div",O,[s(g,{resource:a.reseptionists},{"cell(gender)":o(({item:e})=>[p(n(e.gender=="F"?t.__("Female"):e.gender=="M"?t.__("Male"):null),1)]),"cell(date_of_birth)":o(({item:e})=>[p(n(new Date().getFullYear()-new Date(e.date_of_birth).getFullYear()),1)]),"cell(actions)":o(({item:e})=>[s(f,{onClick:v=>l.editCustomer(e)},{default:o(()=>[A,p(" "+n(t.__("Edit")),1)]),_:2},1032,["onClick"]),s(h,{class:"ms-2",onClick:v=>l.removeCustomer(e)},{default:o(()=>[N,p(" "+n(t.__("Delete")),1)]),_:2},1032,["onClick"])]),_:1},8,["resource"])])])])]),_:1})}const Yt=F(j,[["render",P],["__scopeId","data-v-68ec7ef9"]]);export{Yt as default};

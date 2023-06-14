import{D as M,A as S}from"./AppLayout-f49bf28b.js";import{O as C}from"./inertiajs-tables-laravel-query-builder.es-f3abfc1e.js";import{C as D}from"./Confirm-bf02ee04.js";import{J}from"./Label-df30c280.js";import{J as j}from"./SecondaryButton-713ac718.js";import{J as B}from"./Button-4bcf952d.js";import{J as $}from"./DangerButton-8bc4ac7b.js";import T from"./EditItemMap-b5ff43f8.js";import"./sweetalert.min-d55a1c1c.js";import{c as y,w as s,r as o,o as N,b as i,a as n,i as a,v as d,f as l,t as c}from"./app-150d5054.js";import{_ as V}from"./_plugin-vue_export-helper-c27b6911.js";import"./Edit-bcfc13f2.js";import"./ActionMessage-61e2ac70.js";import"./ActionSection-b2837b81.js";import"./SectionTitle-3e354ea0.js";import"./ConfirmationModal-25a9f4bd.js";import"./Modal-af9a88ec.js";import"./DialogModal-abac778c.js";import"./FormSection-88b4b82e.js";import"./Input-1c19b971.js";import"./Checkbox-4a56b901.js";import"./InputError-a5d97e62.js";import"./SectionBorder-e50f0f2f.js";import"./ValidationErrors-d148bef4.js";/* empty css            */import"./Edit-0682400b.js";import"./TextField-3250345e.js";import"./Edit-3c089fa6.js";import"./Edit-be99b5ee.js";import"./Edit-597f2255.js";import"./Edit-f9922137.js";import"./vue3-multiselect.umd.min-0e68115f.js";import"./Edit-faa18d1d.js";import"./Edit-cd91fcb4.js";import"./Edit-07cd30d2.js";import"./Edit-34545e2b.js";import"./Edit-db4f3217.js";/* empty css                                                                  */import"./Load-49470aa5.js";import"./Load-63f267b7.js";import"./Edit-ae599c19.js";import"./Upload-84ea7cbc.js";import"./Upload-9f5fa312.js";import"./Settings-16afee17.js";import"./Settings-c1b5727e.js";import"./Upload-ac8dd442.js";import"./Request-7a72620a.js";import"./Add-a5bec431.js";import"./Load-9cedd89f.js";import"./Upload-8acddc09.js";import"./Load-38871443.js";import"./ItemsMap-522638f4.js";import"./Upload-92e0933c.js";import"./ItemsMap-e43ca060.js";import"./RequestEx-92427893.js";const A={components:{Dropdown:M,AppLayout:S,Confirm:D,JetLabel:J,Table:C,JetButton:B,JetDangerButton:$,SecondaryButton:j,EditItemMap:T},props:{items:Object},data(){return{currentItem:{},notSortableCols:[]}},methods:{editItemMap(t){this.currentItem=t,this.$nextTick(()=>this.$refs.dlg2.ShowDialog())},deleteItemMap(t){this.currentItem=t,this.$refs.dlg4.ShowModal()},deleteItemMap2(){axios.post(route("ms.items.map.delete"),{MSCode:this.currentItem.MSCode}).then(t=>{this.$store.dispatch("setSuccessFlashMessage",!0),this.showDialog=!1,setTimeout(()=>{window.location.reload()},500)}).catch(t=>{this.$page.props.errors=t.response.data.errors,this.errors=t.response.data.errors})},nestedIndex:function(t,m){try{var e=m.split(".");return e.length==1?t[m].toString():e.length==2?t[e[0]][e[1]].toString():e.length==3?t[e[0]][e[1]][e[2]].toString():"Unsupported Nested Index"}catch{}return"N/A"},editItem:function(t){}}},O={class:"py-4"},E={class:"mx-auto sm:px-6 lg:px-8"},L={class:"bg-white overflow-hidden shadow-xl sm:rounded-lg p-4"};function F(t,m,e,_,u,p){const f=o("edit-item-map"),h=o("jet-label"),g=o("confirm"),I=o("jet-danger-button"),v=o("jet-button"),b=o("Table"),w=o("app-layout");return N(),y(w,null,{default:s(()=>[i(f,{ref:"dlg2",item_map:u.currentItem},null,8,["item_map"]),i(g,{ref:"dlg4",onConfirmed:m[0]||(m[0]=r=>p.deleteItemMap2())},{default:s(()=>[i(h,{for:"type",value:t.__("Are you sure you want to delete this item?")},null,8,["value"])]),_:1},512),n("div",O,[n("div",E,[n("div",L,[i(b,{resource:e.items},{"cell(actions)":s(({item:r})=>[a(i(I,{class:"me-2 mt-2",onClick:x=>p.deleteItemMap(r)},{default:s(()=>[l(c(t.__("Delete")),1)]),_:2},1032,["onClick"]),[[d,r.status!="Valid"&&r.status!="approved"]]),a(i(v,{class:"me-2 mt-2",onClick:x=>p.editItemMap(r)},{default:s(()=>[l(c(t.__("Edit")),1)]),_:2},1032,["onClick"]),[[d,r.status!="Valid"]])]),_:1},8,["resource"])])])])]),_:1})}const qt=V(A,[["render",F],["__scopeId","data-v-4ed6b973"]]);export{qt as default};

import{D as v,A as g}from"./AppLayout-336b7499.js";import{O as w}from"./inertiajs-tables-laravel-query-builder.es-72bd3d80.js";import{C}from"./Confirm-3a44cc87.js";import{J as D}from"./Label-c6c7e0c2.js";import{J as x}from"./SecondaryButton-fb7ef34d.js";import{J as y}from"./Button-fce1e67a.js";import{J as S}from"./DangerButton-bf3f8f1f.js";import $ from"./EditItem-90f272e4.js";import{s as A}from"./sweetalert.min-9f604034.js";import{c as B,w as i,r as p,o as J,b as a,a as u,t as s,f as n,i as l,v as _}from"./app-98cccb0d.js";import{_ as T}from"./_plugin-vue_export-helper-c27b6911.js";import"./Edit-7ca2eef9.js";import"./ActionMessage-529841b6.js";import"./ActionSection-14bbef3c.js";import"./SectionTitle-f26ec90c.js";import"./ConfirmationModal-2d2586d4.js";import"./Modal-2ccc6cf7.js";import"./DialogModal-9cb7d35f.js";import"./FormSection-60b88c5f.js";import"./Input-9c9fd5b2.js";import"./Checkbox-7ff4e1d6.js";import"./InputError-48880b4d.js";import"./SectionBorder-a45d0249.js";import"./ValidationErrors-ce3c07bd.js";import"./Edit-cfad98b4.js";import"./TextField-4dc08153.js";import"./Edit-04381c68.js";import"./Edit-c883850a.js";import"./Edit-663be45d.js";import"./Edit-833659c9.js";import"./vue3-multiselect.umd.min-89fe1e95.js";import"./Edit-e905c401.js";import"./Edit-fb9e1a40.js";import"./Edit-8b049cff.js";import"./Edit-7210d6e2.js";import"./Edit-9520adfe.js";/* empty css                                                                  */import"./Load-c81154ca.js";import"./Load-269b27e0.js";import"./Edit-470aa9e5.js";import"./Edit-ae0efa3b.js";import"./Upload-3f7847e9.js";import"./Upload-cab6aca1.js";import"./Upload-4bb109cf.js";import"./Upload-91640e3b.js";import"./Settings-281c0c2c.js";import"./Settings-3a181d36.js";import"./Upload-b3182070.js";import"./Request-264efc19.js";import"./Add-983c5f77.js";import"./Load-b9d12279.js";import"./Upload-0c9409a0.js";import"./Load-c588859c.js";import"./ItemsMap-ac429fa2.js";import"./Upload-69a7afe4.js";import"./ItemsMap-99c5c9fb.js";import"./RequestEx-4f93fb5e.js";/* empty css            */const j={components:{Dropdown:v,AppLayout:g,Confirm:C,JetLabel:D,Table:w,JetButton:y,JetDangerButton:S,SecondaryButton:x,EditItem:$},props:{items:Object,book:Object},data(){return{currentItem:{},notSortableCols:[]}},methods:{newItem(){this.currentItem=null,this.$nextTick(()=>this.$refs.dlg2.ShowDialog())},editItem(t){this.currentItem=t,this.$nextTick(()=>this.$refs.dlg2.ShowDialog())},approveItem(t){this.currentItem=t,this.currentItem.status="Approved",this.currentItem.attachment=null,this.currentItem.approved_by=this.$page.props.auth.user.id,this.currentItem.activities.forEach(o=>{o.contribution_percentage=o.pivot.contribution_percentage,o.accounting_activity_id=o.id}),axios.post(route("accounting.book.item.store",route().params.book),this.currentItem).then(o=>{this.$store.dispatch("setSuccessFlashMessage",!0)}).catch(o=>{this.currentItem.status=this.currentItem.status=="Active"?"Inactive":"Active",this.$page.props.errors=o.response.data.errors,this.errors=o.response.data.errors})},deleteItem(t){A({title:this.__("Warning"),text:this.__("Are you sure?"),icon:"warning",buttons:!0,dangerMode:!0}).then(o=>{o&&(this.currentItem=t,axios.post(route("accounting.book.item.delete",route().params.book),this.currentItem).then(r=>{this.$store.dispatch("setSuccessFlashMessage",!0),setTimeout(()=>{window.location.reload()},500)}).catch(r=>{this.$page.props.errors=r.response.data.errors,this.errors=r.response.data.errors}))})},downloadPDF(t){var o=route().params.book,r=t.id;window.open(route("accounting.book.item.download",[o,r]))},printItem(t){var o=route().params.book,r=t.id;window.open(route("accounting.book.item.print",[o,r]))}}},E={class:"py-4"},F={class:"mx-auto sm:px-6 lg:px-8"},O={class:"text-2xl text-center"},L={class:"bg-white overflow-hidden shadow-xl sm:rounded-lg p-4 mt-4"};function M(t,o,r,N,b,m){const f=p("edit-item"),c=p("jet-button"),h=p("jet-danger-button"),I=p("Table"),k=p("app-layout");return J(),B(k,null,{default:i(()=>[a(f,{ref:"dlg2",book_item:b.currentItem},null,8,["book_item"]),u("div",E,[u("div",F,[u("div",O,s(t.__("The book entries for "))+s(r.book.name),1),a(c,{onClick:o[0]||(o[0]=e=>m.newItem())},{default:i(()=>[n(s(t.__("Add Book Entry")),1)]),_:1}),u("div",L,[a(I,{resource:r.items},{"cell(transaction_date)":i(({item:e})=>[n(s(new Date(e.transaction_date).toLocaleDateString()),1)]),"cell(actions)":i(({item:e})=>[l(a(h,{class:"me-2 mt-2",onClick:d=>m.approveItem(e)},{default:i(()=>[n(s(t.__("Approve")),1)]),_:2},1032,["onClick"]),[[_,e.status=="Draft"]]),l(a(c,{class:"me-2 mt-2",onClick:d=>m.editItem(e)},{default:i(()=>[n(s(t.__("Edit")),1)]),_:2},1032,["onClick"]),[[_,e.status=="Draft"]]),a(h,{class:"me-2 mt-2",onClick:d=>m.deleteItem(e)},{default:i(()=>[n(s(t.__("Delete")),1)]),_:2},1032,["onClick"]),l(a(c,{class:"me-2 mt-2",onClick:d=>m.downloadPDF(e)},{default:i(()=>[n(s(t.__("Attachment")),1)]),_:2},1032,["onClick"]),[[_,e.attachment!=null]]),a(c,{class:"me-2 mt-2",onClick:d=>m.printItem(e)},{default:i(()=>[n(s(t.__("Print")),1)]),_:2},1032,["onClick"])]),_:1},8,["resource"])])])])]),_:1})}const zt=T(j,[["render",M]]);export{zt as default};
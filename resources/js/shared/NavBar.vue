<template>
  <nav class="bg-white shadow dark:bg-gray-800">
    <div class="container px-6 py-4 mx-auto">
      <div class="md:flex md:items-center md:justify-between">
        <div class="flex items-center justify-between">
          <div class="text-xl font-semibold text-gray-700">
            <Link :href="route('dashboard')" class="flex">
            <jet-application-mark class="w-10" />
            <span class="self-center ms-3">Clinic Master</span>
            </Link>
          </div>

          <!-- Mobile menu button -->
          <div class="flex md:hidden">
            <button @click="isOpen = !isOpen" type="button"
              class="text-gray-500 dark:text-gray-200 hover:text-gray-600 dark:hover:text-gray-400 focus:outline-none focus:text-gray-600 dark:focus:text-gray-400"
              aria-label="toggle menu">
              <svg viewBox="0 0 24 24" class="w-6 h-6 fill-current">
                <path fill-rule="evenodd"
                  d="M4 5h16a1 1 0 0 1 0 2H4a1 1 0 1 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2z">
                </path>
              </svg>
            </button>
          </div>
        </div>
        <div :class="!isOpen ? 'hidden' : ''" class="flex-1 md:flex md:items-center md:justify-between">
          <div class="flex flex-col -mx-4 md:flex-row md:items-center md:mx-5 mt-3 lg:mt-0">
            <Link v-if="$page.props.auth.user.current_team_id == 1" :href="route('dashboard')"
              :class="{ 'text-[#4099de]': $page.url === '/' }" class="grid justify-items-center ms-3 mb-3 lg:mb-0"><i
              class="fas fa-chart-pie"></i>{{ __("Dashboard") }}</Link>


            <!-- start dropdown menus -->
            <!-- doctor menu -->
            <dropdown :align="alignDropDown()" width="48" class="ms-3 mb-3 lg:mb-0">
              <template #trigger>
                <span class="grid justify-items-center cursor-pointer hover:text-[#4099de]" :class="{
                  'text-[#4099de]': $page.url.startsWith('/doctors'),
                }">
                  <!-- <i class="fa fa-user-doctor"></i> -->
                  <i class="fa fa-stethoscope"></i>
                  {{ __("Clinic") }}
                </span>
              </template>
              <template #content>
                <div class="pt-0 divide-y divide-gray-200">
                  <!-- doctor -->
                  <div>
                    <div class="p-1 border-b flex justify-between">
                      <p>{{ __("Doctors") }}</p>
                      <i class="fa-solid fa-caret-down cursor-pointer" @click="doctor = false" v-show="doctor"></i>
                      <i class="fa-solid fa-caret-left cursor-pointer" @click="doctor = true" v-show="!doctor"></i>
                    </div>
                    <div v-show="doctor">
                      <dropdown-link href="#" as="a" @click.prevent="openDlg('dlg1')">
                        <i class="fas fa-plus"></i>
                        {{ __("Add Doctor") }}
                      </dropdown-link>
                      <dropdown-link :href="route('doctors.index')">
                        <i class="fas fa-eye"></i>
                        {{ __("Show Doctors") }}
                      </dropdown-link>
                    </div>
                  </div>
                  <!-- patient -->
                  <div>
                    <div class="p-1 border-b flex justify-between">
                      <p>{{ __("Patients") }}</p>
                      <i class="fa-solid fa-caret-down cursor-pointer" @click="patient = false" v-show="patient"></i>
                      <i class="fa-solid fa-caret-left cursor-pointer" @click="patient = true" v-show="!patient"></i>
                    </div>
                    <div v-show="patient">
                      <dropdown-link href="#" as="a" @click.prevent="openDlg('dlg2')">
                        <i class="fas fa-plus"></i>
                        {{ __("Add Patient") }}
                      </dropdown-link>
                      <dropdown-link :href="route('patients.index')">
                        <i class="fas fa-eye"></i>
                        {{ __("Show Patients") }}
                      </dropdown-link>
                      <dropdown-link as="a" @click.prevent="openDlg('dlg14')" href="#">
                        <i class="fa fa-cloud-arrow-up"></i>
                        {{ __("Upload Patients") }}
                      </dropdown-link>
                    </div>
                  </div>
                  <!-- reseptionist -->
                  <div>
                    <div class="p-1 border-b flex justify-between">
                      <p>{{ __("Reseptionists") }}</p>
                      <i class="fa-solid fa-caret-down cursor-pointer" @click="reseptionist = false"
                        v-show="reseptionist"></i>
                      <i class="fa-solid fa-caret-left cursor-pointer" @click="reseptionist = true"
                        v-show="!reseptionist"></i>
                    </div>
                    <div v-show="reseptionist">
                      <dropdown-link href="#" as="a" @click.prevent="openDlg('dlg11')">
                        <i class="fas fa-plus"></i>
                        {{ __("Add Reseptionist") }}
                      </dropdown-link>
                      <dropdown-link :href="route('reseptionists.index')">
                        <i class="fas fa-eye"></i>
                        {{ __("Show Reseptionists") }}
                      </dropdown-link>
                    </div>
                  </div>
                  <!-- clinic -->
                  <div>
                    <div class="p-1 border-b flex justify-between">
                      <p>{{ __("Clinics") }}</p>
                      <i class="fa-solid fa-caret-down cursor-pointer" @click="clinic = false" v-show="clinic"></i>
                      <i class="fa-solid fa-caret-left cursor-pointer" @click="clinic = true" v-show="!clinic"></i>
                    </div>
                    <div v-show="clinic">
                      <dropdown-link href="#" as="a" @click.prevent="openDlg('dlg3')">
                        <i class="fas fa-plus"></i> <!-- Updated Font Awesome icon class -->
                        {{ __("Add Clinic") }}
                      </dropdown-link>
                      <dropdown-link :href="route('clinics.index')">
                        <i class="fas fa-eye"></i> <!-- Updated Font Awesome icon class -->
                        {{ __("Show Clinics") }}
                      </dropdown-link>
                    </div>
                  </div>
                  <!-- room -->
                  <div>
                    <div class="p-1 border-b flex justify-between">
                      <p>{{ __("Rooms") }}</p>
                      <i class="fa-solid fa-caret-down cursor-pointer" @click="room = false" v-show="room"></i>
                      <i class="fa-solid fa-caret-left cursor-pointer" @click="room = true" v-show="!room"></i>
                    </div>
                    <div v-show="room">
                      <dropdown-link href="#" as="a" @click.prevent="openDlg('dlg4')">
                        <i class="fas fa-plus"></i>
                        {{ __("Add Room") }}
                      </dropdown-link>
                      <dropdown-link :href="route('rooms.index')">
                        <i class="fas fa-eye"></i>
                        {{ __("Show Rooms") }}
                      </dropdown-link>
                    </div>
                  </div>
                  <!-- drug -->
                  <div>
                    <div class="p-1 border-b flex justify-between">
                      <p>{{ __("Drugs") }}</p>
                      <i class="fa-solid fa-caret-down cursor-pointer" @click="drug = false" v-show="drug"></i>
                      <i class="fa-solid fa-caret-left cursor-pointer" @click="drug = true" v-show="!drug"></i>
                    </div>
                    <div v-show="drug">
                      <dropdown-link href="#" as="a" @click.prevent="openDlg('dlg5')">
                        <i class="fas fa-plus"></i>
                        {{ __("Add Drug") }}
                      </dropdown-link>
                      <dropdown-link :href="route('drugs.index')">
                        <i class="fas fa-eye"></i>
                        {{ __("Show Drugs") }}
                      </dropdown-link>
                      <dropdown-link as="a" @click.prevent="openDlg('dlg12')" href="#">
                        <i class="fa fa-cloud-arrow-up"></i>
                        {{ __("Upload Drugs") }}
                      </dropdown-link>
                    </div>
                  </div>
                  <!-- diagnose -->
                  <div>
                    <div class="p-1 border-b flex justify-between">
                      <p>{{ __("Diagnosis") }}</p>
                      <i class="fa-solid fa-caret-down cursor-pointer" @click="diagnose = false" v-show="diagnose"></i>
                      <i class="fa-solid fa-caret-left cursor-pointer" @click="diagnose = true" v-show="!diagnose"></i>
                    </div>
                    <div v-show="diagnose">
                      <dropdown-link href="#" as="a" @click.prevent="openDlg('dlg6')">
                        <i class="fas fa-plus"></i>
                        {{ __("Add Diagnosis") }}
                      </dropdown-link>
                      <dropdown-link :href="route('diagnosis.index')">
                        <i class="fas fa-eye"></i>
                        {{ __("Show Diagnosis") }}
                      </dropdown-link>
                    </div>
                  </div>

                  <!-- prescription -->
                  <div>
                    <div class="p-1 border-b flex justify-between">
                      <p>{{ __("Prescriptions") }}</p>
                      <i class="fa-solid fa-caret-down cursor-pointer" @click="prescription = false"
                        v-show="prescription"></i>
                      <i class="fa-solid fa-caret-left cursor-pointer" @click="prescription = true"
                        v-show="!prescription"></i>
                    </div>
                    <div v-show="prescription">
                      <dropdown-link v-if="$page.props.auth.user.current_team_id == 2" as="a"
                        :href="route('prescriptions.create')">
                        <i class="fas fa-plus"></i>
                        {{ __("Add Prescription") }}
                      </dropdown-link>
                      <dropdown-link as="a" :href="route('prescriptions.index')">
                        <i class="fas fa-eye"></i>
                        {{ __("Show Prescriptions") }}
                      </dropdown-link>
                    </div>
                  </div>
                </div>

              </template>
            </dropdown>

            <!-- Appointment menu -->
            <dropdown :align="alignDropDown()" width="48" class="ms-3 mb-3 lg:mb-0">
              <template #trigger>
                <span class="grid justify-items-center cursor-pointer hover:text-[#4099de]" :class="{
                  'text-[#4099de]': $page.url.startsWith('/appointments'),
                }">
                  <i class="fa-solid fa-calendar-check"></i>
                  {{ __("Appointments") }}
                </span>
              </template>
              <template #content>
                <dropdown-link href="#" as="a" @click.prevent="openDlg('dlg7')">
                  <i class="fas fa-plus"></i>
                  {{ __("Add Appointment") }}
                </dropdown-link>
              </template>
            </dropdown>

            <!-- Bill -->
            <dropdown :align="alignDropDown()" width="48" class="ms-3 mb-3 lg:mb-0">
              <template #trigger>
                <span class="grid justify-items-center cursor-pointer hover:text-[#4099de]" :class="{
                  'text-[#4099de]': $page.url.startsWith('/bill'),
                }">
                  <i class="fa fa-file-invoice"></i>
                  {{ __("Reports") }}
                </span>
              </template>
              <template #content>
                <dropdown-link as="a" :href="route('bills.index')">
                  <!-- <i class="fas fa-plus"></i> -->
                  {{ __("Add Bill") }}
                </dropdown-link>
                <dropdown-link as="a" :href="route('bills.showAll')">
                  <!-- <i class="fas fa-plus"></i> -->
                  {{ __("Show Bills") }}
                </dropdown-link>
                <dropdown-link href="#" as="a" @click.prevent="openDlg('dlg13')">
                  <!-- <i class="fas fa-plus"></i> -->
                  {{ __("Add Item") }}
                </dropdown-link>
                <dropdown-link as="a" :href="route('items.showAll')">
                  <!-- <i class="fas fa-plus"></i> -->
                  {{ __("Show Items") }}
                </dropdown-link>
                <dropdown-link as="a" :href="route('bills.search')">
                  <!-- <i class="fa-solid fa-magnifying-glass mx-1"></i> -->
                  {{ __("Expensess & Incomes") }}
                </dropdown-link>
              </template>
            </dropdown>




            <!-- <dropdown :align="alignDropDown()" class="ms-3 mb-3 lg:mb-0">
              <template #trigger>
                <span
                  class="grid justify-items-center cursor-pointer hover:text-[#4099de]"
                  :class="{
                    'text-[#4099de]': $page.url.startsWith('/customers'),
                  }"
                >
                  <i class="fa fa-user-tie"></i>
                  {{ __("Customers") }}
                </span>
              </template>
              <template #content>
                <dropdown-link
                  as="a"
                  @click.prevent="openDlg('dlg1')"
                  :href="route('customers.create')"
                >
                  {{ __("Add New Customer") }}
                </dropdown-link>

                <dropdown-link :href="route('customers.index')">
                  {{ __("Show Customer") }}
                </dropdown-link>

                <dropdown-link as="a" :href="route('excel.customers')">
                  {{ __("Download") }}
                </dropdown-link>
                <dropdown-link
                  as="a"
                  @click.prevent="openDlg('dlg15')"
                  href="#"
                >
                  {{ __("Upload Customers") }}
                </dropdown-link>
              </template>
            </dropdown>
            <dropdown
              :align="alignDropDown()"
              width="48"
              class="ms-3 mb-3 lg:mb-0"
            >
              <template #trigger>
                <span
                  class="grid justify-items-center cursor-pointer hover:text-[#4099de]"
                  :class="{
                    'text-[#4099de]': $page.url.startsWith('/branches'),
                  }"
                >
                  <i class="fa fa-code-branch"></i>
                  {{ __("Branches") }}
                </span>
              </template>

              <template #content>
                <dropdown-link as="a" @click.prevent="openDlg('dlg2')" href="#">
                  {{ __("Add New Branch") }}
                </dropdown-link>

                <dropdown-link :href="route('branches.index')">
                  {{ __("Show Branches") }}
                </dropdown-link>
              </template>
            </dropdown>
            <dropdown
              :align="alignDropDown()"
              width="48"
              class="ms-3 mb-3 lg:mb-0"
              v-show="$page.props.e_invoice_enabled"
            >
              <template #trigger>
                <span
                  class="grid justify-items-center cursor-pointer hover:text-[#4099de]"
                  :class="{
                    'text-[#4099de]': invoiceConditions,
                  }"
                >
                  <i class="fa fa-file"></i>
                  {{ __("Invoices") }}
                </span>
              </template>

              <template #content>
                <dropdown-link :href="route('invoices.create')">
                  {{ __("Add New Invoice") }}
                </dropdown-link>
                <dropdown-link :href="route('eta.invoices.sent.index')">
                  {{ __("Show My Invoices") }}
                </dropdown-link>
                <dropdown-link :href="route('invoices.search')">
                  {{ __("Search Invoices") }}
                </dropdown-link>
                <dropdown-link :href="route('eta.invoices.received.index')">
                  {{ __("Show Paid Invoices") }}
                </dropdown-link>
                <dropdown-link as="a" @click.prevent="openDlg('dlg6')" href="#">
                  {{ __("Upload Invoices") }}
                </dropdown-link>
                <dropdown-link :href="route('invoices.excel.review')">
                  {{ __("Review Excel Files") }}
                </dropdown-link>
                <dropdown-link as="a" @click.prevent="openDlg('dlg5')" href="#">
                  {{ __("Load from ETA") }}
                </dropdown-link>
              </template>
            </dropdown>
            <dropdown
              :align="alignDropDown()"
              width="48"
              class="ms-3 mb-3 lg:mb-0"
              v-show="$page.props.e_receipt_enabled"
            >
              <template #trigger>
                <span
                  class="grid justify-items-center cursor-pointer hover:text-[#4099de]"
                  :class="{
                    'text-[#4099de]': receiptConditions,
                  }"
                >
                  <i class="fa fa-file"></i>
                  {{ __("Receipts") }}
                </span>
              </template>

              <template #content>
                <dropdown-link :href="route('eta.receipts.index')">
                  {{ __("Show My Receipts") }}
                </dropdown-link>
                <dropdown-link
                  as="a"
                  @click.prevent="openDlg('uploadReceipts')"
                  href="#"
                >
                  {{ __("Upload Receipts") }}
                </dropdown-link>
                <dropdown-link
                  as="a"
                  @click.prevent="openDlg('loadReceipts')"
                  href="#"
                >
                  {{ __("Load from ETA") }}
                </dropdown-link>
              </template>
            </dropdown>
            <dropdown
              :align="alignDropDown()"
              width="48"
              class="ms-3 mb-3 lg:mb-0"
            >
              <template #trigger>
                <span
                  class="grid justify-items-center cursor-pointer hover:text-[#4099de]"
                  :class="{
                    'text-[#4099de]': itemConditions,
                  }"
                >
                  <i class="fa fa-cube"></i>
                  {{ __("Items") }}
                </span>
              </template>
              <template #content>
                <dropdown-link as="a" @click.prevent="openDlg('dlg4')" href="#">
                  {{ __("Add New Item") }}
                </dropdown-link>
                <dropdown-link as="a" @click.prevent="openDlg('dlg7')" href="#">
                  {{ __("Upload Items") }}
                </dropdown-link>

                <dropdown-link
                  :href="
                    route('eta.items.index') +
                    '?page=1&columns%5B0%5D=itemCode&columns%5B1%5D=codeNamePrimaryLang&columns%5B2%5D=parentCodeNameSecondaryLang&columns%5B3%5D=activeTo&columns%5B4%5D=active&columns%5B5%5D=status'
                  "
                >
                  {{ __("Show Items") }}
                </dropdown-link>
                <dropdown-link as="a" @click.prevent="openDlg('dlg3')" href="#">
                  {{ __("Load from ETA") }}
                </dropdown-link>

                <dropdown-link as="a" :href="route('excel.items')">
                  {{ __("Download") }}
                </dropdown-link>
              </template>
            </dropdown>

            <dropdown
              :align="alignDropDown()"
              width="48"
              class="ms-3 mb-3 lg:mb-0"
              v-show="$page.props.inventory_enabled"
            >
              <template #trigger>
                <span
                  class="grid justify-items-center cursor-pointer hover:text-[#4099de]"
                  :class="{
                    'text-[#4099de]': inventoryConditions,
                  }"
                >
                  <i class="fa fa-warehouse"></i>
                  {{ __("Inventories") }}
                </span>
              </template>
              <template #content>
                <dropdown-link
                  as="a"
                  @click.prevent="openDlg('AddInventoryDlg')"
                  href="#"
                >
                  {{ __("Add New Inventory") }}
                </dropdown-link>
                <dropdown-link
                  as="a"
                  @click.prevent="openDlg('UploadInventoryBalanceDlg')"
                  href="#"
                >
                  {{ __("Upload Items Balance") }}
                </dropdown-link>

                <dropdown-link
                  :href="
                    route('eta.items.index') +
                    '?page=1&columns%5B0%5D=itemCode&columns%5B1%5D=codeNamePrimaryLang&columns%5B2%5D=parentCodeNameSecondaryLang&columns%5B3%5D=activeTo&columns%5B4%5D=active&columns%5B5%5D=status'
                  "
                >
                  {{ __("Show Inventories Balance") }}
                </dropdown-link>
              </template>
            </dropdown>

            <dropdown
              :align="alignDropDown()"
              width="48"
              class="ms-3 mb-3 lg:mb-0"
            >
              <template #trigger>
                <span
                  class="grid justify-items-center cursor-pointer hover:text-[#4099de]"
                  :class="{
                    'text-[#4099de]': $page.url.startsWith('/reports'),
                  }"
                >
                  <i class="fa fa-file-invoice"></i>
                  {{ __("Reports") }}
                </span>
              </template>
              <template #content>
                <dropdown-link :href="route('reports.summary.details')">
                  {{ __("Sales Summary") }}
                </dropdown-link>
                <dropdown-link :href="route('reports.summary.purchase')">
                  {{ __("Purchase Summary") }}
                </dropdown-link>
                <dropdown-link :href="route('reports.branches.sales')">
                  {{ __("Branches Summary") }}
                </dropdown-link>
                <dropdown-link :href="route('reports.customers.sales')">
                  {{ __("Customers Summary") }}
                </dropdown-link>
                <dropdown-link as="a" @click.prevent="openDlg('dlg9')" href="#">
                  {{ __("Invoice Settings") }}
                </dropdown-link>
              </template>
            </dropdown>
            <dropdown
              :align="alignDropDown()"
              width="48"
              class="ms-3 mb-3 lg:mb-0"
              v-show="$page.props.e_receipt_enabled"
            >
              <template #trigger>
                <span
                  class="grid justify-items-center cursor-pointer hover:text-[#4099de]"
                  :class="{
                    'text-[#4099de]': $page.url.startsWith('/pos'),
                  }"
                >
                  <i class="fa fa-cash-register"></i>
                  {{ __("POS") }}
                </span>
              </template>
              <template #content>
                <dropdown-link :href="route('pos.index')">
                  {{ __("Show POSs") }}
                </dropdown-link>
                <dropdown-link
                  as="a"
                  @click.prevent="openDlg('addPOS')"
                  href="#"
                >
                  {{ __("Add POS") }}
                </dropdown-link>
              </template>
            </dropdown>

            <dropdown
              :align="alignDropDown()"
              width="48"
              class="ms-3 mb-3 lg:mb-0"
              v-show="$page.props.mobis_enabled"
            >
              <template #trigger>
                <span
                  class="grid justify-items-center cursor-pointer hover:text-[#4099de]"
                  :class="{
                    'text-[#4099de]': mobisConditions,
                  }"
                >
                  <i class="fa fa-file"></i>
                  {{ __("MOBIS") }}
                </span>
              </template>

              <template #content>
                <dropdown-link :href="route('ms.items.map.index')">
                  {{ __("Show Items Map") }}
                </dropdown-link>
                <dropdown-link
                  as="a"
                  @click.prevent="openDlg('msItemsMapUploadDlg')"
                  href="#"
                >
                  {{ __("Upload Items Map") }}
                </dropdown-link>
                <dropdown-link as="a" :href="route('ms.items.map.download')">
                  {{ __("Download Items Map") }}
                </dropdown-link>
                <dropdown-link
                  as="a"
                  @click.prevent="openDlg('msLoadInvoicesDlg')"
                  href="#"
                >
                  {{ __("Upload Invoices") }}
                </dropdown-link>
              </template>
            </dropdown>

            <dropdown
              :align="alignDropDown()"
              width="48"
              class="ms-3 mb-3 lg:mb-0"
              v-show="$page.props.sales_buzz_enabled"
            >
              <template #trigger>
                <span
                  class="grid justify-items-center cursor-pointer hover:text-[#4099de]"
                  :class="{
                    'text-[#4099de]': salesBuzzConditions,
                  }"
                >
                  <i class="fa fa-file"></i>
                  {{ __("Sales Buzz") }}
                </span>
              </template>

              <template #content>
                <dropdown-link :href="route('sb.branches.map.index')">
                  {{ __("Show Branches Map") }}
                </dropdown-link>
                <dropdown-link :href="route('sb.items.map.index')">
                  {{ __("Show Items Map") }}
                </dropdown-link>
                <dropdown-link
                  as="a"
                  @click.prevent="openDlg('dlg14')"
                  href="#"
                >
                  {{ __("Upload Items Map") }}
                </dropdown-link>
                <dropdown-link as="a" :href="route('sb.items.map.download')">
                  {{ __("Download Items Map") }}
                </dropdown-link>
                <dropdown-link
                  as="a"
                  @click.prevent="openDlg('dlg13')"
                  href="#"
                >
                  {{ __("Load Invoices from Sales Buzz") }}
                </dropdown-link>
              </template>
            </dropdown>

            <dropdown
              :align="alignDropDown()"
              width="48"
              class="ms-3 mb-3 lg:mb-0"
            >
              <template #trigger>
                <span
                  class="grid justify-items-center cursor-pointer hover:text-[#4099de]"
                  :class="{
                    'text-[#4099de]': $page.url.startsWith('/archive'),
                  }"
                >
                  <i class="fa fa-box-archive"></i>
                  {{ __("Archives") }}
                </span>
              </template>
              <template #content>
                <dropdown-link :href="route('archive.index')">
                  {{ __("Show Archives") }}
                </dropdown-link>
                <dropdown-link
                  as="a"
                  @click.prevent="openDlg('dlg12')"
                  href="#"
                >
                  {{ __("Request Archive Preparation") }}
                </dropdown-link>
                <dropdown-link :href="route('archive.getArchiveRequests')">
                  {{ __("Show Archives (ETA)") }}
                </dropdown-link>
                <dropdown-link
                  as="a"
                  @click.prevent="openDlg('dlg11')"
                  href="#"
                >
                  {{ __("Request Archive Preparation (ETA)") }}
                </dropdown-link>
              </template>
            </dropdown> -->
          </div>

          <div class="flex flex-col md:flex-row md:items-center -mx-4 md:mx-5">
            <language-selector />
            <dropdown :align="$page.props.locale == 'en' ? 'right' : 'left'" class="ms-3">
              <template #trigger>
                <span class="cursor-pointer hover:text-blue-600 mb-1">
                  <i class="fa fa-user"></i>
                  <span class="hidden lg:inline p-2">
                    {{ $page.props.auth.user.name }}
                  </span>
                </span>
              </template>
              <template #content>
                <div class="p-2 bg-gray-100 lg:hidden font-bold border">
                  {{ $page.props.auth.user.name }}
                </div>
                <dropdown-link :href="route('profile.show')">
                  {{ __("Profile") }}
                </dropdown-link>

                <!-- <dropdown-link :href="route('api-tokens.index')" v-if="$page.props.auth.user.id == 1">
                  {{ __("API Tokens") }}
                </dropdown-link> -->

                <dropdown-link :href="route('users.index')">
                  {{ __("Users") }}
                </dropdown-link>
                <dropdown-link as="a" @click.prevent="openDlg('dlg10')" href="#">
                  {{ __("Settings") }}
                </dropdown-link>

                <dropdown-link as="a" @click.prevent="openDlg('dlg8')" href="#">
                  {{ __("Add New User") }}
                </dropdown-link>
                <div class="border-t border-gray-100"></div>
                <form @submit.prevent="logout">
                  <dropdown-link as="button">
                    <i class="fas fa-sign-out-alt"></i>
                    {{ __("Log Out") }}
                  </dropdown-link>
                </form>
              </template>
            </dropdown>
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
import { Link } from "@inertiajs/vue3";
import LanguageSelector from "@/Language/LanguageSelector.vue";
import Dropdown from "@/Jetstream/Dropdown.vue";
import DropdownLink from "@/Jetstream/DropdownLink.vue";
import JetApplicationMark from "@/Jetstream/ApplicationMark.vue";
import {
  VueCollapsiblePanelGroup,
  VueCollapsiblePanel,
} from '@dafcoe/vue-collapsible-panel';

export default {
  emits: ["open_dlg"],
  components: {
    Link,
    LanguageSelector,
    Dropdown,
    DropdownLink,
    JetApplicationMark,
    VueCollapsiblePanelGroup,
    VueCollapsiblePanel
  },
  data() {
    return {
      isOpen: false,
      doctor: false,
      patient: false,
      reseptionist: false,
      clinic: false,
      room: false,
      drug: false,
      diagnose: false,
      prescription: false
    };
  },
  methods: {
    logout() {
      axios.post(route("logout")).then((res) => {
        window.location.reload();
      });
    },
    alignDropDown() {
      return this.$page.props.locale == "en" ? "left" : "right";
    },
    openDlg($dlg) {
      this.$emit("open_dlg", $dlg);
    },
  },
  computed: {
    invoiceConditions() {
      return (
        this.$page.url.startsWith("/invoices") ||
        this.$page.url.startsWith("/ETA/Invoices")
      );
    },
    itemConditions() {
      return this.$page.url.startsWith("/ETA/Items");
    },
    inventoryConditions() {
      return this.$page.url.startsWith("/inventory/");
    },
    mobisConditions() {
      return this.$page.url.startsWith("/ms/");
    },
    salesBuzzConditions() {
      return this.$page.url.startsWith("/sb/");
    },
    accountingConditions() {
      return this.$page.url.startsWith("/accounting/");
    },
    receiptConditions() {
      return (
        this.$page.url.startsWith("/receipts") ||
        this.$page.url.startsWith("/ETA/Receipts")
      );
    },
  },
};
</script>

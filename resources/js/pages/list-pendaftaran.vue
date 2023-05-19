<template>
  <div class="bg-white">
    <div class="flex bg-gray-50 pb-5">
      <div class="w-full md:w-4/5 lg:w-3/5 md:mx-auto md:max-w-6xl p-4">
        <div class="pt-4 pb-0">
          <div class="flex ">
            <h2 class="flex-grow text-gray-900">
              List Pendaftaran
            </h2>
           <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"  @click="exportToExcel">
              <svg class="w-4 h-4 text-white inline mr-1 -mt-1" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M23 1.5q.41 0 .7.3.3.29.3.7v19q0 .41-.3.7-.29.3-.7.3H7q-.41 0-.7-.3-.3-.29-.3-.7V18H1q-.41 0-.7-.3-.3-.29-.3-.7V7q0-.41.3-.7Q.58 6 1 6h5V2.5q0-.41.3-.7.29-.3.7-.3zM6 13.28l1.42 2.66h2.14l-2.38-3.87 2.34-3.8H7.46l-1.3 2.4-.05.08-.04.09-.64-1.28-.66-1.29H2.59l2.27 3.82-2.48 3.85h2.16zM14.25 21v-3H7.5v3zm0-4.5v-3.75H12v3.75zm0-5.25V7.5H12v3.75zm0-5.25V3H7.5v3zm8.25 15v-3h-6.75v3zm0-4.5v-3.75h-6.75v3.75zm0-5.25V7.5h-6.75v3.75zm0-5.25V3h-6.75v3Z" fill="white"></path>
              </svg>
              Export Excel
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="flex bg-white">
      <div class="flex-grow w-full md:w-2/5 lg:w-2/5 md:mx-auto md:max-w-6xl px-4">
        <div class="mt-8 pb-0"  style="width: 100%; overflow-x: none;">
          <table ref="table" class="table-auto w-full">
               <thead><tr>
                  <!-- <td>No.</td> -->
                  <td>Nama</td>
                  <td>nama usaha</td>
                  <td>Email</td>
                  <td>Level</td>
                  <td>Aksi</td>
                  <!-- <td>provinsi</td>
                  <td>kabupaten</td>
                  <td>kecamatan</td>
                  <td>keluarahan</td>
                  <td>alamat lengkap</td>
                  <td>email usaha</td>
                  <td>no telp</td>
                  <td>no hp</td>
                  <td>jenis kelamin</td>
                  <td>nik</td>
                  <td>nib</td> -->
                </tr>
              </thead>
            </table>
        </div>
      </div>
    </div>
    <open-form-footer class="mt-8 border-t" />
  </div>
</template>

<script>
import store from '~/store'
import { mapGetters, mapState } from 'vuex'
import Fuse from 'fuse.js'
import Form from 'vform'
import axios from 'axios'
import * as XLSX from 'xlsx';
import $ from 'jquery';
import 'datatables.net';
import TextInput from '../components/forms/TextInput.vue'
import OpenFormFooter from '../components/pages/Footer.vue'
import ExtraMenu from '../components/pages/forms/show/ExtraMenu.vue'
import 'datatables.net-dt/css/jquery.dataTables.css';

const loadForms = function () {
  store.commit('open/forms/startLoading')
  store.dispatch('open/workspaces/loadIfEmpty').then(() => {
    store.dispatch('open/forms/loadIfEmpty', store.state['open/workspaces'].currentId)
  })
}

export default {
  components: { OpenFormFooter, TextInput, ExtraMenu },

  beforeRouteEnter (to, from, next) {
    loadForms()
    next()
  },
  middleware: 'auth',

  props: {
    metaTitle: { type: String, default: 'Your Forms' },
    metaDescription: { type: String, default: 'All of your Formss are here. Create new forms, or update your existing one!' }
  },

  data () {
    return {
      showEditFormModal: false,
      selectedForm: null,
      searchForm: new Form({
        search: ''
      }),
      selectedTags: [],
      users: [],
      dataTable: null
    }
  },

  mounted () {
    this.getData();
  },

  methods: {
    getData() {
      axios.get('/api/get-users')
        .then(response => {
          this.users = response.data;
          this.initDataTable();
        })
        .catch(error => console.error(error));
    },
    initDataTable() {
      this.dataTable = $(this.$refs.table).DataTable({
        data: this.users,
        columns: [
          // { data: 'id', className: 'px-4 py-2' },
          { data: 'name', className: 'px-4 py-2' },
          { data: 'nama_usaha', className: 'px-4 py-2' },
          { data: 'email', className: 'px-4 py-2' },
          { data: 'level', className: 'px-4 py-2' },
          // { data: 'nama_provinsi', className: 'px-4 py-2' },
          // { data: 'nama_kabupaten', className: 'px-4 py-2' },
          // { data: 'nama_kecamatan', className: 'px-4 py-2' },
          // { data: 'nama_kelurahan', className: 'px-4 py-2' },
          // { data: 'alamat_lengkap', className: 'px-4 py-2' },
          // { data: 'email_usaha', className: 'px-4 py-2' },
          // { data: 'no_telp', className: 'px-4 py-2' },
          // { data: 'no_hp', className: 'px-4 py-2' },
          // { data: 'jenis_kelamin', className: 'px-4 py-2' },
          // { data: 'nik', className: 'px-4 py-2' },
          // { data: 'nib', className: 'px-4 py-2' },

        ],
      });
    },
    exportToExcel() {
      const data = this.dataTable.data().toArray();
      const worksheet = XLSX.utils.json_to_sheet(data);
      const workbook = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(workbook, worksheet, 'Users');
      XLSX.writeFile(workbook, 'users.xlsx');
    },
    editForm (form) {
      this.selectedForm = form
      this.showEditFormModal = true
    },
    onTagClick (tag) {
      const idx = this.selectedTags.indexOf(tag)
      if (idx === -1) {
        this.selectedTags.push(tag)
      } else {
        this.selectedTags.splice(idx, 1)
      }
    },
    viewForm (form) {
      this.$router.push({name: 'forms.show', params: {slug: form.slug}})
    }
  },

  computed: {
    ...mapGetters({
      user: 'auth/user'
    }),
    ...mapState({
      forms: state => state['open/forms'].content,
      formsLoading: state => state['open/forms'].loading
    }),
    isFilteringForms () {
      return (this.searchForm.search !== '' && this.searchForm.search !== null) || this.selectedTags.length > 0
    },
    enrichedForms () {
      let enrichedForms = this.forms.map((form) => {
        form.workspace = this.$store.getters['open/workspaces/getById'](form.workspace_id)
        return form
      })

      // Filter by Selected Tags
      if (this.selectedTags.length > 0) {
        enrichedForms = enrichedForms.filter((item) => {
          return (item.tags && item.tags.length > 0) ? this.selectedTags.every(r => item.tags.includes(r)) : false
        })
      }

      if (!this.isFilteringForms || this.searchForm.search === '' || this.searchForm.search === null) {
        return enrichedForms
      }

      // Fuze search
      const fuzeOptions = {
        keys: [
          'title',
          'slug',
          'tags'
        ]
      }
      const fuse = new Fuse(enrichedForms, fuzeOptions)
      return fuse.search(this.searchForm.search).map((res) => {
        return res.item
      })
    },
    allTags () {
      return this.$store.getters['open/forms/getAllTags']
    }
  }
}
</script>

<style lang="scss">
		/*Overrides for Tailwind CSS */

		/*Form fields*/
		.dataTables_wrapper select,
		.dataTables_wrapper .dataTables_filter input {
			color: #4a5568;
			/*text-gray-700*/
			padding-left: 1rem;
			/*pl-4*/
			padding-right: 1rem;
			/*pl-4*/
			padding-top: .5rem;
			/*pl-2*/
			padding-bottom: .5rem;
			/*pl-2*/
			line-height: 1.25;
			/*leading-tight*/
			border-width: 2px;
			/*border-2*/
			border-radius: .25rem;
			border-color: #edf2f7;
			/*border-gray-200*/
			background-color: #edf2f7;
			/*bg-gray-200*/
		}

		/*Row Hover*/
		table.dataTable.hover tbody tr:hover,
		table.dataTable.display tbody tr:hover {
			background-color: #ebf4ff;
			/*bg-indigo-100*/
		}

		/*Pagination Buttons*/
		.dataTables_wrapper .dataTables_paginate .paginate_button {
			font-weight: 700;
			/*font-bold*/
			border-radius: .25rem;
			/*rounded*/
			border: 1px solid transparent;
			/*border border-transparent*/
		}

		/*Pagination Buttons - Current selected */
		.dataTables_wrapper .dataTables_paginate .paginate_button.current {
			color: #fff !important;
			/*text-white*/
			box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06);
			/*shadow*/
			font-weight: 700;
			/*font-bold*/
			border-radius: .25rem;
			/*rounded*/
			background: #667eea !important;
			/*bg-indigo-500*/
			border: 1px solid transparent;
			/*border border-transparent*/
		}

		/*Pagination Buttons - Hover */
		.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
			color: #fff !important;
			/*text-white*/
			box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06);
			/*shadow*/
			font-weight: 700;
			/*font-bold*/
			border-radius: .25rem;
			/*rounded*/
			background: #667eea !important;
			/*bg-indigo-500*/
			border: 1px solid transparent;
			/*border border-transparent*/
		}

		/*Add padding to bottom border */
		table.dataTable.no-footer {
			border-bottom: 1px solid #e2e8f0;
			/*border-b-1 border-gray-300*/
			margin-top: 0.75em;
			margin-bottom: 0.75em;
		}

		/*Change colour of responsive icon*/
		table.dataTable.dtr-inline.collapsed>tbody>tr>td:first-child:before,
		table.dataTable.dtr-inline.collapsed>tbody>tr>th:first-child:before {
			background-color: #667eea !important;
			/*bg-indigo-500*/
		}
</style>

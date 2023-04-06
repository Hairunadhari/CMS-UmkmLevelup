<style>
#table {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#table td, #table th {
  border: 1px solid #ddd;
  padding: 8px;
}

#table tr:nth-child(even){background-color: #f2f2f2;}

#table tr:hover {background-color: #ddd;}

#table th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #04AA6D;
  color: white;
}
</style>
  <template>
  <div class="bg-white">
    <div class="flex bg-gray-50 pb-5">
      <div class="w-full md:w-4/5 lg:w-3/5 md:mx-auto md:max-w-4xl p-4">
        <div class="pt-4 pb-0">
          <div class="flex ">
            <h2 class="flex-grow text-gray-900">
              List Pendaftaran
            </h2>
            <v-button v-track.create_form_click :to="{name:''}">
              <svg class="w-4 h-4 text-white inline mr-1 -mt-1" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M23 1.5q.41 0 .7.3.3.29.3.7v19q0 .41-.3.7-.29.3-.7.3H7q-.41 0-.7-.3-.3-.29-.3-.7V18H1q-.41 0-.7-.3-.3-.29-.3-.7V7q0-.41.3-.7Q.58 6 1 6h5V2.5q0-.41.3-.7.29-.3.7-.3zM6 13.28l1.42 2.66h2.14l-2.38-3.87 2.34-3.8H7.46l-1.3 2.4-.05.08-.04.09-.64-1.28-.66-1.29H2.59l2.27 3.82-2.48 3.85h2.16zM14.25 21v-3H7.5v3zm0-4.5v-3.75H12v3.75zm0-5.25V7.5H12v3.75zm0-5.25V3H7.5v3zm8.25 15v-3h-6.75v3zm0-4.5v-3.75h-6.75v3.75zm0-5.25V7.5h-6.75v3.75zm0-5.25V3h-6.75v3Z" fill="white"></path>
              </svg>
              Export Excel
            </v-button>
          </div>
        </div>
      </div>
    </div>
    <div class="flex bg-white">
      <div class="flex-grow w-full md:w-2/5 lg:w-2/5 md:mx-auto md:max-w-6xl px-4">
        <div class="mt-8 pb-0"  style="width: 100%; overflow-x: scroll;">
            <table id="table" class="table table-bordered table-hovered">
                <thead><tr>
                  <td>No.</td>
                  <td>Id user</td>
                  <td>Nama Lengkap</td>
                  <td>Provinsi</td>
                  <td>Kabupaten</td>
                  <td>Kelurahan</td>
                  <td>Kecamatan</td>
                  <td>Alamat lengkap</td>
                  <td>Nama Usaha</td>
                  <td>Email usaha</td>
                  <td>No Telp</td>
                  <td>No Hp (Paket Data)</td>
                  <td>Jenis Kelamin</td>
                  <td>NIK </td>
                  <td>NIB</td>
                  <td>Level UMKM</td>
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td>1</td>
                  <td>1</td>
                  <td>Arifin</td>
                  <td>Jakarta</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>Jalan</td>
                  <td>Toko tok</td>
                  <td>…@gmail.com</td>
                  <td>62839283289</td>
                  <td>08238283</td>
                  <td>Pria</td>
                  <td>3175823782</td>
                  <td>2983928</td>
                  <td>Beginner</td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>2</td>
                  <td>Test</td>
                  <td>Bekasi</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>Jalan</td>
                  <td>Toko tik</td>
                  <td>…@gmail.com</td>
                  <td>62839283289</td>
                  <td>0839283928</td>
                  <td>Pria</td>
                  <td>315787232</td>
                  <td>9824928</td>
                  <td>Observer</td>
                </tr>
              </tbody>
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
import TextInput from '../components/forms/TextInput.vue'
import OpenFormFooter from '../components/pages/Footer.vue'
import ExtraMenu from '../components/pages/forms/show/ExtraMenu.vue'

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
      selectedTags: []
    }
  },

  mounted () {},

  methods: {
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

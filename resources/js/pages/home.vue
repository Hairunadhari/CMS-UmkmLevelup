<template>
  <div class="bg-white">
    <div class="flex bg-gray-50 pb-5">
      <div class="w-full md:w-4/5 lg:w-3/5 md:mx-auto md:max-w-4xl p-4">
        <div class="pt-4 pb-0">
          <div class="flex">
            <h2 class="flex-grow text-gray-900">
              List Kuesioner
            </h2>
            <v-button v-track.create_form_click :to="{name:'forms.create'}">
              <svg class="w-4 h-4 text-white inline mr-1 -mt-1" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M6.99996 1.1665V12.8332M1.16663 6.99984H12.8333" stroke="currentColor" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
              Tambah Baru Kuesioner
            </v-button>
          </div>
          <small class="flex text-gray-500">Manajement Kuesioner.</small>
        </div>
      </div>
    </div>
    <div class="flex bg-white">
      <div class="w-full md:w-4/5 lg:w-3/5 md:mx-auto md:max-w-4xl px-4">
        <div class="mt-8 pb-0">
          <text-input v-if="forms.length > 0" class="mb-6" :form="searchForm" name="search" label="Search a Kuesioner"
                placeholder="Name of Kuesioner to search"
          />
          <div v-if="allTags.length > 0" class="mb-6">
            <div v-for="tag in allTags" :key="tag"
                :class="['text-white p-2 text-xs inline rounded-lg font-semibold cursor-pointer mr-2',{'bg-gray-500 dark:bg-gray-400':selectedTags.includes(tag), 'bg-gray-300 dark:bg-gray-700':!selectedTags.includes(tag)}]"
                title="Click for filter by tag(s)"
                @click="onTagClick(tag)"
            >
              {{ tag }}
            </div>
          </div>
          <div v-if="!formsLoading && enrichedForms.length === 0" class="flex flex-wrap justify-center max-w-4xl">
            <img loading="lazy" class="w-56"
                  :src="asset('img/pages/forms/search_notfound.png')" alt="search-not-found">
            <h3 class="w-full mt-4 text-center text-gray-900 font-semibold">No forms found</h3>
            <div v-if="isFilteringForms && enrichedForms.length === 0 && searchForm.search" class="mt-2 w-full text-center">
              Your search "{{searchForm.search}}" did not match any forms. Please try again.
            </div>
            <v-button v-if="forms.length === 0" class="mt-4" v-track.create_form_click :to="{name:'forms.create'}">
              <svg class="w-4 h-4 text-white inline mr-1 -mt-1" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M6.99996 1.1665V12.8332M1.16663 6.99984H12.8333" stroke="currentColor" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
              Tambah Baru Kuesioner
            </v-button>
          </div>
          <div v-else-if="forms.length > 0" class="mb-10">
            <div v-if="enrichedForms && enrichedForms.length">
              <div v-for="(form) in enrichedForms" :key="form.id"
                  class="mt-4 p-4 flex group bg-white hover:bg-gray-50 dark:bg-notion-dark items-center"
              >
                <div class="flex-grow items-center truncate cursor-pointer" role="button" @click.prevent="viewForm(form)">
                  <span class="font-semibold text-gray-900 dark:text-white">{{ form.title }}</span>
                  <ul class="flex text-gray-500">
                    <li class="pr-1">{{ form.views_count }} view{{ form.views_count > 0 ? 's' : '' }}</li>
                    <li class="list-disc ml-6 pr-1">{{ form.submissions_count }}
                      submission{{ form.submissions_count > 0 ? 's' : '' }}
                    </li>
                    <li class="list-disc ml-6 pr-1 text-blue-500" v-if="form.visibility=='draft'">Draft (not public)</li>
                    <li class="list-disc ml-6">Edited {{ form.last_edited_human }}</li>
                  </ul>
                  <div v-if="form.tags && form.tags.length > 0" class="mt-1">
                    <template v-for="(tag,i) in form.tags">
                      <div v-if="i<1" :key="tag"
                          class="bg-gray-300 dark:bg-gray-700 text-white px-2 py-1 mr-2 text-xs inline rounded-lg font-semibold"
                      >
                        {{ tag }}
                      </div>
                      <div v-if="i==1" :key="tag"
                          class="bg-gray-300 dark:bg-gray-700 text-white px-2 py-1 mr-2 text-xs inline rounded-lg font-semibold"
                      >
                        {{ form.tags.length-1 }} more
                      </div>
                    </template>
                  </div>
                </div>
                <extra-menu :form="form" :isMainPage="true" />
              </div>
            </div>
          </div>
          <div v-if="formsLoading" class="text-center">
            <loader class="h-6 w-6 text-nt-blue mx-auto" />
          </div>
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

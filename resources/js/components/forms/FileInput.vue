<template>
  <div :class="wrapperClass">
    <label v-if="label"
           :class="[theme.default.label,{'uppercase text-xs':uppercaseLabels, 'text-sm':!uppercaseLabels}]"
    >
      {{ label }}
      <span v-if="required" class="text-red-500 required-dot">*</span>
    </label>
    <span class="inline-block w-full rounded-md shadow-sm">
      <button type="button" aria-haspopup="listbox" aria-expanded="true" aria-labelledby="listbox-label" role="button"
              class="cursor-pointer relative flex"
              :class="[theme.default.input,{'ring-red-500 ring-2': hasValidation && form.errors.has(name)}]"
              :style="inputStyle" @click.self="showUploadModal=true"
      >
        <div v-if="currentUrl==null" class="h-6 text-gray-600 dark:text-gray-400 flex-grow truncate"
             @click.prevent="showUploadModal=true"
        >
          Upload {{ multiple ? 'file(s)' : 'a file' }} <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline"
                                                            fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor"
          >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"
            />
          </svg>
        </div>
        <template v-else-if="currentUrl !== null">
          <div :class="{ invisible: !hasDataFile }" class="flex-grow h-6 text-gray-600 dark:text-gray-400 truncate">
            <div>
              <a :href="'/api/open/forms/'+idForm+'/submissions/file/' + currentUrl[0]" target="_blank" rel="noreferrer">{{ currentUrl[0] }}</a>
            </div>
          </div>
          <div :class="{ invisible: !hasDataFile }">
            <a href="#" class="hover:text-nt-blue" role="button" @click.prevent="changeType">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor"
              >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                />
              </svg>
            </a>
          </div>

          <div :class="{ invisible: !emptyDataFile }" class="flex-grow h-6 text-gray-600 dark:text-gray-400 truncate" @click.prevent="showUploadModal=true">
            <div>
              <p v-if="files.length==1"><svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-6 w-6 inline mr-2 -mt-1" fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
              >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                />
              </svg>{{ files[0].file.name }} </p>
              <p v-else><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline mr-2 -mt-1" fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
              >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                />
              </svg>{{ files.length }} file(s)</p>
            </div>
          </div>
          <div :class="{ invisible: !emptyDataFile }">
            <a href="#" class="hover:text-nt-blue" role="button" @click.prevent="rollBack">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor"
              >
              <path fill="#555" fill-rule="evenodd" d="M2.31002808,4.32430661 L13.4291382,4.32430661 C14.9323222,4.3332202 16.3186188,4.84469604 17.588028,5.85873413 C19.4921417,7.37979126 20,9.77059937 20,10.6442261 C20,11.2266439 20,14.1119762 20,19.300223 C19.9151291,19.766741 19.6818447,20 19.3001469,20 C18.918449,20 18.6851647,19.766741 18.6002938,19.300223 C18.6002938,16.1679861 18.592187,13.2826538 18.5759735,10.6442261 C18.5759735,9.34576416 17.2865601,5.89025879 13.4291382,5.72167969 C9.59417725,5.72167969 5.94228109,5.72167969 2.47344971,5.72167969 C3.41463216,6.66485596 4.40236601,7.65355241 5.43665126,8.68776905 C5.59403992,8.84109497 5.7913208,9.24526978 5.49713135,9.60702515 C5.20294189,9.96878052 4.71875649,9.95317983 4.4470171,9.67740321 C4.26585751,9.49355213 2.83951314,8.06792704 0.167984009,5.40052795 C0.0559946696,5.29048603 -1.42108547e-14,5.13733214 -1.42108547e-14,4.94106628 C-1.42108547e-14,4.74480041 0.0684042783,4.57976658 0.205212835,4.44596479 L4.49057007,0.157913208 C4.80293532,-0.0733969681 5.11829572,-0.0577915898 5.43665126,0.204729343 C5.7550068,0.467250276 5.754871,0.797146264 5.43624386,1.19441731 L2.31002808,4.32430661 Z"/>
              </svg>
            </a>
          </div>
        </template>
        <template v-else>
          <div class="flex-grow h-6 text-gray-600 dark:text-gray-400 truncate" @click.prevent="showUploadModal=true">
            <div>
              <p v-if="files.length==1"><svg xmlns="http://www.w3.org/2000/svg"
                                             class="h-6 w-6 inline mr-2 -mt-1" fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor"
              >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                />
              </svg>{{ files[0].file.name }} </p>
              <p v-else><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline mr-2 -mt-1" fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
              >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                />
              </svg>{{ files.length }} file(s)</p>
            </div>
          </div>
          <div v-if="files.length>0">
            <a href="#" class="hover:text-nt-blue" role="button" @click.prevent="clearAll">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                   stroke="currentColor"
              >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                />
              </svg>
            </a>
          </div>
        </template>
      </button>
    </span>
    <small v-if="help" :class="theme.default.help">
      <slot name="help">{{ help }}</slot>
    </small>
    <has-error v-if="hasValidation" :form="form" :field="name" />

    <!--  Modal  -->
    <modal :portal-order="2" :show="showUploadModal" @close="showUploadModal=false">
      <h2 class="text-lg font-semibold">
        Upload {{ multiple ? 'file(s)' : 'a file' }}
      </h2>

      <div class="max-w-3xl mx-auto lg:max-w-none">
        <div class="sm:mt-5 sm:grid sm:grid-cols-1 sm:gap-4 sm:items-start sm:pt-5">
          <div class="mt-2 sm:mt-0 sm:col-span-2 mb-5">
            <div
              v-cloak
              class="w-full flex justify-center items-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md h-128"
              @dragover.prevent="onUploadDragoverEvent($event)"
              @drop.prevent="onUploadDropEvent($event)"
            >
              <div v-if="loading" class="text-gray-600 dark:text-gray-400">
                <loader class="h-6 w-6 mx-auto m-10" />
                <p class="text-center mt-6">
                  Uploading your file...
                </p>
              </div>
              <template v-else>
                <div
                  class="absolute rounded-full bg-gray-100 h-20 w-20 z-10 transition-opacity duration-500 ease-in-out"
                  :class="{
                    'opacity-100': uploadDragoverTracking,
                    'opacity-0': !uploadDragoverTracking
                  }"
                />
                <div class="relative z-20 text-center">
                  <input ref="actual-input" class="hidden" :multiple="multiple" type="file" :name="name"
                         :accept="acceptExtensions"
                         @change="manualFileUpload"
                  >
                  <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-24 w-24 text-gray-200" fill="none"
                       viewBox="0 0 24 24" stroke="currentColor"
                  >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"
                    />
                  </svg>
                  <p class="mt-5 text-sm text-gray-600">
                    <button
                      type="button"
                      class="font-semibold text-nt-blue hover:text-nt-blue-dark focus:outline-none focus:underline transition duration-150 ease-in-out"
                      @click="openFileUpload"
                    >
                      Upload {{ multiple ? 'file(s)' : 'a file' }}
                    </button>
                    or drag and drop
                  </p>
                  <p class="mt-1 text-xs text-gray-500">
                    Up to {{ mbLimit }}mb
                  </p>
                </div>
              </template>
            </div>
            <div v-if="files.length" class="mt-4">
              <div class="border rounded-md">
                <div v-for="file,index in files" class="flex p-2" :class="{'border-t':index!==0}">
                  <p class="flex-grow truncate text-gray-500">
                    {{ file.file.name }}
                  </p>
                  <div>
                    <a href="#" class="text-gray-400 dark:text-gray-600 hover:text-nt-blue flex" role="button"
                       @click.prevent="clearFile(index)"
                    >
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                           stroke="currentColor"
                      >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                        />
                      </svg>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </modal>
  </div>
</template>

<script>
import Modal from '../Modal.vue'
import inputMixin from '~/mixins/forms/input.js'
// import Hashids from 'hashids'
// const hashids = new Hashids()

export default {
  name: 'FileInput',

  components: { Modal },
  mixins: [inputMixin],
  props: {
    multiple: { type: Boolean, default: true },
    mbLimit: { type: Number, default: 5 },
    accept: { type: String, default: '' }
  },

  data: () => ({
    showUploadModal: false,
    emptyDataFile: false,
    hasDataFile: true,
    files: [],
    idForm: '',
    // formId : '',
    uploadDragoverTracking: false,
    uploadDragoverEvent: false,
    loading: false
  }),

  computed: {
    // valFiles () {
    //   return '/api/open/forms/35/submissions/file/' + this.form[this.name]
    // },
    formId () {
      return this.form.id
    },
    currentUrl () {
      return this.form[this.name]
    },
    acceptExtensions () {
      if (this.accept) {
        return this.accept.split(',').map((i) => {
          return '.' + i.trim()
        }).join(',')
      }
      return ''
    }
  },

  watch: {
    files: {
      deep: true,
      handler (files) {
        this.compVal = files.map(file => file.url)
      }
    }
  },

  created () {
    // const checkSub = this.$route.query.submission_id
    console.log(this.form)
    console.log(this.name)
    // const forms = { ...this.form };
    // delete forms[this.name];
    // this.form = forms
    this.idForm = document.querySelector('#form_id').getAttribute('data-id')
    // if (checkSub) {
    //   this.idUser = hashids.decode(checkSub)
    // } else {
    //   this.idUser = ''
    // }
  },

  methods: {
    changeType () {
      this.emptyDataFile = true
      this.hasDataFile = false
    },
    rollBack () {
      this.emptyDataFile = false
      this.hasDataFile = true
    },
    clearAll () {
      this.files = []
    },
    clearFile (index) {
      this.files.splice(index, 1)
    },
    onUploadDragoverEvent (e) {
      this.uploadDragoverEvent = true
      this.uploadDragoverTracking = true
    },
    onUploadDropEvent (e) {
      this.uploadDragoverEvent = false
      this.uploadDragoverTracking = false
      this.droppedFiles(e)
    },
    droppedFiles (e) {
      const droppedFiles = e.dataTransfer.files

      if (!droppedFiles) return

      for (let i = 0; i < droppedFiles.length; i++) {
        this.uploadFileToServer(droppedFiles.item(i))
      }
    },
    openFileUpload () {
      this.$refs['actual-input'].click()
    },
    manualFileUpload (e) {
      const files = e.target.files
      for (let i = 0; i < files.length; i++) {
        this.uploadFileToServer(files.item(i))
      }
    },
    uploadFileToServer (file) {
      this.loading = true
      this.storeFile(file).then(response => {
        if (!this.multiple) {
          this.files = []
        }
        this.files.push({
          file: file,
          url: file.name.split('.').slice(0, -1).join('.') + '_' + response.uuid + '.' + response.extension
        })
        this.showUploadModal = false
        this.loading = false
      }).catch((error) => {
        this.clearAll()
        this.showUploadModal = false
        this.loading = false
      })
    }
  }
}
</script>

<style lang="scss">
  .invisible {
    display: none;
  }
</style>

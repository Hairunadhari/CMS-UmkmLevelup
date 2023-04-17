<template>
  <div v-if="form" class="open-complete-form">
    <button type="button" @click="submitTemporary" class="rounded float-right mt-2 px-4 pt-2 pb-2 mx-1 bg-emerald-400 text-white">Simpan Sementara</button>
    <h1 v-if="!isHideTitle" class="mb-4 px-2" v-text="form.title" />
    <div v-if="isPublicFormPage && form.is_password_protected">
      <p class="form-description mb-4 text-gray-700 dark:text-gray-300 px-2">
        This form is protected by a password.
      </p>
      <div class="form-group flex flex-wrap w-full">
        <div class="relative mb-3 w-full px-2">
          <text-input :form="passwordForm" name="password" native-type="password" label="Password" />
        </div>
      </div>
      <div class="flex flex-wrap justify-center w-full text-center">
        <v-button @click="passwordEntered">
          Submit
        </v-button>
      </div>
    </div>

    <v-transition>
      <div v-if="!form.is_password_protected && form.password && !hidePasswordDisabledMsg"
           class="border shadow-sm p-2 my-4 flex items-center rounded-md bg-yellow-100 border-yellow-500"
      >
        <div class="flex flex-grow">
          <p class="mb-0 py-2 px-4 text-yellow-600">
            We disabled the password protection for this form because you are an owner of it.
          </p>
          <v-button color="yellow" @click="hidePasswordDisabledMsg=true">
            OK
          </v-button>
        </div>
      </div>
    </v-transition>

    <div v-if="isPublicFormPage && (form.is_closed || form.visibility=='closed')"
         class="border shadow-sm p-2 my-4 flex items-center rounded-md bg-yellow-100 border-yellow-500"
    >
      <div class="flex-grow">
        <p class="mb-0 py-2 px-4 text-yellow-600" v-html="form.closed_text" />
      </div>
    </div>

    <div v-if="isPublicFormPage && form.max_number_of_submissions_reached"
         class="border shadow-sm p-2 my-4 flex items-center rounded-md bg-yellow-100 border-yellow-500"
    >
      <div class="flex-grow">
        <p class="mb-0 py-2 px-4 text-yellow-600" v-html="form.max_submissions_reached_text" />
      </div>
    </div>

    <div v-if="getFormCleaningsMsg"
         class="border shadow-sm p-2 my-4 flex items-center rounded-md bg-yellow-100 border-yellow-500"
    >
      <div class="flex-grow">
        <p class="mb-0 py-2 px-4 text-yellow-600">
          You're seeing this because you are an owner of this form. <br>
          All your Pro features are de-activated when sharing this form: <br>

          <span v-html="getFormCleaningsMsg" />
        </p>
      </div>
      <div class="text-right">
        <v-button color="yellow" shade="light" @click="form.cleanings=false">
          Close
        </v-button>
      </div>
    </div>

    <transition
      v-if="!form.is_password_protected && (!isPublicFormPage || (!form.is_closed && !form.max_number_of_submissions_reached && form.visibility!='closed'))"
      enter-active-class="duration-500 ease-out"
      enter-class="translate-x-full opacity-0"
      enter-to-class="translate-x-0 opacity-100"
      leave-active-class="duration-500 ease-in"
      leave-class="translate-x-0 opacity-100"
      leave-to-class="translate-x-full opacity-0"
      mode="out-in"
    >
      <div v-if="!submitted" key="form">
        <p v-if="form.description && form.description !==''"
           class="form-description mb-4 text-gray-700 dark:text-gray-300 whitespace-pre-wrap px-2"
           v-html="form.description"
        />
        <open-form v-if="form"
                   :form="form"
                   :loading="loading"
                   :fields="form.properties"
                   :theme="theme"
                   @submit="submitForm"
        >
          <template #submit-btn="{submitForm}">
            <open-form-button :loading="loading" refs="submitButton" :theme="theme" :color="form.color" class="mt-2 px-8 mx-1"
                                @click.prevent="submitForm"
            >
              {{ form.submit_button_text }}
            </open-form-button>
          </template>
        </open-form>
        <p v-if="!form.no_branding" class="text-center w-full mt-2">
          <a href="#"
             class="text-gray-400 hover:text-gray-500 dark:text-gray-600 dark:hover:text-gray-500 cursor-pointer hover:underline text-xs"
             target="_blank"
          >
          <!-- Powered by <span class="font-semibold">Form Builder</span> -->
        </a>
        </p>
      </div>
      <div v-else key="submitted" class="px-2">
        <p class="form-description text-gray-700 dark:text-gray-300 whitespace-pre-wrap" v-html="form.submitted_text " />
        <open-form-button v-if="form.re_fillable" :theme="theme" :color="form.color" class="my-4" @click="restart">
          {{ form.re_fill_button_text }}
        </open-form-button>
        <p v-if="form.editable_submissions && submissionId" class="mt-5">
          <a target="_parent" :href="form.share_url+'?submission_id='+submissionId" class="text-nt-blue hover:underline">Edit submission</a>
        </p>
        <p v-if="!form.no_branding" class="mt-5">
          <!-- <a target="_parent" href="#" class="text-nt-blue hover:underline">Create your form for free with Form Builder</a> -->
        </p>
      </div>
    </transition>
  </div>
</template>
<!-- <template>
</template> -->

<script>
import Form from 'vform'
import OpenForm from './OpenForm.vue'
import OpenFormButton from './OpenFormButton.vue'
import { themes } from '~/config/form-themes.js'
import VButton from '../../common/Button.vue'
import VTransition from '../../common/transitions/VTransition.vue'
import FormPendingSubmissionKey from '../../../mixins/forms/form-pending-submission-key.js'
import Swal from 'sweetalert2'
import axios from 'axios'

export default {
  components: { VTransition, VButton, OpenFormButton, OpenForm },

  mixins: [FormPendingSubmissionKey],

  props: {
    form: { type: Object, required: true },
    creating: { type: Boolean, default: false } // If true, fake form submit
  },

  data () {
    return {
      loading: false,
      submitted: false,
      simpanSementara: false,
      text: 'Isian akan kami simpan, dan tidak dapat diubah lagi!',
      themes: themes,
      passwordForm: new Form({
        password: null
      }),
      hidePasswordDisabledMsg: false,
      submissionId: false,
      userId: '',
    }
  },

  computed: {
    isIframe () {
      return window.location !== window.parent.location || window.frameElement
    },
    theme () {
      return this.themes[this.themes.hasOwnProperty(this.form.theme) ? this.form.theme : 'default']
    },
    getFormCleaningsMsg () {
      if (this.form.cleanings && Object.keys(this.form.cleanings).length > 0) {
        let message = ''
        Object.keys(this.form.cleanings).forEach((key) => {
          const fieldName = key.charAt(0).toUpperCase() + key.slice(1)
          let fieldInfo = '<br/>' + fieldName + "<br/><ul class='list-disc list-inside'>"
          this.form.cleanings[key].forEach((msg) => {
            fieldInfo = fieldInfo + '<li>' + msg + '</li>'
          })
          message = message + fieldInfo + '<ul/>'
        })

        return message
      }
      return false
    },
    isPublicFormPage () {
      return this.$route.name === 'forms.show_public'
    },
    isHideTitle () {
      return this.form.hide_title || window.location.href.includes('hide_title=true')
    }
  },
  created() {
    this.userId = this.$route.params.id;
  },

  mounted () {
  },

  methods: {
    submitTemporary () {
      this.simpanSementara = true
      const submitButton = document.querySelector('#submitButton');
      if (submitButton) {
        submitButton.click();
      } else {
        console.error('Button not found');
      }
    },
    submitForm (form, onFailure, id) {
      if (this.simpanSementara === true) {
        this.loading = true
        this.closeAlert()
        form.post('/api/forms/' + this.form.slug + '/simpan-sementara' + '/' + this.userId).then((response) => {
          this.$logEvent('form_submission', {
            workspace_id: this.form.workspace_id,
            form_id: this.form.id
          })

          try {
            window.localStorage.removeItem(this.formPendingSubmissionKey)
          } catch (e) {}

          if (response.data.redirect && response.data.redirect_url) {
            window.location.href = response.data.redirect_url
          }

          if (response.data.submission_id) {
            this.submissionId = response.data.submission_id
          }

          this.loading = false
          this.submitted = true
          this.$emit('submitted', true)
        }).catch((error) => {
          if (error.response.data && error.response.data.message) {
            this.alertError(error.response.data.message)
          }
          this.loading = false
          // onFailure()
        })
      } else {
        Swal.fire({
          title: 'Apakah Anda yakin?',
          text: 'Isian akan kami simpan, dan tidak dapat diubah lagi!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, submit it!'
        }).then((result) => {
          if (result.isConfirmed) {
            if (this.creating) {
              this.submitted = true
              this.$emit('submitted', true)
              return
            }

            this.loading = true
            this.closeAlert()
            form.post('/api/forms/' + this.form.slug + '/answer' + '/' + this.userId).then((response) => {
              this.$logEvent('form_submission', {
                workspace_id: this.form.workspace_id,
                form_id: this.form.id
              })

              try {
                window.localStorage.removeItem(this.formPendingSubmissionKey)
              } catch (e) {}

              if (response.data.redirect && response.data.redirect_url) {
                window.location.href = response.data.redirect_url
              }

              if (response.data.submission_id) {
                this.submissionId = response.data.submission_id
              }

              this.loading = false
              this.submitted = true
              this.$emit('submitted', true)
            }).catch((error) => {
              if (error.response.data && error.response.data.message) {
                this.alertError(error.response.data.message)
              }
              this.loading = false
              onFailure()
            })
          }
        })
      }
    },
    restart () {
      this.submitted = false
      this.$emit('restarted', true)
    },
    passwordEntered () {
      if (this.passwordForm.password !== '' && this.passwordForm.password !== null) {
        this.$emit('password-entered', this.passwordForm.password)
      } else {
        this.addPasswordError('The Password field is required.')
      }
    },
    addPasswordError (msg) {
      this.passwordForm.errors.set('password', msg)
    }
  }
}
</script>

<style lang="scss">
.open-complete-form {
  .form-description {
    ol {
      @apply list-decimal list-inside;
    }

    ul {
      @apply list-disc list-inside;
    }
  }
}
</style>

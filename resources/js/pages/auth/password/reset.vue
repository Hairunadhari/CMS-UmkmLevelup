<template>
  <div>
    <div class="flex mt-6 mb-10">
      <div class="w-full md:w-2/3 md:mx-auto md:max-w-md px-4">
        <h1 class="my-6">
          {{ $t('reset_password') }}
        </h1>
        <form @submit.prevent="reset" @keydown="form.onKeydown($event)">
          <alert-success class="mb-4" :form="form" :message="status" />

          <!-- Email -->
          <text-input name="email" :form="form" :label="$t('email')" :required="true" />

          <!-- Password -->
          <text-input class="mt-8" native-type="password"
                      name="password" :form="form" :label="$t('password')" :required="true"
          />

          <!-- Password Confirmation-->
          <text-input class="mt-8" native-type="password"
                      name="password_confirmation" :form="form" :label="$t('confirm_password')" :required="true"
          />

          <!-- Submit Button -->
          <v-button class="w-full" :loading="form.busy">
            {{ $t('reset_password') }}
          </v-button>
        </form>
      </div>
    </div>
    <open-form-footer />
  </div>
</template>

<script>
import Form from 'vform'
import OpenFormFooter from '../../../components/pages/Footer.vue'
import SeoMeta from '../../../mixins/seo-meta.js'

export default {
  middleware: 'guest',
  components: {
    OpenFormFooter
  },

  mixins: [SeoMeta],

  data: () => ({
    metaTitle: 'Reset Password',
    status: '',
    form: new Form({
      token: '',
      email: '',
      password: '',
      password_confirmation: ''
    })
  }),

  created () {
    this.form.email = this.$route.query.email
    this.form.token = this.$route.params.token
  },

  methods: {
    async reset () {
      const { data } = await this.form.post('/api/password/reset')

      this.status = data.status

      this.form.reset()
    }
  }
}
</script>

<template>
  <div>
    <div class="flex mt-6 mb-10">
      <div class="w-full md:max-w-6xl mx-auto px-4 flex md:flex-row-reverse flex-wrap">
        <div class="w-full md:w-1/2 md:p-6">
          <div class="border rounded-md p-6 shadow-md sticky top-4">
            <h2 class="font-semibold text-2xl">
              Login to Back Office UMKM Go Online
            </h2>
            <small>Welcome back! Please enter your email and password.</small>

            <login-form />
          </div>
        </div>
        <div class="w-full md:w-1/2 md:p-6 mt-8 md:mt-0 ">
          <h1 class="font-bold">
            Back Office Apps
          </h1>
          <p class="text-gray-900 my-4 text-lg">
            #
          </p>
          <!-- <div class="flex flex-wrap justify-center">
            <p class="px-3 pb-3 text-sm text-gray-500">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2"
              >
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
              </svg>
              Unlimited forms
            </p>
            <p class="px-3 pb-3 text-sm text-gray-500">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2"
              >
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
              </svg>
              Unlimited fields
            </p>
            <p class="px-3 pb-3 text-sm text-gray-500">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2"
              >
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
              </svg>
              Unlimited submissions
            </p>
          </div> -->
        </div>
      </div>
    </div>
    <open-form-footer />
  </div>
</template>

<script>
import OpenFormFooter from '../../components/pages/Footer.vue'
import Testimonials from '../../components/pages/welcome/Testimonials.vue'
import LoginForm from './components/LoginForm.vue'
import SeoMeta from '../../mixins/seo-meta.js'

export default {
  components: {
    // OpenFormFooter,
    Testimonials,
    LoginForm
  },

  middleware: 'guest',

  mixins: [SeoMeta],

  data: () => ({
    metaTitle: 'Login',
  }),

  methods: {

  }
}
</script>

<template>
  <div class="flex flex-col min-h-screen">
    <div class="w-full md:max-w-3xl md:mx-auto px-4 mb-10 md:pb-20 md:pt-16 text-center flex-grow">
      <h1 class="text-4xl font-semibold">
        Thank you!
      </h1>
      <h4 class="text-xl mt-6">
        We're checking the status of your subscription please wait a moment...
      </h4>
      <div class="text-center">
        <loader class="h-6 w-6 text-nt-blue mx-auto mt-20" />
      </div>
    </div>
    <open-form-footer />
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import Footer from '../../components/pages/Footer.vue'
import SeoMeta from '../../mixins/seo-meta.js'

export default {
  components: { Footer },
  layout: 'default',
  middleware: 'auth',
  mixins: [SeoMeta],

  data: () => ({
    metaTitle: 'Subscription Success',
    interval: null
  }),

  mounted () {
    this.redirectIfSubscribed()
    this.interval = setInterval(() => this.checkSubscription(), 5000)
  },

  beforeDestroy () {
    clearInterval(this.interval)
  },

  methods: {
    async checkSubscription () {
      // Fetch the user.
      await this.$store.dispatch('auth/fetchUser')
      this.redirectIfSubscribed()
    },
    redirectIfSubscribed () {
      if (this.user.is_subscribed) {
        this.$logEvent('subscribed', { plan: this.user.has_enterprise_subscription ? 'enterprise' : 'pro' })
        this.$crisp.push(['set', 'session:event', [[['subscribed', { plan: this.user.has_enterprise_subscription ? 'enterprise' : 'pro' }, 'blue']]]])
        this.$router.push({ name: 'home' })

        if (this.user.has_enterprise_subscription) {
          this.alertSuccess('Awesome! Dude')
        } else {
          this.alertSuccess('Awesome! ')
        }
      }
    }
  },

  computed: {
    ...mapGetters({
      authenticated: 'auth/check',
      user: 'auth/user'
    })
  }
}
</script>

<template>
  <div>
    <div class="mt-6 flex flex-col">
      <div class="w-full md:max-w-3xl md:mx-auto px-4 md:pt-16 pb-10">
        <h1 class="sm:text-5xl mb-4">
          #
        </h1>
        <notion-page page-id="c65a499d39834e0b8978556a8d7af867" />
      </div>
    </div>
    <open-form-footer />
  </div>
</template>

<script>
import Footer from '../../components/pages/Footer.vue'

export default {
  components: { Footer },
  layout: 'default',

  props: {
    metaTitle: { type: String, default: 'Form Quisioneer builder' },
    metaDescription: { type: String, default: 'Description Here.....' }
  },

  data: () => ({
  }),

  computed: {},

  mounted () {
  }
}
</script>

<template>
  <div class="flex items-center">
    <input
      :id="id || name"
      :name="name"
      :checked="internalValue"
      type="checkbox"
      :class="sizeClasses"
      class="rounded border-gray-500 cursor-pointer"
      :disabled="trigRead"
      @click="handleClick"
    >
    <label :for="id || name" class="text-gray-700 dark:text-gray-300 ml-2" :class="{'cursor-not-allowed':disabled}">
      <slot />
    </label>
  </div>
</template>

<script>
export default {
  name: 'VCheckbox',

  props: {
    id: { type: String, default: null },
    name: { type: String, default: 'checkbox' },
    value: { type: [Boolean, String], default: false },
    checked: { type: Boolean, default: false },
    disabled: { type: Boolean, default: false },
    size: { type: String, default: 'normal' }
  },

  data: () => ({
    internalValue: false,
    trigRead: false
  }),

  computed: {
    sizeClasses () {
      if (this.size === 'small') {
        return 'w-3 h-3'
      }
      return 'w-5 h-5'
    }
  },

  watch: {
    value (val) {
      this.internalValue = val
    },

    checked (val) {
      this.internalValue = val
    },

    internalValue (val, oldVal) {
      // Support form data string checkbox (string 1 or 0)
      if (val === 0 || val === '0') val = false
      if (val === 1 || val === '1') val = true

      if (val !== oldVal) {
        this.$emit('input', val)
      }
    }
  },

  created () {
    this.internalValue = this.value

    if ('checked' in this.$options.propsData) {
      this.internalValue = this.checked
    }
    const checkread = this.$route.query.read
    if (checkread) {
      this.trigRead = true
    }
  },

  mounted () {
    this.$emit('input', this.internalValue)
  },

  methods: {
    handleClick (e) {
      this.$emit('click', e)

      if (!e.isPropagationStopped) {
        this.internalValue = e.target.checked
        this.$emit('input', this.internalValue)
      }
    }
  }
}
</script>

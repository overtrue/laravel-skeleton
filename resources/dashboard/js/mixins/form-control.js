export default {
  props: {
    value: {
      type: null,
    },
    editing: {
      type: Boolean,
      default: false,
    },
    field: {
      type: Object,
      required: true,
    },
    attributes: {
      type: Object,
      default() {
        return {}
      },
    },
    placeholder: String,
  },
  data() {
    return {
      input: this.value,
    }
  },
  watch: {
    input() {
      this.$emit('input', this.input)
      this.$emit('change', this.input)
    },
  },
}

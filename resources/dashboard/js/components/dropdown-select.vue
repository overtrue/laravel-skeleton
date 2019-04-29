<template>
  <el-dropdown @command="handleSelect">
    <span class="el-dropdown-link">
      <el-button plain>
        <span style="color:#999" v-if="prefix">{{ prefix }}：</span>
        {{ selectedLabel }} <i class="el-icon-arrow-down el-icon--right"></i>
      </el-button>
    </span>
    <el-dropdown-menu slot="dropdown">
      <el-dropdown-item v-for="item in items" :key="item.value" :command="item">
        {{ item.label }}
        <span class="check-icon">
          <i class="el-icon-check" v-if="selected.includes(item)"></i>
        </span>
      </el-dropdown-item>
    </el-dropdown-menu>
  </el-dropdown>
</template>

<script>
export default {
  props: {
    multiple: {
      type: Boolean,
      default: false
    },
    options: {
      type: Array,
      required: true
    },
    valueKey: {
      type: String,
      default: "value"
    },
    labelKey: {
      type: String,
      default: "label"
    },
    prefix: {
      type: String,
      default: null
    },
    checkAll: {
      type: [Boolean, String],
      default: true
    },
    value: {
      type: [Object, Array],
      default() {
        return undefined
      }
    }
  },
  data() {
    return {
      selected: this.formatValue(),
      items: [],
      checkAllItem: { label: "全部", value: undefined }
    }
  },
  methods: {
    handleSelect(item) {
      if (item.value === this.checkAllItem.value && !!this.checkAll) {
        return (this.selected = [])
      }

      if (!this.selected.includes(item)) {
        if (!this.multiple || item.value < 1) {
          this.selected = [item]
        } else {
          this.selected.some(i => i.value === this.checkAllItem.value) &&
            this.selected.splice(
              this.selected.find(i => i.value === this.checkAllItem.value),
              1
            )
          this.selected.push(item)
        }
      } else {
        this.selected.splice(this.selected.indexOf(item), 1)
      }

      this.$emit("change", this.multiple ? this.selected : this.selected[0])
    },
    formatValue() {
      if (!this.value) {
        return []
      }

      return typeof this.value === "array" ? this.value : [this.value]
    },
    formatOptions() {
      this.items = this.options.map(option => {
        return {
          label: option[this.labelKey],
          value: option[this.valueKey]
        }
      })

      this.prependCheckAllOption()
    },
    prependCheckAllOption() {
      if (this.selected.length <= 0 && this.checkAll) {
        this.items.includes(this.checkAllItem) ||
          this.items.unshift(this.checkAllItem)
      }
    }
  },
  watch: {
    selected() {
      if (this.selected.length <= 0 && this.checkAll) {
        this.selected = [this.checkAllItem]
      }
    },
    options() {
      this.formatOptions()
    }
  },
  computed: {
    selectedLabel() {
      return this.selected.map(item => item.label).join(",")
    }
  },
  mounted() {
    this.formatOptions()

    if (typeof this.checkAll === "string") {
      this.checkAllItem.label = this.checkAll
    }

    if (
      !this.value ||
      (typeof this.value === "object" &&
        this.value.value === this.checkAllItem.value)
    ) {
      this.selected = []
    }
  }
}
</script>

<style lang="scss" scoped>
.check-icon {
  display: inline-block;
  width: 10px;
  margin-left: 4px;
}
</style>

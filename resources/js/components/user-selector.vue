<template>
  <el-select filterable remote v-model="selected" :remote-method="searchUsers" :placeholder="placeholder">
    <el-option v-for="user in users" :key="user.id" :label="user.name" :value="onlyId ? user.id : user">
      <div class="flex items-center">
        <img :src="user.avatar" class="avatar mr-1" height="20"/> {{ user.id }}: {{ user.name.substr(0, 10) }} ({{ user.realname || '无' }})
      </div>
    </el-option>
  </el-select>
</template>
<script>
export default {
  props: {
    value: {
      type: [String, Number, Object]
    },
    onlyId: {
      type: Boolean,
      default: false
    },
    fromEvent: false,
    placeholder: {
      type: String,
      default: "请选择"
    }
  },
  data() {
    return {
      users: [],
      selected: this.value ? this.value : undefined
    }
  },
  watch: {
    value() {
      this.selected = this.value
      this.loadSelected()
    },
    selected() {
      this.$emit("input", this.selected)
      this.$emit("change", this.selected)
    }
  },
  methods: {
    searchUsers(query) {
      if (typeof query !== "string" && query.length < 1) {
        return
      }
      this.$resources.users
        .index({ search: query })
        .then(({ data }) => (this.users = data))
    },
    loadSelected() {
      if (typeof this.selected === "object") {
        this.users.find(u => u.id == this.selected.id) || this.users.push(this.selected)
      }

      if (["string", "number"].indexOf(typeof this.selected) > -1) {
        this.$resources.users
          .find(this.selected)
          .then(user => u => u.id == user.id || this.users.push(user))
          .then(() => (this.loading = false))
      }
    }
  },
  mounted() {
    this.loadSelected()
  }
}
</script>

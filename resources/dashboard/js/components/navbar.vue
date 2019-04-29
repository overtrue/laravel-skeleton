<template>
  <nav class="bd-navbar d-flex fixed-top p-2 align-items-center">
    <ul class="bd-navbar-nav flex-row">
      <li class="nav-item pr-1">
        <a class="nav-link" @click="toggleSidebar">
          <o-icon name="menu" />
        </a>
      </li>
    </ul>
    <div class="px-1 mr-auto mr-2">
      <o-search-input />
    </div>
    <el-dropdown class="mr-2">
      <span class="el-dropdown-link">
        <span class="m-r-1">超级管理员</span>
        <img alt="User" class="avatar ml-2" height="26" width="26" src="https://s3.amazonaws.com/uifaces/faces/twitter/hfalucas/128.jpg">
      </span>
      <el-dropdown-menu slot="dropdown">
        <el-dropdown-item><o-icon name="account" /> 个人资料</el-dropdown-item>
        <el-dropdown-item><o-icon name="settings" /> 设置</el-dropdown-item>
        <el-dropdown-item><o-icon name="logout-variant" /> 登出</el-dropdown-item>
      </el-dropdown-menu>
    </el-dropdown>
  </nav>
</template>

<script>
export default {
  methods: {
    toggleSidebar() {
      document.querySelector("#app").classList.toggle("collapsed")
      this.$localStorage.set(
        "nav-collapsed",
        document.querySelector("#app").classList.contains("collapsed")
      )
    }
  },
  mounted() {
    if (this.$localStorage.get("nav-collapsed", false, Boolean)) {
      document.querySelector("#app").classList.add("collapsed")
    }
  }
}
</script>


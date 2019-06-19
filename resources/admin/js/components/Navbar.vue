<template>
  <nav class="bd-navbar bg-white border-b flex h-16 sticky top px-4 mb-4 items-center">
    <ul class="bd-navbar-nav flex">
      <li class="nav-item pr-4">
        <a class="nav-link">
          <icon name="menu"/>
        </a>
      </li>
    </ul>
    <el-breadcrumb class="flex ml-3">
      <el-breadcrumb-item
        :key="index"
        :to="{ path: breadcrumb.path }"
        v-for="(breadcrumb, index) in breadcrumbs"
      >{{ breadcrumb.title }}</el-breadcrumb-item>
    </el-breadcrumb>

    <el-dropdown
      @command="handleUserAction"
      class="mr-4 ml-auto"
      v-if="user"
    >
      <span class="el-dropdown-link flex items-center">
        <span class="m-r-1">{{ user.name }}</span>
        <img
          :src="user.avatar || '/img/default-avatar.png' "
          alt="User"
          class="avatar ml-2 shadow-sm"
          height="26"
          width="26"
        >
      </span>
      <el-dropdown-menu slot="dropdown">
        <el-dropdown-item>
          <icon name="account"/>个人资料
        </el-dropdown-item>
        <el-dropdown-item>
          <icon name="settings"/>设置
        </el-dropdown-item>
        <el-dropdown-item command="logout">
          <icon name="logout-variant"/>登出
        </el-dropdown-item>
      </el-dropdown-menu>
    </el-dropdown>
  </nav>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
  computed: {
    ...mapGetters({ user: 'auth/user' }),
    breadcrumbs() {
      return this.$route.matched.map(item => {
        return {
          name: item.name,
          path: item.path,
          title: item.meta.title
        }
      })
    }
  },
  methods: {
    async handleUserAction(command) {
      switch (command) {
        case 'logout':
          await this.$store.dispatch('auth/logout')
          this.$router.push({ name: 'login' })
          break

        default:
          break
      }
    }
  }
}
</script>

<style lang="scss">
.bd-navbar {
  position: -webkit-sticky;
  position: sticky;
  top: 0;
  z-index: 1071;

  .navbar-nav .nav-link {
    padding-right: 0.5rem;
    padding-left: 0.5rem;
    color: #444;
    text-decoration: none;
  }

  .subnav-search {
    color: #343a40;
  }
}
</style>

<template>
  <el-menu
    :default-active="activeLink"
    :router="true"
    active-text-color="#FFF"
    background-color="#2d3748"
    class="bd-sidebar overflow-x-hidden min-h-screen fixed top-0"
    text-color="#cbd5e0"
    v-cloak
  >
    <div class="logo h-16 bg-gray-900 text-gray-300 flex items-center justify-center text-center">{{ $metaInfo.title }}</div>
    <div
      :key="menu.label"
      v-for="menu of menus"
    >
      <el-submenu
        :index="menu.label"
        v-if="menu['children']"
      >
        <template slot="title">
          <i :class="menu.icon" />
          <span class="nav-label">{{ menu.label }}</span>
        </template>
        <el-menu-item
          :index="submenu.route.name"
          :key="submenu.label"
          :route="submenu.route"
          v-for="submenu of menu['children']"
        >
          <i :class="submenu.icon" />
          <span slot="title">{{ submenu.label }}</span>
        </el-menu-item>
      </el-submenu>
      <el-menu-item
        :index="menu.route.name"
        :route="menu.route"
        v-else
      >
        <i :class="menu.icon" />
        <span slot="title">{{ menu.label }}</span>
      </el-menu-item>
    </div>
  </el-menu>
</template>

<script>
export default {
  watch: {
    $route(to, from) {
      this.activeLink = to.name
    }
  },
  mounted: function() {
    this.activeLink = this.$route.name
  },
  metaInfo() {
    const { appName } = window.config

    return {
      title: appName,
      titleTemplate: `%s · ${appName}`
    }
  },

  data() {
    return {
      loading: true,
      activeLink: this.$route.name,
      menus: [
        {
          label: '控制面板',
          icon: 'el-icon-pie-chart',
          route: { name: 'home' }
        },
        {
          label: '用户管理',
          icon: 'el-icon-user',
          route: { name: 'users.index' }
        },
        {
          label: '设置',
          icon: 'el-icon-setting',
          children: []
        }
      ]
    }
  }
}
</script>

<style lang="scss">
.bd-sidebar {
  width: 256px;

  .is-active {
    background: rgb(36, 44, 58) !important;
  }

  .el-menu-item span[class^='mdi-'],
  .el-submenu span[class^='mdi-'] {
    vertical-align: middle;
    margin-right: 5px;
    width: 24px;
    text-align: center;
    font-size: 18px;
  }
}
</style>

<template>
  <el-menu
    :default-active="activeLink"
    :router="true"
    active-text-color="#FFF"
    background-color="#2d3748"
    class="bd-sidebar overflow-x-hidden flex-shrink-0"
    text-color="#cbd5e0"
    v-cloak
  >
    <div class="logo text-gray-300 py-4 text-center">
      <div class="my-4">{{ $metaInfo.title }}</div>
    </div>
    <div
      :key="menu.label"
      v-for="menu of menus"
    >
      <el-submenu
        :index="menu.label"
        v-if="menu['children']"
      >
        <template slot="title">
          <Icon
            :name="menu.icon || 'chart-bubble'"
            class="mdi-lg mdi-fw"
          />
          <span class="nav-label">{{ menu.label }}</span>
        </template>
        <el-menu-item
          :index="submenu.route.name"
          :key="submenu.label"
          :route="submenu.route"
          v-for="submenu of menu['children']"
        >
          <Icon
            :name="submenu.icon || 'chart-bubble'"
            class="mdi-lg mdi-fw"
          />
          <span slot="title">{{ submenu.label }}</span>
        </el-menu-item>
      </el-submenu>
      <el-menu-item
        :index="menu.route.name"
        :route="menu.route"
        v-else
      >
        <Icon
          :name="menu.icon || 'chart-bubble'"
          class="mdi-lg mdi-fw"
        />
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
          route: { name: 'home' }
        },
        {
          label: '用户管理',
          icon: 'account',
          route: { name: 'users.index' }
        },
        {
          label: '设置',
          icon: 'settings',
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

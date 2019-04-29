<template>
  <nav class="bd-sidebar bg-dark shadow-sm p-0">
    <div class="logo text-primary py-4">
      <div>
        <o-icon name="chart-bubble" />
      </div>
      <div class="nav-label">Laravel One</div>
    </div>
    <ul class="sidebar-menu sticky-top">
      <template v-for="(group, key) of menus">
        <li class="nav-tag" :key="key">
          <div class="d-flex align-items-center">
            <o-icon name="circle-small"></o-icon><span>{{ key }}</span>
          </div>
        </li>
        <li v-for="menu of group" :key="menu.label">
          <router-link title="Dashboards" :to="route(menu)" class="d-flex align-items-center">
            <o-icon class="mdi-lg mdi-fw" :name="menu.icon || 'chart-bubble'" />
            <span class="nav-label">{{ menu.label }}</span>
            <!-- <o-icon name="chevron-right icon-arrow" v-if="menu['children']" /> -->
          </router-link>
        </li>
      </template>
    </ul>
  </nav>
</template>

<script>
export default {
  data() {
    return {
      loading: true,
      menus: []
    }
  },
  methods: {
    loadMenus() {
      axios.get("/one/menus").then(({ data }) => (this.menus = data))
    },
    route(menu) {
      if (menu["resource"]) {
        return {
          name: "one.items.index",
          params: { resourceName: menu.resource }
        }
      } else if (menu["route"]) {
        return { name: menu.route }
      }

      return { path: menu.path || "#" }
    }
  },
  mounted() {
    this.loadMenus()
  }
}
</script>

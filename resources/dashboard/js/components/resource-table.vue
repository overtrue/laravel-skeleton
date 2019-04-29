<template>
  <div class="resource-index">
    <div class="d-flex align-items-center justify-content-between mb-1">
      <h2>{{ resourceLabel }}</h2>
      <o-item-btn-create :resource-name="resourceName" label="新建用户" />
    </div>
    <div class="resource-table card table-responsive">
      <div class="d-flex justify-content-between">
        <div class="d-flex">
          <o-resource-scopes :resource-label="resourceLabel" :resource-name="resourceName" v-model="query.scope" class="mr-1"></o-resource-scopes>

          <el-button plain class="mr-1">
            <o-icon name="package-down">导出</o-icon>
          </el-button>

          <el-dropdown class="mr-1" v-if="resource && Object.keys(resource.actions).length > 0" @command="handleSelectAction">
            <el-button plain>
              <o-icon name="play">批量操作</o-icon>
            </el-button>
            <el-dropdown-menu slot="dropdown">
              <el-dropdown-item v-for="(action, label) in resource.actions" :key="label" :command="action">{{ label }}</el-dropdown-item>
            </el-dropdown-menu>
          </el-dropdown>

          <o-search-input class="mr-1" v-model="query.q"></o-search-input>

          <o-dropdown-select multiple :options="[{value: 'pending', label: '处理中'}, {value: 'success', label: '已完成'}, {value: 'cancelled', label: '已取消'}]" prefix="订单状态" class="mr-1"></o-dropdown-select>
        </div>
        <div class="d-flex"></div>
      </div>
      <div class="d-flex justify-content-between my-1">
        <div class="flex-grow-1 d-flex align-items-center">
          <slot name="table-actions-left"></slot>
        </div>
        <div>
          <slot name="table-actions-right"></slot>
        </div>
      </div>

      <el-table :data="items.data" class="border w-100" v-if="resource" highlight-current-row @selection-change="handleSelectionChange">
        <el-table-column type="selection" align="center" width="65" />
        <el-table-column :prop="item.field.name" :align="item.field.align" :sortable="item.field.sortable" :label="item.field.label" v-for="(item, name) of resource.layouts.list" :key="item.field.name">
          <template slot-scope="scope">
            <component :is="'o-field-'+(item.field.type || 'text')" :value="scope.row[item.field.name]"></component>
          </template>
        </el-table-column>
        <el-table-column label="操作" width="220" fixed="right" align="center">
          <template slot-scope="scope">
            <o-item-btn-view :resource-name="resourceName" :resource-id="scope.row.id" size="mini"></o-item-btn-view>
            <o-item-btn-edit :resource-name="resourceName" :resource-id="scope.row.id" size="mini"></o-item-btn-edit>
            <o-item-btn-delete :resource-name="resourceName" :resource-id="scope.row.id" size="mini" @deleted="loadResourceItems"></o-item-btn-delete>
            <el-dropdown>
              <span class="el-dropdown-link">
                <el-button plain class="only-icon" size="mini">
                  <o-icon name="dots-vertical" />
                </el-button>
              </span>
              <el-dropdown-menu slot="dropdown">
                <el-dropdown-item>其它操作</el-dropdown-item>
              </el-dropdown-menu>
            </el-dropdown>
          </template>
        </el-table-column>
      </el-table>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    resourceName: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      filters: [],
      fields: [],
      query: {
        scope: "all",
        q: ""
      },
      selected: [],
      resource: null,
      fieldKeys: [],
      query: Object.assign({}, this.$route.query || {}),
      items: {
        data: [],
        meta: {
          last_page: 1,
          total: 0
        }
      }
    }
  },
  computed: {
    resourceLabel() {
      return this.resource
        ? this.resource.label || this.resourceName
        : this.resourceName
    }
  },
  watch: {
    $route(to, from) {
      if (to.path != from.path) {
        this.loadResource()
        this.loadResourceItems()
      }
    },
    query: {
      deep: true,
      handler(query) {
        this.$router.replace({ query: query })
        this.loadResourceItems()
      }
    }
  },
  methods: {
    loadResource() {
      return axios
        .get(`/one/resources/${this.resourceName}`)
        .then(({ data }) => {
          this.resource = data
        })
    },
    loadResourceItems() {
      return axios
        .get(`/one/items/${this.resourceName}`, { params: this.query })
        .then(({ data }) => {
          this.items = data
        })
    },
    handleSelectionChange(selected) {
      this.selected = selected
    },
    handleSelectAction(action) {
      if (this.selected.length < 1) {
        return
      }
      this.executeAction(action, this.selected).then(() => (this.selected = []))
    },
    executeAction(action, items) {
      return axios.post(`/one/items/${this.resourceName}/batch`, {
        action: action,
        id: items.map(item => item.id)
      })
    }
  },
  mounted() {
    this.loadResource()
    this.loadResourceItems()
  }
}
</script>

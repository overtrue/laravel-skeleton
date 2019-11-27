<template>
  <div class="page">
    <div class="flex items-center justify-between mb-2">
      <h2>用户列表</h2>
    </div>

    <div class="flex items-center justify-between mb-4">
      <div class="flex w-1/2 items-center">
        <el-button
          @click="handleCreate"
          plain
          type="primary"
        >
          <Icon name="plus"></Icon>新建用户
        </el-button>
        <SearchInput
          class="w-64 ml-2"
          placeholder="昵称/真实姓名/手机号/身份证号"
          v-model="query.search"
        ></SearchInput>
        <el-select
          class="ml-2"
          v-model="query.gender"
        >
          <el-option
            label="全部"
            value="all"
          ></el-option>
          <el-option
            label="男"
            value="male"
          ></el-option>
          <el-option
            label="女"
            value="female"
          ></el-option>
        </el-select>
      </div>
    </div>

    <el-table
      :data="items.data"
      @selection-change="handleSelectionChange"
      class="border w-full"
      highlight-current-row
      ref="table"
      stripe
    >
      <el-table-column
        label="ID"
        min-width="80"
        prop="id"
      ></el-table-column>
      <el-table-column
        label="账号"
        min-width="120"
        prop="username"
      >
        <template slot-scope="scope">
          <div class="flex items-center">
            <img
              :src="scope.row.avatar"
              alt="Avatar"
              class="avatar mr-4"
              height="30"
              width="30"
            >
            {{ scope.row.username }}
          </div>
        </template>
      </el-table-column>
      <el-table-column
        label="昵称"
        min-width="120"
        prop="name"
      ></el-table-column>
      <el-table-column
        align="center"
        label="手机号"
        min-width="180"
        prop="display_phone"
      ></el-table-column>
      <el-table-column
        align="center"
        label="真实姓名"
        min-width="100"
        prop="display_realname"
      ></el-table-column>
      <el-table-column
        align="center"
        label="性别"
        min-width="60"
        prop="display_gender"
      >
        <template slot-scope="scope">
          <span v-if="scope.row.gender === 'none'">未知</span>
          <icon
            class="text-blue-500"
            name="gender-male"
            v-else-if="scope.row.gender === 'male'"
          ></icon>
          <icon
            class="text-pink-500"
            name="gender-female"
            v-else-if="scope.row.gender === 'female'"
          ></icon>
        </template>
      </el-table-column>
      <el-table-column
        align="center"
        label="最后活跃时间"
        min-width="180"
        prop="display_last_active_at"
      ></el-table-column>
      <el-table-column
        align="center"
        label="创建时间"
        min-width="180"
        prop="created_at"
      ></el-table-column>
      <el-table-column
        align="center"
        fixed="right"
        label="操作"
        min-width="220"
      >
        <template slot-scope="scope">
          <el-button
            @click="handleEdit(scope.row)"
            plain
            size="mini"
            type="primary"
          >编辑</el-button>
          <DeleteButton
            @confirmed="handleDelete(scope.row)"
            class="text-red-500"
            size="mini"
          >删除</DeleteButton>
          <!--<el-dropdown>-->
          <!--<span class="el-dropdown-link">-->
          <!--<el-button plain class="only-icon" size="mini">-->
          <!--<icon name="dots-vertical" />-->
          <!--</el-button>-->
          <!--</span>-->
          <!--<el-dropdown-menu slot="dropdown">-->
          <!--<el-dropdown-item>其它操作</el-dropdown-item>-->
          <!--</el-dropdown-menu>-->
          <!--</el-dropdown>-->
        </template>
      </el-table-column>
    </el-table>

    <Pagination
      :items="items"
      @change="page => query.page = page"
      class="mt-4 text-right"
    />
  </div>
</template>

<script>
export default {
  name: 'users.index',
  data() {
    return {
      selected: [],
      query: Object.assign(
        {
          scope: 'all',
          per_page: 20,
          page: 1,
          search: '',
          gender: 'all'
        },
        this.$route.query || {}
      ),
      items: {
        data: [],
        meta: {
          last_page: 1,
          total: 0
        }
      }
    }
  },
  watch: {
    $route(to, from) {
      if (to.path != from.path) {
        this.loadItems()
      }
    },
    query: {
      deep: true,
      handler(query) {
        this.$router.replace({ query: query })
        this.loadItems()
      }
    }
  },
  methods: {
    handleView(row) {
      this.$refs.table.toggleRowExpansion(row)
    },
    handleCreate() {
      this.$router.push({ name: 'users.create' })
    },
    handleEdit(user) {
      this.$router.push({ name: 'users.edit', params: { id: user.id } })
    },
    handleDelete(user) {
      this.$resources.users.destroy(user.id).then(() => {
        this.$message.success('已删除')
        this.loadItems()
      })
    },
    loadItems() {
      this.$resources.users.index(this.query).then(items => {
        this.items = items
      })
    },
    handleSelectionChange(selected) {
      this.selected = selected
    }
  },
  mounted() {
    this.loadItems()
  }
}
</script>

<style scoped>
</style>

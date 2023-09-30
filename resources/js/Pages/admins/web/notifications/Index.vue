<template>
    <layout-admin>
      <div class="md:shadow h-[90%] md:h-[97.5%]">
        <div class="m-3">
            <div class="grid grid-cols-4 gap-2">
                <div class="col-span-2 ">
                    <el-input
                    v-model="search"
                    placeholder="Tìm kiếm"
                    :suffix-icon="Search"
                    />
                </div>
                <div>
                    <el-button @click="searchEnter">Search</el-button>
                </div>
            </div>
            <div class="mt-2 mb-2">
                <el-button>
                  <Link :href="route('admin.notice.create')">Create</Link>
                </el-button>
            </div>
            <el-table :data="tableData.data" style="width: 100%" @cell-click="hoverRow">
                <el-table-column prop="id" label="ID" width="80">
                    <template #header>
                    <div @click="sortButton('id')">
                        ID <el-icon><DCaret /></el-icon>
                    </div>
                    </template>
                </el-table-column>
                <el-table-column prop="title" label="Title" width="500">
                    <template #header>
                    <div @click="sortButton('title')">
                        Title <el-icon><DCaret /></el-icon>
                    </div>
                    </template>
                </el-table-column>
                <el-table-column prop="status_name" label="Status" width="100"/>
                <el-table-column prop="email" label="created_by" width="250">
                    <template #header>
                    <div @click="sortButton('email')">
                      created by <el-icon><DCaret /></el-icon>
                    </div>
                    </template>
                </el-table-column>
                <el-table-column prop="created_at" label="created_at" width="250">
                    <template #header>
                    <div @click="sortButton('created_at')">
                        created_at <el-icon><DCaret /></el-icon>
                    </div>
                    </template>
                </el-table-column>
                <el-table-column prop="updated_at" label="updated_at" width="250">
                    <template #header>
                    <div @click="sortButton('updated_at')">
                        updated_at <el-icon><DCaret /></el-icon>
                    </div>
                    </template>
                </el-table-column>
                <el-table-column prop="right" label="Operations" fixed="right" width="130px">
                    <template #default="scope">
                      <div class="grap-3">
                        <el-button link type="primary" size="small" @click="SendNotification(scope.row.id)">Send</el-button>
                        <Link :href="route('admin.notice.edit', scope.row.id)"><el-button link type="primary" size="small">Edit</el-button></Link>
                        <el-button link type="primary" size="small" @click="deleteCategory(scope.row.id)">Delete</el-button>
                      </div>
                    </template>
                </el-table-column>
            </el-table>
            <div v-if="tableData.last_page > 1">
              <el-pagination
                background
                layout="prev, pager, next"
                :total="tableData.total ?? 0"
                :page-size="tableData.per_page"
                class="mt-4"
                @current-change="changePage"
              />
            </div>
            <el-dialog v-model="showModel">
              <template #header="{ titleId, titleClass }">
                <div class="my-header">
                  <h4 :id="titleId" :class="titleClass">Title: {{ rowData.title }}</h4>
                </div>
              </template>
              <small v-if="rowData.status == 0">Status: Unsent</small>
              <small v-if="rowData.status == 1">Status: Sent</small>
              <p>Content: <span v-html="rowData.content ?? '...'"></span></p>
              <p>Receiver: <span v-for="(user, index) in rowData.users" :key="index">
                {{ user.username }}, 
              </span>
              <span v-for="(user, index) in rowData.authors" :key="index">
                {{ user.username }}, 
              </span></p>
            </el-dialog>
        </div>
      </div>
    </layout-admin>
</template>

<script setup>
  import axios from 'axios';
  import { ref, watchEffect } from 'vue';
  import layoutAdmin from '../../layout/layoutAdmin.vue'
  import { Search, DCaret, CircleCloseFilled } from '@element-plus/icons-vue'
  import { Link } from '@inertiajs/vue3';
  import { ElMessage } from 'element-plus';

  const tableData = ref([])

  const rowData = ref({})

  const showModel = ref(false)

  const search = ref('')

  const dataInput = ref({
    search: '',
    column: '',
    sort: 'desc',
    page: 1,
  })

  const getCategories = () => {
    axios.get(route('admin.notice.api.lists', dataInput.value))
    .then(function(response){
      tableData.value = response.data
      console.log(response.data);
    }).catch(function(error){
      console.log(error)
    })
  }

  const sortButton = (column) => {
    dataInput.value.sort = dataInput.value.sort == 'desc' ? 'asc' : 'desc'

    dataInput.value.column = column

  }

  const searchEnter = () => {
    dataInput.value.search = search.value
  }

  const changePage = (page) => {
    dataInput.value.page = page;
  }

  const deleteCategory = (id) => {
    axios.delete(route('admin.notice.api.delete', id))
    .then(function(response){
        ElMessage.success(response.data.success)
        // console.log(response.data.success)
        getCategories()
    }).catch(function(error){
        console.log(error);
    })
  }

  const SendNotification = (id) => {
    axios.get(route('admin.notice.api.send', id))
    .then(function(response){
        ElMessage.success(response.data.success)
        // console.log(response.data.success)
        getCategories()
    }).catch(function(error){
        console.log(error);
    })
  }

  const hoverRow = (data, column) => {
    if(column.label != 'Operations'){
      rowData.value = data;
      showModel.value = true
    }
  }

  watchEffect(getCategories);


</script>

<style scoped>
.my-header {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
}
</style>

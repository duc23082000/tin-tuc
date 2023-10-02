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
              <Link :href="route('author.post.create')">
                <el-button>
                  Create
                </el-button>
              </Link>
            </div>
            <el-table :data="tableData.data" v-loading="loading" style="width: 100%">
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
                <el-table-column prop="name" label="Category" width="150">
                    <template #header>
                    <div @click="sortButton('categories.name')">
                      Category <el-icon><DCaret /></el-icon>
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
                <el-table-column prop="email2" label="modified_by" width="250">
                    <template #header>
                    <div @click="sortButton('email2')">
                      modified by <el-icon><DCaret /></el-icon>
                    </div>
                    </template>
                </el-table-column>
                <el-table-column prop="created_at" label="created_at" width="100">
                    <template #header>
                    <div @click="sortButton('created_at')">
                        created_at <el-icon><DCaret /></el-icon>
                    </div>
                    </template>
                </el-table-column>
                <el-table-column prop="updated_at" label="updated_at" width="100">
                    <template #header>
                    <div @click="sortButton('updated_at')">
                        updated_at <el-icon><DCaret /></el-icon>
                    </div>
                    </template>
                </el-table-column>
                <el-table-column prop="right" fixed="right" label="Operations" width="120">
                    <template #default="scope">
                      <Link :href="route('author.post.edit', scope.row.id)"><el-button link type="primary" size="small">Edit</el-button></Link>
                    <el-button link type="primary" size="small" @click="deleteCategory(scope.row.id)">Delete</el-button>
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
            
        </div>
      </div>
    </layout-admin>
</template>

<script setup>
  import axios from 'axios';
  import { ref, watchEffect } from 'vue';
  import layoutAdmin from '../../layout/layoutAdmin.vue'
  import { Search, DCaret } from '@element-plus/icons-vue'
  import { Link } from '@inertiajs/vue3';
  import { ElMessage } from 'element-plus';

  const loading = ref(true);

  const tableData = ref([])

  const handleClick = () => {

  console.log('click')
  }

  const search = ref('')

  const dataInput = ref({
    search: '',
    column: '',
    sort: 'desc',
    page: 1,
  })

  const getCategories = () => {
    axios.get(route('admin.post.api.list', dataInput.value))
    .then(function(response){
      tableData.value = response.data
      loading.value = false;
      // console.log(response.data);
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
    axios.delete(route('author.post.api.delete', id))
    .then(function(response){
        ElMessage.success(response.data.success)
        // console.log(response.data.success)
        getCategories()
    }).catch(function(error){
        console.log(error);
    })
  }

  watchEffect(getCategories);


</script>

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
                    <Link :href="route('admin.author.create')">Create</Link>
                </el-button>
            </div>
            <el-table :data="tableData.data" v-loading="loading" style="width: 100%">
                <el-table-column prop="id" label="ID" width="80">
                    <template #header>
                    <div @click="sortButton('id')">
                        ID <el-icon><DCaret /></el-icon>
                    </div>
                    </template>
                </el-table-column>
                <el-table-column prop="username" label="User Name" width="200">
                    <template #header>
                    <div @click="sortButton('username')">
                      User Name <el-icon><DCaret /></el-icon>
                    </div>
                    </template>
                </el-table-column>
                <el-table-column prop="email" label="Email" width="300">
                    <template #header>
                    <div @click="sortButton('email')">
                      Email <el-icon><DCaret /></el-icon>
                    </div>
                    </template>
                </el-table-column>
                <el-table-column prop="created_at" label="created_at" width="300">
                    <template #header>
                    <div @click="sortButton('created_at')">
                        created_at <el-icon><DCaret /></el-icon>
                    </div>
                    </template>
                </el-table-column>
                <el-table-column prop="updated_at" label="updated_at" width="300">
                    <template #header>
                    <div @click="sortButton('updated_at')">
                        updated_at <el-icon><DCaret /></el-icon>
                    </div>
                    </template>
                </el-table-column>
                <el-table-column prop="right" fixed="right" label="Operations" width="120">
                    <template #default="scope">
                        <Link :href="route('admin.author.edit', scope.row.id)"><el-button link type="primary" size="small">Edit</el-button></Link>
                    <el-button link type="primary" size="small" @click="deleteAuthor(scope.row.id)">Delete</el-button>
                    </template>
                </el-table-column>
            </el-table>
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

  const tableData = ref([])

  const loading = ref(true)

  const search = ref('')

  const dataInput = ref({
    search: '',
    column: '',
    sort: 'desc',
  })

  const getAuthors = () => {
    axios.get(route('admin.author.api.list', dataInput.value))
    .then(function(response){
      tableData.value = response.data
      loading.value = false
      console.log(response.data.data)
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

  const deleteAuthor = (id) => {
    axios.delete(route('admin.author.api.delete', id))
    .then(function(response){
        ElMessage.success(response.data.success)
        console.log(response.data.success)
        getAuthors()
    }).catch(function(error){
        console.log(error);
    })
  }

  watchEffect(getAuthors);


</script>

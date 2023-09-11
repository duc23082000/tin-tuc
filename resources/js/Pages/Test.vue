<template>
    <layout-admin>
      <div class="shadow">
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
        <el-table :data="tableData.data" style="width: 100%">
          <el-table-column fixed prop="id" label="ID" width="80">
            <template #header>
              <div @click="sortButton('id')">
                ID <el-icon><DCaret /></el-icon>
              </div>
            </template>
          </el-table-column>
          <el-table-column prop="name" label="Name" width="500">
            <template #header>
              <div @click="sortButton('name')">
                Name <el-icon><DCaret /></el-icon>
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
          <el-table-column prop="right" label="Operations" width="120">
            <template #default>
              <el-button link type="primary" size="small" @click="handleClick"
                >Detail</el-button
              >
              <el-button link type="primary" size="small">Edit</el-button>
            </template>
          </el-table-column>
        </el-table>
      </div>
    </layout-admin>
</template>

<script setup>
  import axios from 'axios';
  import { ref, watchEffect } from 'vue';
  import layoutAdmin from '../Pages/admins/layout/layoutAdmin.vue'
  import { Search, DCaret } from '@element-plus/icons-vue'
  const tableData = ref([])

  const handleClick = () => {

  console.log('click')
  }

  const search = ref('')

  const dataInput = ref({
    search: '',
    column: '',
    sort: 'desc',
  })

  const getCategories = () => {
    axios.get(route('test', dataInput.value))
    .then(function(response){
      tableData.value = response.data
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

  watchEffect(getCategories);


</script>

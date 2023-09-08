<template>
    <layout-admin>
      <div class="shadow">
        <div class="grid grid-cols-4 gap-2">
          <div class="col-span-2 ">
            <el-input
              v-model="dataInput.search"
              placeholder="Tìm kiếm"
              :suffix-icon="Search"
            />
          </div>
          <div>
            <el-button @click="getCategories">Search</el-button>
          </div>
        </div>
        <el-table :data="tableData.data" style="width: 100%">
          <el-table-column fixed prop="id" label="ID" width="50" />
          <el-table-column prop="name" label="Name" width="500" />
          <el-table-column prop="created_at" label="created_at" width="300" />
          <el-table-column prop="updated_at" label="updated_at" width="300"/>
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
  import { Search } from '@element-plus/icons-vue'
  const tableData = ref([])

  const handleClick = () => {

  console.log('click')
  }

  const dataInput = ref({
    search: '',
  })

  const getCategories = () => {
    axios.get(route('test', dataInput))
    .then(function(response){
      tableData.value = response.data
      console.log(response.data.data)
    }).catch(function(error){
      console.log(error)
    })
  }

  watchEffect(getCategories);


</script>

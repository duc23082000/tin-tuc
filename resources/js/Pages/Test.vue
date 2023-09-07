<template>
    <layout-admin>
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
    </layout-admin>
</template>

<script setup>
  import axios from 'axios';
  import { ref } from 'vue';
  import layoutAdmin from '../Pages/admins/layout/layoutAdmin.vue'
  const tableData = ref([])

  axios.get(route('test')).then(function(response){
    tableData.value = response.data
    console.log(response.data.data)
  }).catch(function(error){
    console.log(error)
  })
  
  const handleClick = () => {

  console.log('click')
}


</script>

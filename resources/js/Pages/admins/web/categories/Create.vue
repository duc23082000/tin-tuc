<template>
    <layout-admin>
      <div class="shadow">
        <div class="m-3">
            <label for="">Name:</label>
            <el-input v-model="name" />
            <small v-if="errors.name" class="text-red-600">{{ errors.name[0] }}</small>
            <div class="mt-2">
                <el-button type="primary" @click="createCategory">Create</el-button>
            </div>
        </div>
      </div>
    </layout-admin>
</template>

<script setup>
  import axios from 'axios';
  import { ref, watchEffect } from 'vue';
  import layoutAdmin from '../../layout/layoutAdmin.vue'
  import { ElMessage } from 'element-plus';


  const name = ref('')

  const errors = ref({})

  const createCategory = () => {
    axios.post(route('api.create'), {
        name: name.value,
    })
    .then(function(response){
        ElMessage.success(response.data.success)
        console.log(response.data.success)
    }).catch(function(error){
        errors.value = error.response.data.errors
    })
  }


  
</script>

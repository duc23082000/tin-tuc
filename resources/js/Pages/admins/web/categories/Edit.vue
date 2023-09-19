<template>
    <layout-admin>
      <div class="shadow">
        <div class="m-3">
            <label for="">Name:</label>
            <el-input v-model="name" />
            <small v-if="errors.name" class="text-red-600">{{ errors.name[0] }}</small>
            <div class="mt-2">
                <el-button type="primary" @click="updateCategory">Create</el-button>
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
  import { router } from '@inertiajs/vue3';



  const props = defineProps({
    id: String,
    });

  const name = ref('')

  const errors = ref({})

  const getCategory = () => {
    axios.get(route('admin.category.api.edit', props.id))
    .then(function(response){
        name.value = response.data.name
    }).catch(function(error){
        console.log(error);
    })
  }
 
  

  const updateCategory = () => {
    axios.put(route('admin.category.api.update', props.id), {
        name: name.value,
        id: props.id,
    })
    .then(function(response){
        ElMessage.success(response.data.success)
        router.visit(response.data.url)
    }).catch(function(error){
        errors.value = error.response.data.errors
    })
  }

  watchEffect(getCategory)

  
</script>

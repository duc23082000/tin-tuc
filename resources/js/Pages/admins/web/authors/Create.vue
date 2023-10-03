<template>
    <layout-admin>
      <div class="shadow h-[90%] md:h-[97.5%] m-3">
        <div class="m-3">
          <label for="">User Name:</label>
          <el-input 
            v-model="data.username"
            placeholder="Please input user name"
          />
          <small v-if="errors.username" class="text-red-600">{{ errors.username[0] }}</small>
        </div>

        <div class="m-3">
          <label for="">Email:</label>
          <el-input 
            v-model="data.email"
            placeholder="Please input email"
          />
          <small v-if="errors.email" class="text-red-600">{{ errors.email[0] }}</small>
        </div>

        <div class="m-3">
          <label for="">Password:</label>
          <el-input 
            v-model="data.password"
            type="password"
            placeholder="Please input password"
            show-password 
          />
          <small v-if="errors.password" class="text-red-600">{{ errors.password[0] }}</small>
        </div>

        <div class="m-3">
          <label for="">Confirm Password:</label>
          <el-input 
            v-model="data.cfpassword"
            type="password"
            placeholder="Please input confirm password"
            show-password 
          />
          <small v-if="errors.cfpassword" class="text-red-600">{{ errors.cfpassword[0] }}</small>
        </div>

        <div class="mt-5 w-full">
          <el-button type="primary" @click="createAuthor" class="w-full md:w-20">Create</el-button>
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


  const data = ref({
    username: '',
    email: '',
    password: '',
    cfpassword: '',
  })

  const errors = ref({})

  const createAuthor = () => {
    axios.post(route('admin.author.api.create'), data.value)
    .then(function(response){
        ElMessage.success(response.data.success)
        router.visit(response.data.url)
    }).catch(function(error){
        errors.value = error.response.data.errors
        console.log(error.response.data);
    })
  }


  
</script>

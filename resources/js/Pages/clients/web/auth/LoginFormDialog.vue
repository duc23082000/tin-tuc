<template>
    <el-form :model="form">
      <el-form-item label=" Email">
        <el-input v-model="form.email"
          autocomplete="off"
          placeholder="Please input email"
         />
      </el-form-item>
      <el-form-item label="Password">
        <el-input
          v-model="form.password"
          type="password"
          placeholder="Please input password"
          show-password
        />
      </el-form-item>
    </el-form>
    <span class="dialog-footer">
      <el-button type="primary" @click="handleLogin">
        Confirm
      </el-button>
    </span>
</template>

<script setup>
import axios from 'axios';
import { ElMessage } from 'element-plus';
import { ref, watchEffect } from 'vue';

const emit = defineEmits(['loginSuccess'])

const form = ref({
  name: '',
  password: '',
  url: window.location.href,
})

const handleLogin = () => {
  axios.post(route('api.user.handelLogin'), form.value)
  .then(function(response){
    ElMessage.success(response.data.success)
    emit('loginSuccess', window.location.href);
  }).catch(function(error){
    console.log(error);
    ElMessage.error(error.response.data.fail)
  })
}

</script>

<style scoped>
.el-button--text {
  margin-right: 15px;
}
.el-select {
  width: 300px;
}
.el-input {
  width: 300px;
}
.dialog-footer button:first-child {
  margin-right: 10px;
}
</style>
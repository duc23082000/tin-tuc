<template>
    <div class="flex justify-center text-[14px] mt-[20px] mb-[20px]">
      Đăng nhập bằng Email & password
    </div>
    <el-form :model="form" label-position="top" class="ml-[20px] mr-[20px]">
      <el-form-item>
        <template #label>
          <label class="font-semibold text-[14px] text-[#45474B]">Email</label>
        </template>
        <el-input 
        v-model="form.email"
        autocomplete="off"
        placeholder="Please input email"
        size="large"
        class="!w-full"
        />
      </el-form-item>
      <el-form-item>
        <template #label>
          <label class="font-semibold text-[14px] text-[#45474B]">Password</label>
        </template>
        <el-input
          v-model="form.password"
          type="password"
          placeholder="Please input password"
          class="!w-full"
          size="large"
          show-password
        />
      </el-form-item>
      
      <a :href="route('password.request')">
        <div class="flex justify-end text-[14px] text-[#8b8b8b] cursor-pointer">
          Quên mật khẩu?
        </div>
      </a>
    </el-form>

    <el-button @click="handleLogin" class="w-full !h-[38px] mt-[20px] !bg-[#0098d1] !text-white !text-[14px]">
      Đăng Nhập
    </el-button>
    <p class="flex justify-center text-[14px] mt-[20px] mb-[20px]">hoặc</p>
    <a :href="route('account.login.Google')">
      <el-button class="w-full !h-[38px]">
        <font-awesome-icon class="mr-[10px]" :icon="['fab', 'google']" /> Đăng nhập bằng tài khoản Google
      </el-button>
    </a>
    
</template>

<script setup>
import axios from 'axios';
import { ElMessage } from 'element-plus';
import { ref } from 'vue';

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
<template>
    <el-form :model="form">
      <el-form-item label=" Email" :label-width="formLabelWidth">
        <el-input v-model="form.email"
          autocomplete="off"
          placeholder="Please input email"
         />
      </el-form-item>
      <el-form-item label="Password" :label-width="formLabelWidth">
        <el-input
          v-model="form.input"
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
import { ref, watchEffect } from 'vue';

const form = ref({
  name: '',
  password: '',
})

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
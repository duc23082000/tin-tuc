<template>
  <layout-admin>
    <div class="shadow">
      <div class="m-3">
          <div class="mt-3">
            <label for="">Title:</label>
            <div>
              <el-input v-model="data.title" />
            </div>
            <small v-if="errors.title" class="text-red-600">{{ errors.title[0] }}</small>
          </div>

          <div class="mt-3">
            <ckeditor :editor="ClassicEditor" id="editor" v-model="data.content" ></ckeditor>
          </div>

          <div class="mt-3">
            <label for="">Category:</label>
            <div>
              <el-select v-model="data.category_id" class=" w-96" placeholder="Select" >
                <el-option
                  v-for="(item, index) in props.categories"
                  :key="index"
                  :label="item.name"
                  :value="item.id"
                />
              </el-select>
            </div>
            <small v-if="errors.category" class="text-red-600">{{ errors.category[0] }}</small>
          </div>

          <div class="mt-3">
            <label for="">Status:</label>
            <el-radio-group v-model="data.status" v-for="(value, key) in props.status" :key="value">
              <el-radio class="ml-3" :label="value">{{ key }}</el-radio>
            </el-radio-group>
            <small v-if="errors.status" class="text-red-600">{{ errors.status[0] }}</small>
          </div>

          <div class="mt-3">
            <label for="">Posted at:</label>
            <div>
              <el-date-picker
                v-model="data.posted_at"
                type="date"
                placeholder="Pick a day"
              />
            </div>
            <small v-if="errors.posted_at" class="text-red-600">{{ errors.posted_at[0] }}</small>
          </div>

          <div class="mt-3">
            <label for="">Tags:</label>
            <div>
              <el-select
                v-model="data.tags"
                multiple
                filterable
                default-first-option
                :reserve-keyword="false"
                placeholder="Choose tags for your article"
              >
                <el-option
                  v-for="item in props.tags"
                  :key="item.id"
                  :label="item.name"
                  :value="item.id"
                />
              </el-select>
            </div>
          </div>

          <div class="mt-3">
            <label for="">Image:</label>
            <div>
              <input type="file" @change="onChangeFileUpload($event)"/>
            </div>
            <small v-if="errors.image" class="text-red-600">{{ errors.image[0] }}</small>
          </div>

          <div class="mt-2">
              <el-button type="primary" @click="update">Update</el-button>
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
  import ClassicEditor from '@ckeditor/ckeditor5-build-classic';


  const props = defineProps(['status', 'tags', 'categories', 'post'])

  const data = ref({
    title: props.post.title,
    content: props.post.content ?? '',
    category_id: props.post.category_id,
    status: props.post.status,
    posted_at: props.post.posted_at,
    tags: props.post.tags_id,
    _method: "PUT",
  });
  const errors = ref({})

  const update = () => {
    axios.post(route('admin.post.api.update', props.post.id),
      data.value,
    {
        headers: {
          'Content-Type': 'multipart/form-data'
        },
    })
    .then(function(response){
        ElMessage.success(response.data.success)
        router.visit(response.data.url)
    }).catch(function(error){
        errors.value = error.response.data.errors
    })
  }
  
</script>

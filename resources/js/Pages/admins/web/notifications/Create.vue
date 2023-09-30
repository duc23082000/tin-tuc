<template>
    <layout-admin>
      <div class="shadow h-[90%] md:h-[97.5%] m-3">
        <div class="m-3">
            <div class="mt-3">
              <label for="">Title:</label>
              <div>
                <el-input v-model="data.title" />
              </div>
              <small v-if="errors.title" class="text-red-600">{{ errors.title[0] }}</small>
            </div>

            <div class="mt-3">
              <label for="">Content:</label>
              <ckeditor :editor="ClassicEditor" id="editor" v-model="data.content" ></ckeditor>
            </div>

            <div class="mt-3">
              <div>Receiver</div>
              <div class="ml-2">
                <div>
                  <label for="" class="text-xs">User:</label>
                  <div>
                    <el-select
                    v-model="data.users"
                    multiple
                    collapse-tags
                    collapse-tags-tooltip
                    :max-collapse-tags="3"
                    placeholder="Select"
                    style="width: 240px"
                    >
                    <el-option
                      v-for="item in props.users"
                      :key="item.id"
                      :label="item.username"
                      :value="item.id"
                    />
                    </el-select>
                  </div>
                </div>
                <div>
                  <label for="" class="text-xs">Author:</label>
                  <div>
                    <el-select
                    v-model="data.authors"
                    multiple
                    collapse-tags
                    collapse-tags-tooltip
                    :max-collapse-tags="3"
                    placeholder="Select"
                    style="width: 240px"
                    >
                    <el-option
                      v-for="item in props.authors"
                      :key="item.id"
                      :label="item.username"
                      :value="item.id"
                    />
                    </el-select>
                  </div>
                </div>
              </div>
              <small v-if="errors.users" class="text-red-600">{{ errors.users[0] }}</small>
              <small v-if="errors.authors" class="text-red-600">{{ errors.authors[0] }}</small>
            </div>

            <div class="mt-5 w-full">
              <el-button type="primary" @click="create" class="w-full md:w-20">Create</el-button>
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
  import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
  import { router } from '@inertiajs/vue3';


  const data = ref({
    title: '',
    content: '',
    users: [],
    authors: [],
  })

  const props = defineProps(['users', 'authors'])

  const errors = ref({})

  const create = () => {
    axios.post(route('admin.notice.api.create'), data.value)
    .then(function(response){
        ElMessage.success(response.data.success)
        router.visit(response.data.url)
    }).catch(function(error){
        errors.value = error.response.data.errors
        if(errors.value.users[0] == errors.value.authors[0]){
          delete errors.value.authors
        }
    })
  }
  
</script>

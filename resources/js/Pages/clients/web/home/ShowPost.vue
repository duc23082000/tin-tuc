<template>
    <layout-client>
        <div class="grid grid-cols-4">
            <div class="col-span-3">
                <h1 class="text-2xl">
                    <strong>{{ postData.title }}</strong>
                </h1>
            </div>
            <div class="col-span-1">
                <p class="text-sm flex items-center h-full">{{ formatDate(postData.posted_at) }}</p>
            </div>
        </div>
        <hr>
        <div class="my-2 image">
            <img :src="'storage/images/' + postData.image" alt="">
        </div>
        <div v-html="postData.content ?? '...'"></div>

        <div class="shadow-sm h-[35px] bg-gray-100 my-5">
            <div class="h-full flex items-center mx-3">
              <el-button type="primary" size="small" @click="handleLike"><font-awesome-icon icon="fa-thumbs-up" class="mr-2"/> Thích {{ likes.length }}</el-button>
              <el-button type="primary" size="small"><font-awesome-icon icon="share-from-square" class="mr-2"/> Chia sẻ</el-button>
              <el-button type="primary" size="small"><font-awesome-icon icon="comment" class="mr-2"/> Bình luận</el-button>
            </div>
        </div>
        <hr>
        <div class="my-5">
                <Link v-for="(tag, index) in postData.tags" :key="index" 
                    :href="route('home.tag') + '?tag=' + tag.name">
                    <el-button class="mr-2 mt-2">{{ tag.name }}</el-button>
                </Link>
        </div>

        <div class="bg-gray-100">
            <div class="px-3 py-5">
                <p class="text-xl mb-2">Bình luận({{ commentData.length }})</p>
                <el-input
                    v-model="comment"
                    :rows="3"
                    type="textarea"
                    placeholder="Nhập bình luận"
                    class="mb-2"
                    @click="checkLogin"
                />
                <div class="mb-5">
                    <el-button type="primary" @click="handleComment">Gửi bình luận</el-button>
                </div>
                <hr>
                <div class="my-5 grid grid-cols-10" v-for="(comment, index) in commentData" :key="index">
                    <div class="col-span-1">{{ comment.commented_by.username }}:</div>
                    <div class="col-span-9">{{ comment.content }}</div>
                </div>
            </div>
        </div>

        <el-dialog v-model="login" title="Login Form">
            <LoginFormDialog @login-success="handleLoginSuccess" />
        </el-dialog>
    </layout-client>
</template>

<script setup>
import { ref } from 'vue';
import LayoutClient from '../../layout/layoutClient.vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import axios from 'axios';
import LoginFormDialog from '../auth/LoginFormDialog.vue'
import moment from 'moment';


const props = defineProps(['post', 'comments'])

const postData = ref(props.post);

const commentData = ref(props.comments);

const comment = ref('')

const likes = ref(props.post.likes)

const login = ref(false);

const checkLogin = () => {
    if(!usePage().props.auth.user){
        login.value = true;
    }
}

const handleComment = () => {
    if(!usePage().props.auth.user){
        login.value = true;
    } else {
        axios.post(route('api.comment', props.post.id), {
            'content': comment.value,
        })
        .then(function(respornse){
            commentData.value = respornse.data.comment;
            comment.value = '';
        }).catch(function(errors){
            console.log(errors.data);
        })
    }
}

const handleLike = () => {
    if(!usePage().props.auth.user){
        login.value = true;
    } else {
        axios.get(route('api.like', props.post.id))
        .then(function(respornse){
            likes.value = respornse.data.likes
        }).catch(function(errors){
            console.log(errors.data);
        })
    }
}

const formatDate = (date) => {
  return moment(date).format('HH:mm-DD/MM/YYYY');
}

const handleLoginSuccess = (url) => {
    router.visit(url)
}

</script>

<style>
.image{
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>
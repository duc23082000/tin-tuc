<template>
    <layout-client>
        <div class="md:grid grid-cols-4">
            <div class="col-span-3">
                <h1 class="text-2xl">
                    <strong>{{ postData.title }}</strong>
                </h1>
            </div>
            <div class="md:col-span-1">
                <p class="text-xs md:text-sm flex items-center h-full">{{ formatDate(postData.posted_at) }}</p>
            </div>
        </div>
        <hr>
        <div class="flex">
            <div class="md:w-[60%]">
                <div class="my-2 image">
                    <img v-if="postData.image" :src="'storage/images/' + postData.image" alt="">
                </div>
                <div v-html="postData.content ?? '...'"></div>
            </div>
            <div class="hidden md:block text-center w-[40%] pt-[8px]">
                <div class="flex justify-center pb-[20px]">
                    <div class="w-[70%] cursor-pointer">
                        <el-carousel height="600px">
                            <el-carousel-item v-for="item in 2" :key="item" class="!cursor-pointer">
                                <iframe class="!h-full" scrolling="no" src="https://static-cmsads.admicro.vn/cmsads/2023/10/EVN--1697510422961/index.html"></iframe>
                            </el-carousel-item>
                        </el-carousel>
                    </div>
                </div>
                <div class="flex justify-center pb-[20px]">
                    <div class="w-[70%]">
                        <el-carousel height="250px">
                            <el-carousel-item v-for="item in 2" :key="item">
                                <iframe class="!h-full" scrolling="no" src="//adi.admicro.vn/adt/adn/2019/05/zt554-adx5cda835a03f4a.gif"></iframe>
                            </el-carousel-item>
                        </el-carousel>
                    </div>
                </div>
                <div class="flex justify-center pb-[20px]">
                    <div class="w-[70%]">
                        <el-carousel height="250px">
                            <el-carousel-item v-for="item in 2" :key="item">
                                <iframe class="!h-full" scrolling="no" src="https://cdnstoremedia.com/adt/banners/nam2015/4043/min_html5/2023-10-18/anhnguyendoanle/300x250_T10_44/300x250_T10_44/300x250_T10_44.html?url=%2F%2Flg1.logging.admicro.vn%2Fadn%3Fdmn%3Dhttps%253A%252F%252Fthanhnien.vn%252Fche-nhao-doi-thu-hlv-mourinho-chinh-thuc-nhan-an-phat-tu-lien-doan-bong-da-y-185231025104737217.htm%26rid%3D378e1d70-cb05-41e8-a441-c8bbcf5ed427142-6538e1b1%26sspb%3D18720%26sspr%3D0.6985%26lsn%3D1698226606419%26ce%3D1%26lc%3D4%26cr%3D1692687360%26ui%3D5626873601984316383%26uuid%3D%26profileID%3D9b69e325-d2da-4f9a-a839-e0c5e3137896%26bi%3D0%26cmpg%3D83686%26items%3D359072%26zid%3D512049%26pr%3D35989193750%26cid%3D-1%26tp%3D11%26tpn%3D4%26alg%3D1102%26dg%3D621b8a00e78328a46510fdcfccbb8ee3%26xtr%3DeyJhc2lkIjo1MzE2LCJwcm9maWxlaWQiOiI5YjY5ZTMyNS1kMmRhLTRmOWEtYTgzOS1lMGM1ZTMxMzc4OTYifQ%253D%253D%26sspz%3D2013982%26cov%3D1%26re%3Dhttps%253A%252F%252Fnhathuoclongchau.com.vn%252Fkhuyen-mai%252Fve-nha-nho-mang-theo-qua%253Futm_source%253DAdmicro%2526utm_medium%253DCPC%2526utm_campaign%253DSub-10-2023%2526utm_term%253DNew%2526utm_content%253Dthanhnien.vn&temp=0&loc=4&weath=&autoplay=0&admid=adnzone_512049_0_359072&vast=https%3A%2F%2Fsspapi.admicro.vn%2Fssp_request%2Fvideo%3Fu%3Dthanhnien.vn%252Fche-nhao-doi-thu-hlv-mourinho-chinh-thuc-nhan-an-phat-tu-lien-doan-bong-da-y-185231025104737217.htm%26z%3D512049%26p%3D1%26w%3D650%26h%3D300%26%26lsn%3D1698226606419%26dgid%3D621b8a00e78328a46510fdcfccbb8ee3%26l%3D4%26loc%3D4%26i%3D5626873601984316383%26isdetail%3D1%26pid%3D%26tags%3D5%26adstype%3D%26vtype%3D8%26vid%3D%26bannerid%3D359072"></iframe>
                            </el-carousel-item>
                        </el-carousel>
                    </div>
                </div>
            </div>
        </div>

        <div class="shadow-sm h-[35px] bg-gray-100 my-5 rounded">
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

        <div class="bg-gray-100 rounded">
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
                <div class="my-5 grid grid-cols-3 md:grid-cols-10" v-for="(comment, index) in commentData" :key="index">
                    <div class="col-span-1">{{ comment.commented_by.username }}:</div>
                    <div class="col-span-2 md:col-span-9">{{ comment.content }}</div>
                </div>
            </div>
        </div>

        <el-dialog v-model="login" class="!w-[300px] md:!w-[20%] md:!h-[750px] bottom-[100px] md:bottom-[50px]" :show-close="true">
            <template #header>
                <el-tabs v-model="activeName" class="demo-tabs">
                    <el-tab-pane label="Đăng nhập" name="first">
                        <LoginFormDialog @login-success="handleLoginSuccess"/>
                    </el-tab-pane>
                    <el-tab-pane label="Đăng ký" name="second">
                        <RegisterFormDialog @login-success="handleLoginSuccess"/>
                    </el-tab-pane>
                </el-tabs>
            </template>
        </el-dialog>
    </layout-client>
</template>

<script setup>
import { ref } from 'vue';
import LayoutClient from '../../layout/layoutClient.vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import axios from 'axios';
import LoginFormDialog from '../auth/LoginFormDialog.vue'
import RegisterFormDialog from '../auth/RegisterFormDialog.vue'
import moment from 'moment';

const props = defineProps(['post', 'comments'])
const postData = ref(props.post);
const commentData = ref(props.comments);
const comment = ref('')
const likes = ref(props.post.likes)
const login = ref(false);
const activeName = ref('first')

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

.demonstration {
  color: var(--el-text-color-secondary);
}

.el-carousel__item:nth-child(2n) {
  background-color: #99a9bf;
}

.el-carousel__item:nth-child(2n + 1) {
  background-color: #d3dce6;
}
.gwd-page-container.gwd-pagedeck {
    cursor: pointer;
}
.el-tabs__nav {
    display: flex;
    width: 100% !important;
    justify-content: center;
}
.el-tabs__item {
    width: 100% !important;
    margin-bottom: 14px;
    padding-left: 0px !important;
    padding-right: 0px !important;
}
.el-dialog__header {
    margin: 0px !important;
}

.el-dialog__headerbtn {
    right: -10px;
    top: -10px;
    border-radius: 50px;
    background-color: #0098d1;
    max-width: 20px;
    max-height: 20px;
}

button i svg {
    color: #fff;
    font-size: 14px;
}
</style>
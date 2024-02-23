import { faLessThanEqual } from '@fortawesome/free-solid-svg-icons';
import { usePage } from '@inertiajs/vue3'
import axios from 'axios';
import { defineStore } from 'pinia'
import { ref, watch } from 'vue';
import { computed } from 'vue'


export const useUsersStore = defineStore('users', () => {
  const notifications = ref(null)

  function getNotifications () {
    axios.get(route('api.notification.all'))
    .then(function(res){
      notifications.value  = res.data
    })
    .catch(function(err){
      console.log(err);
    })
  }

  // Sử dụng computed property để truy cập user khi có sẵn
  const user = computed(() => usePage().props.auth.user)

  // Gọi hàm getNotifications sau khi có user
  watch(user, (newValue) => {
    if (newValue) {
      getNotifications()
    }
  })

  if (notifications.value === null) {
    getNotifications()
  }

  return { user, notifications, getNotifications }
})

export const usePageStore = defineStore('pages', () => {
  const categories = ref(null);
  const authors = ref(null);
  const tags = ref(null);

  const getCategories = () => {
    axios.get(route('home.api.categories'))
    .then(function(respornse){
      categories.value = respornse.data
  
    })
    .catch(function(errors){
      console.log(errors);
    })
  }

  const getAuthors = () => {
    axios.get(route('home.api.authors'))
    .then(function(respornse){
      authors.value = respornse.data
  
    })
    .catch(function(errors){
      console.log(errors);
    })
  }

  const getTags = () => {
    axios.get(route('home.api.tags'))
    .then(function(respornse){
      tags.value = respornse.data
    })
    .catch(function(errors){
      console.log(errors);
    })
  }

  function selected(url) { 
    let pathname = window.location.pathname
    if (pathname == '/') {
      pathname  = '';
    }
    return window.location.origin + pathname == route('home' + url) ? 'text-blue-400' : 'text-gray-700';
  }

  getAuthors()
  getCategories()
  getTags()
  
  return { categories, authors, tags, selected }
})
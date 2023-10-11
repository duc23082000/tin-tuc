import { usePage } from '@inertiajs/vue3'
import axios from 'axios';
import { defineStore } from 'pinia'
import { ref } from 'vue';

// You can name the return value of `defineStore()` anything you want,
// but it's best to use the name of the store and surround it with `use`
// and `Store` (e.g. `useUserStore`, `useCartStore`, `useProductStore`)
// the first argument is a unique id of the store across your application
export const useUsersStore = defineStore('users', () => {
  const user = usePage().props.auth.user;

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

  if(notifications.value === null) {
    getNotifications()
  }

  return { user, notifications, getNotifications }
})
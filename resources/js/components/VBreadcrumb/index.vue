<script setup>
import { array } from 'vue-types';
import { Inertia } from '@inertiajs/inertia'

const props = defineProps({
  routes: array()
})

const redirectToPage = (route, index) => {
  if (index !== props.routes.length - 1){
    Inertia.visit(route.to)
  }
}
</script>

<template>
  <div>
      <ul class="inline-flex flex-wrap text-sm font-medium sm:mb-6 mb-4">
          <li
              class="after:content-['/'] last:after:hidden after:text-slate-400 after:px-2"
              v-for="(route, index) in routes"
              :key="index"
          >
              <a :id="route.active ? 'active' : 'passive'" class="hover:text-primary cursor-pointer" :class="route.active ? 'text-primary' : 'text-slate-500'" @click="redirectToPage(route, index)">{{ route.name }}</a>
          </li>
      </ul>
  </div>
</template>


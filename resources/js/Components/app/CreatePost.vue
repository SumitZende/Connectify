<script setup>

import {ref} from "vue";

const  postcreating=ref(false)
</script>

<template>
  <div class="p-4 bg-white rounded-lg border">
    <div @click="postcreating = true"
         class="px-3 py-2 mb-3 border border-2  rounded-[10px] text-gray-300 border-gray-500">
      Create Post here
    </div>
    <div v-if="postcreating"
        class="flex gap-2 justify-between">
      <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2
                                   text-sm font-semibold text-white shadow-sm hover:bg-indigo-500
                                   focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2
                                   focus-visible:outline-indigo-600 relative">
        Attach File
        <input type="file" class="absolute top-0 bottom-0 right-0 left-0 opacity-0" />
      </button>
      <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2
                                   text-sm font-semibold text-white shadow-sm hover:bg-indigo-500
                                   focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2
                                   focus-visible:outline-indigo-600">
        Submit
      </button>
    </div>
  </div>
</template>

<style scoped>

</style>
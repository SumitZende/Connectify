<script setup>
defineProps({
  image:String,
  title:String,
  description:String
})
</script>

<template>
  <div class= "mb-3 cursor-pointer hover:bg-gray-300" >
    <div class="flex items-start gap-1 py-2 px-2">
      <img :src="image" class="w-[32px] rounded-full"/>
      <div>
        <h3 class="font-black text-xl"> {{title}}</h3>
        <div class="text-sm text-gray-500">{{description}}</div>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>
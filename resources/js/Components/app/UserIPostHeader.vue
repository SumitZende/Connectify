<script setup>


defineProps({
  post:{
    type:Object
  },
  time:{
    type:Boolean,
    default: true
  }
})
</script>

<template>
  <div class="flex items-center  gap-4">
    <a href="javascript:void(0)">
      <img :src="post.user.avatar_url"
           class="w-[50px] rounded-full border border-2 transition-all hover:border-blue-600">
    </a>
    <div>
      <h4 class="font-bold">
        <a href="javascript:void(0)" class="hover:underline">{{post.user.name}}</a>
        <template v-if="post.group">
          >
          <a href="javascript:void(0)" class="hover:underline">{{post.group.name}}</a>
        </template>
      </h4>
      <small v-if="time" class="text-gray-400 hover:underline">{{post.created_at}}</small><br>
      <small v-if="time && post.updated_at != post.created_at" class="text-gray-400 hover:underline">updated on {{post.updated_at}}</small>
    </div>
  </div>
</template>


<style scoped>

</style>
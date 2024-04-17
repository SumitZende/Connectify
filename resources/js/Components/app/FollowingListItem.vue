<script setup>

import TextInput from "@/Components/TextInput.vue";
import FollowingItem from "@/Components/app/FollowingItem.vue";
import {ref} from "vue";
const  serachKeyword = ref()
</script>

<template>
  <TextInput :model-value="serachKeyword" placeholder="type for search " class="w-full mt-4" />
  <div class=" mt-3  h-[200px]  lg:flex-1 overflow-auto">
    <div v-if="false" class="text-gray-400  text-center  p-6 ">
      You not have any followers yet!
    </div>
    <div v-else>
      <FollowingItem image="https://picsum.photos/100"
                     name="Vaibhav Ghadge"
      />
      <FollowingItem image="https://picsum.photos/100"
                     name="Prashant Salunke"
      />
      <FollowingItem image="https://picsum.photos/100"
                     name="Vaibhav Ghadge"
      />
      <FollowingItem image="https://picsum.photos/100"
                     name="Prashant Salunke"
      />
      <FollowingItem image="https://picsum.photos/100"
                     name="Vaibhav Ghadge"
      />
      <FollowingItem image="https://picsum.photos/100"
                     name="Prashant Salunke"
      />
      <FollowingItem image="https://picsum.photos/100"
                     name="Vaibhav Ghadge"
      />
      <FollowingItem image="https://picsum.photos/100"
                     name="Prashant Salunke"
      />
      <FollowingItem image="https://picsum.photos/100"
                     name="Vaibhav Ghadge"
      />
      <FollowingItem image="https://picsum.photos/100"
                     name="Prashant Salunke"
      />
      <FollowingItem image="https://picsum.photos/100"
                     name="Vaibhav Ghadge"
      />
      <FollowingItem image="https://picsum.photos/100"
                     name="Prashant Salunke"
      />
    </div>
  </div>
</template>

<style scoped>

</style>
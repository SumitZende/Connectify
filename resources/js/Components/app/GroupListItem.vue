<script setup>

import GroupIIem from "@/Components/app/GroupIIem.vue";
import TextInput from "@/Components/TextInput.vue";

</script>

<template>
  <TextInput :model-value="serachKeyword" placeholder="type for search " class="w-full  mt-4"/>
  <div class="mt-3  h-[200px]  lg:flex-1 overflow-auto ">
    <div v-if="false" class="text-gray-400  text-center p-6">
      You are not joined to any groups
    </div>
    <div v-else >
      <GroupIIem image="https://picsum.photos/100"
                 title="Laravel Developers"
                 description="Lorem ipsum dolor sit amet, consectetur adipisicing elit."
      />
      <GroupIIem image="https://picsum.photos/100"
                 title="Vue.js Developers"
                 description="Lorem ipsum dolor sit amet, consectetur adipisicing elit."
      />
      <GroupIIem image="https://picsum.photos/100"
                 title="Cyber Security Analyst"
                 description="Lorem ipsum dolor sit amet, consectetur adipisicing elit."
      />
      <GroupIIem image="https://picsum.photos/100"
                 title="Laravel Developers"
                 description="Lorem ipsum dolor sit amet, consectetur adipisicing elit."
      />
      <GroupIIem image="https://picsum.photos/100"
                 title="Vue.js Developers"
                 description="Lorem ipsum dolor sit amet, consectetur adipisicing elit."
      />
      <GroupIIem image="https://picsum.photos/100"
                 title="Cyber Security Analyst"
                 description="Lorem ipsum dolor sit amet, consectetur adipisicing elit."
      />
    </div>
  </div>
</template>

<style scoped>

</style>
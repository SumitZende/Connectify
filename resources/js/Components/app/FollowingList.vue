<script setup>

import TextInput from "@/Components/TextInput.vue";

import {ref} from "vue";

import FollowingItem from "@/Components/app/FollowingItem.vue";
import FollowingListItem from "@/Components/app/FollowingListItem.vue";
import {Disclosure, DisclosureButton, DisclosurePanel} from "@headlessui/vue";
import GroupListItem from "@/Components/app/GroupListItem.vue";

const  serachKeyword = ref()
</script>

<template>
  <div class="px-3 py-3 bg-white rounded border   lg:h-full overflow-hidden flex flex-col ">
    <!--small screen-->
    <div class="block lg:hidden flex-1">
      <Disclosure v-slot="{ open }">
        <DisclosureButton class=" w-full" >
          <div class="flex justify-between items-center ">
            <h2 class="text-xl font-bold"> My Following</h2>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                 class="w-6 h-6 transition-all"
                 :class="open ? 'rotate-90 transform' : ''">
              <path fill-rule="evenodd" d="M16.28 11.47a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 0 1-1.06-1.06L14.69 12 7.72 5.03a.75.75 0 0 1 1.06-1.06l7.5 7.5Z"
                    clip-rule="evenodd" />
            </svg>

          </div>

        </DisclosureButton>
        <DisclosurePanel>
          <FollowingListItem/>
        </DisclosurePanel>
      </Disclosure>
    </div>
    <!--    large screen-->
    <div class="lg:flex h-full overflow-hidden flex-col hidden">
      <h2 class="text-xl font-bold "> My Following</h2>
      <FollowingListItem/>
    </div>

  </div>

</template>

<style scoped>

</style>
<script setup>
import {computed, ref} from 'vue'
import {Tab, TabGroup, TabList, TabPanel, TabPanels} from '@headlessui/vue'
import {usePage} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TabItem from "@/Pages/Profile/Partials/TabItem.vue";
import Edit from "@/Pages/Profile/Edit.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const  isMyProfile = computed(()=>authUser && authUser.id === props.user.id);
const authUser = usePage().props.auth.user;
const  props= defineProps({
  mustVerifyEmail: {
    type: Boolean,
  },
  status: {
    type: String,
  },
  user:{
    type:Object
  }
});

const categories = ref({
  Recent: [
    {
      id: 1,
      title: 'Does drinking coffee make you smarter?',
      date: '5h ago',
      commentCount: 5,
      shareCount: 2,
    },
    {
      id: 2,
      title: "So you've bought coffee... now what?",
      date: '2h ago',
      commentCount: 3,
      shareCount: 2,
    },
  ],
  Popular: [
    {
      id: 1,
      title: 'Is tech making coffee better or worse?',
      date: 'Jan 7',
      commentCount: 29,
      shareCount: 16,
    },
    {
      id: 2,
      title: 'The most innovative things happening in coffee',
      date: 'Mar 19',
      commentCount: 24,
      shareCount: 12,
    },
  ],
  Trending: [
    {
      id: 1,
      title: 'Ask Me Anything: 10 answers to your questions about coffee',
      date: '2d ago',
      commentCount: 9,
      shareCount: 5,
    },
    {
      id: 2,
      title: "The worst advice we've ever heard about coffee",
      date: '4d ago',
      commentCount: 1,
      shareCount: 2,
    },
  ],
})
</script>
<template>
  <AuthenticatedLayout>
    <div class="w-[768px] mx-auto  h-full overflow-auto ">
      <!--    cover image-->
      <div class="relative bg-white">
        <img src="https://timelinecovers.pro/facebook-cover/download/ultra-hd-space-facebook-cover.jpg"
             class="w-full  h-[200px] object-cover" >
        <!--      Avatar image-->

        <div class="flex">
          <img src="https://cdn.iconscout.com/icon/free/png-256/free-avatar-370-456322.png?f=webp"
               class=" ml-[48px] w-[128px] h-[128px] -mt-[64px]"/>
          <div class="flex justify-between items-center flex-1 p-4">
            <h2 class="font-bold text-lg ">{{user.name}}</h2>
            <PrimaryButton v-if="isMyProfile">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                   class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
              </svg>

            </PrimaryButton>
          </div>
        </div>
      </div>
      <div class="border-t-2">
        <div>
          <TabGroup>
            <TabList class=" flex bg-white">
              <Tab v-if="isMyPrfile" v-slot="{ selected }" as="template" >
                <TabItem text="About"  :selected="selected"/>
              </Tab>
              <Tab v-slot="{ selected }" as="template" >
                <TabItem text="Posts"  :selected="selected"/>
              </Tab>
              <Tab v-slot="{ selected }" as="template" >
                <TabItem text="Followers"  :selected="selected"/>
              </Tab>
              <Tab v-slot="{ selected }" as="template" >
                <TabItem text="Following"  :selected="selected"/>
              </Tab>
              <Tab v-slot="{ selected }" as="template" >
                <TabItem text="Photos"  :selected="selected"/>
              </Tab>

            </TabList>

            <TabPanels class="mt-2">
              <TabPanel  v-if="isMyProfile" >
                <Edit  :must-verify-email="mustVerifyEmail" :status="status"/>
              </TabPanel>
              <TabPanel  class="bg-white p-3 shadow">
                Post Content
              </TabPanel>
              <TabPanel  class="bg-white p-3 shadow">
                Followers
              </TabPanel>
              <TabPanel  class="bg-white p-3 shadow">
                Following
              </TabPanel>
              <TabPanel  class="bg-white p-3 shadow">
                Photos
              </TabPanel>
            </TabPanels>
          </TabGroup>
        </div>
      </div>

    </div>
  </AuthenticatedLayout>
</template>



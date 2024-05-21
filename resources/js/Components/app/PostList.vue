<script setup>
import PostItem from "@/Components/app/PostItem.vue";

defineProps({
  posts : Array
})

const  post1={
  user:{
    id:1,
    name:"Sumit Zende",
    avatar:'https://i.pravatar.cc/80?img=2'
  },
  attachement:[
    {
      id:1,
      name:'test.png',
      url:'https://picsum.photos/1000',
      mime:'image/png'
    },
    {
      id:2,
      name:'test2.png',
      url:'https://picsum.photos/1000',
      mime:'image/png'
    },
    {
      id:3,
      name:'MyDocument.docx',
      url:'',
      mime:'application/msword'
    }
  ],
  group:null,
  body:`<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias aliquid architecto autem, cupiditate ducimus eos
    exercitationem facere fuga, laboriosam nesciunt odit, possimus quam rem sint soluta temporibus voluptate. Eum,
    repellendus!</p>

    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias aliquid architecto autem, cupiditate ducimus eos
    exercitationem facere fuga, laboriosam nesciunt odit, possimus quam rem sint soluta temporibus voluptate. Eum,
    repellendus!</p>`,
  created_at:'10-04-24 10:30'

}
const  post2={
  user:{
    id:1,
    name:"Prashant Salunke",
    avatar:'https://i.pravatar.cc/80?img=3'
  },
  group:{
    id:3,
    name:'Cyber Security Analyst'
  },
  body:`<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias aliquid architecto autem, cupiditate ducimus eos
    exercitationem facere fuga, laboriosam nesciunt odit, possimus quam rem sint soluta temporibus voluptate. Eum,
    repellendus!</p>

    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias aliquid architecto autem, cupiditate ducimus eos
    exercitationem facere fuga, laboriosam nesciunt odit, possimus quam rem sint soluta temporibus voluptate. Eum,
    repellendus!</p>`,
  created_at:'19-04-24 19:30'

}
</script>

<template >
  <div class=" overflow-auto">
    <PostItem  v-for="post of posts" :key="post.id" :post="post"/>
  </div>

</template>

<style scoped>

</style>
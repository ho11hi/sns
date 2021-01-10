<template>
   <div>
      <div class="posts-index-item" v-for="(item, i) in posts" :key="i">
         <div class="post-left">
            <img
               v-if="item.image_name !== null"
               :src="path + 'storage/user_img/' + item.image_name"
            />
            <img
               v-if="item.image_name === null"
               :src="path + 'assets/default-user-image.png'"
            />
         </div>
         <div class="post-right">
            <div class="post-user-name">
               <a :href="path + 'users/' + item.u_id">{{ item.name }}</a>
            </div>
            <a :href="path + 'posts/' + item.p_id">{{ item.content }}</a>
         </div>
      </div>
   </div>
</template>

<script>
export default {
   props: ["path", "posts"]
};
</script>

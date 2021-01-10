<template>
   <div class="likeWrap">
      <span
         @click="likeToggle"
         class="fa fa-heart"
         :class="[isActive === true ? 'like-btn-unlike' : 'like-btn']"
      ></span>
      {{ this.likeCount }}
   </div>
</template>

<script>
const axios = require("axios");

export default {
   props: ["post", "likes", "likecnt", "path", "user_id"],
   data() {
      return {
         isActive: false,
         likeCount: this.likecnt.count
      };
   },
   methods: {
      likeToggle() {
         this.isActive = !this.isActive;

         // AjaxでDBのLIKE（いいね）データを管理
         if (this.isActive) {
            axios //store
               .post(this.path + "like", {
                  user_id: this.user_id,
                  post_id: this.likecnt.post_id
               });
            this.likeCount++;
         } else {
            axios //delete
               .delete(
                  this.path +
                     "like/" +
                     this.user_id +
                     "/" +
                     this.likecnt.post_id
               );
            this.likeCount--;
         }
      }
   },
   mounted() {
      // LIKE情報を取得
      if (this.likes) {
         return (this.isActive = true);
      }
   }
};
</script>

<style scoped></style>

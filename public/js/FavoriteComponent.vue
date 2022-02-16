<template>
</template>

<script>
export default {
 props: ['item_id'],      
 data() {
   return {
     status: false,
   }
 },
 created() {
   this.like_check()      2
 },
 methods: {
   like_check() {
     const id = this.item_id
     const array = ["/items/",id,"/check"];
     const path = array.join('')
     axios.get(path).then(res => {
       if(res.data == 1) {
         this.status = true
       } else {
         this.status = false
       }
     }).catch(function(err) {
       console.log(err)
     })
   },
   like() {                         3
     const id = this.item_id
     const array = ["/items/",id,"/likes"];
     const path = array.join('')
     axios.post(path).then(res => {
       this.like_check()
     }).catch(function(err) {
       console.log(err)
     })
   }
 }
}
</script>
<?php include __DIR__.'/../../Seller.php' ?>

<script>
class Kasier {
   constructor() {
      this.run();
   }

   run() {
      callApi("seller/kasier/get", {
         client_token: $jp_client_token
      }, e => {
         if(e.Data.length != 0) {
            let key = e.Data[0].key;

            $("form.kasier input.key").val(key);
         }
      })
   }

   generateUlang() {
      callApi("seller/kasier/post", {
         client_token: $jp_client_token
      }, e => {
         if (e.Error) {
            e('div.message','danger',e.Message,5)
         }else{
            notif('div.message','success',e.Message,5)
            kasier.run()
         }
      })
   }

   copyToClipboard() {
      let text = document.getElementById('key').select();
      document.execCommand('copy');
   }
}

var kasier = new Kasier;

$(document).on("submit", "form.kasier", function() {
   kasier.generateUlang();
   return false;
})

$(document).on("click", "form.kasier button._copy", function () {
   kasier.copyToClipboard();
})
</script>
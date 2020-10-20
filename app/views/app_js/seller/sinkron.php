<?php include 'Seller.php' ?>

<script type="text/javascript">
   class Sinkron {
      constructor() {
         this.run();
      }

      run() {
         callApi("seller/sinkron/sync_key", {
            client_token: $jp_client_token
         }, e => {
            $("form.sync input.key").val(e.Data[0].kasier_sync_key);
         });
      }

      save() {
         callApi("seller/sinkron/sync_key_save", {
            client_token: $jp_client_token,
            key: $("form.sync input.key").val()
         }, e => {
            if(e.Error == true) {
               $("div.message").html(`
                  <div class="alert alert-danger">${e.Message}</div>
               `);
            }else {
               $("div.message").html(`
                  <div class="alert alert-success">${e.Message}</div>
               `);

               sinkron._sync_etalase();
            }
         })
      }

      _sync_etalase() {
         $("div.output").append(`
            <div class="alert alert-primary">Sinkronsasi etalase sedang berjalan.</div>
         `);
         callApi("seller/sinkron/etalase", {
            client_token: $jp_client_token
         }, e => {
            $("div.output").append(`
               <div class="alert alert-success">Sinkronsasi etalase berhasil.</div>
            `);
            sinkron._sync_produk();
         })
      }

      _sync_produk() {
         $("div.output").append(`
            <div class="alert alert-primary">Sinkronsasi produk sedang berjalan.</div>
         `);
         callApi("seller/sinkron/produk", {
            client_token: $jp_client_token
         }, e => {
            $("div.output").append(`
               <div class="alert alert-success">Sinkronsasi produk berhasil.</div>
            `);
         })
      }
   }

   var sinkron = new Sinkron;

   $(document).on("submit", "form.sync", function() {
      sinkron.save();

      return false;
   })
</script>
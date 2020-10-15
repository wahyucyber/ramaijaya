<?php include 'Seller.php' ?>

<script type="text/javascript">
   class Etalase {
      constructor() {
         this.get();
      }

      get() {
         const data = {
            client_token: $jp_client_token
         };

         var table = new Table;

         table.run({
            tabel: "table.etalase",
            url: "seller/etalase/get",
            data: data,
            columns: [
               {
						data: null,
						render: function (data, type, row, meta) {
							return meta.row + meta.settings._iDisplayStart + 1 + '.';
						}
					},
               {
                  data: "nama"
               },
               {
                  data: null,
                  render: e => {
                     return `
                        <button type="button" class="btn btn-primary edit" data-toggle="modal" data-target="#edit" data-id="${e.id}" data-nama="${e.nama}"><i class="fas fa-edit"></i></button>
                        <button type="button" class="btn btn-danger delete" data-toggle="modal" data-target="#delete" data-id="${e.id}" data-nama="${e.nama}"><i class="fas fa-trash"></i></button>
                     `;
                  }
               }
            ]
         });
      }

      add(params) {
         callApi("seller/etalase/add", params, e => {
            if (e.Error) {
               notif('div.modal#add form div.message','danger',e.Message)
            }else{
               $("div.modal#add form div.message").html(``);
               $("div.modal#add form input").val(``);
               $("div.modal#add").modal('hide');
               etalase.get();
            }
         })
      }

      update(params) {
         callApi("seller/etalase/update", params, e => {
            if (e.Error) {
               notif('div.modal#edit form div.message','danger',e.Message)
            }else{
               $("div.modal#edit form div.message").html(``);
               $("div.modal#edit form input").val(``);
               $("div.modal#edit").modal('hide');
               etalase.get();
            }
         })
      }

      delete(params) {
         callApi("seller/etalase/delete", params, e => {
            $("div.modal#delete").modal('hide');
            etalase.get();
         })
      }
   }

   var etalase = new Etalase;

   $(document).on("click", "button.btn-refresh", function() {
      etalase.get();
   })

   $(document).on("submit", "div.modal#add form", function() {
      let nama = $("div.modal#add form input.nama").val();

      etalase.add({
         client_token: $jp_client_token,
         nama: nama
      });

      return false;
   })

   $(document).on("click", "button.edit", function() {
      let id = $(this).data('id');
      let nama = $(this).data('nama');

      $("div.modal#edit input.id").val(id);
      $("div.modal#edit input.nama").val(nama);
   })
   
   $(document).on("submit", "div.modal#edit form", function() {
      let id = $("div.modal#edit input.id").val();
      let nama = $("div.modal#edit input.nama").val();

      etalase.update({
         client_token: $jp_client_token,
         id: id,
         nama: nama
      });

      return false;
   })

   $(document).on("click", "button.delete", function() {
      let id = $(this).data('id');
      let nama = $(this).data('nama');

      $("div.modal#delete div.alert").html(`Apakah anda yakin ingin menghapus etalase <b>${nama}</b>?`);
      $("div.modal#delete input[type=hidden].id").val(id);
   })

   $(document).on("click", "button._deleted-it", function() {
      let id = $("div.modal#delete input[type=hidden].id").val();

      etalase.delete({
         client_token: $jp_client_token,
         id: id
      });
   })
</script>
<section class="dashboard_store">
	<?php $this->load->view('seller/sidebar') ?>
   <div class="content-right" id="content-right">
      <div class="clearfix mb-1">
         <div class="float-left">
            <h5 class="fs-20 mb-3 badge badge-success bg-orange"><i class="fal fa-briefcase "></i>	Daftar etalase</h5>
         </div>
         <div class="float-right">
            <button class="btn btn-warning btn-sm btn-refresh"><i class="fa fa-retweet"></i>	Refresh</button>
            <button type="button" data-toggle="modal" data-target="#add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah etalase</button>
         </div>
      </div>
      <div class="card">
         <div class="card-body">
            <div class="table-responsive">
               <table class="table table-hover table-condensed table-striped etalase" style="width: 100%;">
                  <thead class="bg-orange text-white">
                     <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Aksi</th>
                     </tr>
                  </thead>
                  <tbody>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</section>

<div class="modal fade" id="add">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header bg-orange text-white">
            Tambah etalase
         </div>
         <form>
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-12 message"></div>
                  <div class="col-md-12">
                     <div class="form-group">
                        <label for="" class="control-label">Nama</label>
                        <input type="text" name="" id="" class="form-control nama" maxlength="100">
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fal fa-times-circle"></i> Batal</button>
               <button type="submit" class="btn btn-success btn-sm"><i class="fal fa-save"></i>	Simpan</button>
            </div>
         </form>
      </div>
   </div>
</div>

<div class="modal fade" id="edit">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header bg-orange text-white">
            Tambah etalase
         </div>
         <form>
            <input type="hidden" name="" class="id">
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-12 message"></div>
                  <div class="col-md-12">
                     <div class="form-group">
                        <label for="" class="control-label">Nama</label>
                        <input type="text" name="" id="" class="form-control nama" maxlength="100">
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fal fa-times-circle"></i> Batal</button>
               <button type="submit" class="btn btn-success btn-sm"><i class="fal fa-save"></i>	Simpan</button>
            </div>
         </form>
      </div>
   </div>
</div>

<div class="modal fade" id="delete">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            Konfirmasi
         </div>
         <div class="modal-body">
            <div class="alert alert-warning">
            </div>
         </div>
         <div class="modal-footer">
            <input type="hidden" name="" class="id">
            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fal fa-times-circle"></i> Batal</button>
            <button type="button" class="btn btn-success btn-sm _deleted-it"><i class="fal fa-trash"></i> Hapus</button>
         </div>
      </div>
   </div>
</div>
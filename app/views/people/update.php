<div class="container">

	<h4 class="nama-user-atas"><i class="far fa-user mb-3"></i>&nbsp Nama User</h4>

	<div class="card">
			
		<ul class="nav nav-tabs" id="searchTabs" role="tablist">
		  <li class="nav-item">
		    <a class="nav-link active" id="biodata-tab" data-toggle="tab" href="#biodata" role="tab" aria-controls="biodata" aria-selected="true"><i class="fas fa-user-friends icon"></i> Biodata Diri</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" id="alamat-tab" data-toggle="tab" href="#alamat" role="tab" aria-controls="alamat" aria-selected="false"><i class="fas fa-globe-asia icon"></i> Daftar Alamat</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" id="pembayaran-tab" data-toggle="tab" href="#pembayaran" role="tab" aria-controls="pembayaran" aria-selected="false"><i class="fa fa-dollar-sign icon"></i> Pembayaran</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" id="rekening-tab" data-toggle="tab" href="#rekening" role="tab" aria-controls="rekening" aria-selected="false"><i class="fa fa-credit-card icon"></i> Rekening Bank</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" id="notifikasi-tab" data-toggle="tab" href="#notifikasi" role="tab" aria-controls="notifikasi" aria-selected="false"><i class="far fa-bell icon"></i> Notifikasi</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" id="keamanan-tab" data-toggle="tab" href="#keamanan" role="tab" aria-controls="keamanan" aria-selected="false"><i class="fas fa-lock icon"></i> Keamanan</a>
		  </li>
		</ul>

		<div class="tab-content p-3 " id="searchTabsContent">

			<div class="tab-pane fade show active" id="biodata" role="tabpanel" aria-labelledby="biodata-tab">
				
				<div class="row">

					<div class="col-md-4">

						<div class="card">
							
							<div class="card-body">
								
								<img src="https://ecs7.tokopedia.net/img/cache/300/default_picture_user/default_toped-15.jpg" class="w-100">
								<button class="btn btn-block btn-outline-primary mt-3 mb-3">Pilih Foto</button>
								<small>Besar file: maksimum 10.000.000 bytes (10 Megabytes)</small>
								<br>
								<small>Ekstensi file yang diperbolehkan: .JPG .JPEG .PNG</small>

							</div>

						</div>

					</div>

					<div class="col-md-8">
						
						<h6 class="ubah-biodata-diri"><b>Ubah Biodata Diri</b></h6>

						<div class="row">
							
							<div class="col-md-3 mt-1">
								<h6 class="label-edit-profil">Sekolah </h6>
								<h6 class="label-edit-profil">Berdiri </h6>
							</div>

							<div class="col-md-9 mt-1">
								<h6 class="label-edit-profil"><h6 class="label-biodata">Sekolah :</h6>SMK / SMA / SMP /SD</h6>
								<h6 class="label-edit-profil"><h6 class="label-biodata mt-3">Berdiri :</h6>4 September 2002 &emsp;
									<!-- Button trigger modal -->
									<a href="" type="" class="btn text-primary p-0" data-toggle="modal" data-target="#ModalTanggal">
									  Ubah
									</a>

									<!-- Modal -->
									<div class="modal fade" id="ModalTanggal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									  <div class="modal-dialog modal-dialog-centered" role="document">

									    <div class="modal-content">

									      <div class="modal-body">
									      	<h5 class="modal-title text-center" id="exampleModalLabel"><b>Ubah Tanggal Berdiri</b><button type="button" class="close" data-dismiss="modal" aria-label="Close">
									          <span aria-hidden="true">&times;</span>
									        </button></h5>
									      	<p class="text-center mt-3">Kamu hanya dapat mengubah tanggal berdiri satu kali. Pastikan tanggal berdiri sudah benar</p>
									        <div class="row mb-5 mt-5">
									        	<div class="col-md-4">
									        		<select class="form-control">
										        		<option>1</option>
										        		<option>2</option>
										        		<option>3</option>
										        	</select>
									        	</div>
									        	<div class="col-md-4">
									        		<select class="form-control">
										        		<option>Januari</option>
										        		<option>Februari</option>
										        		<option>Maret</option>
										        	</select>
									        	</div>
									        	<div class="col-md-4">
									        		<select class="form-control">
										        		<option>2001</option>
										        		<option>2002</option>
										        		<option>2003</option>
										        	</select>
									        	</div>

									        </div>
									        <button type="button" class="btn btn-primary btn-block"><i class="far fa-save"></i>&nbsp Simpan</button>
									      </div>
									    </div>
									  </div>
									</div>
								</h6>

							</div>

						</div>

						<h6 class="mt-5"><b>Ubah Kontak</b></h6>

						<div class="row">
							
							<div class="col-md-3 mt-1">
								<h6 class="label-edit-profil">Email</h6>
								<h6 class="label-edit-profil">Nomor HP</h6>
							</div>

							<div class="col-md-9 mt-2">
								<h6 class="label-edit-profil"><h6 class="label-biodata">Email :</h6>sekolah@gmail.com &emsp; <a href="#" class="badge badge-primary"><i class="fas fa-check"></i>Terverifikasi</a> &emsp;</h6>

								<h6 class="label-edit-profil"><h6 class="label-biodata">Nomor HP :</h6>0823-1325-8715 &emsp; <a href="#" class="badge badge-primary"><i class="fas fa-check"></i>Terverifikasi</a> &emsp; 
									<!-- Button trigger modal -->
									<a href="" type="" class="btn text-primary p-0" data-toggle="modal" data-target="#ModalHP">
									  Ubah
									</a>

									<!-- Modal -->
									<div class="modal fade" id="ModalHP" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									  <div class="modal-dialog modal-dialog-centered" role="document">

									    <div class="modal-content">

									      <div class="modal-body">
									      	<h5 class="modal-title text-center" id="exampleModalLabel">Yakin ingin Mengubah Nomor Telepon?<button type="button" class="close m-0" data-dismiss="modal" aria-label="Close">
									          <span aria-hidden="true">&times;</span>
									        </button></h5>
									        
									        <p class="mt-4 text-center"><b>Apabila terjadi perubahan nomor ponsel:</b></p>

									        <div class="row">
									        	<div class="col-md-2 text-right">
									        		<img src="http://cdn.onlinewebfonts.com/svg/img_418389.png" class="w-50">
									        	</div>
									        	<div class="col-md-10">
									        		<small>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
									        		tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
									        		quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
									        		consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
									        		cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
									        		proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</small>
									        	</div>
									        </div>

									        <div class="row">
									        	<div class="col-md-6">
									        		<button type="button" class="btn btn-block mt-4 btn-secondary" data-dismiss="modal">Batal</button>
									        	</div>
									        	<div class="col-md-6">								        		
		        									<button type="button" class="btn btn-block mt-4 btn-primary">Ubah Nomor Ponsel</button>
									        	</div>
									        </div>

									    </div>
									</div>
								</h6>
							</div>

						</div>
						
					</div>
				</h6>
			</div>
		</div>

				</div>
			</div>

			<div class="tab-pane fade" id="alamat" role="tabpanel" aria-labelledby="alamat-tab">
				
				<div class="row mt-4">
					
					<div class="col-md-3">
						<button class="btn btn-primary btn-tambah-alamat"><i class="fas fa-plus"></i>&nbsp Tambah Alamat Baru</button>
					</div>

					<div class="col-md-2 txt-urutkan-edit">
						<span>Urutkan</span>
					</div>

					<div class="col-md-3">

						<select class="form-control">
							<option>Alamat Terbaru</option>
							<option>Nama Alamat</option>
							<option>Nama Penerima</option>
						</select>
					</div>

					<div class="col-md-4 input-cari-edit">
						<div class="input-group">
							<input type="text" class="form-control" name="q" placeholder="Cari buku..." value="" id="navbar-search-input" autocomplete="off">
							<div class="input-group-append">
								<button class="btn btn-primary" type="submit" id="btn-search-query"><i class="fa fa-search"></i></button>
							</div>
						</div>
					</div>

				</div>

				<table class="table table-responsive mt-5">
				  <thead>
				    <tr>
				      <th scope="col"></th>
				      <th scope="col" width="15%">Penerima</th>
				      <th scope="col" width="25%">Alamat Pengiriman</th>
				      <th scope="col" width="25%">Daerah Pengiriman</th>
				      <th scope="col" width="10%" class="">Pin Point</th>
				      <th scope="col"></th>
				    </tr>
				  </thead>

				  <tbody>
				    <tr>
				      <th scope="row"><input type="radio" aria-label="Radio button for following text input" value=""></th>
				      <td>
				      	<h6><b>SMKN 1 Lumajang</b></h6>
				      	<small>6282313258715</small>
				      </td>

				      <td>
				      	<h6><b>Sekolah</b></h6>
				      	<small>Jln. H.O.S Cokroaminoto, Lumajang</small>
				      </td>

				      <td>Jawa Timur, Kab. Lumajang, Indonesia</td>

				      <td class="text-center"><i class="fas fa-map-marker-alt"></i></td>

				      <td>
				      	<div class="row">
				      		<button class="btn btn-outline-secondary"><i class="far fa-edit"></i>&nbsp Ubah</button>
				      		<button class="btn btn-outline-secondary"><i class="far fa-trash-alt"></i>&nbsp Hapus</button>
				      	</div>
				      </td>
				    </tr>
				  </tbody>
				</table>

			</div>

			<div class="tab-pane fade" id="pembayaran" role="tabpanel" aria-labelledby="pembayaran-tab">
				
				<div class="row">
					
					<div class="col-md-5 mt-5">
						<h4>Hai SMKN 1 Lumajang</h4>
						<h4><b>Pengaturan Pembayaran</b></h4>

						<small>Atur pembayaran Anda untuk meningkatkan keamanan dan kemudahan berbelanja Anda di JP Mall.</small>

						<div class="card mt-5">
							<div class="card-header">
								<a href="" class="d-block">

									<div class="row">
										
										<div class="col-md-6">
											<h6>Kartu Kredit / Debit</h6>											
										</div>

										<div class="col-md-6 text-right">
											<h6>0/4 Tersimpan</h6>											
										</div>

									</div>
								</a>
							</div>

						</div>

					</div>

					<div class="col-md-7 kartu-debit-kanan">
						<div class="card">
							<div class="card-header">

								<div class="row">

									<div class="col-md-6">
										<h6>Kartu Kredit / Debit</h6>
									</div>

									<div class="col-md-6 text-right">
										<h6><a href="">Pengaturan Verifikasi</a></h6>
									</div>

								</div>

							</div>

							<div class="card-body text-center">
								<img src="https://ecs7.tokopedia.net/img/toppay/empty-cc.svg" class="w-50 mt-5">
								<p>Untuk kemudahan pembayaran kartu kredit / debit, simpan informasi kartu kredit / debit Anda.</p>
								<button class="btn btn-outline-primary mb-5">Tambah Kartu Kredit / Debit</button>
							</div>
						</div>
					</div>

				</div>

			</div>

			<div class="tab-pane fade text-center" id="rekening" role="tabpanel" aria-labelledby="rekening-tab">
				<img src="https://ecs7.tokopedia.net/img/empty-bank-accounts.svg" class="mt-5">

				<h6><b>Oops, rekening bank masih kosong</b></h6>
				<h6>Tambahkan rekening bank untuk mempermudah proses penarikan dana</h6>

				<button class="btn btn-primary mb-5">Tambah Rekening</button>

			</div>

			<div class="tab-pane fade" id="notifikasi" role="tabpanel" aria-labelledby="notifikasi-tab">
				<h4 class="mt-3"><b>Notifikasi</b></h4>
				<h6>Setiap notifikasi yang Anda aktifkan, akan Anda terima melalui email</h6>

				<div class="row mt-5 row-notifikasi">
					<div class="col-md-1 img-notifikasi-edit">
						<i class="fa fa-comment-dots fs-23"></i>
					</div>

					<div class="col-md-9">
						<h6><b>Ulasan</b></h6>
						<small>Setiap ulasan dan komentar yang saya terima</small>
					</div>

					<div class="col-md-2">
						<div class="custom-control custom-switch">
						  <input type="checkbox" class="custom-control-input" id="customSwitch1">
						</div>
					</div>

				</div>

				<hr>

				<div class="row row-notifikasi">
					<div class="col-md-1 img-notifikasi-edit">
						<i class="fa fa-comments fs-23"></i>
					</div>

					<div class="col-md-9">
						<h6><b>Diskusi Produk</b></h6>
						<small>Setiap pertanyaan dan komentar diskusi yang saya terima</small>
					</div>

					<div class="col-md-2">
						<div class="custom-control custom-switch">
						  <input type="checkbox" class="custom-control-input" id="customSwitch1">
						</div>
					</div>

				</div>

				<hr>

				<div class="row row-notifikasi">
					<div class="col-md-1 img-notifikasi-edit">
						<i class="fas fa-comment fs-23"></i>
					</div>

					<div class="col-md-9">
						<h6><b>Chat</b></h6>
						<small>Setiap chat yang saya terima</small>
					</div>

					<div class="col-md-2">
						<div class="custom-control custom-switch">
						  <input type="checkbox" class="custom-control-input" id="customSwitch1">
						</div>
					</div>

				</div>

				<hr>

				<div class="row row-notifikasi">
					<div class="col-md-1 img-notifikasi-edit">
						<i class="fas fa-users fs-23"></i>
					</div>

					<div class="col-md-9">
						<h6><b>Chat JP Mall Administrator</b></h6>
						<small>Setiap chat dari Tokopedia Administrator yang saya terima</small>
					</div>

					<div class="col-md-2">
						<div class="custom-control custom-switch">
						  <input type="checkbox" class="custom-control-input" id="customSwitch1">
						</div>
					</div>

				</div>

				<hr>

				<div class="row row-notifikasi">
					<div class="col-md-1 img-notifikasi-edit">
						<i class="fas fa-chart-pie fs-23"></i>
					</div>

					<div class="col-md-9">
						<h6><b>Laporan Toko Mingguan</b></h6>
						<small>Kirim laporan toko & produk via Seller Info</small>
					</div>

					<div class="col-md-2">
						<div class="custom-control custom-switch">
						  <input type="checkbox" class="custom-control-input" id="customSwitch1">
						</div>
					</div>

				</div>

				<hr>

				<div class="row row-notifikasi">
					<div class="col-md-1 img-notifikasi-edit">
						<i class="fas fa-project-diagram fs-23"></i>
					</div>

					<div class="col-md-9">
						<h6><b>Laporan Transaksi Bulanan</b></h6>
						<small>Kirim Laporan Bulanan via email</small>
					</div>

					<div class="col-md-2">
						<div class="custom-control custom-switch">
						  <input type="checkbox" class="custom-control-input" id="customSwitch1">
						</div>
					</div>

				</div>

				<hr>

				<div class="row row-notifikasi">
					<div class="col-md-1 img-notifikasi-edit">
						<i class="fas fa-newspaper fs-23"></i>
					</div>

					<div class="col-md-9">
						<h6><b>Buletin Tokopedia</b></h6>
						<small>Setiap promo, tips & trik, informasi terbaru seputar Tokopedia untuk saya</small>
					</div>

					<div class="col-md-2">
						<div class="custom-control custom-switch">
						  <input type="checkbox" class="custom-control-input" id="customSwitch1">
						</div>
					</div>

				</div>



			</div>

			<div class="tab-pane fade" id="keamanan" role="tabpanel" aria-labelledby="keamanan-tab">
				
				<div class="row">
					
					<div class="col-md-5 mt-5 text-center">
						<h5>Hai Septian Iqbal Pratama,</h5>
						<h5>Atur <b>Keamanan Akun</b> Anda di sini</h5>

						<button class="btn btn-outline-primary btn-block mt-5 btn-aktivitas-login">Aktivitas Login</button>
					</div>

					<div class="col-md-7">
						
						<div class="card">
							
							<div class="card-body">
								<h5 class="text-center mt-3"><b>Aktivitas Login</b></h5>

								<div class="alert alert-primary mt-3 text-center" role="alert">
								  <small>Bila terdapat aktivitas tidak dikenal, segera klik "Keluar" dan <a href="">ubah kata sandi.</a></small>
								</div>

								<h6 class="mt-4">Aktivitas login saat ini</h6>

								<div class="row mt-4">
									<div class="col-md-1">
										
									</div>
									<div class="col-md-11">
										<h6><b>Chrome di Windows 10</b></h6>
										<h6 class=" text-white-lightern-3" title="">Gresik &#9679; 182.1.85.221 </h6>
										<span class="badge badge-primary">Sedang Aktif</span>

									</div>
								</div>

								<hr>

								<h6 class="mt-4">Riwayat dalam 30 hari terakhir</h6>

								<div class="row mt-4">
									<div class="col-md-1">
										
									</div>
									<div class="col-md-11">
										<h6><b>Chrome di Windows 10</b></h6>
										<h6 class=" text-white-lightern-3" title="">Gresik &#9679; 182.1.85.221 </h6>
										<small>Aktif 18 Mar 2019, 09.33 WIB</small>

									</div>
								</div>

							</div>

						</div>
					</div>

				</div>

			</div>
		</div>


	</div><!-- card -->

</div><!-- container -->


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Berhasil Membuat Akun</title>
</head>
<body bgcolor="#eee" style="background: #eee">
	<div bgcolor="">
        <table border="0" cellspacing="0" cellpadding="0" align="center" style="min-width:520px">
			<tbody>
	          	<tr>
	          		<td align="center" style="padding-top:20px">
			            <a href="" target="_blank"><img width="150" border="0" src="<?= app_url('storage/favicon.png'); ?>" alt="<?= env('APP_NAME'); ?>" style="text-align:center;border:none"></a>
			        </td>
			    </tr>
				<tr><td height="15"></td></tr>
				<tr>
					<td width="550" style="border-radius:8px;background: #fff;overflow: hidden">
						<div style="text-align: center; padding: .5rem 1rem;background: #007bff;vertical-align: middle;min-height: 150px;color: #fff">
							<p style="line-height: 100px;font-size: 25px;font-family:&quot;Helvetica Neue&quot;,Arial,sans-serif">Akun Berhasil Dibuat</p>
						</div>
						<table style="border-collapse:collapse;border-spacing:0;width:100%;margin:0;padding:0" bgcolor="transparent">
							<tbody>
								<tr>
									<td style="border-collapse:collapse;font-size:14px;line-height:24px;border-spacing:0;font-family:&quot;Helvetica Neue&quot;,Arial,sans-serif;min-width:8px;margin:0;padding:0"></td>
									<td style="border-collapse:collapse;font-size:14px;line-height:24px;border-spacing:0;font-family:&quot;Helvetica Neue&quot;,Arial,sans-serif;margin:0;padding:20px">
										<h4 style="font-family:&quot;Helvetica Neue&quot;,Arial,sans-serif;font-size:14px;margin:0;padding: 0">
											<!-- Salam -->
											Hai <?= $nama; ?>,
										</h4>
										<p style="font-family:&quot;Helvetica Neue&quot;,Arial,sans-serif;margin:0;padding:0 0 10px">
											<!-- Teks -->
											Segera lakukan verifikasi email yang Anda gunakan dengan klik tombol <b>Verifikasi</b> dibawah ini
										</p>
										
										<table style="border-collapse:collapse;border-spacing:0;width:100%;margin:0;padding:0" bgcolor="transparent">
											<tbody>
												<tr>
													<td style="border-collapse:collapse;font-size:14px;line-height:24px;border-spacing:0;font-family:&quot;Helvetica Neue&quot;,Arial,sans-serif;margin:0;padding:16px 0 0;text-align: center;">
														<a href="<?= app_url('?member='.$kode.'='.$token); ?>" style="font-family:&quot;Helvetica Neue&quot;,Arial,sans-serif;color:#fff!important;text-decoration:none;font-weight:bold;background-color:#007bff;display:block;border-radius:4px;margin:0;padding:8px" target="_blank"> 
															Verifikasi Sekarang
														</a>
													</td>
												</tr>
											</tbody>
										</table>
										
										<p style="font-family:&quot;Helvetica Neue&quot;,Arial,sans-serif;margin:0;padding:20px 0 0;text-align: center;">
											<!-- Teks -->
											Atau klik link dibawah ini <br>
											<a href="<?= app_url('?member='.$kode.'='.$token); ?>" style="font-family:&quot;Helvetica Neue&quot;,Arial,sans-serif;color:#007bff!important;text-decoration:none;font-weight:bold;display:block;border-radius:4px;margin:0;padding:0;" target="_blank"> 
															<?= app_url('?member='.$kode.'='.$token); ?>
														</a>
											
										</p>
									</td>
									<td style="border-collapse:collapse;font-size:14px;line-height:24px;border-spacing:0;font-family:&quot;Helvetica Neue&quot;,Arial,sans-serif;min-width:8px;margin:0;padding:0"></td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<tr><td height="18"></td></tr>
				<tr>
					<td width="550" style="border-radius:8px;">
						<table style="border-collapse:collapse;border-spacing:0;width:100%;margin:0;padding:0" bgcolor="transparent">
							<tbody>
								<tr>
									<td align="center"><p style="font-size: 13px;color: gray;font-family:&quot;Helvetica Neue&quot;,Arial,sans-serif">Copyright &copy; 2020 <?= env('APP_NAME') ?> All Rights Reserved</p></td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
	        </tbody>
	    </table>
        <div style="display:none;white-space:nowrap;font:15px courier;line-height:0">
	        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
	        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
        </div>
	</div>
</body>
</html>
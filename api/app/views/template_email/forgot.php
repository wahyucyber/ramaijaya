<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Reset Password</title>
</head>
<body bgcolor="#eee" style="background: #eee">
	<div bgcolor="">
        <table border="0" cellspacing="0" cellpadding="0" align="center" style="min-width:520px">
			<tbody>
	          	<tr>
	          		<td align="center" style="padding-top:20px">
			            <a href="" target="_blank"><img width="150" border="0" src="<?= base_url('storage/favicon.png'); ?>" alt="<?= env('APP_NAME'); ?>" style="text-align:center;border:none"></a>
			        </td>
			    </tr>
				<tr><td height="15"></td></tr>
				<tr>
					<td width="550" style="border-radius:8px;background: #fff;overflow: hidden">
						<div style="text-align: center; padding: .5rem 1rem;background: #007bff;vertical-align: middle;min-height: 150px;color: #fff">
							<p style="line-height: 100px;font-size: 25px;font-family:&quot;Helvetica Neue&quot;,Arial,sans-serif">Reset Password</p>
						</div>
						<table style="border-collapse:collapse;border-spacing:0;width:100%;margin:0;padding:0" bgcolor="transparent">
							<tbody>
								<tr>
									<td style="border-collapse:collapse;font-size:14px;line-height:24px;border-spacing:0;font-family:&quot;Helvetica Neue&quot;,Arial,sans-serif;min-width:8px;margin:0;padding:0"></td>
									<td style="border-collapse:collapse;font-size:14px;line-height:24px;border-spacing:0;font-family:&quot;Helvetica Neue&quot;,Arial,sans-serif;margin:0;padding:20px">
										<h4 style="font-family:&quot;Helvetica Neue&quot;,Arial,sans-serif;font-size:14px;margin:0;padding: 0">
											<!-- Salam -->
											Hai <?= $name; ?>,
										</h4>
										<p style="font-family:&quot;Helvetica Neue&quot;,Arial,sans-serif;margin:0;padding:0 0 10px">
											<!-- Teks -->
											Kami dengar anda membutuhkan reset password. Klik tautan di bawah dan anda diarahkan ke situs yang aman tempat anda dapat mengatur password baru amda
										</p>
										<table style="border-collapse:collapse;border-spacing:0;width:100%;margin:0;padding:0" bgcolor="transparent">
											<tbody>
												<tr>
													<td style="border-collapse:collapse;font-size:14px;line-height:24px;border-spacing:0;font-family:&quot;Helvetica Neue&quot;,Arial,sans-serif;margin:0;padding:16px 0 0;text-align: center;">
														<a href="<?= base_url('forgot/').$token; ?>&&<?= md5($email); ?>?success=true" style="font-family:&quot;Helvetica Neue&quot;,Arial,sans-serif;color:#fff!important;text-decoration:none;font-weight:bold;background-color:#007bff;display:block;border-radius:4px;margin:0;padding:8px" target="_blank"> 
															Ubah Password
														</a>
													</td>
												</tr>
											</tbody>
										</table>
									</td>
									<td style="border-collapse:collapse;font-size:14px;line-height:24px;border-spacing:0;font-family:&quot;Helvetica Neue&quot;,Arial,sans-serif;min-width:8px;margin:0;padding:0"></td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<tr><td height="18"></td></tr>
	        </tbody>
	    </table>
        <div style="display:none;white-space:nowrap;font:15px courier;line-height:0">
	        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
	        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
        </div>
	</div>
</body>
</html>
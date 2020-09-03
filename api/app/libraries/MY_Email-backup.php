<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . "libraries/phpmailer/Exception.php";
require APPPATH . "libraries/phpmailer/PHPMailer.php";
require APPPATH . "libraries/phpmailer/SMTP.php";

// require APPPATH . "libraries/swiftmailer/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MY_Email {

	public function send_email($to,$subject,$html)
	{
	    
	   // $mail = new PHPMailer;
    //     $mail->isSMTP();
    //     $mail->Host = env('MAIL_HOST');
    //     $mail->Username = env('MAIL_USERNAME');
    //     $mail->Password = env('MAIL_PASSWORD');
    //     $mail->Port = env('MAIL_PORT');
    //     $mail->SMTPAuth = true;
    //     $mail->SMTPSecure = env('MAIL_SMTPSECURE');
    //     $mail->setFrom(env('MAIL_USERNAME'), env('MAIL_NAME'));
    //     $mail->addAddress($to);
    //     $mail->isHTML(true);
    //     $mail->Subject = $subject;
    //     $mail->Body = $html;
    //     $send = $mail->send();
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = 'jkt16.dewaweb.com';
        $mail->Username = "admin@jpstore.id";
        $mail->Password = "Jp_tmG45";
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPDebug = 0;
        $mail->setFrom("admin@jpstore.id", "JPStore");
        // $mail->addAddress("m.nur.wahyu1974@gmail.com");
        $mail->addAddress($to);
        $mail->isHTML(true);
        // $mail->Subject = "test";
        $mail->Subject = $subject;
        $mail->Body = "<div style='color: red;'>test</div>";
        // $mail->Body = $html;
        $mail->send();
        
        $result['Error'] = false;
        $result['Message'] = "Berhasil mengirim email ke $to";
        goto output;
	    
        // Create the Transport
        // $transport = (new Swift_SmtpTransport('jkt16.dewaweb.com', 587, 'tls'))
        //   ->setUsername('admin@jpstore.id')
        //   ->setPassword('Jp_tmG45')
        // ;
        
        // // Create the Mailer using your created Transport
        // $mailer = new Swift_Mailer($transport);
        
        // // Create a message
        // $message = (new Swift_Message("$subject"))
        //   ->setFrom(['admin@jpstore.id' => 'JPStore'])
        //   ->setTo(["$to"])
        //   ->setBody(env('MAIL_TEMPLATE_HEADER'), 'text/html')
        //   ;
        
        // // Send the message
        // $result_mail = $mailer->send($message);
        // goto output;

        output:
        return $result;
    }

	public function template_email($subject,$name,$url)
	{
		$html = '<!DOCTYPE html>
					<html lang="en">
					  <head>
					    <title>'.$subject.'</title>
					    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					    <meta name="viewport" content="width=device-width, initial-scale=1">
					    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
					    <style>
					    	* {
					    		margin: 0;
					    		padding: 0;
					    	}
					    </style>
					  </head>
					  <body style="
						background: #F3F3F3
					  ">
						  
						  <div style="
							width: 100%;
							min-height: 100vh;
							display: flex;
							align-items: center;
							justify-content: center;
							font-family: Arial;
							padding: 20px 0;
						  ">
						  	
						  	<div style="
							  	width: 420px;
								min-height: 400px;
						  		margin: auto;
						  		padding: 0 15px;
						  	">

						  		<div style="
						  			width: 100%;
									background: #fff;
									border-radius: 6px;
									overflow: hidden;
									margin-bottom: 20px;
						  		">
						  			<div style="
						  				width: 100%;
										height: 150px;
										/* background: #34B6EAFF; */
										background: url('.env('MAIL_TEMPLATE_HEADER').');
										background-size: 100%;
										background-repeat: no-repeat;
						  			">
						  			</div>
						  			<div style="
						  				padding: 20px;
						  			">
						  				
						  				<div style="
						  					text-align: center;
						  					padding: 10px 0;
						  				">

						  					<h1 style="
						  						font-weight: normal;
						  						color: #343a40;
						  						margin-bottom: 10px;
						  					">'.$subject.'</h1>

							  				<p style="
							  					color: #6c757d;
							  					margin-bottom: 15px;
							  					line-height: 1.5;
							  				">
							  					Hai, '.$name.'<br>
							  					<span style="
							  						color: #6c757d;
							  					">
							  						Segera lakukan verifikasi email yang Anda gunakan dengan klik tombol <b>Konfirmasi</b> dibawah ini
							  					</span>
							  				</p>

											<a href="'.app_url($url).'" style="
												text-decoration: none;
												padding: 10px 30px;
												border-radius: 4px;
												background: #FDB401FF;
												text-align: center;
												display: inline-block;
												color: #fff;
												box-shadow: 0 0 4px rgba(211,211,211,.7);
											">Konfirmasi</a>
						  					
						  				</div>

						  			</div>
						  		</div>

						  		<div style="
						  			text-align: center;
									color: #969696FF;
						  		">

									<h3 style="
										font-size: 22px;
										font-weight: normal;
										font-style: italic;
										margin-bottom: 10px;
									">Stay in touch</h3>

									<div style="
										display: flex;
										justify-content: center;
										margin-bottom: 15px;
									">
										<div style="
											margin: 0 auto;
										">
												<img src="'.env('MAIL_TEMPLATE_TWITTER').'" alt="Twitter" style="
												width: 30px;
												height: 30px;
												margin: 0 10px;
											">
											<img src="'.env('MAIL_TEMPLATE_FACEBOOK').'" alt="Facebook" style="
												width: 30px;
												height: 30px;
												margin: 0 10px;
											">
											<img src="'.env('MAIL_TEMPLATE_BOX').'" alt="Message" style="
												width: 30px;
												height: 30px;
												margin: 0 10px;
											">
										</div>
									</div>
									
									<p>
										<small>Copyright &copy; 2019 '.env('APP_NAME').'</small>
									</p>

								</div>

						  	</div>

						  </div>

					  </body>
					</html>';

		return $html;
	}

	public function debug()
	{
		return $this->print_debugger();
	}

}

/* End of file MY_Email.php */
/* Location: .//F/xampp/htdocs/com/JPStore/api/base/libraries/MY_Email.php */
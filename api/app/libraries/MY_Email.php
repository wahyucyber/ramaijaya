<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/swiftmailer/autoload.php';

class MY_Email {

// 	public function send_email($to,$subject,$html)
// 	{
//         $mail = new PHPMailer;
//         $mail->isSMTP();
//         $mail->Host = env('MAIL_HOST');
//         $mail->Username = env('MAIL_USERNAME');
//         $mail->Password = env('MAIL_PASSWORD');
//         $mail->Port = env('MAIL_PORT');
//         $mail->SMTPAuth = false;
//         $mail->SMTPAutoTLS = false; 
//         $mail->SMTPSecure = env('MAIL_SMTPSECURE');
//         $mail->setFrom(env('MAIL_USERNAME'), env('MAIL_NAME'));
//         $mail->addAddress($to);
//         $mail->isHTML(true);
//         $mail->Subject = $subject;
//         $mail->Body = $html;
//         $send = $mail->send();
//         if($send){
//             $result['Error'] = false;
//             $result['Message'] = "Berhasil mengirim email ke $to";
//             goto output;
//         }
        
//         $result['Error'] = true;
//         $result['Message'] = "Gagal mengirim email ke $to";
//         $result['Debug'] = $mail->ErrorInfo;
//         goto output;
        
//         output:
//         return $result;
//     }

    protected $to;
    
	protected $subject;
	
	protected $message;
    
    public function __construct()
    {
        
    }
    
    public function initialize($config)
    {
        $this->to = $config['to'];
        $this->subject = $config['subject'];
        $this->message = $config['message'];
    }
    
    public function send()
    {
        $option['ssl']['verify_peer'] = FALSE;
        $option['ssl']['verify_peer_name'] = FALSE;
		$transport = (new Swift_SmtpTransport(env('MAIL_HOST'), env('MAIL_PORT'), env('MAIL_SMTPSECURE')))
		  ->setUsername(env('MAIL_USERNAME'))
		  ->setPassword(env('MAIL_PASSWORD'))
		  ->setStreamOptions($option);

		$mailer = new Swift_Mailer($transport);

		$message = (new Swift_Message($this->subject))
		  ->setFrom([env('MAIL_USERNAME') => env('MAIL_NAME')])
		  ->setTo([$this->to])
		  ->setBody($this->message, 'text/html');

		$sender = $mailer->send($message);
		if ($sender) {
			$result['Error'] = false;
			$result['Message'] = "Berhasil mengirim email ke $this->to";
			goto output;
		}
		$result['Error'] = true;
		$result['Message'] = "Gagal mengirim email ke $this->to";
		goto output;
		output:
		return $result;
    }

}

/* End of file MY_Email.php */
/* Location: .//F/xampp/htdocs/com/JPStore/api/base/libraries/MY_Email.php */
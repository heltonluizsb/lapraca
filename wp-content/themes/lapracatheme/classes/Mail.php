<?php


	class Mail{

		public $opt,$mailer;
		public $email = 'contato@lapraca.com';//Trocar e-mail aqui!
		public $senha = 'Vamosnessa!2021';//Trocar senha aqui!

		public function __construct(Array $parametros, $subject = null, $body = ''){
			require_once(get_stylesheet_directory().'/classes/phpmailer/PHPMailerAutoload.php');
			$this->mailer = new PHPMailer();

			$this->mailer->IsSMTP();
			$this->mailer->Host = 'securemail.webnames.ca'; //SERVIDOR SMTP DA HOSPEDAGEM
			$this->mailer->Port = 465; //PORTA DO SMTP
			$this->mailer->SMTPDebug = 0;
			$this->mailer->SMTPAuth = true;
			$this->mailer->SMTPSecure = 'ssl';
			$this->mailer->Username = $this->email;
			$this->mailer->Password = $this->senha;

			$this->mailer->IsHTML(true);
			$this->mailer->SingleTo = true;


			$this->mailer->From = $this->email;
			$this->mailer->FromName = $this->email;


			if($subject == null){
				$this->mailer->Subject = 'Nova mensagem do site!';
			}
			else{
				$this->mailer->Subject = $subject;				
			}

			$this->addAddress($this->email,'Administrador');
	
			$this->mailer->Body = $body;

			if($body == ''){
				foreach ($parametros as $key => $value) {
					$body.=ucfirst($key).": ".$value;
					$body.="<hr>";
				}
			}
		}

		public function addAddress($mail,$nome){
			$this->mailer->addAddress($mail,$nome);
			return $this;
		}

		public function sendMail(){
			$this->mailer->CharSet = "utf-8";
			if($this->mailer->send()){
				return true;
			}else{
				return false;
			}
		}


	}

?>
<?php

	class Configuration_Controller extends App_Controller
	{
		public function IMAPmail($ssl=TRUE)
		{
			global $MSG;
			
    			$usuario = $_SESSION['email'];
    			$senha   = $_SESSION['senha'];
    			$retVal = (condition) ? a : b ;
	    		if ($ssl)
	    		{
	    			$mbox = imap_open("{".IMAPPORTOCOLO.".".IMAPSERVIDOR.":".IMAPPORTA."/".IMAPPROTOCOLO."/ssl}", $usuario . "@" . IMAPCONTA, $senha); 
	    		} else
			{
				$mbox = imap_open("{".IMAPPORTOCOLO.".".IMAPSERVIDOR.":".IMAPPORTA."/".IMAPPROTOCOLO."}", $usuario . "@" . IMAPCONTA, $senha);
			}

	    		$erro[] = imap_last_error();

		      if ($erro[0] == "Mailbox is empty") // testo se tem email no servidor
		      {
				$MSG->alert[] = " não tem nenhuma mensagem";
		      	exit;
		      } elseif ($erro[0] == " IMAP connection broken in response")// verifico se esta certo o usuario e senha 
		      {
		      	$MSG->error[] = " Usuario ou a senha estao errados";
		      	exit;
		      } elseif ($erro[0] == "Host not found (#11004): ".IMAPPORTOCOLO.".".IMAPSERVIDOR)// testo se o servidor esta certo
		      {
		      	$MSG->error[] = " O servidor ".IMAPSERVIDOR." esta errado";
		      	exit;
		      } 

    			header('Content-Type: text/html; charset=utf-8');

			if ($erro[0] == "") // se a $erro estiver vazia ele continua
			{
				$numero_mensagens = imap_num_msg($mbox);
				$numero_mens_nao_lidas = imap_num_recent($mbox);
				if (!$_GET['msg_id']) 
				{
					if ($numero_mensagens == 1) 
					{
						echo " você tem $numero_mensagens mensagem <br>";
					} else
					{
						echo "você tem $numero_mensagens mensagens <br>";
					} 
					echo "<br><br>";
					for($i = 1;$i <= imap_num_msg($mbox);$i++) 
					{
						$headers = imap_header($mbox, $i);
						$assunto = $headers->subject;
						$message_id = $headers->message_id;
						$toaddress = $headers->toaddress;
						$to = $headers->to;
						$remetente = $to[0]->personal;
						$email_remetente = $to[0]->mailbox;
						$servidor_remetente = $to[0]->host;
						$data = $headers->date;
						$data = strtotime($data);
						$data = date("d/m/Y H:i:s", $data);
						$emails[$i] = "Assunto = ".imap_utf8($assunto)." - Remetente = ".imap_utf8($email_remetente)."@".imap_utf8($servidor_remetente)." Data = ".imap_utf8($data)." <a href='imap.php?id=".$i."' class='micoxajax loading[Lendo_a_Mensagem]' target='div".$i."'>LEIAME</a><br><div id='div".$i."' class='retornos'></div><br>";
					}
					krsort($emails);
					foreach ($emails as $key => $value) 
					{
						echo $value;
					}
				} else
				{
					echo "<br>";
					if (isset($_GET["id"])) 
					{
						$id = $_GET["id"];
						$mensagem = imap_fetchbody($mbox, $id, 1);
						echo imap_utf8(nl2br(quoted_printable_decode($mensagem)));
					} 
					imap_close($mbox);
				}
			}
		}

		public function POPmail()
		{

		}
	}
?>
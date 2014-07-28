<?php
class App_Controller extends PHPMailer
{
    // redirects to any page
    public function redirect_to($addr="")
    {
        $wwwroot = WWWROOT;
        header("location:$wwwroot/$addr");
    }

    public function paginate($data, $page=0, $factor=10)
    {
        // mounts the pagination numbers
        $total = count($data);
        $pages = round($total/$factor);
        if (round($total/$factor) < ($total/$factor)) $pages++;
        $regex = "/&page=([0-9]{1,3})/";
        $qstr = preg_replace($regex, '', $_SERVER['QUERY_STRING']);
        $paginator = '<div class="pagination pagination-centered"><ul>';
        $paginator .= '<li><a href="?'.$qstr.'&page=1">Primeiro</a></li>';
        if ($pages > 1)
            $paginator .= '<li><a href="?'.$qstr.'&page='.($page-1).'">Anterior</a></li>';
        else
            $paginator .= '<li class="active"><a href="?'.$qstr.'&page='.($page).'">&laquo;</a></li>';
        $start = 1;
        $max = $pages;
        if ($pages > 5)
        {
            $start = $page;
            $max = $start + 5;
        }
        for ($i=$start;$i<=$max;$i++)
        {
            $active = $page == $i ? ' class="active"' : '';
            $paginator .= '<li'.$active.'><a href="?'.$qstr.'&page='.$i.'">'.$i.'</a></li>';
            if ($i==$pages)break;
        }
        if ($pages > 1)
            $paginator .= '<li><a href="?'.$qstr.'&page='.($page+1).'">Próximo</a></li>';
        else
            $paginator .= '<li class="active"><a href="?'.$qstr.'&page='.($page).'">&raquo;</a></li>';
        $paginator .= '<li><a href="?'.$qstr.'&page='.$pages.'">Último</a></li>';
        $paginator .= '</ul></div>';
        // paginates the array
        if (!$page || $page == 1)
        {
            $offset = 0;
        }
        else
        {
            $multiply = (int)$page - 1;
            $offset = $factor * $multiply;
        }
        return array(
            'query' => array_slice($data, $offset, $factor),
            'paginator' => $paginator
        );
    }
    // sends general emails
    public function send_email($destinatario=false, $menssagem=false, $titulo=false)
    {
        global $MSG;

        $mail             = new PHPMailer();

        $body             = ($menssagem) ? $menssagem : "<p>No menssagem!</p>" ;
        $body            .= file_get_contents('contents.html');
        $body             = eregi_replace("[\]",'',$body);
        $mail->IsSMTP(); // telling the class to use SMTP
        $mail->Host       = "localhost"; // SMTP server
        $mail->SMTPDebug  = 1; // enables SMTP debug information (for testing) // 1 = errors and messages // 2 = messages only
        $mail->SMTPAuth   = true;                  // enable SMTP authentication
        $mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
        $mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
        $mail->Port       = 465;                   // set the SMTP port for the GMAIL server
        $mail->Username   = "gcassianof@gmail.com";  // GMAIL username
        $mail->Password   = "sis_cassiano";            // GMAIL password
        $mail->SetFrom('gcassianof@gmail.com', 'AppBus');
        $mail->AddReplyTo("noreply@gmail.com","NoReply");
        $mail->Subject    = ($titulo) ? $titulo : "Alerta Automatico" ;
        $mail->MsgHTML($body);

        if ($destinatario)
        {
            foreach ($destinatario as $nome => $email) 
            {
                $mail->AddAddress($email, "Sr(a). ".$nome);
            }
        } else
        {
            $mail->AddAddress($mail->Username, "No cliente");
        }
        /*
        $mail->AddAttachment("images/phpmailer.gif");      // attachment
        $mail->AddAttachment("images/phpmailer_mini.gif"); // attachment
        */
        if(!$mail->Send()) 
        {
            $MSG->error[] = "Mailer Error: " . $mail->ErrorInfo;
        } else 
        {
            $MSG->success[] = "Menssagem Enviada!";
        }
    }

    // sends authentication email to user
    function send_auth_email($obj, $addr=FALSE)
    {
        if (is_object($obj))
        {
            $body = file_get_contents(WWWROOT."/users/auth?id=".$obj->id);
            $body = eregi_replace("[\]",'',$body);
            return $this->send_email($body, $obj->user_email, $obj->user_full_name, "Please activate your account");
        }
        return false;
    }
}
?>
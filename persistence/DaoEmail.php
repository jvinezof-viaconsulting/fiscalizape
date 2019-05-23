<?php
namespace fiscalizape\persistence;
new \fiscalizape\Autoload("model", "Email");

use \fiscalizape\model\Email;

class DaoEmail extends Email {
    private $email;
    
    private function novoEmail() {
        $this->email = $this->mailer();
    }
    
    private function enviarPara($email, $nome) {
        if (count($email) > 1 && count($nome) > 1) {
            for ($i = 0; i < count($email); $i++) {
                $this->enviarPara($email[$i], $nome[$i]);
            }
        } else {
            $this->email->AddAddress($email, $nome);
        }
    }
    
    private function emailDe($remetenteEmail = '', $remetenteNome = '') {
        # Verificando se foi passado parametros
        
        # Email Destinatario
        if ($remetenteEmail <> '' && $remetenteNome <> '') {
            $remetenteEmail = filter_var($remetenteEmail, FILTER_SANITIZE_EMAIL);
            $remetenteNome = filter_var($remetenteNome, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        } else {
            $remetenteEmail = 'fiscalizapebr@gmail.com';
            $remetenteNome = 'Fiscaliza PE';
        }
        
        $this->email->setFrom($remetenteEmail, $remetenteNome);
    }
    
    private function adicionarAnexo($caminho, $nome = '') {
        # Verificando se foi passado um nome
        if ($nome <> '') {
            $nome = filter_var($nome, FILTER_SANITIZE_SPECIAL_CHARS);
        }
        
        $this->email->addAttachment($caminho, $nome);
    }
    
    public function enviarEmail($destinatario, $destinatarioNome, $assunto, $mensagem, $mensagemSemHTML, $remetente = '', $remetenteNome = '', $charset = 'utf-8') {
        try {
            # Verificando parametros
            # Charset
            if ($charset <> 'utf-8') {
                $charset = filter_var($charset, FILTER_SANITIZE_SPECIAL_CHARS);
            }
            
            $this->novoEmail();
            
            # Remetente do email
            $this->emailDe($remetente, $remetenteNome);
            
            # Para enviar email para mais de uma pessoa
            # Basta adicionar um array em email e um em nome
            $this->enviarPara($destinatario, $destinatarioNome);

            # Definindo dados do email
            # Informando que vai conter html no email
            $this->email->isHTML(true);

            # Definindo o charset como utf
            $this->email->CharSet = $charset;

            # Assunto do email
            $this->email->Subject = $assunto;

            # "Corpo" da mensagem, aqui vai o conteudo do email em si
            $this->email->Body = $mensagem;

            # Aqui é definida a mensagem sem formatação HTML para clientes que não aceitam/suportam formatação html
            $this->email->AltBody = $mensagemSemHTML;
            
            # Finalmente enviando o email
            $this->email->Send();
            return true;
        } catch (Exception $ex) {
            echo 'PHPMailer Erro: ' . $ex->errorMessage();
        } catch (Exception $ex) {
            echo 'PHP Internal Error: ' . $ex->getMessage();
        }
    }
}


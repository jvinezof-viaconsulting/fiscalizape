<?php
namespace fiscalizape\model;
require_once '../vendor/autoload.php';

/**
 * Classe para envio de emails
 *
 * @author João Vinezof.
 *
 * @copyright (c) 2019, FiscalizaPE
 */
class Email {
	private $host;
	private $usuario;
	private $apelido;
	private $senha;
	private $porta;
	private $criptografia;
	private $transporte;
	private $mensagem;
	private $resultado;

	public function __construct($host='', $usuario='', $apelido='', $senha='', $porta='', $criptografia='') {
		if ($host != '') {
			$this->host = $host;
		} else {
			$this->host = 'smtp.gmail.com';
		}

		if (count($usuario) != '' && $apelido != '' && $senha != '') {
			$this->usuario = $usuario;
			$this->senha = $senha;
			$this->apelido = $apelido;
		} else {
			$this->usuario = 'fiscalizapebr@gmail.com';
			$this->senha = 'fiscp3#Br';
			$this->apelido = 'FiscalizaPE';
		}

		if ($porta = '' && $encrypt = '') {
			$this->porta = $porta;
			$this->criptografia = $criptografia;
		} else {
			$this->porta = 587;
			$this->criptografia = 'tls';
		}
	}

	public function getResultado() {
		return $this->resultado;
	}

	private function transporte() {
		$this->transporte = (new \Swift_SmtpTransport($this->host, $this->porta, $this->criptografia))
		->setUsername($this->usuario)
		->setPassword($this->senha)
		;

		return $this->transporte;
	}

	public function mensagem($titulo, $body, $para) {
		$this->mensagem = (new \Swift_Message())
		->setSubject($titulo)
		->setFrom([$this->usuario => $this->apelido])
		->setTo([$para[0] => $para[1]])
		->setBody($body, 'text/html')
		;

		return $this->mensagem;
	}

	public function enviar($mensagem) {
		$mailer = new \Swift_Mailer($this->transporte());
		$this->resultado = $mailer->send($this->mensagem);

		return $this->resultado;
	}
}
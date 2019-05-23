<?php
namespace fiscalizape\util;

class Util {
   # Cria um hash com a senha passada pelo parametro
   public function gerarHash($senha) {
        return password_hash($senha, PASSWORD_DEFAULT);
    }
    # Compara se a senha do usuario está correta, passando a senha digitada e a senha do bd;
    public function compararHash($senha, $hash) {
        if(password_verify($senha, $hash)) {
            return true;
        }

        return false;
    }

    # Validar CEP
    public function validarCep($cep) {
        # acessa o viacep com o cep passado
        $jsonURL = "https://viacep.com.br/ws/" . $cep . "/json/";
        # pega o arquivo json e transforma em uma string
        $jsonFile = file_get_contents($jsonURL);
        # Pega a string e transforma num array
        $jsonArray = json_decode($jsonFile, true);

        if (isset($jsonArray["erro"]) || $jsonArray == null) {
            return false;
        }

        return true;
    }

    # Pegar IP
    public function getUserIP() {
        isset($_SERVER['HTTP_CLIENT_IP']) ? $client = $_SERVER['HTTP_CLIENT_IP'] : $client = null;
        isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $forward = $_SERVER['HTTP_X_FORWARDED_FOR'] : $forward = null;
        isset($_SERVER['REMOTE_ADDR']) ? $remote = $_SERVER['REMOTE_ADDR'] : $remote = null;

        if(filter_var($client, FILTER_VALIDATE_IP))
        {
            $ip = $client;
        }
        elseif(filter_var($forward, FILTER_VALIDATE_IP))
        {
            $ip = $forward;
        }
        else
        {
            $ip = $remote;
        }

        return $ip;
    }

    # (acho que isso não funciona) && (acho que não estamos utilizando)
    # envia dados via metodo post
    public function viaPost($link, $campos, $valores) {
        $content = http_build_query(array('primeiroLogin' => 1, 'email' => $email,'senha' => $senha));
        $context = stream_context_create(array('http' => array('method' => 'POST','content' => $content)));
        return file_get_contents($pagina, null, $context);
    }

    public function validarTamanhoString($string, $minimo, $maximo) {
        $tamanhoString = strlen($string);
        if ($tamanhoString >= $minimo && $tamanhoString <= $maximo) {
            return true;
        }
        return false;
    }

    public function validarCPF($cpf) {
        // Extrai somente os números
        $cpf = preg_replace( '/[^0-9]/is', '', $cpf );

        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return false;
        }
        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }
        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf{$c} * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf{$c} != $d) {
                return false;
            }
        }
        return true;
    }

    public function somenteNumeros($string) {
        return preg_replace("/[^0-9]/", "", $string);
    }

    public function dateTimeRecife() {
        date_default_timezone_set('America/Recife');
        return date("Y-m-d H:i:s");
    }

    public function scriptPai() {
        $path = filter_var($_SERVER['PHP_SELF'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $script = explode("/", $path);
        $script = end($script);
        return $script;
    }

    // header function
    public function h($string) {
        header($string);
        exit;
    }

    public function validarData($data, $formato = 'Y-m-d') {
        $d = \DateTime::createFromFormat($formato, $data);
        return $d && $d->format($formato) == $data;
    }

	function mascara($mask, $str){
		$str = str_replace(" ","",$str);

		for($i=0;$i<strlen($str);$i++){
			$mask[strpos($mask,"#")] = $str[$i];
		}

		return $mask;
	}
}
<?php
namespace fiscalizape\model;

class Cookie {
    
    /**
     * Salvar dados de determinado formulário.
     *
     * @param string $dono Página em que os dados serão exibidos.
     * @param mix[] $dados Dados os forms que serão salvos.
     * @param int $time = 60 Tempo em que o cookie irá expirar, é somado com time() 
    */
    public static function salvarForm($dono, $dados, $time = 60) {
        $nome = "form_$dono";
        $path = "/fiscalizape/view/$dono.php";
        $validade = time() + $time;

        return false;
    }
}
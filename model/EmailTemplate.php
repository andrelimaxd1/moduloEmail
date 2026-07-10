<?php
// model/EmailTemplate.php
namespace App\Model;

class EmailTemplate {
    private ?int $id;
    private string $titulo;
    private string $assunto;
    private string $corpo;

    private function __construct(){}

    public static function criar(?int $id, string $titulo, string $assunto, string $corpo): static {
        $t = new static();
        $t->id = $id;
        $t->setTitulo($titulo);
        $t->setAssunto($assunto);
        $t->setCorpo($corpo);
        return $t;
    }

    public function getId(): ?int { return $this->id; }
    public function getTitulo(): string { return $this->titulo; }
    public function getAssunto(): string { return $this->assunto; }
    public function getCorpo(): string { return $this->corpo; }

    public function setTitulo(string $titulo): void {
        if (trim($titulo) === "") {
            throw new \InvalidArgumentException("O título é obrigatório.");
        }
        $this->titulo = $titulo;
    }

    public function setAssunto(string $assunto): void {
        if (trim($assunto) === "") {
            throw new \InvalidArgumentException("O assunto é obrigatório.");
        }
        $this->assunto = $assunto;
    }

    public function setCorpo(string $corpo): void {
        if (trim($corpo) === "") {
            throw new \InvalidArgumentException("O corpo do e-mail é obrigatório.");
        }
        $this->corpo = $corpo;
    }
}
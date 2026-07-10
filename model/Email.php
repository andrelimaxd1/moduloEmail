<?php
// model/Email.php  -> representa UM envio (pode ter N destinatários)
namespace App\Model;

class Email {
    private ?int $id;
    private ?int $templateId;
    private string $assunto;
    private string $corpo;
    private array $destinatarios = []; // cada item: ['email' => string, 'usuarioId' => ?int]

    private function __construct(){}

    public static function criar(?int $templateId, string $assunto, string $corpo, array $destinatarios): static {
        $e = new static();
        $e->id = null;
        $e->templateId = $templateId;
        $e->setAssunto($assunto);
        $e->setCorpo($corpo);
        $e->setDestinatarios($destinatarios);
        return $e;
    }

    public function getId(): ?int { return $this->id; }
    public function getTemplateId(): ?int { return $this->templateId; }
    public function getAssunto(): string { return $this->assunto; }
    public function getCorpo(): string { return $this->corpo; }
    public function getDestinatarios(): array { return $this->destinatarios; }

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

    public function setDestinatarios(array $destinatarios): void {
        if (empty($destinatarios)) {
            throw new \InvalidArgumentException("Informe ao menos um destinatário.");
        }
        foreach ($destinatarios as $d) {
            $email = $d['email'] ?? null;
            if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new \InvalidArgumentException("E-mail inválido: " . ($email ?? '(vazio)'));
            }
        }
        $this->destinatarios = $destinatarios;
    }
}
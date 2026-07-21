<?php
// dal/EmailTemplateDao.php
namespace App\Dal;

use App\Model\EmailTemplate;
use PDO;
use PDOException;
use App\Dal\Conn;

abstract class EmailTemplateDao {
    public static function cadastrar(EmailTemplate $t): int {
    try {
        $pdo = Conn::getConn();
        $sql = $pdo->prepare("INSERT INTO email_templates (titulo, assunto, corpo, anexos) VALUES (:titulo, :assunto, :corpo, :anexos)");
        
        $sql->bindValue(":titulo", $t->getTitulo());
        $sql->bindValue(":assunto", $t->getAssunto());
        $sql->bindValue(":corpo", $t->getCorpo());
        $sql->bindValue(":anexos", $t->getAnexos());
        
        $sql->execute();
        return (int) $pdo->lastInsertId();
    } catch (PDOException $e) {
        throw $e;
    }
}

    public static function listar(): array {
    $pdo = Conn::getConn();
    $sql = $pdo->query("SELECT * FROM email_templates ORDER BY titulo");
    $res = $sql->fetchAll(PDO::FETCH_ASSOC);

    return array_map(fn($d) => EmailTemplate::criar(
        (int)$d["id"], $d["titulo"], $d["assunto"], $d["corpo"], $d["anexos"] ?? null
    ), $res);
}

    public static function buscarPorId(int $id): ?EmailTemplate {
    $pdo = Conn::getConn();
    $sql = $pdo->prepare("SELECT * FROM email_templates WHERE id=?");
    $sql->execute([$id]);
    $d = $sql->fetch(PDO::FETCH_ASSOC);
    
    if (!$d) return null;
    
    return EmailTemplate::criar(
        (int)$d["id"], 
        $d["titulo"], 
        $d["assunto"], 
        $d["corpo"], 
        $d["anexos"] ?? null
    );
}

    public static function editar(EmailTemplate $t): void {
        $pdo = Conn::getConn();
        $sql = $pdo->prepare("UPDATE email_templates SET titulo=?, assunto=?, corpo=?, anexos=? WHERE id=?");
        $sql->execute([$t->getTitulo(), $t->getAssunto(), $t->getCorpo(), $t->getAnexos(), $t->getId()]);
        if ($sql->rowCount() !== 1) {
            throw new \Exception("Nenhum registro foi alterado.");
        }
    }

    public static function excluir(int $id): void {
        $pdo = Conn::getConn();
        $sql = $pdo->prepare("DELETE FROM email_templates WHERE id=?");
        $sql->execute([$id]);
        if ($sql->rowCount() !== 1) {
            throw new \Exception("Erro ao deletar template.");
        }
    }
}
<?php
// dal/EmailDao.php
namespace App\Dal;

use App\Model\Email;
use PDO;
use PDOException;
use App\Dal\Conn;

abstract class EmailDao {
    public static function registrarEnvio(Email $email, array $resultadosPorDestinatario): int {
        $pdo = Conn::getConn();
        try {
            $pdo->beginTransaction();

            $temErro = in_array(false, array_column($resultadosPorDestinatario, 'sucesso'), true);
            $status = !$temErro ? 'enviado' : (
                array_search(true, array_column($resultadosPorDestinatario, 'sucesso')) !== false ? 'parcial' : 'erro'
            );

            $sql = $pdo->prepare("INSERT INTO emails (template_id, assunto, corpo, status) VALUES (:template_id, :assunto, :corpo, :status)");
            $sql->bindValue(":template_id", $email->getTemplateId(), PDO::PARAM_INT);
            $sql->bindValue(":assunto", $email->getAssunto());
            $sql->bindValue(":corpo", $email->getCorpo());
            $sql->bindValue(":status", $status);
            $sql->execute();
            $emailId = (int) $pdo->lastInsertId();

            $sqlDest = $pdo->prepare(
                "INSERT INTO email_destinatarios (email_id, usuario_id, destinatario, status, erro_msg)
                 VALUES (:email_id, :usuario_id, :destinatario, :status, :erro_msg)"
            );

            foreach ($email->getDestinatarios() as $i => $d) {
                $resultado = $resultadosPorDestinatario[$i];
                $sqlDest->execute([
                    ":email_id" => $emailId,
                    ":usuario_id" => $d['usuarioId'] ?? null,
                    ":destinatario" => $d['email'],
                    ":status" => $resultado['sucesso'] ? 'enviado' : 'erro',
                    ":erro_msg" => $resultado['erro'] ?? null,
                ]);
            }

            $pdo->commit();
            return $emailId;
        } catch (PDOException $e) {
            $pdo->rollBack();
            throw $e;
        }
    }
}
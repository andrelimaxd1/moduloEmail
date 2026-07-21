<?php
namespace App\Util;

class UploadService {

    public static function uploadAnexosMultiplos(?array $arquivos, string $subPasta): ?string {
        if (!$arquivos || empty($arquivos['name'][0])) {
            return null;
        }

        $caminhosAnexos = [];
        $diretorioDestino = __DIR__ . '/../assets/uploads/' . $subPasta . '/';

        if (!is_dir($diretorioDestino)) {
            mkdir($diretorioDestino, 0777, true);
        }

        $totalArquivos = count($arquivos['name']);
        
        for ($i = 0; $i < $totalArquivos; $i++) {
            if ($arquivos['error'][$i] === UPLOAD_ERR_OK) {
                $nomeOriginal = basename($arquivos['name'][$i]);
                $nomeLimpo = preg_replace('/[^a-zA-Z0-9.\-_]/', '', $nomeOriginal);
                $nomeFinal = uniqid() . '_' . $nomeLimpo; 
                
                $caminhoCompleto = $diretorioDestino . $nomeFinal;
                
                if (move_uploaded_file($arquivos['tmp_name'][$i], $caminhoCompleto)) {
                    $caminhosAnexos[] = 'assets/uploads/' . $subPasta . '/' . $nomeFinal;
                }
            }
        }

        return !empty($caminhosAnexos) ? json_encode($caminhosAnexos) : null;
    }

    public static function deletarArquivos(?string $jsonAnexos): void {
        if ($jsonAnexos) {
            $caminhos = json_decode($jsonAnexos, true);
            
            if (is_array($caminhos)) {
                foreach ($caminhos as $caminhoRelativo) {
                    // Monta o caminho absoluto do servidor para achar o arquivo
                    $caminhoAbsoluto = __DIR__ . '/../' . $caminhoRelativo;
                    
                    // Se o arquivo realmente existir na pasta, apaga ele (unlink)
                    if (file_exists($caminhoAbsoluto) && is_file($caminhoAbsoluto)) {
                        unlink($caminhoAbsoluto);
                    }
                }
            }
        }
    }
}
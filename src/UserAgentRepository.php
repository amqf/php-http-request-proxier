<?php

namespace AMQF\HttpRequestProxier;

use Exception;

class UserAgentRepository
{
    public function __construct(
        private string $_filePath
    )
    {
    }

    public function getAll() : array
    {
        if (!file_exists($this->_filePath)) {
            throw new Exception("Arquivo não encontrado: " . $this->_filePath);
        }

        $lines = file($this->_filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        return $lines;
    }

    public function getRandom() : string
    {
        $userAgents = $this->getAll();

        if (empty($userAgents)) {
            throw new Exception("Nenhum user agent encontrado no arquivo.");
        }

        $randomIndex = array_rand($userAgents);
        return $userAgents[$randomIndex];
    }

    public function update(string $filePath, array $userAgents) : void
    {
        $fp = fopen($filePath, 'w');
        if ($fp === false) {
            throw new Exception("Não foi possível abrir o arquivo para escrita: " . $this->_filePath);
        }

        // Adiciona o cabeçalho do CSV
        fputcsv($fp, ['Device Name', 'User Agent']);

        foreach ($userAgents as $userAgent) {
            fputcsv($fp, $userAgent);
        }

        fclose($fp);
    }
}
<?php

namespace App\Support;

class MachineFingerprint
{
    public static function current(): string
    {
        $parts = [
            php_uname('n'),
            php_uname('s'),
            php_uname('r'),
            self::machineId(),
        ];

        return hash('sha256', implode('|', $parts));
    }

    private static function machineId(): string
    {
        if (PHP_OS_FAMILY === 'Windows') {
            $output = [];
            $exitCode = 0;

            @exec('reg query "HKLM\\SOFTWARE\\Microsoft\\Cryptography" /v MachineGuid 2>nul', $output, $exitCode);

            foreach ($output as $line) {
                if (stripos($line, 'MachineGuid') !== false) {
                    $parts = preg_split('/\s+/', trim($line));
                    return trim(end($parts));
                }
            }

            return 'windows-machine-unknown';
        }

        foreach ([
            '/etc/machine-id',
            '/var/lib/dbus/machine-id',
        ] as $path) {
            if (is_readable($path)) {
                $value = trim(@file_get_contents($path));
                if ($value !== '') {
                    return $value;
                }
            }
        }

        return php_uname('m') ?: 'unknown-machine';
    }
}
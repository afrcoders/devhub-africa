<?php
namespace App\Services\Kortextools\Handlers;

use App\Contracts\ToolHandlerInterface;

class PingToolHandler implements ToolHandlerInterface
{
    public function handle(array $data): array
    {
        $host = trim($data['host'] ?? '');
        if (empty($host)) {
            return ['success' => false, 'error' => 'Host is required'];
        }

        try {
            $output = [];
            $cmd = sprintf("ping -c 4 %s", escapeshellarg($host));
            @exec($cmd, $output, $exitCode);

            return [
                'success' => $exitCode === 0,
                'host' => $host,
                'reachable' => $exitCode === 0,
                'output' => implode("\n", $output),
                'status' => $exitCode === 0 ? 'Reachable' : 'Unreachable'
            ];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function getValidationRules(): array
    {
        return ['host' => 'required|string|max:255'];
    }

    public function getTemplate(): string
    {
        return 'africoders.kortextools.tools.ping-tool';
    }
}

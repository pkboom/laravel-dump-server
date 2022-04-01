<?php

namespace Pkboom\DumpServer;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use React\EventLoop\Loop;
use React\Socket\ConnectionInterface;
use React\Socket\SocketServer;
use React\Stream\ReadableResourceStream;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\VarDumper\Dumper\CliDumper;
use Throwable;

class DumpServerCommand extends Command
{
    protected $signature = 'dump-server {--clear}';

    public function handle()
    {
        $socket = new SocketServer(Config::get('dump-server.host'));
        
        $descriptor = new CliDescriptor(new CliDumper());

        $io = new SymfonyStyle($this->input, $this->output);
        
        $socket->on('connection', function (ConnectionInterface $connection) use ($descriptor, $io) {
            $connection->on('data', function ($data) use ($descriptor, $io) {
                if ($data === '') {
                    return;
                }
                
                $payload = @unserialize(base64_decode($data));

                [$data, $context] = $payload;

                try {
                    $descriptor->describe($io, $data, $context, 1, $this->option('clear'));
                } catch (Throwable $e) {
                    $io->error($e->getMessage());
                }
            });
        });
       
        
        $socket->on('error', function (Exception $e) use ($io) {
            $io->error($e->getMessage());
        });

        $this->info(sprintf('Server listening on %s', $socket->getAddress()));
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Aws\Sqs\SqsClient;
use App\Jobs\ProcessSQSMessage;

class SQSListener extends Command
{
    protected $signature = 'sqs:listen';
    protected $description = 'Listen for messages on SQS';

    public function handle()
    {
        $sqs = new SqsClient([
            'version' => 'latest',
            'region'  => config('queue.connections.sqs.region'),
            'credentials' => [
                'key'    => config('queue.connections.sqs.key'),
                'secret' => config('queue.connections.sqs.secret'),
            ],
        ]);

        $queueUrl = config('queue.connections.sqs.prefix') . '/' . config('queue.connections.sqs.queue');

        while (true) {
            $result = $sqs->receiveMessage(['QueueUrl' => $queueUrl]);

            if ($result->get('Messages') !== null) {
                foreach ($result->get('Messages') as $message) {
                    ProcessSQSMessage::dispatch($message);
                    $sqs->deleteMessage([
                        'QueueUrl' => $queueUrl,
                        'ReceiptHandle' => $message['ReceiptHandle'],
                    ]);
                }
            }

            sleep(1); // Avoid busy-waiting
        }
    }
}
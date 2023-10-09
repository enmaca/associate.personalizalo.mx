<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
class SetupEnv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'personalizalo:setup-env {workshop} {username} {password} {--create}';
    protected $url = 'https://api.personalizalo.mx/workshop/setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $workshop = $this->argument('workshop');
        $username = $this->argument('username');
        $password = $this->argument('password');
        $create = $this->option('create');

        $client = new Client();

        try {
            $response = $client->get($this->url, [
                'query' => [
                    'workshop' => $workshop,
                    'username' => $username,
                    'password' => $password,
                    'create' => $create
                ]
            ]);

            $data = json_decode($response->getBody(), true);

            if (is_array($data)) {
                $envPath = base_path('.env');
                $envFileContent = file_get_contents($envPath);

                foreach ($data as $key => $value) {
                    $key = strtoupper($key);

                    if (preg_match("/^{$key}=/m", $envFileContent)) {
                        $envFileContent = preg_replace(
                            "/^{$key}=.*/m",
                            "{$key}={$value}",
                            $envFileContent
                        );
                    } else {
                        $envFileContent .= "\n{$key}={$value}";
                    }
                }

                file_put_contents($envPath, $envFileContent);
                $this->info('Updated .env file with fetched data.');
            } else {
                $this->error('Invalid JSON received from the provided URL.');
            }
        } catch (\Exception $e) {
            $this->error('An error occurred: ' . $e->getMessage());
        }
    }
}

<?php

namespace Creem\CreemLaravel\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class WebhookSecretCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'creem:webhook-secret {secret? : The webhook secret to set}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set or generate the CREEM webhook secret in the .env file';

    /**
     * Execute the console command.
     *
     * @return int Returns 0 on success, 1 on failure.
     */
    public function handle(): int
    {
        $secret = $this->argument('secret') ?: Str::random(40);

        if (! $this->setSecretInEnvironmentFile($secret)) {
            return 1;
        }

        $this->info("CREEM webhook secret set successfully: {$secret}");

        return 0;
    }

    /**
     * Updates the .env file with the provided secret.
     *
     * @param string $secret The secret to store in the .env file.
     * @return bool Returns true if the file was successfully updated.
     */
    protected function setSecretInEnvironmentFile(string $secret): bool
    {
        $path = base_path('.env');

        if (! file_exists($path)) {
            $this->error('.env file not found.');
            return false;
        }

        $content = file_get_contents($path);

        if (Str::contains($content, 'CREEM_WEBHOOK_SECRET=')) {
            $content = preg_replace(
                '/CREEM_WEBHOOK_SECRET=.*/',
                'CREEM_WEBHOOK_SECRET=' . $secret,
                $content
            );
        } else {
            $content .= PHP_EOL . 'CREEM_WEBHOOK_SECRET=' . $secret . PHP_EOL;
        }

        file_put_contents($path, $content);

        return true;
    }
}

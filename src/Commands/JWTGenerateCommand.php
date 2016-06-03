<?php

/*
 * This file is part of jwt-auth.
 *
 * (c) Sean Tymon <tymon148@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tymon\JWTAuth\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

class JWTGenerateCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'jwt:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set the JWTAuth secret key used to sign the tokens';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $encryptSecret = $this->getRandomKey(32);
        $signatureKey = $this->getRandomKey(32);

        if ($this->option('show')) {
            return $this->line('<comment>'.$encryptSecret.'</comment>');
        }

        $path = config_path('jwt.php');

        if (file_exists($path)) {

            $this->updateConfigFile('encrypt_secret', $encryptSecret, $path);
            $this->updateConfigFile('signature_secret', $signatureKey, $path);
        }

        $this->laravel['config']['jwt.encrypt_secret'] = $encryptSecret;
        $this->laravel['config']['jwt.signature_secret'] = $signatureKey;

        $this->info("jwt-auth encrypt secret [$encryptSecret] and signature secret [$signatureKey] set successfully.");
    }

    /**
     * Generate a random key for the JWT Auth secret.
     *
     * @param int $len
     * @return string
     */
    protected function getRandomKey($len = 32)
    {
        return Str::random($len);
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['show', null, InputOption::VALUE_NONE, 'Simply display the key instead of modifying files.'],
        ];
    }

    /**
     * Update config file
     *
     * @param $key
     * @param $value
     * @param $path
     */
    protected function updateConfigFile($key, $value, $path)
    {
        file_put_contents($path, str_replace(
            $this->laravel['config']["jwt.$key"], $value, file_get_contents($path)
        ));
    }
}

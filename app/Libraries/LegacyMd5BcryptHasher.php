<?php

namespace App\Libraries;

use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Hashing\BcryptHasher;

class LegacyMd5BcryptHasher implements Hasher
{
    private $bcrypt;

    public function __construct(array $options = [])
    {
        $this->bcrypt = new BcryptHasher($options);
    }

    public function info($hashedValue)
    {
        if ($this->isLegacyMd5($hashedValue)) {
            return ['algo' => null, 'algoName' => 'md5', 'options' => []];
        }

        return $this->bcrypt->info($hashedValue);
    }

    public function make($value, array $options = [])
    {
        return $this->bcrypt->make($value, $options);
    }

    public function check($value, $hashedValue, array $options = [])
    {
        if ($this->isLegacyMd5($hashedValue)) {
            return hash_equals(strtolower($hashedValue), md5($value));
        }

        return $this->bcrypt->check($value, $hashedValue, $options);
    }

    public function needsRehash($hashedValue, array $options = [])
    {
        return $this->isLegacyMd5($hashedValue)
            || $this->bcrypt->needsRehash($hashedValue, $options);
    }

    private function isLegacyMd5($hashedValue)
    {
        return is_string($hashedValue) && preg_match('/^[a-f0-9]{32}$/i', $hashedValue) === 1;
    }
}

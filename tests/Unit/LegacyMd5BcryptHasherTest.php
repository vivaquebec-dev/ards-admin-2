<?php

namespace Tests\Unit;

use Tests\TestCase;

class LegacyMd5BcryptHasherTest extends TestCase
{
    public function test_it_accepts_legacy_md5_and_creates_bcrypt_hashes()
    {
        $hasher = $this->app->make('hash');
        $legacyHash = md5('mot-de-passe');

        $this->assertTrue($hasher->check('mot-de-passe', $legacyHash));
        $this->assertTrue($hasher->needsRehash($legacyHash));

        $bcryptHash = $hasher->make('mot-de-passe');

        $this->assertTrue($hasher->check('mot-de-passe', $bcryptHash));
        $this->assertFalse($hasher->needsRehash($bcryptHash));
        $this->assertStringStartsWith('$2y$', $bcryptHash);
    }
}

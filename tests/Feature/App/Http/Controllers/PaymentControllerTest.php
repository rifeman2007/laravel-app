<?php

namespace Tests\Feature\App\Http\Controllers\PaymentControllerTest;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaymentControllerTest extends TestCase
{
    public function successfulUrlsProvider(): array
    {
        return [
            [
                ['uri' => '/payment']
            ],
        ];
    }

    /**
     * @dataProvider successfulUrlsProvider
     */
    public function testIsSuccessful(array $request, array $roles = null)
    {
        $this->assertRequestSuccess($request, $roles);
    }
}

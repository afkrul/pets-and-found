<?php

namespace Tests\Unit\QrCode\Actions;

use App\Actions\QrCode\GenerateQrCode;
use App\Models\Pet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Tests\TestCase;

class GenerateQrCodeTest extends TestCase
{
    use RefreshDatabase;

    public function test_generates_and_persists_qr_code_when_missing(): void
    {
        config(['qrcode.frontend_url' => 'http://localhost:5173']);
        $user = User::factory()->create();
        $pet = Pet::factory()->for($user)->create(['qr_code' => null]);

        $capturedPayload = '';
        QrCode::shouldReceive('format->size->margin->errorCorrection->generate')
            ->once()
            ->with(Mockery::on(function ($payload) use (&$capturedPayload) {
                $capturedPayload = $payload;

                return str_contains($payload, '/pet?code=');
            }))
            ->andReturn('<svg>qr</svg>');

        $action = new GenerateQrCode;
        $result = $action($pet);

        $pet->refresh();

        $this->assertNotNull($result->code);
        $this->assertSame($pet->qr_code, $result->code);
        $this->assertSame('<svg>qr</svg>', $result->bytes);
        $this->assertSame('image/svg+xml', $result->mime);
        $this->assertSame("pet-{$pet->id}-qr.svg", $result->filename);
        $this->assertStringContainsString("http://localhost:5173/pet?code={$result->code}", $capturedPayload);
    }

    public function test_reuses_existing_qr_code(): void
    {
        config(['qrcode.frontend_url' => 'http://localhost:5173']);

        $user = User::factory()->create();
        $pet = Pet::factory()->for($user)->create(['qr_code' => 'EXISTINGCODE']);

        $capturedPayload = '';
        QrCode::shouldReceive('format->size->margin->errorCorrection->generate')
            ->once()
            ->with(Mockery::on(function ($payload) use (&$capturedPayload) {
                $capturedPayload = $payload;

                return str_contains($payload, '/pet?code=');
            }))
            ->andReturn('<svg>qr</svg>');

        $action = new GenerateQrCode;
        $result = $action($pet);

        $pet->refresh();

        $this->assertSame('EXISTINGCODE', $result->code);
        $this->assertSame('EXISTINGCODE', $pet->qr_code);
        $this->assertStringContainsString('http://localhost:5173/pet?code=EXISTINGCODE', $capturedPayload);
    }
}

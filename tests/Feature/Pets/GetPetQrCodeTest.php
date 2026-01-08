<?php

namespace Tests\Feature\Pets;

use App\Models\Pet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Tests\TestCase;

class GetPetQrCodeTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_can_download_qr_code(): void
    {
        config(['qrcode.frontend_url' => 'http://localhost:5173']);

        $user = User::factory()->create();
        $pet = Pet::factory()->for($user)->create();

        $capturedPayload = '';
        QrCode::shouldReceive('format->size->margin->errorCorrection->generate')
            ->once()
            ->with(Mockery::on(function ($payload) use (&$capturedPayload) {
                $capturedPayload = $payload;

                return str_contains($payload, '/pet?code=');
            }))
            ->andReturn('<svg>qr</svg>');

        $this->actingAsApi($user);

        $response = $this->get("/api/pets/{$pet->id}/qr-code");

        $response->assertOk();
        $response->assertHeader('Content-Type', 'image/svg+xml');
        $response->assertHeader('Content-Disposition', 'attachment; filename="pet-'.$pet->id.'-qr.svg"');
        $this->assertSame('<svg>qr</svg>', $response->getContent());
        $this->assertNotNull($pet->qr_code);
        $this->assertStringContainsString("/pet?code={$pet->qr_code}", $capturedPayload);
        $this->assertStringContainsString('http://localhost:5173', $capturedPayload);
    }

    public function test_user_cannot_download_qr_code_for_someone_elses_pet(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $pet = Pet::factory()->for($owner)->create();

        $this->actingAsApi($otherUser);

        $response = $this->getJson("/api/pets/{$pet->id}/qr-code");
        $response->assertForbidden();
    }

    public function test_guest_cannot_download_qr_code(): void
    {
        $pet = Pet::factory()->for(User::factory()->create())->create();

        $response = $this->getJson("/api/pets/{$pet->id}/qr-code");
        $response->assertUnauthorized();
    }
}

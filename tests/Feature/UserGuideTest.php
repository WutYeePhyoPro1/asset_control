<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class UserGuideTest extends TestCase
{
    public function test_user_guide_opens_the_asset_control_pdf_inline(): void
    {
        $user = new User(['emp_code' => 'guide-test']);
        $user->id = 1;

        $response = $this->actingAs($user)->get(route('user-guide'));

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/pdf');
        $this->assertStringContainsString('inline', $response->headers->get('Content-Disposition'));
    }

}

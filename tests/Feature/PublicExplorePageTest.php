<?php

namespace Tests\Feature;

use App\Models\Perlombaan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicExplorePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_can_view_explore_page_with_competitions_grouped_by_status(): void
    {
        $available = Perlombaan::factory()->create([
            'status' => Perlombaan::STATUS_REGISTRATION_OPEN,
            'nama_lomba' => 'Lomba Poster Sekolah',
        ]);
        $ongoing = Perlombaan::factory()->create([
            'status' => Perlombaan::STATUS_JUDGING,
            'nama_lomba' => 'Lomba Film Pendek',
        ]);
        $past = Perlombaan::factory()->create([
            'status' => Perlombaan::STATUS_FINISHED,
            'nama_lomba' => 'Lomba Desain Logo',
        ]);
        $draft = Perlombaan::factory()->create([
            'status' => Perlombaan::STATUS_DRAFT,
            'nama_lomba' => 'Lomba Internal Draft',
        ]);

        $response = $this->get(route('explore.index'));

        $response->assertOk();
        $response->assertSee('Lomba');
        $response->assertSee($available->nama_lomba);
        $response->assertSee($ongoing->nama_lomba);
        $response->assertSee($past->nama_lomba);
        $response->assertDontSee($draft->nama_lomba);
    }
}

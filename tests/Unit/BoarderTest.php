<?php

use App\Models\Boarder;
use App\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BoarderTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_boarder()
    {
        $room = Room::factory()->create();

        $boarder = Boarder::factory()->create(['room_id' => $room->id]);

        $this->assertDatabaseHas('boarders', [
            'id' => $boarder->id,
            'name' => $boarder->name,
        ]);
    }
}

<?php
use App\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoomTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_room()
    {
        $room = Room::factory()->create([
            'room_name' => 'Deluxe Room',
            'slots' => 3,
            'status' => 'available',
            'price' => 2000.00
        ]);

        $this->assertDatabaseHas('rooms', [
            'id' => $room->id,
            'room_name' => 'Deluxe Room',
        ]);
    }
}

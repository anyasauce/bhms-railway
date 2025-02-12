<?php

use App\Models\Payment;
use App\Models\Boarder;
use App\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_payment()
    {
        $room = Room::factory()->create();
        $boarder = Boarder::factory()->create(['room_id' => $room->id]);

        $payment = Payment::factory()->create([
            'name' => 'Monthly Rent',
            'room_id' => $room->id,
            'room_name' => $room->room_name,
            'amount' => 5000,
            'description' => 'Monthly payment for boarding',
            'payment_due_date' => now()->addDays(30),
            'status' => 'pending',
            'partial_amount' => 2500,
        ]);

        $this->assertDatabaseHas('payments', [
            'id' => $payment->id,
            'name' => 'Monthly Rent',
        ]);
    }
}

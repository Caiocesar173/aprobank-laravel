<?php

namespace Caiocesar173\Aprobank\Events;

use Caiocesar173\Aprobank\Models\BankSlip;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BankSlipHookEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $bankslip;

    /**
     * Create a new event instance.
     *
     * @param  Caiocesar173\Aprobank\Models\BankSlip  $bankslip
     * @return void
     */
    public function __construct(BankSlip $bankslip)
    {   
        $this->bankslip = $bankslip;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}

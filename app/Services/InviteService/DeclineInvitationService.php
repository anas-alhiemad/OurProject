<?php
namespace App\Services\InviteService;

use App\Models\Invitation;

class DeclineInvitationService
{
    public function declineInvitation($invitationId)
    {
    
        $invitation = Invitation::whereId($invitationId)
                                 ->where('status','pending')->first();
        $invitation->status = "rejected";
        $invitation->save();

        return response()->json(["Message"=>"You have successfully rejected invitation","info"=>$invitation]);

    }
}
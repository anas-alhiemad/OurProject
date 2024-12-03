<?php
namespace App\Services\InviteService;

use App\Models\User;
use App\Models\Group;
use App\Models\Invitation;


class CancelInvitationService 
{
    protected $model;
    function __construct(){
        $this -> model = new Invitation();
    }
 
    public function cancelInvitation($invitationId)
    {
        $invitation = Invitation::whereId($invitationId)
                                 ->whereStatus('pending')->first();

        if (!$invitation) {
            return response()->json(['message' => 'this Invtation not found'], 404);
        }

        $group =Group::whereId($invitation->groupId)->first();
        
        $user = User::whereId(auth()->guard('user')->id())->first(); 
        
        $owner = $user->can('cancel', $group); 

        if ($owner) {
            $invitation ->delete();

            return response()->json(["message" => "The invitation has been cancel successfully","InfoInvite"=>$invitation],200);
        }

        return response()->json(['Message' => 'You do not have the authority to cancel invitation.'], 422);   

    }

}
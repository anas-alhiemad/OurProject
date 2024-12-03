<?php
namespace App\Services\InviteService;

use App\Models\Group;
use App\Models\User;
use App\Models\Invitation;

class SendInvitationService 
{
    protected $model;
    function __construct(){
        $this -> model = new Invitation();
    }

    public function isOwner($user,$group)
    { 
        if ($user->can('create', $group)) 
                    return true;
        return false;            
    }

        public function createInvitation($userInvitedId,$GroupId)
        {
            $group = Group::whereId($GroupId)->first(); 
           
            $user = User::whereId(auth()->guard('user')->id())->first(); 
          
            $owner = $user->can('create', $group); 

            if ($owner) {
                    $invitation = new Invitation();
                    $invitation->groupId = $GroupId;
                    $invitation->invitedUserId = $userInvitedId;
                    $invitation->save();
                    return response()->json(["message" => "The invitation has been sent successfully","InfoInvite"=>$invitation],200);
                }
        
                return response()->json(['Message' => 'You do not have the authority to send invitation.'], 422);   

        }

}
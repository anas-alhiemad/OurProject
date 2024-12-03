<?php
namespace App\Services\InviteService;

use App\Models\Invitation;

class DisplayInvitationService 
{


    public function index()
    {
    
        $allInvitations = Invitation::all();
        return response()->json(["Message"=>"all info for Invitations","infoInvitations"=>$allInvitations]);
    }

    public function UserSpecific()
    {
        $allInvitations = Invitation::where('invitedUserId',auth()->guard('user')->id())
                                    ->whereStatus('pending')->get();

        return response()->json(["Message"=>" info Your invitations","infoInvitations"=>$allInvitations]);
    }


    public function GroupSpecific($groupId)
    {
        $allInvitations = Invitation::where('groupId',$groupId)
                                    ->whereStatus('pending')->get();

        return response()->json(["Message"=>" info Your invitations","infoInvitations"=>$allInvitations]);
    }

}
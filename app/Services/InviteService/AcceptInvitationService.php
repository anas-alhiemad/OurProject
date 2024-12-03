<?php
namespace App\Services\InviteService;

use App\Models\Invitation;
use App\Models\UserGroup;
use Exception;

class AcceptInvitationService
{
    protected $model;
    function __construct(){
        $this -> model = new Invitation();
    }


    public function acceptInvitation($invitationId)
    {
    
        $invitation = Invitation::whereId($invitationId)
                                 ->where('status','pending')->first();
        $invitation->status = "approved";
        $invitation->save();
       // throw new Exception('there is error');
        $userGp = new UserGroup();
        $userGp->userId = auth()->guard('user')->id();
        $userGp->groupId =$invitation->groupId;
        $userGp->isOwner = false;
        $userGp->save();

        return response()->json(["Message"=>"You have successfully joined group","info"=>$userGp]);

    }
}
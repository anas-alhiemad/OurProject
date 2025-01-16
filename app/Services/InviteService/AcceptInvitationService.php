<?php
namespace App\Services\InviteService;

use App\Repositories\GroupUserRepository;
use App\Repositories\InvitationRepository;

class AcceptInvitationService
{
    protected $invitationRepository;
    protected $groupUserRepository;
    public function __construct(InvitationRepository $invitationRepository,GroupUserRepository $groupUserRepository)
    {
        $this->invitationRepository = $invitationRepository;
        $this->groupUserRepository = $groupUserRepository;

    }


    public function acceptInvitation($invitationId)
    {
        $invitation = $this->invitationRepository->changeInvitationStatus($invitationId,'approved');

       $userGroupInfo =['groupId' =>$invitation->groupId,'userId'=>$invitation->invitedUserId,'isOwner'=>false];
       $this->groupUserRepository->create($userGroupInfo);


        return response()->json(["Message"=>"You have successfully joined group","info"=> $invitation]);

    }
}
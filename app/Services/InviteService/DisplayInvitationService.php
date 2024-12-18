<?php
namespace App\Services\InviteService;

use App\Models\Invitation;
use App\Repositories\InvitationRepository;

class DisplayInvitationService 
{

    protected $invitationRepository;
    public function __construct(InvitationRepository $invitationRepository)
    {
        $this->invitationRepository = $invitationRepository;
    }

    public function index()
    {
    
        $allInvitations = $this->invitationRepository->getAll();
        return response()->json(["Message"=>"all info for Invitations","infoInvitations"=>$allInvitations]);
    }

    public function UserSpecific()
    {
        $allInvitations =  $this->invitationRepository->userSpecificInvitation(auth()->guard('user')->id());

        return response()->json(["Message"=>" info Your invitations","infoInvitations"=>$allInvitations]);
    }


    public function GroupSpecific($groupId)
    {
        $allInvitations =  $this->invitationRepository->groupSpecificInvitation($groupId);

        return response()->json(["Message"=>" info Your invitations","infoInvitations"=>$allInvitations]);
    }

}
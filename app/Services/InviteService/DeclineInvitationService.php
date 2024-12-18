<?php
namespace App\Services\InviteService;

use App\Models\Invitation;
use App\Repositories\InvitationRepository;

class DeclineInvitationService
{

    protected $invitationRepository;
    public function __construct(InvitationRepository $invitationRepository)
    {
        $this->invitationRepository = $invitationRepository;
    }

    public function declineInvitation($invitationId)
    {
        $invitation = $this->invitationRepository->changeInvitationStatus($invitationId,'rejected');

        return response()->json(["Message"=>"You have successfully rejected invitation","info"=>$invitation]);

    }
}
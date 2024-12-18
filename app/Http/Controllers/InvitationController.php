<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\InviteService\SendInvitationService;
use App\Services\InviteService\AcceptInvitationService;
use App\Services\InviteService\CancelInvitationService;
use App\Services\InviteService\DeclineInvitationService;
use App\Services\InviteService\DisplayInvitationService;


class InvitationController extends Controller
{

    protected $sendInvitationService;
    protected $displayInvitationService;
    protected $cancelInvitationService;
    protected $acceptInvitationService;
    protected $declineInvitationService;

    public function __construct(SendInvitationService $sendInvitationService,DisplayInvitationService $displayInvitationService,CancelInvitationService $cancelInvitationService ,AcceptInvitationService $acceptInvitationService,DeclineInvitationService $declineInvitationService)
    {
        $this->sendInvitationService = $sendInvitationService;
        $this->displayInvitationService = $displayInvitationService;
        $this->cancelInvitationService = $cancelInvitationService;
        $this->acceptInvitationService = $acceptInvitationService;
        $this->declineInvitationService = $declineInvitationService;
    }

    public function indexInvitation()
    {

        return $this->displayInvitationService->index();
    }



    public function sendInvitation($userInvitedId,$GroupId)
    {

        return $this->sendInvitationService->createInvitation($userInvitedId,$GroupId);
    }


    public function cancelInvitation($invitationId)
    {
        return $this->cancelInvitationService->cancelInvitation($invitationId);
    }

    

    public function invitationUserSpecific()
    {

        return $this->displayInvitationService->userSpecific();
    }


    public function invitationGroupSpecific($GroupId)
    {

        return $this->displayInvitationService->GroupSpecific($GroupId);
    }


    public function acceptInvitation($invitationId)
    {

        return $this->acceptInvitationService->acceptInvitation($invitationId);
    }

    public function declineInvitation($invitationId)
    {
        return $this->declineInvitationService->declineInvitation($invitationId);
    }
}

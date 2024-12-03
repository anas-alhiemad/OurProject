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

    public function __construct() {
        $this->middleware('auth:user');
    }


    public function indexInvitation()
    {

        return (new DisplayInvitationService)->index();
    }



    public function sendInvitation($userInvitedId,$GroupId)
    {

        return (new SendInvitationService)->createInvitation($userInvitedId,$GroupId);
    }


    public function cancelInvitation($invitationId)
    {
        return (new CancelInvitationService)->cancelInvitation($invitationId);
    }

    

    public function invitationUserSpecific()
    {

        return (new DisplayInvitationService)->UserSpecific();
    }


    public function invitationGroupSpecific($GroupId)
    {

        return (new DisplayInvitationService)->GroupSpecific($GroupId);
    }


    public function acceptInvitation($invitationId)
    {

        return (new AcceptInvitationService)->acceptInvitation($invitationId);
    }

    public function declineInvitation($invitationId)
    {
        return (new DeclineInvitationService)->declineInvitation($invitationId);
    }
}

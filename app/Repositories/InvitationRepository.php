<?php
namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Interfaces\RepositoryInterface;
use App\Models\Invitation;

class InvitationRepository extends BaseRepository implements RepositoryInterface
{
    public function __construct(Invitation $model)
    {
        parent::__construct($model);
    }

    public function getInvitationPending($invitationId)
    {
        $invitation = Invitation::whereId($invitationId)
                                 ->whereStatus('pending')->first();
        return $invitation;
    }


    public function changeInvitationStatus($invitationId,$status)
    {
        $invitation = $this->model::whereId($invitationId)
                                 ->whereStatus('pending')->first();

        $invitation->status = $status;
        $invitation->save();                         
        return $invitation;
    }

    public function userSpecificInvitation($userId)
    {
        $allInvitations =$this->model::where('invitedUserId',$userId)
                                    ->whereStatus('pending')->get();                     
        return $allInvitations;
    }

    public function groupSpecificInvitation($groupId)
    { 
        $allInvitations = $this->model::where('groupId',$groupId)
                                    ->whereStatus('pending')->get();
        return $allInvitations;
    }

}
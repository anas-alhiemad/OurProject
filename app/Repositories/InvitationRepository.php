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

    public function getallinvitedUser()
    {
        $invitation = $this->model->with('invitedUser','group')->get();
        return $invitation;
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
                        ->whereStatus('pending')->with(['group','group.userGroup'=>function ($query) {
                        $query->where('isOwner', 1)->with('user');}])->get();                     
        return $allInvitations;
    }

    public function groupSpecificInvitation($groupId)
    { 
        $allInvitations = $this->model::where('groupId',$groupId)
                                    ->whereStatus('pending')->with('invitedUser')->get();
        return $allInvitations;
    }

}
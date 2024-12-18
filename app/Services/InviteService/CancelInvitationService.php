<?php
namespace App\Services\InviteService;

use App\Models\User;
use App\Models\Group;
use App\Models\Invitation;
use App\Repositories\UserRepository;
use App\Repositories\GroupRepository;
use App\Repositories\InvitationRepository;


class CancelInvitationService 
{
    protected $invitationRepository;
    protected $groupRepository;
    protected $userRepository;

    public function __construct(InvitationRepository $invitationRepository,GroupRepository $groupRepository,UserRepository $userRepository)
    {
        $this->invitationRepository = $invitationRepository;
        $this->groupRepository = $groupRepository;
        $this->userRepository = $userRepository;
    }

 
    public function cancelInvitation($invitationId)
    {
        $invitation = $this->invitationRepository->getInvitationPending($invitationId);
        if (!$invitation) {
            return response()->json(['message' => 'this Invtation not found'], 404);
        }

        $group = $this->groupRepository->getById($invitation->groupId);
           
        $user =  $this->userRepository->getById(auth()->guard('user')->id()); 
      
        $owner = $user->can('create', $group); 

        if ($owner) {
            $this->invitationRepository->delete($invitationId);

            return response()->json(["message" => "The invitation has been cancel successfully","InfoInvite"=>$invitation],200);
        }

        return response()->json(['Message' => 'You do not have the authority to cancel invitation.'], 422);   

    }

}
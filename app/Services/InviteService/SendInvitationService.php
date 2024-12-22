<?php
namespace App\Services\InviteService;

use App\Models\Group;
use App\Models\User;
use App\Models\Invitation;
use App\Repositories\GroupRepository;
use App\Repositories\InvitationRepository;
use App\Repositories\UserRepository;

class SendInvitationService 
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

    public function isOwner($user,$group)
    { 
        if ($user->can('create', $group)) 
                    return true;
        return false;            
    }

        public function createInvitation($userInvitedId,$groupId)
        {
            $group = $this->groupRepository->getById($groupId);
           
            $user =  $this->userRepository->getById(auth()->guard('user')->id()); 
          
            $owner = $user->can('create', $group); 

            if ($owner) {
                $invitationInfo = ['groupId'=>$groupId,'invitedUserId'=>$userInvitedId];
                $invitationCreated = $this->invitationRepository->create($invitationInfo);
                    return response()->json(["message" => "The invitation has been sent successfully","InfoInvite"=>$invitationCreated],200);
                }
        
                return response()->json(['Message' => 'You do not have the authority to send invitation.'], 422);   

        }

}
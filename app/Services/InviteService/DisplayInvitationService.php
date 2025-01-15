<?php
namespace App\Services\InviteService;

use App\Models\Invitation;
use App\Repositories\UserRepository;
use App\Repositories\GroupRepository;
use App\Repositories\InvitationRepository;

class DisplayInvitationService 
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

    public function index()
    {
    
        $allInvitations = $this->invitationRepository->getallinvitedUser();
        return response()->json(["Message"=>"all info for Invitations","infoInvitations"=>$allInvitations]);
    }

    public function UserSpecific()
    {
        $allInvitations =  $this->invitationRepository->userSpecificInvitation(auth()->guard('user')->id());

        return response()->json(["Message"=>" info Your invitations","infoInvitations"=>$allInvitations]);
    }


    public function GroupSpecific($groupId)
    {
        $group = $this->groupRepository->getById($groupId);
           
        $user =  $this->userRepository->getById(auth()->guard('user')->id()); 
        $isOwner = $this->isOwner($user,$group);
        if ($isOwner){
            
        
        $allInvitations =  $this->invitationRepository->groupSpecificInvitation($groupId);

        return response()->json(["Message"=>" info Your invitations","infoInvitations"=>$allInvitations]);
        }
        return response()->json(["Message"=>"You do not have the authority to do this."]);
    }

}
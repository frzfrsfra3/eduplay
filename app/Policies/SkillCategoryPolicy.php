<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SkillCategory;
use App\Models\Skill;
use Illuminate\Auth\Access\HandlesAuthorization;

class SkillCategoryPolicy
{
    // Policies for Skill and Skill Category collaboration
    use HandlesAuthorization;

    // Viewing
    public function viewSkill(User $user, Skill $skill)
    {
        //
    }

    public function viewSkillCategory(User $user, SkillCategory $skillCategory)
    {
        //
    }

    // Creating
    public function createSkill(User $user)
    {
        //authenticated user should be a teacher who is collaborator for the Discipline
    }

    public function createSkillCategory(User $user)
    {
        //
    }

    // updating
    public function updateSkill(User $user, Skill $skill)
    {
        //authenticated user should be a collaborator, the skill should be createdby that user, the status should be unpublished
    }

    public function updateSkillCategory(User $user, SkillCategory $skillCategory)
    {
        //authenticated user should be a collaborator, the skill should be createdby that user, the status should be unpublished
    }

    // deleting
    public function deleteSkill(User $user, Skill $skill)
    {
        //
    }

    public function deleteSkillCategory(User $user, SkillCategory $skillCategory)
    {
        //
    }
}

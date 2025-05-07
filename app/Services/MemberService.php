<?php

namespace App\Services;

use App\Models\Member;

class MemberService
{
    /**
     * Generate a unique member number like CGTA-00001
     *
     * @return string
     */
    public function generateMemberNumber(): string
    {
        $lastMember = Member::orderBy('id', 'desc')->first();
        $nextId = $lastMember ? $lastMember->id + 1 : 1;

        return 'CGTA-' . str_pad($nextId, 5, '0', STR_PAD_LEFT);
    }
}

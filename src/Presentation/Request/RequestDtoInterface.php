<?php

namespace App\Presentation\Request;

use Symfony\Component\HttpFoundation\Request;

interface RequestDtoInterface
{
    public function __construct(Request $request);
}

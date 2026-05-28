<?php

namespace hemilrajput\TypeGen\Tests\Fixtures\Resources;

use hemilrajput\TypeGen\Attributes\TypeScript;
use Illuminate\Http\Resources\Json\JsonResource;

#[TypeScript]
class UserResource extends JsonResource {}

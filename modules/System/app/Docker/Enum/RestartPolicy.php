<?php

namespace Modules\System\Docker\Enum;

enum RestartPolicy: string
{
    case NONE = 'no';
    case ON_FAILURE = 'on_failure';
    case ALWAYS = 'always';
    case UNLESS_STOPPED = 'unless-stopped';
}

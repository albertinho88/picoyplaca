<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ResponseType extends Enum
{
    const SUCCESS = 'success';
    const ERROR = 'danger';
    const WARNING = 'warning';

}

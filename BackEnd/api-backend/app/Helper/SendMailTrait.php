<?php

namespace App\Helper;

use App\Jobs\SendForgotJob;
use App\Jobs\SendForgotPasswordJob;
use App\Jobs\SendUserInfoJob;

trait SendMailTrait
{
    public function callSendUserInfoMail(array $data): void
    {
        dispatch(new SendUserInfoJob($data));
    }

    public function callSendForgotPassword(array $data): void
    {
        dispatch(new SendForgotPasswordJob($data));
    }
}

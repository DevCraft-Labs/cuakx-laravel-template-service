<?php

namespace App\Http\Controllers\Auth;

use Cuakx\Core\DTO\BaseResponseDTO;
use Cuakx\Core\Utils\Auth\Session\AuthenticationUtil;
use Cuakx\Core\Utils\Auth\Session\Model\UserSession;
use Cuakx\Core\Utils\Auth\XToken\XTokenUtil;
use Cuakx\Core\Utils\Console;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;

class SampleUsingAuthController
{
    public function sampleUsingAuth(Request $request)
    {
        $session = new UserSession(
            user_id: 100,
            role_id: "NYENYE",
            access_id: 100,
            organization_id: 100,
            user_name: "Lala",
            organization_name: "SHLV",
            issued_at: new DateTime()
        );

        $auth = new AuthenticationUtil();
        $token = $auth->issueToken($session);


        $hmac = hash_hmac('sha512', '{"test":"test"}', env('APP_KEY'));

        $lah = XTokenUtil::validateToken($hmac, $request);

        Console::writeLine("Issued Token {$hmac} | XToken {$lah}");


        return BaseResponseDTO::success("Success", (object) [
            "token" => $token,
            "x_token" => $lah,
        ]);
    }
}

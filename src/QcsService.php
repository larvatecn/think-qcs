<?php

namespace Larva\ThinkQcs;

use TencentCloud\Common\Credential;
use TencentCloud\Common\Profile\ClientProfile;
use TencentCloud\Common\Profile\HttpProfile;
use TencentCloud\Ims\V20201229\ImsClient;
use TencentCloud\Tms\V20201229\TmsClient;

class QcsService extends \think\Service
{
    public function register()
    {
        $this->app->bind('tms-service', function () {
            $credential = new Credential(config('services.tms.secret_id'), config('services.tms.secret_key'));
            $httpProfile = new HttpProfile();
            $httpProfile->setEndpoint(config('services.tms.endpoint', 'tms.tencentcloudapi.com'));

            $clientProfile = new ClientProfile();
            $clientProfile->setHttpProfile($httpProfile);

            return new TmsClient($credential, config('services.tms.region', 'ap-guangzhou'), $clientProfile);
        });

        $this->app->bind('tms', function () {
            return \tap(
                new \Larva\ThinkQcs\Moderators\Tms(),
                function (\Larva\ThinkQcs\Moderators\Tms $tms) {
                    $tms->setStrategy('strict', fn ($result) => $result['Suggestion'] === 'Pass');
                }
            );
        });

        $this->app->bind('ims-service', function () {
            $credential = new Credential(config('services.ims.secret_id'), config('services.ims.secret_key'));
            $httpProfile = new HttpProfile();
            $httpProfile->setEndpoint(config('services.ims.endpoint', 'ims.tencentcloudapi.com'));

            $clientProfile = new ClientProfile();
            $clientProfile->setHttpProfile($httpProfile);

            return new ImsClient($credential, config('services.ims.region', 'ap-guangzhou'), $clientProfile);
        });

        $this->app->bind('ims', function () {
            return \tap(
                new \Larva\ThinkQcs\Moderators\Ims(),
                function (\Larva\ThinkQcs\Moderators\Ims $ims) {
                    $ims->setStrategy('strict', fn ($result) => $result['Suggestion'] === 'Pass');
                }
            );
        });
    }

    public function boot()
    {
    }
}

<?php

namespace Larva\ThinkQcs\Moderators;

use Larva\ThinkQcs\Exceptions\Exception;
use Larva\ThinkQcs\Exceptions\InvalidTextException;
use Larva\ThinkQcs\Traits\HasStrategies;
use TencentCloud\Tms\V20201229\Models\TextModerationRequest;

class Tms
{
    use HasStrategies;

    public const DEFAULT_STRATEGY = 'strict';

    /**
     * @throws Exception
     */
    public function check(string $contents)
    {
        $request = new TextModerationRequest();
        $request->fromJsonString(\json_encode(['Content' => \base64_encode($contents)]));
        $response = \json_decode(\app('tms-service')->TextModeration($request)->toJsonString(), true);
        if (empty($response['Suggestion'])) {
            throw new Exception('API 调用失败(empty response)');
        }
        return $response;
    }

    /**
     * @throws InvalidTextException
     * @throws Exception
     */
    public function validate(string $contents, string $strategy = self::DEFAULT_STRATEGY): bool
    {
        $response = $this->check($contents);

        if (!$this->satisfiesStrategy($response, $strategy)) {
            throw new InvalidTextException($contents, $response);
        }

        return true;
    }

    /**
     * @throws Exception
     */
    public function mask(string $contents, string $strategy = self::DEFAULT_STRATEGY, string $char = '*')
    {
        $result = $this->check($contents);

        if (empty($result['Keywords']) || $this->satisfiesStrategy($result, $strategy)) {
            return $contents;
        }

        return \str_replace($result['Keywords'], $char, $contents);
    }
}

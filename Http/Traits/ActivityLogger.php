<?php

namespace Modules\Log\Http\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Jaybizzle\LaravelCrawlerDetect\Facades\LaravelCrawlerDetect as Crawler;

use Modules\Log\Entities\Activity;
use Validator;

trait ActivityLogger
{
    /**
     * Laravel Logger Log Activity.
     *
     * @param string $description
     * @return void
     */
    public static function activity($description = null)
    {
        $userType = trans('log::general.userTypes.guest');
        $userId = null;

        if (\Auth::check()) {
            $userType = trans('log::general.userTypes.registered');
            $userIdField = config('log.default_user_id');
            $userId = Request::user()->{$userIdField};
        }

        if (Crawler::isCrawler()) {
            $userType = trans('log::general.userTypes.crawler');
            $description = $userType.' '.trans('log::general.verbTypes.crawled').' '.Request::fullUrl();
        }

        if (!$description) {
            switch (strtolower(Request::method())) {
                case 'post':
                    $verb = trans('log::general.verbTypes.created');
                    break;

                case 'patch':
                case 'put':
                    $verb = trans('log::general.verbTypes.edited');
                    break;

                case 'delete':
                    $verb = trans('log::general.verbTypes.deleted');
                    break;

                case 'get':
                default:
                    $verb = trans('log::general.verbTypes.viewed');
                    break;
            }

            $description = $verb.' '.Request::path();
        }

        $data = [
            'description'   => $description,
            'userType'      => $userType,
            'userId'        => $userId,
            'route'         => Request::fullUrl(),
            'ipAddress'     => Request::ip(),
            'userAgent'     => Request::header('user-agent'),
            'locale'        => Request::header('accept-language'),
            'referer'       => Request::header('referer'),
            'methodType'    => Request::method(),
        ];

        // Validation Instance
        $validator = Validator::make($data, Activity::Rules([]));
        if ($validator->fails()) {
            $errors = self::prepareErrorMessage($validator->errors(), $data);

            Log::error('Failed to record activity event. Failed Validation: '.$errors);

        } else {
            self::storeActivity($data);
        }
    }

    /**
     * Store activity entry to database.
     *
     * @param array $data
     * @return void
     */
    private static function storeActivity($data)
    {
        Activity::create([
            'description'   => $data['description'],
            'userType'      => $data['userType'],
            'userId'        => $data['userId'],
            'route'         => $data['route'],
            'ipAddress'     => $data['ipAddress'],
            'userAgent'     => $data['userAgent'],
            'locale'        => $data['locale'],
            'referer'       => $data['referer'],
            'methodType'    => $data['methodType'],
        ]);
    }

    /**
     * Prepare Error Message (add the actual value of the error field).
     *
     * @param $validator
     * @param $data
     * @return string
     */
    private static function prepareErrorMessage($validatorErrors, $data)
    {
        $errors = json_decode(json_encode($validatorErrors, true));
        array_walk($errors, function (&$value, $key) use ($data) {
            array_push($value, "Value: $data[$key]");
        });

        return json_encode($errors, true);
    }
}
<?php

namespace Modules\Log\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

use Modules\Log\Http\Traits\IpAddressDetails;
use Modules\Log\Http\Traits\UserAgentDetails;
use Modules\Log\Entities\Activity;

class LogController extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use IpAddressDetails;
    use UserAgentDetails;
    use ValidatesRequests;

    private $_rolesMiddlware;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->_rolesMiddlware = config('log.middleware');
        
        $this->middleware($this->_rolesMiddlware);
    }

    /**
     * Add additional details to a collections.
     *
     * @param collection $collectionItems
     *
     * @return collection
     */
    private function mapAdditionalDetails($collectionItems)
    {
        $collectionItems->map(function ($collectionItem) {
            $eventTime = Carbon::parse($collectionItem->updated_at);
            $collectionItem['timePassed'] = $eventTime->diffForHumans();
            $collectionItem['userAgentDetails'] = UserAgentDetails::details($collectionItem->useragent);
            $collectionItem['langDetails'] = UserAgentDetails::localeLang($collectionItem->locale);
            $collectionItem['userDetails'] = config('log.default_user_model')::find($collectionItem->userId);

            return $collectionItem;
        });

        return $collectionItems;
    }

    /**
     * Show the activities log dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAccessLog(Request $request)
    {
        $activities = Activity::orderBy('created_at', 'desc');
        $activities = $this->searchActivityLog($activities, $request);

        $activities = $activities->paginate(config('log.paginate'));
        $totalActivities = $activities->total();

        self::mapAdditionalDetails($activities);

        $users = config('log.default_user_model')::all();

        $data = [
            'activities'        => $activities,
            'totalActivities'   => $totalActivities,
            'users'             => $users,
        ];

        return view('log::logger.activity-log', $data);
    }

    /**
     * Show an individual activity log entry.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return \Illuminate\Http\Response
     */
    public function showAccessLogEntry(Request $request, $id)
    {
        $activity = Activity::findOrFail($id);

        $userDetails = config('log.default_user_model')::find($activity->userId);
        $userAgentDetails = UserAgentDetails::details($activity->useragent);
        $ipAddressDetails = IpAddressDetails::checkIP($activity->ipAddress);
        $langDetails = UserAgentDetails::localeLang($activity->locale);
        $eventTime = Carbon::parse($activity->created_at);
        $timePassed = $eventTime->diffForHumans();

        $userActivities = Activity::where('userId', $activity->userId)
            ->orderBy('created_at', 'desc')
            ->paginate(config('log.paginate'));
        $totalUserActivities = $userActivities->total();

        self::mapAdditionalDetails($userActivities);

        $data = [
            'activity'              => $activity,
            'userDetails'           => $userDetails,
            'ipAddressDetails'      => $ipAddressDetails,
            'timePassed'            => $timePassed,
            'userAgentDetails'      => $userAgentDetails,
            'langDetails'           => $langDetails,
            'userActivities'        => $userActivities,
            'totalUserActivities'   => $totalUserActivities,
            'isClearedEntry'        => false,
        ];

        return view('log::logger.activity-log-item', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function clearActivityLog(Request $request)
    {
        $activities = Activity::all();
        foreach ($activities as $activity) {
            $activity->delete();
        }

        return redirect('activity')->with('success', trans('log::general.messages.logClearedSuccessfuly'));
    }

    /**
     * Show the cleared activity log - softdeleted records.
     *
     * @return \Illuminate\Http\Response
     */
    public function showClearedActivityLog()
    {
        $activities = Activity::onlyTrashed()
            ->orderBy('created_at', 'desc')
            ->paginate(config('log.paginate'));
        $totalActivities = $activities->total();

        self::mapAdditionalDetails($activities);

        $data = [
            'activities'        => $activities,
            'totalActivities'   => $totalActivities,
        ];

        return view('log::logger.activity-log-cleared', $data);
    }

    /**
     * Show an individual cleared (soft deleted) activity log entry.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return \Illuminate\Http\Response
     */
    public function showClearedAccessLogEntry(Request $request, $id)
    {
        $activity = self::getClearedActvity($id);

        $userDetails = config('log.default_user_model')::find($activity->userId);
        $userAgentDetails = UserAgentDetails::details($activity->useragent);
        $ipAddressDetails = IpAddressDetails::checkIP($activity->ipAddress);
        $langDetails = UserAgentDetails::localeLang($activity->locale);
        $eventTime = Carbon::parse($activity->created_at);
        $timePassed = $eventTime->diffForHumans();

        $data = [
            'activity'              => $activity,
            'userDetails'           => $userDetails,
            'ipAddressDetails'      => $ipAddressDetails,
            'timePassed'            => $timePassed,
            'userAgentDetails'      => $userAgentDetails,
            'langDetails'           => $langDetails,
            'isClearedEntry'        => true,
        ];

        return view('log::logger.activity-log-item', $data);
    }

    /**
     * Get Cleared (Soft Deleted) Activity - Helper Method.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    private static function getClearedActvity($id)
    {
        $activity = Activity::onlyTrashed()->where('id', $id)->get();
        if (count($activity) != 1) {
            return abort(404);
        }

        return $activity[0];
    }

    /**
     * Destroy the specified resource from storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function destroyActivityLog(Request $request)
    {
        $activities = Activity::onlyTrashed()->get();
        foreach ($activities as $activity) {
            $activity->forceDelete();
        }

        return redirect('activity')->with('success', trans('log::general.messages.logDestroyedSuccessfuly'));
    }

    /**
     * Restore the specified resource from soft deleted storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function restoreClearedActivityLog(Request $request)
    {
        $activities = Activity::onlyTrashed()->get();
        foreach ($activities as $activity) {
            $activity->restore();
        }

        return redirect('activity')->with('success', trans('log::general.messages.logRestoredSuccessfuly'));
    }

    /**
     * Search the activity log according to specific criteria.
     *
     * @param query
     * @param request
     *
     * @return filtered query
     */
    public function searchActivityLog($query, $requeset)
    {
        if (in_array('description', explode(',', 'description,user,method,route,ip')) && $requeset->get('description')) {
            $query->where('description', 'like', '%'.$requeset->get('description').'%');
        }

        if (in_array('user', explode(',', 'description,user,method,route,ip')) && $requeset->get('user')) {
            $query->where('userId', '=', $requeset->get('user'));
        }

        if (in_array('method', explode(',', 'description,user,method,route,ip')) && $requeset->get('method')) {
            $query->where('methodType', '=', $requeset->get('method'));
        }

        if (in_array('route', explode(',', 'description,user,method,route,ip')) && $requeset->get('route')) {
            $query->where('route', 'like', '%'.$requeset->get('route').'%');
        }

        if (in_array('ip', explode(',', 'description,user,method,route,ip')) && $requeset->get('ip_address')) {
            $query->where('ipAddress', 'like', '%'.$requeset->get('ip_address').'%');
        }

        return $query;
    }
}

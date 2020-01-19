@extends(config('log.extended'))

@section('template_linked_css')
    @include('log::partials.styles')
@endsection

@section('footer_scripts')
    @include('log::partials.scripts', ['activities' => $activities])
    @include('log::scripts.confirm-modal', ['formTrigger' => '#confirmDelete'])
    @include('log::scripts.confirm-modal', ['formTrigger' => '#confirmRestore'])

    <script type="text/javascript">
        $(function() {
            $(".clickable-row").click(function() {
                window.location = $(this).data("href");
            });
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection

@section('template_title')
    {{ trans('log::general.dashboardCleared.title') }}
@endsection

@section('content')

    <div class="container">

        @include('log::partials.form-status')

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span>
                                {!! trans('log::general.dashboardCleared.title') !!}
                                <sup class="label label-default">
                                    {{ $totalActivities }} {!! trans('log::general.dashboardCleared.subtitle') !!}
                                </sup>
                            </span>

                            <div class="dropdown pull-right btn-group-xs">
                                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
                                    <span class="sr-only">
                                        {!! trans('log::general.dashboard.menu.alt') !!}
                                    </span>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li>
                                        <a href="{{ route('activity') }}"><i class="fa fa-fw fa-mail-reply" aria-hidden="true"></i>
                                            {!! trans('log::general.dashboard.menu.back') !!}
                                        </a>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    @if($totalActivities)
                                        <li>@include('log::forms.delete-activity-log')</li>
                                        <li>@include('log::forms.restore-activity-log')</li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        @include('log::logger.partials.activity-table', ['activities' => $activities, 'hoverable' => true])
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('log::modals.confirm-modal', ['formTrigger' => 'confirmDelete', 'modalClass' => 'danger', 'actionBtnIcon' => 'fa-trash-o'])
    @include('log::modals.confirm-modal', ['formTrigger' => 'confirmRestore', 'modalClass' => 'success', 'actionBtnIcon' => 'fa-check'])

@endsection
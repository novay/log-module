@extends(config('log.extended'))

@section('template_linked_css')
    @include('log::partials.styles')
@endsection

@section('footer_scripts')
    @include('log::partials.scripts', ['activities' => $activities])
    @include('log::scripts.confirm-modal', ['formTrigger' => '#confirmDelete'])

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
    {{ trans('log::general.dashboard.title') }}
@endsection

@section('content')
    <div class="container">
        <br/>
        @include('log::partials.form-search')
        @include('log::partials.form-status')
        <br/>
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span>
                                {!! trans('log::general.dashboard.title') !!}
                                <small>
                                    <sup class="label label-default">
                                        {{ $totalActivities }} {!! trans('log::general.dashboard.subtitle') !!}
                                    </sup>
                                </small>
                            </span>

                            <div class="dropdown pull-right btn-group-xs">
                                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
                                    <span class="sr-only">
                                        {!! trans('log::general.dashboard.menu.alt') !!}
                                    </span>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li>@include('log::forms.clear-activity-log')</li>
                                    <li role="separator" class="divider"></li>
                                    <li>
                                        <a href="{{ route('cleared') }}"><i class="fa fa-fw fa-history" aria-hidden="true"></i>
                                            {!! trans('log::general.dashboard.menu.show') !!}
                                        </a>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                    <div class="panel-body" style="padding: 0;">
                        @include('log::logger.partials.activity-table', ['activities' => $activities, 'hoverable' => true])
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('log::modals.confirm-modal', [
        'formTrigger' => 'confirmDelete', 
        'modalClass' => 'danger', 
        'actionBtnIcon' => 'fa-trash-o'
    ])

@endsection
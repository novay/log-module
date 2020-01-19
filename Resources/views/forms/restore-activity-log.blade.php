{!! Form::open(array('route' => 'restore-activity', 'method' => 'POST', 'class' => 'mb-0')) !!}

    {!! Form::button('<i class="fa fa-fw fa-history" aria-hidden="true"></i>' . trans('log::general.dashboardCleared.menu.restoreAll'), 
    	[
    		'type' => 'button', 
    		'class' => 'text-success dropdown-item', 
    		'data-toggle' => 'modal', 
    		'data-target' => '#confirmRestore', 
    		'data-title' => trans('log::general.modals.restoreLog.title'),
    		'data-message' => trans('log::general.modals.restoreLog.message')
    	]) !!}

{!! Form::close() !!}
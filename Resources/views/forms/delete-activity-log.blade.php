{!! Form::open(array('route' => 'destroy-activity', 'class' => 'mb-0')) !!}
    {!! Form::hidden('_method', 'DELETE') !!}

    {!! Form::button('<i class="fa fa-fw fa-eraser" aria-hidden="true"></i>' . trans('log::general.dashboardCleared.menu.deleteAll'), 
    	[
    		'type' => 'button', 
    		'class' => 'text-danger dropdown-item', 
    		'data-toggle' => 'modal', 
    		'data-target' => '#confirmDelete', 
    		'data-title' => trans('log::general.modals.deleteLog.title'),
    		'data-message' => trans('log::general.modals.deleteLog.message')
    	]) !!}

{!! Form::close() !!}
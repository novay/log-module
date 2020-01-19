{!! Form::open(array('route' => 'clear-activity')) !!}
    {!! Form::hidden('_method', 'DELETE') !!}
    
    {!! Form::button('<i class="fa fa-fw fa-trash" aria-hidden="true"></i>' . trans('log::general.dashboard.menu.clear'), 
    	[
    		'type' => 'button', 
    		'data-toggle' => 'modal', 
    		'data-target' => '#confirmDelete', 
    		'data-title' => trans('log::general.modals.clearLog.title'),
    		'data-message' => trans('log::general.modals.clearLog.message'), 
    		'class' => 'dropdown-item'
    	]) !!}

{!! Form::close() !!}
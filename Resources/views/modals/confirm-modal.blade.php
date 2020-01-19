@php
  if (!isset($actionBtnIcon)) {
      $actionBtnIcon = null;
  } else {
      $actionBtnIcon = $actionBtnIcon . ' fa-fw';
  }
  if (!isset($modalClass)) {
      $modalClass = null;
  }
  if (!isset($btnSubmitText)) {
      $btnSubmitText = trans('log::general.modals.shared.btnConfirm');
  }
@endphp

<div class="modal fade modal-{{$modalClass}}" tabindex="-1" role="dialog" id="{{$formTrigger}}" aria-labelledby="{{$formTrigger}}Label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header {{$modalClass}}">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Confirm</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <i class="fa fa-fw fa-close" aria-hidden="true"></i> 
                    {{ trans('log::general.modals.shared.btnCancel') }}
                </button>
                <button type="button" class="btn btn-{{ $modalClass }}" id="confirm">
                    <i class="fa {{ $actionBtnIcon }}" aria-hidden="true"></i>
                    {{ $btnSubmitText }}
                </button>
            </div>
        </div>
    </div>
</div>
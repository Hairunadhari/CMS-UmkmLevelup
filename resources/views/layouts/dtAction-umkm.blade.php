<div class="custom-control custom-switch " id="btn-change" style="cursor: pointer">
    
    <input style="cursor: pointer" 
        type="checkbox" 
        class="custom-control-input " 
        data-id="{{ $data->id }}" 
        id="{{ $data->id }}" 
        {{ ($data->is_accept == 1 ? 'checked' : '')  }}
    >
    <label class="custom-control-label change{{ $data->id }}" for="customSwitch{{ $data->id }}" style="cursor: pointer">
       <span class="text-is-active">
        @if ($data->is_accept == 1)
            Active 
        @else  
            Not Active        
        @endif
       </span>
    </label>
</div>
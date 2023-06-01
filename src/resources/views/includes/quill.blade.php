<div>
    <label for="{{$key}}" class="form-label">{{$label}}</label>
    <div id="{{$key}}_quill">{!!$value!!}</div>
    <input type="hidden" id="{{$key}}" name="{{$key}}" value="{{$value}}">
    <input type="hidden" id="{{$key}}_unfiltered" name="{{$key}}_unfiltered" value="{{$value_unfiltered}}">
    @error($key)
        <div class="invalid-message">{{ $message }}</div>
    @enderror
    @error($key.'_unfiltered')
        <div class="invalid-message">{{ $message }}</div>
    @enderror
</div>

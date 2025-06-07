@foreach ($fields as $name => $field)
    @php
        // jika name memiliki dot, ubah ke bracket notation
        $inputName = str_contains($name, '.') ? preg_replace('/\./', '][', $name) : $name;
        $inputName = str_contains($name, '.') ? preg_replace('/^(.*?)\]\[/', '$1[', $inputName) . ']' : $inputName;
    @endphp
    <div class="mb-3">
        <label for="{{ $name }}" class="form-label">{{ $field['label'] ?? ucfirst($name) }}</label>

        @switch($field['type'])

            @case('text')
            @case('email')
            @case('number')
            @case('tel')
            @case('date')
            @case('password')
                <input
                    type="{{ $field['type'] }}"
                    name="{{ $inputName }}"
                    id="{{ $name }}"
                    class="form-control @error($inputName) is-invalid @enderror"
                    value="{{ $field['type'] != 'password' ? (old($name) ?? \Arr::get($data, $name, '')) : '' }}"
                    @if (!empty($field['placeholder'])) placeholder="{{ $field['placeholder'] }}" @endif
                    @if ((!empty($field['required']) && $field['type'] != 'password') || (!empty($field['required']) && $field['type'] == 'password' && \Arr::get($data, $name, '') == '')) required @endif
                    {{isset($field['readonly']) ? 'readonly="'. $field['readonly'] .'"' : ''}}
                >
                @break

            @case('textarea')
                <textarea
                    name="{{ $inputName }}"
                    id="{{ $name }}"
                    class="form-control @error($inputName) is-invalid @enderror"
                    @if (!empty($field['placeholder'])) placeholder="{{ $field['placeholder'] }}" @endif
                    @if (!empty($field['required'])) required @endif
                    {{isset($field['readonly']) ? 'readonly="'. $field['readonly'] .'"' : ''}}
                >{{ old($name) ?? \Arr::get($data, $name, '') }}</textarea>
                @break

            @case('select')
                <select name="{{ $inputName }}" id="{{ $name }}" class="form-control form-select @error($inputName) is-invalid @enderror" {{isset($field['readonly']) ? 'readonly="'. $field['readonly'] .'"' : ''}}>
                    @if(isset($field['placeholder']))
                    <option value="">{{$field['placeholder']}}</option>
                    @endif
                    @foreach ($field['options'] as $key => $option)
                        <option value="{{ $key }}" @selected(old($name, \Arr::get($data, $name, '')) == $key)>{{ $option }}</option>
                    @endforeach
                </select>
                @break
            
            @case('select2')
                <select name="{{ $inputName }}" id="{{ $name }}" class="form-control select2 form-select @error($inputName) is-invalid @enderror" {{isset($field['readonly']) ? 'readonly="'. $field['readonly'] .'"' : ''}}>
                    @if(isset($field['placeholder']))
                    <option value="">{{$field['placeholder']}}</option>
                    @endif
                    @foreach ($field['options'] as $key => $option)
                        <option value="{{ $key }}" @selected(old($name, \Arr::get($data, $name, '')) == $key)>{{ $option }}</option>
                    @endforeach
                </select>
                @break

            @case('checkbox')
                @foreach ($field['options'] as $key => $option)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="{{ $name }}[]" id="{{ $name }}_{{ $key }}" value="{{ $key }}"
                            @if (is_array(old($name, \Arr::get($data, $name, ''))) && in_array($key, old($name, \Arr::get($data, $name, '')))) checked @endif {{isset($field['readonly']) ? 'readonly="'. $field['readonly'] .'"' : ''}}>
                        <label class="form-check-label" for="{{ $name }}_{{ $key }}">
                            {{ $option }}
                        </label>
                    </div>
                @endforeach
                @break
            
            @case('group-checkbox')
                @foreach ($field['options'] as $featureName => $featureItems)
                <div class="form-wrapper mb-3">
                    <label for="">{{ucwords($featureName)}}</label>
                    @foreach($featureItems as $label => $item)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="{{ $inputName }}[]" id="{{ $name }}_{{$featureName}}_{{ $label }}" value="{{$item}}"
                            @if (is_array(old($name, \Arr::get($data, $name, ''))) && in_array($item, old($name, \Arr::get($data, $name, '')))) checked @endif {{isset($field['readonly']) ? 'readonly="'. $field['readonly'] .'"' : ''}}>
                        <label class="form-check-label" for="{{ $name }}_{{$featureName}}_{{ $label }}">
                            {{ ucwords($label) }}
                        </label>
                    </div>
                    @endforeach
                </div>
                @endforeach
                @break

            @case('radio')
                @foreach ($field['options'] as $key => $option)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="{{ $inputName }}" id="{{ $name }}_{{ $key }}" value="{{ $key }}"
                            @checked(old($name, \Arr::get($data, $name, '')) == $key) {{isset($field['readonly']) ? 'readonly="'. $field['readonly'] .'"' : ''}}>
                        <label class="form-check-label" for="{{ $name }}_{{ $key }}">
                            {{ $option }}
                        </label>
                    </div>
                @endforeach
                @break

            @case('file')
                <input type="hidden" name="{{ $inputName }}" id="{{ $name }}">
                <input type="file" name="file_upload_{{$name}}" id="{{ $name }}" data-target="{{$name}}" class="form-control @error('file_upload_'.$inputName) is-invalid @enderror libraries-file-upload">
                @break

            @default
                <input type="text" name="{{ $inputName }}" id="{{ $name }}" class="form-control @error($inputName) is-invalid @enderror" value="{{ old($name, \Arr::get($data, $name, '')) }}" {{isset($field['readonly']) ? 'readonly="'. $field['readonly'] .'"' : ''}}>
        @endswitch

        {{-- Error message --}}
        @error($inputName)
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
@endforeach

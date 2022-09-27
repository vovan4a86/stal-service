<div style="width: 400px">
    <form data-id="{{ $param->id }}" action="{{ route('admin.catalog.save_param', $param->id) }}" onsubmit="saveParam(this, event)">
        {!! Form::groupText('name', $param->name) !!}
        {!! Form::groupText('value', $param->value) !!}
        {!! Form::groupText('group', $param->group) !!}
        {!! Form::hidden('on_list', 0) !!}
        {!! Form::hidden('on_spec', 0) !!}
        {!! Form::groupCheckbox('on_list', 1, $param->on_list, 'Показывать в списке товаров') !!}
        {!! Form::groupCheckbox('on_spec', 1, $param->on_spec, 'Показывать в шапке товара') !!}

        <input type="submit" value="Сохранить" class="btn btn-primary" />
    </form>
</div>

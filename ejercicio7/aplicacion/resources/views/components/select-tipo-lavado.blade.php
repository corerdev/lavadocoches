    <div class="form-group">
        <label for="body">Tipo de lavado</label>
        <select name="tipo_lavado" class="form-control">
            <option value="">-</option>
            @foreach ($listado as $op)

                <?php var_dump($op->tipo_lavado); ?>

                <option value="{{ $op->descripcion}}" @selected($selectTipo == $op->id)>
                    {{ $op->descripcion}}
                </option>
            @endforeach
        </select>
        @error('tipo_lavado')
        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
        @enderror
    </div>
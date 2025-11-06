
<form id="addWarehouseForm" action="{{ route('admin.user_frontend.update_level', ['id' => $user->id]) }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="province_id">Tài khoản: {{ $user->name }} - {{ config("point.level")[$user->level] }}</label>
        <select name="level" class="form-control" required>
            <option value="">-- Chọn level --</option>
           @foreach (config("point.level") as $key => $itemLevel)
            <option value="{{ $key }}" @if( (old('level')?? $user->level)== $key){{'selected'}} @endif>{{ $itemLevel }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-success">Cập nhật</button>
</form>


<form id="addWarehouseForm" action="{{ route('admin.user_frontend.update_level', ['id' => $user->id]) }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="province_id">Tài khoản: {{ $user->name }} - Level {{ $user->level }}</label>
        <select name="level" class="form-control" required>
            <option value="">-- Chọn level --</option>
            <option value="1">Level 1</option>
            <option value="2">Level 2</option>
            <option value="3">Level 3</option>
            <option value="4">Level 4</option>
            <option value="5">Level 5</option>
        </select>
    </div>
    <button type="submit" class="btn btn-success">Cập nhật</button>
</form>

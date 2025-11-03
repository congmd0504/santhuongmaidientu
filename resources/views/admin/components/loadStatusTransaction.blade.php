<form action="{{ route('admin.updateStatus',['id'=>$data->id]) }}"
     method="POST" role="form" name="formTransactionStatus" id="formTransactionStatus"
     data-url="{{ route('admin.updateStatus',['id'=>$data->id]) }}">
    @csrf
    <input type="hidden" name="id" value="{{ $data->id }}">
    <div class="form-group">
        <label for="">Trạng thái</label>
        <select name="status" class="form-control" required="required">
            @foreach ($statusTransaction as $item)
                <option value="{{ $item['status'] }}" {{ $data->status==$item['status']?'selected':'' }}>{{ $item['name'] }}</option>
            @endforeach
        </select>
    </div>
    {{-- <div class="form-group">
        <label for="">Thanh toán</label>
        <div class="form-check">
            <label class="form-check-label">
                <input type="radio" class="form-check-input" value="1" name="thanhtoan" {{ $data->thanhtoan==1?'checked':'' }}>Đã thanh toán
            </label>
        </div>
        <div class="form-check">
            <label class="form-check-label">
                <input type="radio" class="form-check-input" value="0" name="thanhtoan" {{ $data->thanhtoan==0?'checked':'' }}>Chưa thanh toán
            </label>
        </div>
    </div>
    <div class="form-group">
        <label for="">Ghi chú của shop:</label>
        <textarea class="form-control" rows="5" name="note_shop" placeholder="Ghi chú">{{ $data->note_shop }}</textarea>
    </div> --}}
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
    <button type="submit" class="btn btn-primary">Chấp nhận</button>
</form>

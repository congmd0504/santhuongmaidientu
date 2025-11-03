$(document).on('change', '#city', function() {
    let urlRequest = $(this).data("url");
    let mythis = $(this);
    let value = $(this).val();
    let defaultCity = "<option value=''>Chọn tỉnh/thành phố</option>";
    let defaultDistrict = "<option value=''>Chọn quận/huyện</option>";
    let defaultCommune = "<option value=''>Chọn xã/phường/thị trấn</option>";
    if (!value) {
        $('#district').html(defaultDistrict);
        $('#commune').html(defaultCommune);
    } else {
        $.ajax({
            type: "GET",
            url: urlRequest,
            data: { 'cityId': value },
            success: function(data) {
                if (data.code == 200) {
                    let html = defaultDistrict + data.data;
                    $('#district').html(html);
                    $('#commune').html(defaultCommune);
                }
            }
        });
    }
})
$(document).on('change', '#district', function() {
    let urlRequest = $(this).data("url");
    let mythis = $(this);
    let value = $(this).val();
    let defaultCity = "<option value=''>Chọn tỉnh/thành phố</option>";
    let defaultDistrict = "<option value=''>Chọn quận/huyện</option>";
    let defaultCommune = "<option value=''>Chọn xã/phường/thị trấn</option>";
    if (!value) {
        $('#commune').html(defaultCommune);
    } else {
        $.ajax({
            type: "GET",
            url: urlRequest,
            data: { 'districtId': value },
            success: function(data) {
                if (data.code == 200) {
                    let html = defaultCommune + data.data;
                    $('#commune').html(html);
                }
            }
        });
    }
})
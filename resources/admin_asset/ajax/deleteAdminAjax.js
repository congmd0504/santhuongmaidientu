$(document).on("click", ".lb_delete", actionDelete);

function actionDelete(event) {
    event.preventDefault();
    let urlRequest = $(this).data("url");
    let mythis = $(this);
    alert(mythis.parents(".lb_item_delete"));
    Swal.fire({
        title: 'Bạn có chắc chắn muốn xóa',
        text: "Bạn sẽ không thể khôi phục điều này",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "GET",
                url: urlRequest,
                success: function(data) {
                    if (data.code == 200) {

                        mythis.closest(".lb_item_delete").remove();
                    }
                },
                error: function() {

                }
            });
            // Swal.fire(
            // 'Deleted!',
            // 'Your file has been deleted.',
            // 'success'
            // )
        }
    })
}
@foreach ($data as $i_child)
    @php
        $userDang = App\Models\User::where('id', $i_child->user_id)->first();
    @endphp
    <div class="box-comment-new">
        <div class="avater-comment">
            <img src="{{ $userDang->avatar_path ?? asset('admin_asset/images/username.png') }}"
                alt="{{ $userDang->name }}">
        </div>
        <div class="content-comment">
            <span>{{ $userDang->name }} <p>
                    ({{ \Carbon\Carbon::parse($i_child->created_at)->diffForHumans() }})
                </p></span>
            <p class="commnt-news-bottom">{{ $i_child->content }}</p>
            @if (Auth::id() == $i_child->user_id)
                <span class="delete" id="delete_{{ $i_child->id }}">...</span>
            @endif
            <a href="{{ route('destroyComment', ['id' => $i_child->id, 'post_id' => $id_post->id]) }}">
                <span class="btn-xoa" id="btn-xoa_{{ $i_child->id }}">Xóa</span>
            </a>
        </div>
    </div>
    <script>
        $(document).on('click', '#delete_{{ $i_child->id }}', function(e) {
            var btnXoa_{{ $i_child->id }} = document.querySelector('#btn-xoa_{{ $i_child->id }}');
            btnXoa_{{ $i_child->id }}.classList.toggle('active');
        });
    </script>
    <script>
        $(document).on('click', '#btn-xoa_{{ $i_child->id }}', function(e) {
            e.preventDefault();
            var listComment = document.getElementById('list-comment-{{ $id_post->id }}');
            $.ajax({
                type: 'GET',
                url: "{{ route('destroyComment', ['id' => $i_child->id, 'post_id' => $id_post->id]) }}",
                success: function(response) {
                    $('#list-comment-{{ $id_post->id }}').html(response.html);
                    $('#count_comment_{{ $id_post->id }}').html(response.countComment);
                    if (response.countComment <= 3) {
                        listComment.style.height = 'auto';
                        listComment.style.overflowY = 'unset';
                    } else {
                        listComment.style.height = '200px';
                        listComment.style.overflowY = 'scroll';
                    }
                },
                error: function(response) {}
            });
        });
    </script>
@endforeach

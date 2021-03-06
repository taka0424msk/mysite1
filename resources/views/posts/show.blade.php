<x-layout>
    <x-slot name="title">
        {{ $post->title }} - My BBS
    </x-slot>
    <div class="back-link">
        &laquo; <a href="{{ route('posts.index') }}">Back</a>
    </div>

    <h1>
        <span>{{ $post->title }}</span>
        <a href="{{ route('posts.edit', $post) }}">[Edit]</a>
        <form method="post" action="{{ route('posts.destroy', $post) }}" id="delete_post">
            @method('DELETE') {{--削除処理の際はdelete形式で送信する必要があるらしい--}}
            @csrf

            <button class="btn">[x]</button>
        </form>
    </h1>
    <p>{!! nl2br(e($post->body)) !!}</p> {{--nl2brで入力された通りに改行させる。文字絶対参照が適用されているため<br>が表示されてしまい、改行されない。{!! !!}で囲むことで文字絶対参照を解除できる。しかし、これだと悪意のある文字コードが入力されると困るので、e()で囲むことにより文字絶対参照にする。--}}

    <h2>Comments</h2>
    <ul>
        <li>
            <form action="{{ route('comments.store', $post) }}" method="post" class="comment-form">
                @csrf

                <input type="text" name="body">
                <button>Add</button>
            </form>
        </li>
        @foreach ($post->comments()->latest()->get() as $comment)
            <li>
                {{ $comment->body }}
                <form action="{{ route('comments.destroy', $comment) }}" method="post" class="delete-comment">
                    @method('DELETE')
                    @csrf

                    <button class="btn">[x]</button>
                </form>
            </li>
        @endforeach
    </ul>

    <script>
        'use strict'

        {
            document.getElementById('delete_post').addEventListener('submit', e => {
                e.preventDefault();

                if (!confirm('Sure to delete?')) {
                    return;
                }

                e.target.submit();
            });

            document.querySelectorAll('.delete-comment').forEach(form => {
                form.addEventListener('submit', e => {
                    e.preventDefault();

                    if (!confirm('Sure to delete?')) {
                        return;
                    }

                    form.submit();
                });
            });
        }

    </script>
</x-layout>


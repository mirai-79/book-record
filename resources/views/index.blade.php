<x-layout>
    <div x-cloak x-data="{ dialogOpen : false, dialogData: {} }" class="m-0 p-0 w-full h-screen">
        <x-element.breadcrumbs>
            {{ Breadcrumbs::render('home') }}
        </x-element.breadcrumbs>
        <x-layout.container>
        <x-element.tab>
            <x-slot name="index">感想一覧</x-slot>
            <x-slot name="my_record">自分の感想</x-slot>
            <x-slot name="my_favorite">お気に入り</x-slot>
        </x-element.tab>
            <section>
                @foreach ($records as $record)
                <article class="flex flex-col rounded-lg border sm:flex-row mt-6 bg-white drop-shadow-md relative ">
                    <img src="{{ $record->book->thumbnail_path }}"
                        class="rounded-l-lg md:max-w-[182px] max-sm:w-[200px] max-sm:h-[300px] sm:max-h-[188px] max-sm:mx-auto max-sm:rounded-none max-sm:pt-2">
                    <div class="flex flex-col py-2 px-4 flex-1 justify-between">
                        <div class="">
                            <div class="flex justify-between items-start">
                                <h3 class="text-lg font-bold text-gray-800 w-2/3">
                                    {{ $record->book->title }}
                                </h3>
                                <div class="flex items-center">
                                    <img src="{{ asset('/storage/images/edit_square_FILL0_wght400_GRAD0_opsz48.svg') }}"
                                        alt="投稿者を示すペンのアイコン" class="w-8 h-8 opacity-50">
                                    <p class="min-[400px]:pl-1 sm:w-[84px]">{{ $record->user->name }}</p>
                                </div>
                            </div>
                            <x-element.category :category_name="$record->category->name"></x-element.category>
                            <p class="text-gray-500">
                                {{ $record->content }}
                            </p>
                        </div>
                        <div class="flex justify-between items-center pt-4">
                            @auth
                            @if (!Auth::user()->checkFavorite($record->id))
                            <button @click="entryFavorite({{ $record->id }})" type="submit"><img
                                    src="{{ asset('/storage/images/star_border_black_24dp.svg') }}" alt="お気に入り登録ボタン"
                                    class="h-9 w-9"></button>
                            @else
                            <button @click="deleteFavorite({{ $record->id }})" type="submit"><img
                                    src="{{ asset('/storage/images/star_black_24dp.svg') }}" alt="お気に入り解除ボタン"
                                    class="h-9 w-9"></button>
                            @endif
                            @endauth
                            @auth
                            @if (Auth::id() !== $record->user_id)
                            <div class="">
                                <x-element.a-button :link="route('other.book.record', ['id' => $record->book->id])" :category="'record'">
                                    この本の感想を登録する
                                </x-element.a-button>
                            </div>
                            @endauth
                            @endif
                            @if (Auth::id() === $record->user_id)
                            <div class="flex">
                                <div class="translate-y-[2px]">
                                    <x-element.a-button :link="route('record.edit', ['record_id' => $record->id])" :category="'edit'">編集</x-element.a-button>
                                </div>
                                <div class="pl-6">
                                    <button
                                        @click="dialogOpen = true, dialogData = { recordId: '{{ $record->id }}', bookThumbnail: '{{ $record->book->thumbnail_path }}', bookTitle: '{{ $record->book->title }}', bookAuthor: '{{ $record->book->author }}', recordContent: '{{ $record->content }}' }"
                                        class="px-2 border-red-300 border-solid border-2 rounded-full hover:text-white hover:bg-red-300 duration-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">削除</button>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </article>
                @endforeach
            </section>
            <div class="mx-auto pt-4">
                {{ $records->links() }}
            </div>
            @auth
            <div class="relative">
                <a href="{{ route('search') }}"
                    class="fixed bottom-24 right-10 xl:right-1/4 xl:translate-x-40 py-2 px-4 text-white bg-blue-600 rounded-full hover:bg-blue-400 duration-300 shadow-xl shadow-gray-400">感想<span
                        class="block"></span>登録</a>
            </div>
            @endauth
        </x-layout.container>
        <!-- ダイアログ -->
        @include('delete')
    </div>
</x-layout>
<script>
    // 削除ダイアログ
    function deleteRecord(recordId) {
        console.log("IDは" + recordId);
        const deleteUrl = '/delete/' + recordId;
        fetch(deleteUrl, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
        })
        .then(response => {
            console.log('削除成功');
            location.reload();
        })
        .catch(error => {
            console.log("エラーが発生しました:", error);
        });
    }

    //お気に入り登録
    function entryFavorite(recordId) {
        console.log(`お気に入り登録のIDは:${recordId}`);
        const favoriteUrl = '/index/' + recordId;
        fetch(favoriteUrl, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
        })
        .then(response => {
            console.log(response);
            console.log('お気に入り登録成功');
            location.reload();
        })
        .catch(error => {
            console.log("エラーが発生しました:", error);
        });
    }

    //お気に入り削除
    function deleteFavorite(recordId) {
        console.log(`お気に入り登録のIDは:${recordId}`);
        const favoriteDeleteUrl = '/index/' + recordId;
        fetch(favoriteDeleteUrl, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
        })
        .then(response => {
            console.log(response);
            console.log('お気に入り削除成功');
            location.reload();
        })
        .catch(error => {
            console.log("エラーが発生しました:", error);
        });
    }
</script>

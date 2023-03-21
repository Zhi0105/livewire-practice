<div class="min-h-screen flex flex-col justify-center items-center">



    @error('newComment') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

    <div>
        @if (session()->has('message'))
        <div class="w-full p-3 bg-green-300 text-green-700 rounded">
            {{ session('message') }}
        </div>
        @endif
    </div>

    <section>
        @if($image)
        <img src="{{$image}}" width="200" />
        @endif
        <x-input type="file" id="image" wire:change="$emit('fileChoosen')" />
    </section>
    <form class="w-[30%] flex justify-center items-center mb-4" wire:submit.prevent="handleAddComment">
        <x-input id="password" class="block mt-1 w-full" type="text" placeholder="Whats on your mind ?" wire:model.debounce.500ms="newComment" />
        <x-button class="ml-4" type="submit">
            submit
        </x-button>
    </form>

    @foreach($comments as $comment)
    <div class="w-[50%] relative grid grid-cols-1 p-4 mb-8 border rounded-lg bg-white shadow-lg">
        <div class="relative flex gap-4">
            <img src="https://icons.iconarchive.com/icons/diversity-avatars/avatars/256/charlie-chaplin-icon.png" class="relative rounded-lg -top-8 -mb-4 bg-white border h-20 w-20" alt="" loading="lazy">
            <div class="flex flex-col w-full">
                <div class="flex flex-row justify-between">
                    <p class="relative text-xl whitespace-nowrap truncate overflow-hidden">{{ $comment->user->name }}</p>
                    <button wire:click="handleRemoveComment({{$comment->id}})"><span class="hover:text-red-600">x</span></button>
                </div>
                <p class="text-gray-400 text-sm">{{ $comment->created_at->diffForHumans()}}</p>
            </div>
        </div>
        <p class="-mt-4 text-gray-500">{{ $comment['body'] }}</p>
        @if($comment->image)
        <img src="{{$comment->imagePath}}" width="50" height="50" />
        @endif
    </div>
    @endforeach
    {{ $comments->links('pagination-links') }}
    <!-- {{ $comments->links() }} -->



    <script>
        window.livewire.on('fileChoosen', postId => {
            let input = document.getElementById('image')
            let file = input.files[0]

            let reader = new FileReader()

            reader.onloadend = () => {
                window.livewire.emit('fileUpload', reader.result)
            }

            reader.readAsDataURL(file);
        })
    </script>
</div>
@props(['post'])

<x-layout>
    <section class="px-6 py-8">
        <x-setting :heading="'Edit Post: ' . $post->title">
            <form method="POST" action="/admin/posts/{{  $post->id }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

               <x-form.input name="title" :value="$post->title" required />
               <x-form.input name="slug" :value="$post->slug" required />

                <div class="flex mt-6">
                    <div class="flex-1">
                        <x-form.input name="thumbnail" type="file" :value="old('thumbnail', $post->thumbnail)" />
                    </div>

                    <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="" class="rounded-xl ml-6" width="100">
                </div>

                <x-form.textarea name="excerpt" required >{{  $post->excerpt }}</x-form.textarea>
                <x-form.textarea name="body" required >{{ $post->body }}</x-form.textarea>

                <x-form.field name="category" >
                    <x-form.label name="category" />

                    <select name="category_id" id="category_id">
                        @foreach (\App\Models\Category::all() as $category)
                            <option
                                value="{{ $category->id }}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}
                            >{{ ucwords($category->name) }}</option>
                        @endforeach
                    </select>
                    <x-form.error name="category"/>
                </x-form.field>

                <x-form.button>Edit</x-form.button>
            </form>
        </x-setting>

    </section>
</x-layout>

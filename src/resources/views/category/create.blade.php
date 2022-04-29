<x-admin.layout.app>
    @php
    $breadcrumbs = [
        ['name' => 'Element', 'link' => route("admin.element.index")],
        ['name' => $element->title],
        ['name' => "Shop Address Filter", "link" => route('LaravelBlock2ThumbnailFilterIcon.index', $element->id)],
        ['name' => "Category", "link" => route("LaravelBlock2ThumbnailFilterIcon.category.index", $element->id)],
        ['name' => "Create"]
    ];
    @endphp
    <x-admin.atoms.breadcrumb :breadcrumbs="$breadcrumbs" />

    <form
        class="relative mt-7"
        method="POST"
        action="{{ route("LaravelBlock2ThumbnailFilterIcon.category.store", $element->id) }}"
        enctype="multipart/form-data"
    >
        @csrf
        
        <x-admin.atoms.required />

        @foreach (config('translatable.locales') as $locale)
            <x-admin.atoms.row>
                <x-admin.atoms.label class="required" for="title_{{ $locale }}">
                    Title ({{ $locale }})
                </x-admin.atoms.label>
                <x-admin.atoms.text name="title[{{$locale}}]" id="title_{{$locale}}" />
                @error("title.*")
                    <x-admin.atoms.error>
                        {{ $message }}
                    </x-admin.atoms.error>
                @enderror
            </x-admin.atoms.row>
        @endforeach

        <hr class="my-10">

        <div class="text-right">
            <x-admin.atoms.link
                href="{{ route('LaravelBlock2ThumbnailFilterIcon.category.index', $element->id) }}"
            >
                Back
            </x-admin.atoms.link>
            <x-admin.atoms.button id="save">
                Save
            </x-admin.atoms.button>
        </div>
    </form>
</x-admin.layout.app>

<x-admin.layout.app>
    @php
    $breadcrumbs = [
        ['name' => 'Element', 'link' => route("admin.element.index")],
        ['name' => $element->title],
        ['name' => "Thumbnail Filter Icon", "link" => route('LaravelBlock2ThumbnailFilterIcon.index', $element->id)],
        ['name' => "Config Create"]
    ];
    @endphp
    <x-admin.atoms.breadcrumb :breadcrumbs="$breadcrumbs" />

    <form
        class="relative mt-7"
        method="POST"
        action="{{ route("LaravelBlock2ThumbnailFilterIcon.config.store", $element->id) }}"
    >
        @csrf
        <x-admin.atoms.required />

        <x-admin.atoms.row>
            <x-admin.atoms.label for="img_width" class="required">
                Image Width
            </x-admin.atoms.label>
            <x-admin.atoms.text name="img_width" id="img_width" />
            @error("img_width")
                <x-admin.atoms.error>
                    {{ $message }}
                </x-admin.atoms.error>
            @enderror
        </x-admin.atoms.row>

        <x-admin.atoms.row>
            <x-admin.atoms.label for="img_height" class="required">
                Image Height
            </x-admin.atoms.label>
            <x-admin.atoms.text name="img_height" id="img_height" />
            @error("img_height")
                <x-admin.atoms.error>
                    {{ $message }}
                </x-admin.atoms.error>
            @enderror
        </x-admin.atoms.row>

        <x-admin.atoms.row>
            <x-admin.atoms.label for="layout" class="required">
                Layout
            </x-admin.atoms.label>
            <x-admin.atoms.select name="layout" id="layout">
                <option value="">--Select Item--</option>
                @foreach (config("gmj.laravel_block2_thumbnail_filter_icon_config.layout") as $item)
                    <option value="{{ $item }}">{{ $item }}</option>
                @endforeach 
            </x-admin.atoms.select>
            @error("layout")
                <x-admin.atoms.error>
                    {{ $message }}
                </x-admin.atoms.error>
            @enderror
        </x-admin.atoms.row>


        <hr class="my-10">

        <div class="text-right">
            <x-admin.atoms.link
                href="{{ route('LaravelBlock2ThumbnailFilterIcon.index', $element->id) }}"
            >
                Back
            </x-admin.atoms.link>
            <x-admin.atoms.button id="save">
                Save
            </x-admin.atoms.button>
        </div>
    </form>
</x-admin.layout.app>

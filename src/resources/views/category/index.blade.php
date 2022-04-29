<x-admin.layout.app>
    @php
        $breadcrumbs = [
            ['name' => 'Element', 'link' => route("admin.element.index")],
            ['name' => $element->title],
            ['name' => "Thumbnail Filter Icon", "link" => route('LaravelBlock2ThumbnailFilterIcon.index', $element->id)],
            ["name" => "Category"]
        ];
    @endphp
    <x-admin.atoms.breadcrumb :breadcrumbs="$breadcrumbs" />

    <div>
        <x-admin.atoms.row>
            <div class="text-right">
                <x-admin.atoms.link href="{{ route('LaravelBlock2ThumbnailFilterIcon.category.create', $element_id) }}">
                    ADD
                </x-admin.atoms.link>

                <x-admin.atoms.link href="{{ route('LaravelBlock2ThumbnailFilterIcon.category.order', $element_id) }}">
                    ORDER
                </x-admin.atoms.link>
            </div>
        </x-admin.atoms.row>

        
        <x-admin.atoms.header-banner>
            <div class="flex-1">Title</div>
            <div class="flex-1"></div>
        </x-admin.atoms.header-banner>

        @forelse ($collections as $item)
            <div class="flex items-center space-x-2 p-3">
                <div class="flex-1">
                    {{ $item->title }}
                </div>
                <div class="flex-1">
                    <x-admin.atoms.link
                        href="{{ route('LaravelBlock2ThumbnailFilterIcon.category.edit', ['element_id' => $element_id, 'id' => $item->id]) }}">
                        Edit
                    </x-admin.atoms.link>
                    <form
                        action="{{ route('LaravelBlock2ThumbnailFilterIcon.category.delete', ['element_id' => $element_id, 'id' => $item->id]) }}"
                        method="POST"
                        class="inline-block">
                        @csrf
                        @method("DELETE")
                        <x-admin.atoms.button class="delete">
                            Delete
                        </x-admin.atoms.button>
                    </form>
                </div>
            </div>
        @empty
            <div class="text-center p-4 font-bold text-3xl">No Data</div>
        @endforelse
    </div>
    @push('js')
        <script src="{{ asset("js/jquery-3.6.0.min.js") }}"></script>
        <script src="{{ asset("js/sweetalert-2.1.2.min.js") }}"></script>
        <script>
             $(".delete").on("click", function(event){
                const $this = $(this);
                event.preventDefault();
                Swal.fire({
                    title: 'Are you sure to Delete?',
                    showCancelButton: true,
                    confirmButtonText: "Yes",
                }).then(res => {
                    if (res.isConfirmed) {
                        $this.closest("form").submit();
                    }
                });
            });
        </script>
    @endpush
</x-admin.layout.app>
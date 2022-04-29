<div class="laravel_block2_shop_addr_filter" x-data="{region: 0}">
    <div class="mt-6" x-data="{region: 'all'}">
        <x-frontend.container>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-2">
                <div x-on:click="region = 'all'">
                    <div
                        class="px-6 py-3 cursor-pointer hover:bg-black hover:text-white text-center"
                        x-bind:class="region == 'all' ? 'bg-black text-white border border-gray-500' : 'border border-gray-500'"
                    >
                        ALL
                    </div>
                </div>
                @foreach ($categories as $item)
                    <div x-on:click="region = {{ $item->id }}">
                        <div
                            class="px-6 py-3 cursor-pointer hover:bg-black hover:text-white text-center"
                            x-bind:class="region == {{ $item->id }} ? 'bg-black text-white border border-gray-500' : 'border border-gray-500'"
                        >
                            {{ $item->getTranslation('title', $locale) }}
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="my-6 grid sm:grid-cols-2 lg:grid-cols-3 justify-items-center gap-4">
                @foreach ($collection as $item)
                    <div x-bind:class="region != 'all' && !{!! json_encode($item->categories->pluck("id")->toArray()) !!}.includes(region) && 'hidden'">
                        <div class="relative bg-gray-100 h-full" style="max-width:328px; min-height:380px;">
                            <div>
                                @isset ($item->elementLinkPage)
                                    @if ($item->elementLinkPage->is_custom_link)
                                        <a href="{{ $item->elementLinkPage->custom_link }}" class="block hover:opacity-60" {{ $item->elementLinkPage->is_external ? "target='_blank'" : ""}}>
                                    @else
                                        <a href="{{ route('frontend.page', $item->elementLinkPage->page->slug) }}" class="block hover:opacity-60">
                                    @endif
                                @endisset

                                <img src="{{ $item->getFirstMedia("laravel_block2_thumbnail_filter_icon")->getUrl() }}" alt="">

                                @isset ($item->elementLinkPage)
                                    </a>
                                @endisset
                            </div>
                            <div class="mt-4 px-4 text-xl font-semibold flex items-center gap-x-4">
                                <img src="{{ $item->iconManagement->icon->getFirstMedia("icon")->getUrl() }}" alt="" class="w-12 h-12">
                                <p>
                                    {{ $item->getTranslation("title", $locale) }}
                                </p>
                            </div>
                            <p class="p-4">
                                {{ $item->getTranslation("text", $locale) }}
                            </p>
                        </div>
                    </div>
                @endforeach  
            </div>
        </x-frontend.container>
    </div>
</div>

@push('css')
    <style>
        .detail-tabs .detail-tab-item{
            text-align: center;
            padding: 10px 5px;
            min-width: 100px;
            border-left: 1px solid #ddd;
            border-top: 1px solid #ddd;
            border-right: 1px solid #ddd;
            background: #000;
            color: #fff;
            font-size: 15px;
            cursor: pointer;
        }

        .detail-tabs .detail-tab-item:hover,
        .detail-tabs .detail-tab-item.active {
            font-weight: 700;
            background: #fff;
            color: #000;
        }
    </style>
@endpush
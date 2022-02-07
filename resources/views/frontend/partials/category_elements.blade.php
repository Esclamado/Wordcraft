<div class="row">
    @foreach (\App\Utility\CategoryUtility::get_immediate_children_ids($category->id) as $key => $first_level_id)
        <div class="col-12 col-lg-4">
            <a href="{{ route('products.category', \App\Category::find($first_level_id)->slug) }}" class="px-0 py-3 bg-soft-primary d-none d-lg-block rounded-top all-category position-relative text-left border-bottom mx-3 mb-2">
                <span class="fw-600 fs-16 px-0 promotion-header text-header-blue">{{ \App\Category::find($first_level_id)->getTranslation('name') }}</span>
            </a>

            <ul class="list-unstyled categories no-scrollbar py-2 mb-0 text-left">
                @foreach (\App\Utility\CategoryUtility::get_immediate_children_ids($first_level_id) as $key => $second_level_id)
                    <li class="category-nav-element" data-id="{{ $category->id }}">
                        <a href="{{ route('products.category', \App\Category::find($second_level_id)->slug) }}" class="text-truncate text-reset py-2 px-3 d-block text-title-thin">
                            <span class="cat-name">{{ \App\Category::find($second_level_id)->getTranslation('name') }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach
</div>
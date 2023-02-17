{{ csrf_field() }}

<div class="form-group title-input">
    <label for="name">{{ trans('common.name') }}</label>
    @include('form.text', ['name' => 'name', 'autofocus' => true])
</div>

<div class="form-group description-input">
    <label for="description">{{ trans('common.description') }}</label>
    @include('form.textarea', ['name' => 'description'])
</div>

<div component="shelf-sort" class="grid half gap-xl">
    <div class="form-group">
        <label for="books">{{ trans('entities.shelves_books') }}</label>
        <input refs="shelf-sort@input" type="hidden" name="books"
               value="{{ isset($shelf) ? $shelf->visibleBooks->implode('id', ',') : '' }}">
        <div class="scroll-box-header-item">{{ trans('entities.shelves_drag_books') }}</div>
        <ul refs="shelf-sort@shelf-book-list" class="scroll-box">
            @foreach (($shelf->visibleBooks ?? []) as $book)
                @include('shelves.parts.shelf-sort-book-item', ['book' => $book])
            @endforeach
        </ul>
    </div>
    <div class="form-group">
        <label for="books">{{ trans('entities.shelves_add_books') }}</label>
        <input type="text" refs="shelf-sort@book-search" class="scroll-box-search" placeholder="{{ trans('common.search') }}">
        <ul refs="shelf-sort@all-book-list" class="scroll-box">
            @foreach ($books as $book)
                @include('shelves.parts.shelf-sort-book-item', ['book' => $book])
            @endforeach
        </ul>
    </div>
</div>



<div class="form-group collapsible" component="collapsible" id="logo-control">
    <button refs="collapsible@trigger" type="button" class="collapse-title text-link" aria-expanded="false">
        <label>{{ trans('common.cover_image') }}</label>
    </button>
    <div refs="collapsible@content" class="collapse-content">
        <p class="small">{{ trans('common.cover_image_description') }}</p>

        @include('form.image-picker', [
            'defaultImage' => url('/book_default_cover.png'),
            'currentImage' => (isset($shelf) && $shelf->cover) ? $shelf->getBookCover() : url('/book_default_cover.png') ,
            'name' => 'image',
            'imageClass' => 'cover'
        ])
    </div>
</div>

<div class="form-group collapsible" component="collapsible" id="tags-control">
    <button refs="collapsible@trigger" type="button" class="collapse-title text-link" aria-expanded="false">
        <label for="tag-manager">{{ trans('entities.shelf_tags') }}</label>
    </button>
    <div refs="collapsible@content" class="collapse-content">
        @include('entities.tag-manager', ['entity' => $shelf ?? null])
    </div>
</div>

<div class="form-group text-right">
    <a href="{{ isset($shelf) ? $shelf->getUrl() : url('/shelves') }}" class="button outline">{{ trans('common.cancel') }}</a>
    <button type="submit" class="button">{{ trans('entities.shelves_save') }}</button>
</div>
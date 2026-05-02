@csrf

<div class="form-grid">
    <label>
        <span>Title</span>
        <input type="text" name="title" value="{{ old('title', $course->title) }}" required>
        @error('title')
            <small>{{ $message }}</small>
        @enderror
    </label>

    <label>
        <span>Level</span>
        <input type="text" name="level" value="{{ old('level', $course->level) }}" placeholder="Beginner" required>
        @error('level')
            <small>{{ $message }}</small>
        @enderror
    </label>

    <label>
        <span>Duration</span>
        <input type="text" name="duration" value="{{ old('duration', $course->duration) }}" placeholder="6 Weeks" required>
        @error('duration')
            <small>{{ $message }}</small>
        @enderror
    </label>

    <label>
        <span>Price</span>
        <input type="number" name="price" value="{{ old('price', $course->price) }}" min="0" step="1000" required>
        @error('price')
            <small>{{ $message }}</small>
        @enderror
    </label>

    <label>
        <span>Image Style</span>
        <select name="image_style" required>
            @foreach ($imageStyles as $value => $label)
                <option value="{{ $value }}" @selected(old('image_style', $course->image_style ?: 'img-1') === $value)>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        @error('image_style')
            <small>{{ $message }}</small>
        @enderror
    </label>

    <label class="full">
        <span>Description</span>
        <textarea name="description" rows="6" required>{{ old('description', $course->description) }}</textarea>
        @error('description')
            <small>{{ $message }}</small>
        @enderror
    </label>
</div>

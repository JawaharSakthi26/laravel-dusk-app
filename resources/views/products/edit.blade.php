<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <!-- Include any required CSS/JS files -->
</head>
<body>
    <h1>Edit Product</h1>

    <form action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" />
            @error('name')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="description">Description:</label>
            <input type="text" id="description" name="description" value="{{ old('description', $product->description) }}" />
        </div>

        <div>
            <label for="price">Price:</label>
            <input type="text" id="price" name="price" value="{{ old('price', $product->price) }}" />
            @error('price')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <button type="submit">Update</button>
    </form>

    <a href="{{ route('products.index') }}">Back to Product List</a>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Create Product</title>
    <!-- Include any required CSS/JS files -->
</head>
<body>
    <h1>Create Product</h1>
    
    <form action="{{ route('products.store') }}" method="POST">
        @csrf

        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" />
            @error('name')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="description">Description:</label>
            <input type="text" id="description" name="description" value="{{ old('description') }}" />
        </div>

        <div>
            <label for="price">Price:</label>
            <input type="text" id="price" name="price" value="{{ old('price') }}" />
            @error('price')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <button type="submit">Save</button>
    </form>
    
    <a href="{{ route('products.index') }}">Back to Product List</a>
</body>
</html>

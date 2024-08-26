<!DOCTYPE html>
<html>
<head>
    <title>Products</title>
    <!-- Include any required CSS/JS files -->
</head>
<body>
    <h1>Products</h1>

    <a href="{{ route('products.create') }}">Create New Product</a>

    <ul>
        @foreach ($products as $product)
            <li>
                {{ $product->name }} - {{ $product->price }}
                <a href="{{ route('products.edit', $product->id) }}">Edit</a>
                <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" id="delete-product-{{ $product->id }}">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
</body>
</html>

import Link from "next/link";


async function fetchProducts(page = 1) {
  let url = process.env.NEXT_PUBLIC_API_URL;
  const res = await fetch(`${url}/api/products?page=${page}`, {
    cache: 'no-store', // Ensures fresh data is fetched each time
  });
  if (!res.ok) {
    throw new Error('Failed to fetch products');
  }
  return res.json();
}

export default async function ProductsPage({ searchParams }) {
    const page = searchParams?.page || 1;
    const products = await fetchProducts(page);
    return (
      <div >
        <h1 >Products</h1>
  
        <ul style={{ listStyle: "none" }}>
          {products.data.map((product) => (
            <li key={product.id} style={{ marginBottom: "10px" }}>
              <div style={{ fontWeight: "600" }}>{product.name}</div>
              <div>{product.description || "No description available."}<br/>
              Price: ${product.price}<br/>
              Quantity: {product.quantity}<br/>
              Added: {product.created.human}</div>
            </li>
          ))}
        </ul>
  
        <div style={{ display:"flex", gap: "1rem" }}>
        {products.meta.links.prev && (
            <Link
              href={`/products?page=${products.meta.current_page - 1}`}
            >
              Previous
            </Link>
          )}
  
          {products.meta.links.next && (
            <Link
              href={`/products?page=${products.meta.current_page + 1}`}
            >
              Next
            </Link>
          )}
        </div>
      </div>
    );
}
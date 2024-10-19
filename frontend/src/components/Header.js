import Link from 'next/link';

export default function Header() {
  return (
    <header style={{ padding: '1rem', backgroundColor: '#f8f9fa' }}>
      <nav>
        <ul style={{ display: 'flex', gap: '1rem', listStyle: 'none' }}>
          <li><Link href="/">Home</Link></li>
          <li><Link href="/products">Products</Link></li>
          <li><Link href="/about">About</Link></li>
        </ul>
      </nav>
    </header>
  );
}

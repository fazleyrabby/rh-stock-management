
import Header from "@/components/Header";
import "./globals.css";


export default function RootLayout({ children }) {
  return (
    <html lang="en">
      <body>
        <Header />
        <main style={{ marginInline: "20px" }}>{children}</main>
      </body>
    </html>
  );
}

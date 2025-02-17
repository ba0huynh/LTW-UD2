import { Routes, Route } from "react-router-dom";
import CartPage from "./pages/CartPage";
import ProductDetail from "./pages/ProductDetail";

const App = () => {
  return (
    <>
      <main>
        <Routes>
          <Route path="/cart" element={<CartPage />} />
          <Route path="/product" element={<ProductDetail />} />
        </Routes>
      </main>
    </>
  );
};

export default App;

import { Routes,Route } from "react-router-dom"
import CartPage from "./pages/CartPage"

const App = () => {
  return (
<>
<Routes>
  <Route path="/cart" element={<CartPage/>}/>
</Routes>
</>
  )
}

export default App
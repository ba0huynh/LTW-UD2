import React from 'react'
import "./CartPage.css"
import CtaButton from '../../public/components/CtaButton'
const CartPage = () => {
  return (
    <div className='background'>
        <div className='empty-cart'>
<img height={200} src="/empty-cart.png" alt="" />
<p>Chưa có sản phẩm trog giỏ hàng của bạn.</p>
<CtaButton text={"Mua Sắm Ngay"} />
        </div>
    </div>
  )
}

export default CartPage